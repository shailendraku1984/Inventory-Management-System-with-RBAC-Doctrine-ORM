<?php

namespace App\Repositories;

use App\Entities\Branch;
use App\Interfaces\Repository\BranchRepositoryInterface;

class BranchRepository extends AbstractSoftDeleteRepository implements BranchRepositoryInterface
{
    protected function entityClass(): string
    {
        return Branch::class;
    }
}
