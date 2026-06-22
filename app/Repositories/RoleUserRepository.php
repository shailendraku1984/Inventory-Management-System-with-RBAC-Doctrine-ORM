<?php

namespace App\Repositories;

use App\Entities\RoleUser;
use App\Entities\Users;
use App\Interfaces\Repository\RoleUserRepositoryInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ParameterType;
use Doctrine\ORM\EntityManagerInterface;

class RoleUserRepository implements RoleUserRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function findActiveUserIdsByRole(int|string $roleId): array
    {
        $ids = $this->entityManager->createQueryBuilder()
            ->select('u.id')
            ->from(Users::class, 'u')
            ->where('u.role = :roleId')
            ->andWhere('u.deletedAt IS NULL')
            ->setParameter('roleId', (string) $roleId)
            ->getQuery()
            ->getSingleColumnResult();

        return array_map(static fn ($id): int => (int) $id, $ids);
    }

    public function existsForUser(int $userId): bool
    {
        return $this->entityManager->getRepository(RoleUser::class)->find($userId) !== null;
    }

    public function ensureEntriesForRole(int|string $roleId): void
    {
        foreach ($this->findActiveUserIdsByRole($roleId) as $userId) {
            $this->persistIfMissing($userId, (string) $roleId);
        }

        $this->entityManager->flush();
    }

    public function ensureEntriesForRoleOnConnection(int|string $roleId, Connection $connection): void
    {
        foreach ($this->findActiveUserIdsByRole($roleId) as $userId) {
            $exists = $connection->fetchOne(
                'SELECT 1 FROM role_user WHERE user_id = ? LIMIT 1',
                [$userId],
                [ParameterType::INTEGER]
            );

            if ($exists !== false) {
                continue;
            }

            $connection->insert('role_user', [
                'user_id' => $userId,
                'role_id' => (string) $roleId,
            ]);
        }
    }

    private function persistIfMissing(int $userId, string $roleId): void
    {
        if ($this->existsForUser($userId)) {
            return;
        }

        $roleUser = (new RoleUser())
            ->setUserId($userId)
            ->setRoleId($roleId);

        $this->entityManager->persist($roleUser);
    }
}
