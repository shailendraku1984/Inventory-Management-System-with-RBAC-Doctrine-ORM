<?php

namespace App\Repositories;

use App\Entities\Warehouse;
use App\Interfaces\Repository\WarehouseRepositoryInterface;

class WarehouseRepository extends AbstractSoftDeleteRepository implements WarehouseRepositoryInterface
{
    protected function entityClass(): string
    {
        return Warehouse::class;
    }
}
