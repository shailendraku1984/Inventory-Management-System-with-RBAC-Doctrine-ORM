<?php

namespace App\Services;

use App\Interfaces\Repository\CrudRepositoryInterface;
use App\Interfaces\Service\CrudServiceInterface;
use DateTime;
use InvalidArgumentException;

class NamedEntityService implements CrudServiceInterface
{
    public function __construct(
        private readonly CrudRepositoryInterface $repository,
        private readonly string $entityClass,
        private readonly bool $hasAddress = false
    ) {
    }

    public function list(): array
    {
        return $this->repository->allActive();
    }

    public function find(int $id): ?object
    {
        return $this->repository->findActive($id);
    }

    public function save(array $data, ?int $id = null): object
    {
        $entity = $id ? $this->find($id) : new $this->entityClass();

        if ($entity === null) {
            throw new InvalidArgumentException('Record not found.');
        }

        $name = trim((string) ($data['name'] ?? ''));
        if ($name === '') {
            throw new InvalidArgumentException('Name is required.');
        }

        $entity->setName($name);

        if ($this->hasAddress) {
            $address = trim((string) ($data['address'] ?? ''));
            if ($address === '') {
                throw new InvalidArgumentException('Address is required.');
            }
            $entity->setAddress($address);
        }

        if ($id !== null && method_exists($entity, 'setModifyAt')) {
            $entity->setModifyAt(new DateTime());
        }

        $this->repository->save($entity);

        return $entity;
    }

    public function delete(int $id): void
    {
        $entity = $this->find($id);

        if ($entity === null) {
            throw new InvalidArgumentException('Record not found.');
        }

        $this->repository->softDelete($entity);
    }
}
