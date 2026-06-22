<?php

namespace App\Repositories;

use App\Interfaces\Repository\CrudRepositoryInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractSoftDeleteRepository implements CrudRepositoryInterface
{
    public function __construct(
        protected readonly EntityManagerInterface $entityManager
    ) {
    }

    abstract protected function entityClass(): string;

    public function allActive(): array
    {
        return $this->entityManager
            ->getRepository($this->entityClass())
            ->findBy(['deletedAt' => null], ['id' => 'DESC']);
    }

    public function findActive(int $id): ?object
    {
        return $this->entityManager
            ->getRepository($this->entityClass())
            ->findOneBy(['id' => $id, 'deletedAt' => null]);
    }

    public function save(object $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function softDelete(object $entity): void
    {
        if (method_exists($entity, 'setDeletedAt')) {
            $entity->setDeletedAt(new DateTime());
        }

        if (method_exists($entity, 'setModifyAt')) {
            $entity->setModifyAt(new DateTime());
        }

        $this->save($entity);
    }
}
