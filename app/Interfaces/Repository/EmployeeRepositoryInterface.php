<?php

namespace App\Interfaces\Repository;

interface EmployeeRepositoryInterface extends CrudRepositoryInterface
{
    public function findByEmail(string $email, ?int $excludeId = null): ?object;
}
