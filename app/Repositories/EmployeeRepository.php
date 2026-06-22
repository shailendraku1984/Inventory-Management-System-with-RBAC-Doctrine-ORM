<?php

namespace App\Repositories;

use App\Entities\Users;
use App\Interfaces\Repository\EmployeeRepositoryInterface;

class EmployeeRepository extends AbstractSoftDeleteRepository implements EmployeeRepositoryInterface
{
    protected function entityClass(): string
    {
        return Users::class;
    }

    public function findByEmail(string $email, ?int $excludeId = null): ?Users
    {
        $criteria = [
            'email' => strtolower(trim($email)),
            'deletedAt' => null,
        ];

        $user = $this->entityManager->getRepository(Users::class)->findOneBy($criteria);

        if ($user !== null && $excludeId !== null && $user->getId() === $excludeId) {
            return null;
        }

        return $user;
    }
}
