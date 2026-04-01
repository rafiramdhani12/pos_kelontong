<?php

namespace App\Controllers;

use App\Models\Products;

class Home extends BaseController
{
    public function index(): string
    {
        $products = new Products();
        $data['products'] = $products->getAllProducts();
        return view('pages/home_page',$data);
    }
}
