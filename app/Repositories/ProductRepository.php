<?php

namespace App\Repositories;

use App\Entities\Product;
use App\Interfaces\Repository\ProductRepositoryInterface;

class ProductRepository extends AbstractSoftDeleteRepository implements ProductRepositoryInterface
{
    protected function entityClass(): string
    {
        return Product::class;
    }

    public function findByName(string $name, ?int $ignoreId = null): ?Product
    {
        return $this->findUnique('name', trim($name), $ignoreId);
    }

    public function findBySku(string $sku, ?int $ignoreId = null): ?Product
    {
        return $this->findUnique('sku', strtoupper(trim($sku)), $ignoreId);
    }

    private function findUnique(string $field, string $value, ?int $ignoreId): ?Product
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('product')
            ->from(Product::class, 'product')
            ->where('product.' . $field . ' = :value')
            ->andWhere('product.deletedAt IS NULL')
            ->setParameter('value', $value)
            ->setMaxResults(1);

        if ($ignoreId !== null) {
            $qb->andWhere('product.id != :id')->setParameter('id', $ignoreId);
        }

        return $qb->getQuery()->getOneOrNullResult();
    }
}
