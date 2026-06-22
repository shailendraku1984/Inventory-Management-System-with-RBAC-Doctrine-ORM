<?php

namespace App\Interfaces\Repository;

use Doctrine\DBAL\Connection;

interface RoleUserRepositoryInterface
{
    /**
     * Active users whose `users.role` column matches the given role id.
     *
     * @return list<int>
     */
    public function findActiveUserIdsByRole(int|string $roleId): array;

    public function existsForUser(int $userId): bool;

    /**
     * Insert role_user rows for users on this role when no pivot row exists yet.
     */
    public function ensureEntriesForRole(int|string $roleId): void;

    /**
     * Same as ensureEntriesForRole but participates in an outer DBAL transaction.
     */
    public function ensureEntriesForRoleOnConnection(int|string $roleId, Connection $connection): void;
}
