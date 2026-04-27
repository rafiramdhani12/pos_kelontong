<?php 

namespace App\Controllers;

use App\Models\Products;

class Barang extends BaseController
{
    // private function isOwner(){
    //     if(session()->get('role') != 'owner'){
    //         return redirect()->to(site_url('dashboard'));
    //     }
    // }
    public function index()
    {
        $productsModel = new Products();
        $data = [
            'title' => 'Master Barang',
            'page_heading' => 'Daftar barang',
            'products' => $productsModel->getAllProducts(),
        ];
        return view('pages/products/products',$data);
    }

    public function tambahBarang(){
        $productsModel = new Products();
        $data = [
            'kode_product' => $this->request->getPost('kode_product'),
            'nama_product' => $this->request->getPost('nama_product'),
            'kategori' => $this->request->getPost('kategori'),
            'qty' => $this->request->getPost('qty'),
            'harga' => $this->request->getPost('harga'),
            'is_active' => 1,
        ];
        $productsModel->insert($data);
        return redirect()->to(site_url('barang'))->with('success', 'Barang berhasil ditambahkan');
    }

    public function updateStock(){
        $productsModel = new Products();
        $id = $this->request->getPost('id');
        $data = [
            'kode_product' => $this->request->getPost('kode_product'),
            'nama_product' => $this->request->getPost('nama_product'),
            'kategori' => $this->request->getPost('kategori'),
            'qty' => $this->request->getPost('qty'),
            'harga' => $this->request->getPost('harga'),
            'is_active' => $this->request->getPost('is_active'),
        ];
        $productsModel->update($id, $data);
        return redirect()->to(site_url('barang'))->with('success', 'Barang berhasil diupdate');
    }

    public function nonActiveStock(){
        $productsModel = new Products();
        $id = $this->request->getPost('id');
        $data = [
            'is_active' => 0,
        ];
        $productsModel->update($id, $data);
        return redirect()->to(site_url('dashboard'));
    }
}


?>