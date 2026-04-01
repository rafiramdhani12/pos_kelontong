<?php

namespace App\Controllers;

use App\Models\Products;

class Kasir extends BaseController
{
    public function index(): string
    {
        $productsModel = new Products();
        $keyword = trim((string) $this->request->getGet('q'));

        $builder = $productsModel
            ->select('id, kode_product, nama_product, kategori, jumlah, harga')
            ->where('jumlah >', 0)
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
}

