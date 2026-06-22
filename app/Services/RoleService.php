<?php

namespace App\Services;

use App\Interfaces\Repository\PermissionRepositoryInterface;
use App\Interfaces\Repository\RoleRepositoryInterface;
use App\Interfaces\Repository\RoleUserRepositoryInterface;
use App\Interfaces\Service\RoleServiceInterface;
use CodeIgniter\Router\RouteCollection;
use Doctrine\ORM\EntityManagerInterface;

class RoleService implements RoleServiceInterface
{
    private const EXCLUDED_MODULES = ['Auth', 'Order', 'Profile', 'TestDoctrine'];

    public function __construct(
        private readonly RoleRepositoryInterface $roles,
        private readonly PermissionRepositoryInterface $permissions,
        private readonly RoleUserRepositoryInterface $roleUsers,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function listWithPermissions(): array
    {
        $this->syncPermissionsFromRoutes();

        $rolesWithPermissions = [];

        foreach ($this->roles->findAllForIndexExceptSuperAdmin() as $role) {
            $permissionNames = $this->permissions->findNamesByRoleId($role['id']);

            $badgedPermissions = array_map(
                static fn (string $name): string => '<span class="badge text-bg-success me-1 mb-1">' . esc($name) . '</span>',
                $permissionNames
            );

            $role['permissions_string'] = implode(' ', $badgedPermissions);
            $rolesWithPermissions[] = $role;
        }

        return $rolesWithPermissions;
    }

    public function getEditData(int $id): ?array
    {
        $role = $this->roles->findByIdForEdit($id);

        if ($role === null) {
            return null;
        }

        $this->roleUsers->ensureEntriesForRole($role['id']);

        return [
            'role' => $role,
            'allPermissions' => $this->permissions->findAll(),
            'activePermissionIds' => $this->permissions->findPermissionIdsByRoleId($id),
        ];
    }

    public function updatePermissions(int $id, array $permissionIds): bool
    {
        $roleId = (string) $id;
        $connection = $this->entityManager->getConnection();

        try {
            $connection->beginTransaction();

            $this->permissions->replaceRolePermissionsOnConnection($roleId, $permissionIds, $connection);
            $this->roleUsers->ensureEntriesForRoleOnConnection($roleId, $connection);

            $connection->commit();

            return true;
        } catch (\Throwable) {
            if ($connection->isTransactionActive()) {
                $connection->rollBack();
            }

            return false;
        }
    }

    private function syncPermissionsFromRoutes(): void
    {
        /** @var RouteCollection $routesCollection */
        $routesCollection = service('routes');
        $allRoutes = array_merge(
            $routesCollection->getRoutes('GET'),
            $routesCollection->getRoutes('POST')
        );

        foreach ($allRoutes as $uri => $handler) {
            if (! is_string($handler)) {
                continue;
            }

            $parsed = $this->parseRouteForPermission($uri, $handler);

            if ($parsed === null) {
                continue;
            }

            $this->permissions->upsertByName($parsed['actionName'], $parsed['moduleName']);
        }
    }

    /**
     * @return array{actionName: string, moduleName: string}|null
     */
    private function parseRouteForPermission(string $uri, string $handler): ?array
    {
        $uri = str_replace('([0-9]+)/', '', $uri);
        $uri = str_replace('/([0-9]+)', '/update', $uri);

        $moduleNam = explode('/', $uri)[0];
        $uri = str_replace('/', '.', $uri);

        if ($uri === $moduleNam) {
            return null;
        }

        $handler2 = str_replace('\App\Controllers\\', '', $handler);
        $handler3 = str_replace('Controller', '', $handler2);
        $handler4 = str_replace('/$1', '', $handler3);
        $parts = explode('::', $handler4);
        $moduleName = $parts[0];
        $actionName = $uri;

        if (in_array($moduleName, self::EXCLUDED_MODULES, true)) {
            return null;
        }

        if ($actionName === '') {
            return null;
        }

        return [
            'actionName' => $actionName,
            'moduleName' => $moduleName,
        ];
    }
}
