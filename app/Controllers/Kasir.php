<?php

namespace App\Controllers;

use App\Models\DetailTransaksi;
use App\Models\ProductsModel;
use App\Models\Transaksi;
use App\Models\AuditTrailModel;
use CodeIgniter\HTTP\ResponseInterface;

class Kasir extends BaseController
{
    public function index(): string
    {
        $productsModel = new ProductsModel();
        $keyword = trim((string) $this->request->getGet('q'));

        $builder = $productsModel
            ->select('id, kode_product, nama_product, kategori, qty, image, harga')
            ->where('qty >', 0)
            ->where('is_active', 1)
            ->orderBy('nama_product', 'ASC');

        if ($keyword !== '') {
            $builder = $builder
                ->groupStart()
                ->like('nama_product', $keyword)
                ->orLike('kode_product', $keyword)
                ->groupEnd();
        }

        $products = $builder->findAll(30);

        return view('pages/kasir', [
            'title'        => 'Kasir POS — AmbaToys',
            'page_heading' => 'Transaksi kasir',
            'products'     => $products,
            'keyword'      => $keyword,
        ]);
    }

  public function penjualan(){
    $transaksiModel = new Transaksi();
    $detailTransaksiModel = new DetailTransaksi();
    $productsModel = new ProductsModel();

    $transaksi = $transaksiModel->select('id, total, created_at')->findAll();

    // Flatten semua items sekalian
    $allItems = [];
    foreach ($transaksi as &$t){
        $items = $detailTransaksiModel->where('transaksi_id', $t['id'])->findAll();
        $t['items'] = $items;
        foreach ($items as $item) {
            $allItems[] = $item;
        }
    }

    $products = $productsModel->select('id, nama_product, kategori, harga, qty')->findAll();

    return $this->response->setJSON([
        'transaction' => $transaksi,
        'items'       => $allItems,  // ← flat array semua detail
        'products'    => $products
    ]);
}

    public function laporan_penjualan()
{
    $transaksiModel = new Transaksi();
    $detailTransaksiModel = new DetailTransaksi();
    $filterType = (string) ($this->request->getGet('filter') ?? 'harian');
    $allowedFilters = ['harian', 'mingguan', 'bulanan'];
    if (!in_array($filterType, $allowedFilters, true)) {
        $filterType = 'harian';
    }

    $tanggal = trim((string) ($this->request->getGet('tanggal') ?? ''));
    $minggu = trim((string) ($this->request->getGet('minggu') ?? ''));
    $bulan = trim((string) ($this->request->getGet('bulan') ?? ''));

    $builder = $transaksiModel->select('id, total, created_at');

    if ($filterType === 'harian' && $tanggal !== '') {
        $builder->where('DATE(created_at)', $tanggal);
    } elseif ($filterType === 'mingguan' && $minggu !== '') {
        $startDate = null;
        if (preg_match('/^(\d{4})-W(\d{2})$/', $minggu, $match) === 1) {
            $isoYear = (int) $match[1];
            $isoWeek = (int) $match[2];
            $weekStart = new \DateTime();
            $weekStart->setISODate($isoYear, $isoWeek);
            $startDate = $weekStart->format('Y-m-d');
            $weekStart->modify('+6 days');
            $endDate = $weekStart->format('Y-m-d');
            $builder->where('DATE(created_at) >=', $startDate)->where('DATE(created_at) <=', $endDate);
        }
    } elseif ($filterType === 'bulanan' && $bulan !== '') {
        $builder->where("DATE_FORMAT(created_at, '%Y-%m') =", $bulan);
    }

    // Ambil data transaksi
    $transaksi = $builder->orderBy('created_at', 'DESC')->findAll();

    // Attach detail item (pake cara lu yang tadi biar simpel)
    foreach ($transaksi as &$t) {
        $t['items'] = $detailTransaksiModel
            ->select('detail_transaksi.*, products.nama_product') // Join biar muncul nama produknya, bukan cuma ID
            ->join('products', 'products.id = detail_transaksi.product_id')
            ->where('transaksi_id', $t['id'])
            ->findAll();
    }

    return view('pages/penjualan', [
        'title'       => 'Laporan Penjualan',
        'transaction' => $transaksi,
        'filter_type' => $filterType,
        'tanggal'     => $tanggal,
        'minggu'      => $minggu,
        'bulan'       => $bulan,
    ]);
}

    public function tambah(): ResponseInterface
    {
        $id = (int) $this->request->getPost('product_id');
        $qty = (int) $this->request->getPost('qty');
        if ($qty < 1) {
            $qty = 1;
        }

        $product = (new ProductsModel())->find($id);
        if (!$product) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Produk tidak ditemukan']);
        }

        if ((int) ($product['is_active'] ?? 0) !== 1) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Produk tidak aktif']);
        }

        $cart = session()->get('cart') ?? [];
        $currentQty = $cart[$id]['qty'] ?? 0;
        $newQty = $currentQty + $qty;

        if ($newQty > (int) $product['qty']) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Stok tidak mencukupi']);
        }

        $cart[$id] = [
            'id' => $id,
            'nama' => $product['nama_product'],
            'harga' => (float) $product['harga'],
            'qty' => $newQty,
            'image' => $product['image'] ?? '',
        ];

        session()->set('cart', $cart);

        return $this->response->setJSON(['ok' => true, 'message' => 'Produk berhasil ditambahkan ke keranjang', 'cart' => array_values($cart)]);
    }

    public function hapus(): ResponseInterface
    {
        $id = (int) $this->request->getPost('product_id');
        $cart = session()->get('cart') ?? [];

        unset($cart[$id]);
        session()->set('cart', $cart);

        return $this->response->setJSON(['ok' => true, 'cart' => array_values($cart)]);
    }

    public function bayar(): ResponseInterface
    {
        $cart = session()->get('cart') ?? [];

        if ($cart === []) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Keranjang kosong']);
        }

        $db = db_connect();
        $productModel = new ProductsModel();
        $transaksiModel = new Transaksi();
        $detailModel = new DetailTransaksi();

        $total = 0.0;
        foreach ($cart as $item) {
            $total += (float) $item['harga'] * (int) $item['qty'];
        }
        $totalInt = (int) round($total);

        $db->transStart();

        $transaksiId = $transaksiModel->insert([
            'total' => $totalInt,
            'user_id' => session()->get('user_id')
            ]);
        if ($transaksiId === false) {
            $db->transRollback();

            return $this->response->setJSON(['ok' => false, 'message' => 'Gagal menyimpan transaksi']);
        }

        foreach ($cart as $item) {
            $pid = (int) $item['id'];
            $needQty = (int) $item['qty'];
            $harga = (float) $item['harga'];
            $subtotal = (int) round($harga * $needQty);

            $product = $productModel->find($pid);
            if (!$product || (int) ($product['is_active'] ?? 0) !== 1) {
                $db->transRollback();

                return $this->response->setJSON(['ok' => false, 'message' => 'Produk tidak valid atau tidak aktif']);
            }

            $stok = (int) $product['qty'];
            if ($stok < $needQty) {
                $db->transRollback();

                return $this->response->setJSON(['ok' => false, 'message' => 'Stok tidak mencukupi untuk salah satu item']);
            }

            $hargaBaris = (int) round($harga);

            if ($detailModel->insert([
                'transaksi_id' => $transaksiId,
                'product_id'   => $pid,
                'qty'          => $needQty,
                'harga'        => $hargaBaris,
                'subtotal'     => $subtotal,
            ]) === false) {
                $db->transRollback();

                return $this->response->setJSON(['ok' => false, 'message' => 'Gagal menyimpan detail transaksi']);
            }

            if ($productModel->skipValidation(true)->update($pid, [
                'qty' => $stok - $needQty,
            ]) === false) {
                $db->transRollback();

                return $this->response->setJSON(['ok' => false, 'message' => 'Gagal memperbarui stok']);
            }
        }

        if ($db->transComplete() === false) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Transaksi gagal, coba lagi']);
        }

        session()->remove('cart');

        return $this->response->setJSON([
            'ok'      => true,
            'message' => 'Transaksi berhasil',
            'total'   => $totalInt,
        ]);
    }

public function rollBack($id)
{
    $db = \Config\Database::connect();
    $transaksiModel = new Transaksi();
    $detailModel = new DetailTransaksi();
    $productModel = new ProductsModel();
    $auditModel = new AuditTrailModel();

    $db->transStart();
    $items = $detailModel->where('transaksi_id', $id)->findAll();

    if (!empty($items)) {
        foreach ($items as $item) {
            $db->query("UPDATE products SET qty = qty + ? WHERE id = ?", [
                $item['qty'], 
                $item['product_id']
            ]);
            $auditModel->insert([
                'detail_transaksi_id' => $item['id'],
                'user_id' => session()->get('user_id'),
                'nominal' => $item['subtotal']
            ]);
        }
    }

    $detailModel->where('transaksi_id', $id)->delete();
    $transaksiModel->delete($id);
    $db->transComplete();
    if ($db->transStatus() === false) {
        return redirect()->back()->with('error', 'Gagal melakukan rollback transaksi.');
    }

    return redirect()->to('/kasir/penjualan')->with('message', 'Transaksi #TX-' . $id . ' berhasil dibatalkan dan stok telah kembali.');
}
// refactor pindahin method ini ke dashboard
    public function getDataFromFlask(){
        try {
            $transaksiModel = new Transaksi();
            $detailTransaksiModel = new DetailTransaksi();
            $productsModel = new ProductsModel();
            $transactions = $transaksiModel->select('id, total, created_at')->findAll();
            $items = $detailTransaksiModel->select('transaksi_id, product_id, qty, subtotal')->findAll();
            $products = $productsModel
                ->select('id, kode_product, nama_product, kategori, qty, harga, is_active')
                ->where('is_active', 1)
                ->findAll();

            $client = \Config\Services::curlrequest();
            $res = $client->post('http://ai_service:5000/forecast',[
                'timeout' => 10,
                'http_errors' => false,
                'json' => [
                    'transaction' => $transactions,
                    'items' => $items,
                    'products' => $products,
                ],
            ]);

            $statusCode = $res->getStatusCode();
            $payload = json_decode($res->getBody(), true);

            if (!is_array($payload)) {
                return $this->response->setStatusCode(502)->setJSON([
                    'status' => 'error',
                    'message' => 'Respons AI service tidak valid',
                ]);
            }

            if (($payload['status'] ?? null) !== 'success') {
                return $this->response->setStatusCode($statusCode >= 400 ? $statusCode : 502)->setJSON([
                    'status' => 'error',
                    'message' => $payload['message'] ?? 'AI service mengembalikan error',
                    'flask_http_code' => $statusCode,
                ]);
            }

            return $this->response->setStatusCode(200)->setJSON($payload);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(503)->setJSON([
                "status" => "error",
                "message" => "AI service offline",
            ]);
        }
    }
}

