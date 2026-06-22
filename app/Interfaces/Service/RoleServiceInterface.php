<?php

namespace App\Interfaces\Service;

interface RoleServiceInterface
{
    /**
     * Sync route permissions, then return roles with rendered permission badges for the index view.
     *
     * @return list<array<string, mixed>>
     */
    public function listWithPermissions(): array;

    /**
     * @return array{
     *     role: array<string, mixed>,
     *     allPermissions: list<array<string, mixed>>,
     *     activePermissionIds: list<int|string>
     * }|null
     */
    public function getEditData(int $id): ?array;

    /**
     * @param list<int|string> $permissionIds
     */
    public function updatePermissions(int $id, array $permissionIds): bool;
}
