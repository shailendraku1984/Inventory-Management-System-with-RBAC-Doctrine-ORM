<?php

namespace App\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'tax_rate')]
class TaxRate
{
    public const STATUS_OPEN = 1;
    public const STATUS_CLOSE = 2;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 50)]
    private string $label = '';

    #[ORM\Column(name: 'added_at', type: 'datetime')]
    private DateTime $addedAt;

    #[ORM\Column(name: 'modify_at', type: 'datetime', nullable: true)]
    private ?DateTime $modifyAt = null;

    #[ORM\Column(type: 'integer')]
    private int $status = self::STATUS_OPEN;

    public function __construct()
    {
        $this->addedAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = trim($label);

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

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
}
