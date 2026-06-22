<?php

namespace App\Controllers;

class ProductUpdateHistoryController extends BaseController
{
    public function index(): string
    {
        return view('admin/product_history/index', [
            'title' => 'Product Update History',
            'history' => service('productService')->history(),
        ]);
    }
}
