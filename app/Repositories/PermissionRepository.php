<?php

namespace App\Repositories;

use App\Interfaces\Repository\PermissionRepositoryInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ParameterType;
use Doctrine\ORM\EntityManagerInterface;

class PermissionRepository implements PermissionRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function upsertByName(string $name, string $module): array
    {
        $connection = $this->entityManager->getConnection();

        $existing = $connection->fetchAssociative(
            'SELECT id, module FROM permissions WHERE name = ?',
            [$name]
        );

        if ($existing !== false) {
            if (($existing['module'] ?? '') !== $module) {
                $connection->executeStatement(
                    'UPDATE permissions SET module = ? WHERE id = ?',
                    [$module, $existing['id']]
                );

                return ['inserted' => false, 'updated' => true];
            }

            return ['inserted' => false, 'updated' => false];
        }

        $connection->insert('permissions', [
            'name' => $name,
            'module' => $module,
        ]);

        return ['inserted' => true, 'updated' => false];
    }

    public function findAll(): array
    {
        return $this->entityManager->getConnection()->fetchAllAssociative(
            'SELECT id, name, module FROM permissions ORDER BY module ASC, name ASC'
        );
    }

    public function findNamesByRoleId(int|string $roleId): array
    {
        $rows = $this->entityManager->getConnection()->fetchAllAssociative(
            'SELECT p.name
             FROM permission_role pr
             INNER JOIN permissions p ON p.id = pr.permission_id
             WHERE pr.role_id = ?
             ORDER BY p.name ASC',
            [(string) $roleId]
        );

        return array_column($rows, 'name');
    }

    public function findPermissionIdsByRoleId(int|string $roleId): array
    {
        $rows = $this->entityManager->getConnection()->fetchAllAssociative(
            'SELECT permission_id FROM permission_role WHERE role_id = ?',
            [(string) $roleId]
        );

        return array_column($rows, 'permission_id');
    }

    public function replaceRolePermissions(int|string $roleId, array $permissionIds): bool
    {
        $connection = $this->entityManager->getConnection();

        try {
            $connection->beginTransaction();
            $this->replaceRolePermissionsOnConnection($roleId, $permissionIds, $connection);
            $connection->commit();

            return true;
        } catch (\Throwable) {
            if ($connection->isTransactionActive()) {
                $connection->rollBack();
            }

            return false;
        }
    }

    public function replaceRolePermissionsOnConnection(
        int|string $roleId,
        array $permissionIds,
        Connection $connection
    ): void {
        $connection->executeStatement(
            'DELETE FROM permission_role WHERE role_id = ?',
            [(string) $roleId],
            [ParameterType::STRING]
        );

        foreach ($permissionIds as $permissionId) {
            $connection->insert('permission_role', [
                'role_id' => (string) $roleId,
                'permission_id' => (int) $permissionId,
            ]);
        }
    }
}
