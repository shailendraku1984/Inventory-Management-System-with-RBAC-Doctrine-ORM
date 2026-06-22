<?php

namespace App\Interfaces\Service;

use App\Entities\Users;

interface AuthServiceInterface
{
    /**
     * @return array{success: bool, message: string, user: Users|null}
     */
    public function attempt(string $email, string $password): array;

    /**
     * @return array<string, mixed>
     */
    public function sessionPayload(Users $user): array;

    public function currentUser(): ?Users;
}
