<?php

namespace App\Repositories;

use App\Entities\Users;
use App\Interfaces\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function findByEmail(string $email): ?Users
    {
        return $this->entityManager
            ->getRepository(Users::class)
            ->findOneBy([
                'email' => strtolower(trim($email)),
                'deletedAt' => null,
            ]);
    }

    public function findById(int $id): ?Users
    {
        return $this->entityManager
            ->getRepository(Users::class)
            ->findOneBy([
                'id' => $id,
                'deletedAt' => null,
            ]);
    }

    public function save(Users $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
