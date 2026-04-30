<?php 

namespace App\Controllers;

use App\Models\ProductsModel;

class Products extends BaseController
{
    protected $productsModel;

    public function __construct()
    {
        $this->productsModel = new ProductsModel();
    }

    public function index()
    {
        return view('pages/products/products', [
            'title'        => 'Master Barang',
            'page_heading' => 'Daftar barang',
            'products'     => $this->productsModel->findAll(), // FIX
        ]);
    }

    public function tambahProduct()
    {
        $kodes    = $this->request->getPost('kode_product');
        $namas    = $this->request->getPost('nama_product');
        $kategori = $this->request->getPost('kategori');
        $qtys     = $this->request->getPost('qty');
        $hargas   = $this->request->getPost('harga');

        $files = $this->request->getFiles(); // FIX
        $images = $files['image'] ?? [];

        $data  = [];

        foreach ($kodes as $i => $kode) {
            if (empty(trim($kode))) continue;

            $imageName = null;

            if (isset($images[$i]) && $images[$i]->isValid() && !$images[$i]->hasMoved()) {
                $file = $images[$i];
                $imageName = $file->getRandomName();
                $file->move(FCPATH . 'assets/img', $imageName);
            }

            $data[] = [
                'kode_product' => trim($kode),
                'nama_product' => trim($namas[$i]),
                'kategori'     => $kategori[$i],
                'qty'          => (int) $qtys[$i],
                'harga'        => (float) $hargas[$i],
                'is_active'    => 1,
                'image'        => $imageName,
            ];
        }

        if (!empty($data)) {
            $this->productsModel->skipValidation(true)->insertBatch($data); // FIX
        }

        return redirect()->to('/products')->with('success', count($data) . ' produk berhasil ditambahkan.');
    }

    public function updateStock()
    {
        $id = $this->request->getPost('id');

        $data = [
            'nama_product' => $this->request->getPost('nama_product'),
            'qty'          => $this->request->getPost('qty'),
            'harga'        => $this->request->getPost('harga'),
        ];

        $file = $this->request->getFile('image');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getRandomName();
            $file->move(FCPATH . 'assets/img', $imageName);
            $data['image'] = $imageName;
        }

        $this->productsModel->update($id, $data); 

        return redirect()->to('/products')->with('success', 'Barang berhasil diupdate');
    }

   public function toggleStock($id)
{
    $product = $this->productsModel->find($id);
    if ($product) {
        $newStatus = ($product['is_active'] == 1) ? 0 : 1;
        $this->productsModel->where('id', $id)
                           ->set(['is_active' => $newStatus])
                           ->update();
                           
        return redirect()->to('/products')->with('msg', 'Status produk berhasil diubah!');
    }
    
    return redirect()->to('/products')->with('error', 'Produk tidak ditemukan');
}
}