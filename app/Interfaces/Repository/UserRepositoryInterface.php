<?php

namespace App\Interfaces\Repository;

use App\Entities\Users;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?Users;

    public function findById(int $id): ?Users;

    public function save(Users $user): void;
}
