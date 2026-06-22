<?php

namespace App\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class Users
{
    public const ROLE_SUPER_ADMIN = '1';
    public const ROLE_ADMIN = '2';
    public const ROLE_EMPLOYEE = '3';
    public const ROLE_USER = '4';

    public const ROLE_LABELS = [
        self::ROLE_SUPER_ADMIN => 'SUPER_ADMIN',
        self::ROLE_ADMIN => 'ADMIN',
        self::ROLE_EMPLOYEE => 'EMPLOYEE',
        self::ROLE_USER => 'USER',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 150)]
    private string $name = '';

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private string $email = '';

    #[ORM\Column(type: 'string', length: 255)]
    private string $password = '';

    #[ORM\Column(type: 'string', length: 1, options: ['default' => self::ROLE_USER])]
    private string $role = self::ROLE_USER;

    #[ORM\Column(name: 'branch_id', type: 'integer', nullable: true)]
    private ?int $branchId = null;

    #[ORM\Column(name: 'is_active', type: 'boolean')]
    private bool $isActive = true;

    #[ORM\Column(name: 'last_login', type: 'datetime', nullable: true)]
    private ?DateTime $lastLogin = null;

    #[ORM\Column(name: 'created_at', type: 'datetime')]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: true)]
    private ?DateTime $updatedAt = null;

    #[ORM\Column(name: 'deleted_at', type: 'datetime', nullable: true)]
    private ?DateTime $deletedAt = null;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = trim($name);

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = strtolower(trim($email));

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function setPasswordHash(string $plainPassword): self
    {
        $this->password = password_hash($plainPassword, PASSWORD_DEFAULT);

        return $this;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getRoleLabel(): string
    {
        return self::ROLE_LABELS[$this->role] ?? 'USER';
    }

    public function setRole(string $role): self
    {
        $role = strtoupper(trim($role));
        $nameToValue = array_flip(self::ROLE_LABELS);
        $this->role = $nameToValue[$role] ?? (array_key_exists($role, self::ROLE_LABELS) ? $role : self::ROLE_USER);

        return $this;
    }

    public function getBranchId(): ?int
    {
        return $this->branchId;
    }

    public function setBranchId(?int $branchId): self
    {
        $this->branchId = $branchId !== null && $branchId > 0 ? $branchId : null;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getLastLogin(): ?DateTime
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?DateTime $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?DateTime $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
}
