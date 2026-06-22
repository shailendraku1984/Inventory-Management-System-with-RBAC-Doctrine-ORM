<?php

namespace App\Repositories;

use App\Entities\TaxRate;
use App\Interfaces\Repository\TaxRateRepositoryInterface;

class TaxRateRepository extends AbstractSoftDeleteRepository implements TaxRateRepositoryInterface
{
    protected function entityClass(): string
    {
        return TaxRate::class;
    }

    public function allActive(): array
    {
        return $this->entityManager
            ->getRepository(TaxRate::class)
            ->findBy(['status' => TaxRate::STATUS_OPEN], ['id' => 'ASC']);
    }
}
