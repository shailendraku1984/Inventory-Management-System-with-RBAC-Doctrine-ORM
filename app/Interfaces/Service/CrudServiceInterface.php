<?php

namespace App\Interfaces\Service;

interface CrudServiceInterface
{
    public function list(): array;

    public function find(int $id): ?object;

    public function save(array $data, ?int $id = null): object;

    public function delete(int $id): void;
}
