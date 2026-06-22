<?php

namespace App\Repositories;

use App\Entities\Role;
use App\Interfaces\Repository\RoleRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class RoleRepository implements RoleRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function all(): array
    {
        return $this->entityManager
            ->getRepository(Role::class)
            ->findBy([], ['id' => 'ASC']);
    }

    public function findAllForIndexExceptSuperAdmin(): array
    {
        return $this->entityManager->getConnection()->fetchAllAssociative(
            "SELECT id, name FROM roles WHERE id > '1' ORDER BY id ASC"
        );
    }

    public function findByIdForEdit(int $id): ?array
    {
        $role = $this->entityManager->getRepository(Role::class)->find((string) $id);

        if ($role !== null) {
            return [
                'id' => $role->getId(),
                'name' => $role->getName(),
            ];
        }

        $row = $this->entityManager->getConnection()->fetchAssociative(
            'SELECT id, name FROM role WHERE id = ?',
            [(string) $id]
        );

        return $row !== false ? $row : null;
    }
}
