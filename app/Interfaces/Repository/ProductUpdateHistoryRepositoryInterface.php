<?php

namespace App\Interfaces\Repository;

use App\Entities\ProductUpdateHistory;

interface ProductUpdateHistoryRepositoryInterface
{
    public function allLatest(): array;

    public function save(ProductUpdateHistory $history): void;
}
