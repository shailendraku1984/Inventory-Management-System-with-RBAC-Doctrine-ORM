<?php

namespace App\Repositories;

use App\Entities\UserProfile;
use App\Interfaces\Repository\UserProfileRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserProfileRepository implements UserProfileRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function findByUserId(int $userId): ?UserProfile
    {
        return $this->entityManager
            ->getRepository(UserProfile::class)
            ->findOneBy(['userId' => $userId]);
    }

    public function findByEmpCode(string $empCode, ?int $excludeUserId = null): ?UserProfile
    {
        $profile = $this->entityManager
            ->getRepository(UserProfile::class)
            ->findOneBy(['empCode' => strtoupper(trim($empCode))]);

        if ($profile !== null && $excludeUserId !== null && $profile->getUserId() === $excludeUserId) {
            return null;
        }

        return $profile;
    }

    public function save(UserProfile $profile): void
    {
        $this->entityManager->persist($profile);
        $this->entityManager->flush();
    }
}
