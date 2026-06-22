<?php

namespace App\Interfaces\Repository;

use Doctrine\DBAL\Connection;

interface PermissionRepositoryInterface
{
    /**
     * Insert or update a permission row keyed by route alias name.
     *
     * @return array{inserted: bool, updated: bool}
     */
    public function upsertByName(string $name, string $module): array;

    /**
     * @return list<array<string, mixed>>
     */
    public function findAll(): array;

    /**
     * @return list<string>
     */
    public function findNamesByRoleId(int|string $roleId): array;

    /**
     * @return list<int|string>
     */
    public function findPermissionIdsByRoleId(int|string $roleId): array;

    /**
     * Replace all permission_role rows for a role inside a transaction.
     *
     * @param list<int|string> $permissionIds
     */
    public function replaceRolePermissions(int|string $roleId, array $permissionIds): bool;

    /**
     * Replace permission_role rows using an existing DBAL connection (no transaction started here).
     *
     * @param list<int|string> $permissionIds
     */
    public function replaceRolePermissionsOnConnection(
        int|string $roleId,
        array $permissionIds,
        Connection $connection
    ): void;
}
