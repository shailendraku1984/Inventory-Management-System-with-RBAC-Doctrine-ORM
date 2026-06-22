<?php

namespace App\Controllers;

use App\Entities\Product;

class TestDoctrineController extends BaseController
{
    public function index()
    {
		//echo "dddd";exit;
        $product = new Product();

        $product->setName('Laptop');
        $product->setPrice(55000);
        $product->setStock(10);

        $this->entityManager->persist($product);

        $this->entityManager->flush();

        echo "Product Saved";exit;
    }
}