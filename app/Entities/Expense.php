<?php

namespace App\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'expense')]
class Expense
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;
 
    #[ORM\Column(type: 'string', length: 180, nullable: true)]
    private ?string $label = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(name: 'accountId', type: 'integer')]
    private int $accountId = 0;

    #[ORM\Column(name: 'headId', type: 'integer')]
    private int $headId = 0;

    #[ORM\Column(name: 'departmentId', type: 'integer')]
    private int $departmentId = 0;
 
    #[ORM\Column(type: 'decimal', precision: 12, scale: 2)]
    private string $price = '0.00';
     
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $image = null;

	#[ORM\Column(name: 'value_date', type: 'datetime', nullable: true)]
    private ?DateTime $valueDate = null;
	
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

    public function getId(): ?int { return $this->id; }
	 
    public function getLabel(): ?string { return $this->label; }
    public function setLabel(?string $label): self { $this->label = $label ? trim($label) : null; return $this; }
    
    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): self { $this->description = $description ? trim($description) : null; return $this; }
	
    public function getHeadId(): int { return $this->headId; }
    public function setHeadId(int $headId): self { $this->headId = $headId; return $this; }
	
    public function getDepartmentId(): int { return $this->departmentId; }
    public function setDepartmentId(int $departmentId): self { $this->departmentId = $departmentId; return $this; }
	
    public function getAccountId(): int { return $this->accountId; }
    public function setAccountId(int $accountId): self { $this->accountId = $accountId; return $this; }
	 
    public function getPrice(): string { return $this->price; }
    public function setPrice(string $price): self { $this->price = number_format((float) $price, 2, '.', ''); return $this; }
     
    public function getImage(): ?string { return $this->image; }
    public function setImage(?string $image): self { $this->image = $image; return $this; }
	
    public function getValueDate(): ?DateTime { return $this->valueDate; }
    public function setValueDate(?DateTime $valueDate): self { $this->valueDate = $valueDate; return $this; }
     
    public function getAddedAt(): DateTime { return $this->addedAt; }
    public function setAddedAt(DateTime $addedAt): self { $this->addedAt = $addedAt; return $this; }

    public function getModifyAt(): ?DateTime { return $this->modifyAt; }
    public function setModifyAt(?DateTime $modifyAt): self { $this->modifyAt = $modifyAt; return $this; }

    public function getDeletedAt(): ?DateTime { return $this->deletedAt; }
    public function setDeletedAt(?DateTime $deletedAt): self { $this->deletedAt = $deletedAt; return $this; }
}
