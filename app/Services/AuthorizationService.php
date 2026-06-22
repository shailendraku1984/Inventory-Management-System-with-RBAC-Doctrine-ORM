<?php

namespace App\Services;

class AuthorizationService
{
    /**
     * Checks if a specific user ID holds a required permission name.
     */
    public function checkUserPermission(int $userId, string $permissionName): bool
    {
        // 1. Connect straight to the core CodeIgniter Query Builder
        $db = \Config\Database::connect();

        // 2. Perform a clean join to verify the relationship link
        $builder = $db->table('role_user ru');
        $builder->select('p.id');
        $builder->join('permission_role pr', 'pr.role_id = ru.role_id');
        $builder->join('permissions p', 'p.id = pr.permission_id');
        
        // 3. Apply criteria constraints
        $builder->where('ru.user_id', $userId);
        $builder->where('p.name', $permissionName);

        $row = $builder->get()->getRow();

        // Returns true if a match exists, otherwise returns false
        return $row !== null;
    }
}
