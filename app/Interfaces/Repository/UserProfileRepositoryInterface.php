<?php

namespace App\Interfaces\Repository;

use App\Entities\UserProfile;

interface UserProfileRepositoryInterface
{
    public function findByUserId(int $userId): ?UserProfile;

    public function findByEmpCode(string $empCode, ?int $excludeUserId = null): ?UserProfile;

    public function save(UserProfile $profile): void;
}
