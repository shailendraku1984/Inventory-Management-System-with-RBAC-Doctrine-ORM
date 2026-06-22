<?php

namespace App\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'side_menu')]
class Sidemenu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'text')]
    private string $actions = '';

    #[ORM\Column(type: 'string', length: 150)]
    private string $tab = '';

    #[ORM\Column(name: 'added_at', type: 'datetime')]
    private DateTime $addedAt;

    #[ORM\Column(name: 'modify_at', type: 'datetime', nullable: true)]
    private ?DateTime $modifyAt = null;

    #[ORM\Column(name: 'deleted_at', type: 'datetime', nullable: true)]
    private ?DateTime $deletedAt = null;

    public function __construct()
    {
        $this->addedAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActions(): string
    {
        return $this->actions;
    }

    public function setActions(string $actions): self
    {
        $this->actions = trim($actions);

        return $this;
    }

    public function getTab(): string
    {
        return $this->tab;
    }

    public function setTab(string $tab): self
    {
        $this->tab = trim($tab);

        return $this;
    }

    public function getAddedAt(): DateTime
    {
        return $this->addedAt;
    }

    public function getModifyAt(): ?DateTime
    {
        return $this->modifyAt;
    }

    public function setModifyAt(?DateTime $modifyAt): self
    {
        $this->modifyAt = $modifyAt;

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
