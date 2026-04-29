<?php 

namespace App\Controllers;

use App\Models\ProductsModel;

class Products extends BaseController
{
    public function index()
    {
        $productsModel = new ProductsModel();
        return view('pages/products/products', [
            'title'        => 'Master Barang',
            'page_heading' => 'Daftar barang',
            'products'     => $productsModel->getAllProducts(),
        ]);
    }

    public function tambahProduct()
    {
        $kodes    = $this->request->getPost('kode_product');
        $namas    = $this->request->getPost('nama_product');
        $kategori = $this->request->getPost('kategori');
        $qtys     = $this->request->getPost('qty');
        $hargas   = $this->request->getPost('harga');

        // Ambil semua file gambar yang diupload (array)
        $images = $this->request->getFiles('image');

        $model = new Products();
        $data  = [];

        foreach ($kodes as $i => $kode) {
            if (empty(trim($kode))) continue;

            $imageName = null;

            // Cek apakah ada file gambar di index ke-i
            if (isset($images['image'][$i]) && $images['image'][$i]->isValid() && !$images['image'][$i]->hasMoved()) {
                $file = $images['image'][$i];
                // Generate nama unik biar nggak bentrok
                $imageName = $file->getRandomName();
                // Pindahin ke folder assets/img
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
            $model->skipValidation(true)->insertBatch($data);
        }

        return redirect()->to('/barang')->with('success', count($data) . ' produk berhasil ditambahkan.');
    }

    public function updateStock()
    {
        $productsModel = new ProductsModel();
        $id   = $this->request->getPost('id');

        $data = [
            'kode_product' => $this->request->getPost('kode_product'),
            'nama_product' => $this->request->getPost('nama_product'),
            'kategori'     => $this->request->getPost('kategori'),
            'qty'          => $this->request->getPost('qty'),
            'harga'        => $this->request->getPost('harga'),
            'is_active'    => $this->request->getPost('is_active'),
        ];

        // Update gambar kalau ada yang diupload
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getRandomName();
            $file->move(FCPATH . 'assets/img', $imageName);
            $data['image'] = $imageName;
        }

        $productsModel->update($id, $data);
        return redirect()->to(site_url('barang'))->with('success', 'Barang berhasil diupdate');
    }

    public function nonActiveStock()
    {
        $productsModel = new ProductsModel();
        $id = $this->request->getPost('id');
        $productsModel->update($id, ['is_active' => 0]);
        return redirect()->to(site_url('dashboard'));
    }
}