<?php

namespace App\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Products;
use App\Models\Transaksi;
use CodeIgniter\HTTP\ResponseInterface;

class Kasir extends BaseController
{
    public function index(): string
    {
        $productsModel = new Products();
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
        $productsModel = new Products();

        // ambil dulu semua transaksi nya
        $transaksi = $transaksiModel->select('id , total , created_at')->findAll();

        // attach item ke setiap transaksi
        foreach ($transaksi as &$t){
            $t['items'] = $detailTransaksiModel->where('transaksi_id' , $t['id'])->findAll();
        }

        // ambil semua produk
        $products =  $productsModel->select('id , nama_product , kategori , harga , qty')->findAll();

        return $this->response->setJSON(
            [
                'transaction' => $transaksi,
                'products' => $products
            ]
        );

    }

    public function laporan_penjualan()
{
    $transaksiModel = new Transaksi();
    $detailTransaksiModel = new DetailTransaksi();

    // Ambil data transaksi
    $transaksi = $transaksiModel->select('id, total, created_at')->orderBy('created_at', 'DESC')->findAll();

    // Attach detail item (pake cara lu yang tadi biar simpel)
    foreach ($transaksi as &$t) {
        $t['items'] = $detailTransaksiModel
            ->select('detail_transaksi.*, products.nama_product') // Join biar muncul nama produknya, bukan cuma ID
            ->join('products', 'products.id = detail_transaksi.product_id')
            ->where('transaksi_id', $t['id'])
            ->findAll();
    }

    return view('pages/penjualan', [
        'title'       => 'Laporan Penjualan — AmbaToys',
        'transaction' => $transaksi
    ]);
}

    public function tambah(): ResponseInterface
    {
        $id = (int) $this->request->getPost('product_id');
        $qty = (int) $this->request->getPost('qty');
        if ($qty < 1) {
            $qty = 1;
        }

        $product = (new Products())->find($id);
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
        $productModel = new Products();
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
}

