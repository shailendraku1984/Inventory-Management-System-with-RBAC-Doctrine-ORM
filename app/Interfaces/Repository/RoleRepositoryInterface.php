<?php

namespace App\Interfaces\Repository;

interface RoleRepositoryInterface
{
    public function all(): array;

    /**
     * Roles for index listing (excludes SUPER_ADMIN). Uses legacy `roles` table.
     *
     * @return list<array<string, mixed>>
     */
    public function findAllForIndexExceptSuperAdmin(): array;

    /**
     * Single role for edit form. Uses legacy `role` table (ACL pivot source).
     *
     * @return array<string, mixed>|null
     */
    public function findByIdForEdit(int $id): ?array;
}
