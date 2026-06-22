<?php

namespace App\Repositories;

use App\Entities\ProductUpdateHistory;
use App\Interfaces\Repository\ProductUpdateHistoryRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class ProductUpdateHistoryRepository implements ProductUpdateHistoryRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function allLatest(): array
    {
        return $this->entityManager
            ->getRepository(ProductUpdateHistory::class)
            ->findBy([], ['id' => 'DESC']);
    }

    public function save(ProductUpdateHistory $history): void
    {
        $this->entityManager->persist($history);
        $this->entityManager->flush();
    }
}
