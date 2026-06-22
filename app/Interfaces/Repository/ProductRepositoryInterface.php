<?php

namespace App\Interfaces\Repository;

use App\Entities\Product;

interface ProductRepositoryInterface extends CrudRepositoryInterface
{
    public function findByName(string $name, ?int $ignoreId = null): ?Product;

    public function findBySku(string $sku, ?int $ignoreId = null): ?Product;
}
