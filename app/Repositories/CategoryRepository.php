<?php

namespace App\Repositories;

use App\Entities\Category;
use App\Interfaces\Repository\CategoryRepositoryInterface;

class CategoryRepository extends AbstractSoftDeleteRepository implements CategoryRepositoryInterface
{
    protected function entityClass(): string
    {
        return Category::class;
    }
}
