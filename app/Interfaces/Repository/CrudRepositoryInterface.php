<?php

namespace App\Interfaces\Repository;

interface CrudRepositoryInterface
{
    public function allActive(): array;

    public function findActive(int $id): ?object;

    public function save(object $entity): void;

    public function softDelete(object $entity): void;
}
