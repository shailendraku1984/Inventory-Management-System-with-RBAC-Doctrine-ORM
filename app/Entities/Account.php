<?php

namespace App\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'account')]
class Account
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;
 
    #[ORM\Column(type: 'string', length: 180, nullable: true)]
    private ?string $label = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $currency = null;

    #[ORM\Column(name: 'added_at', type: 'datetime')]
    private DateTime $addedAt;

    #[ORM\Column(name: 'modify_at', type: 'datetime', nullable: true)]
    private ?DateTime $modifyAt = null;

    #[ORM\Column(name: 'deleted_at', type: 'datetime', nullable: true)]
    private ?DateTime $deletedAt = null;

    public function __construct()
    {
        // Automatically sets the current date and time on creation
        $this->addedAt = new DateTime();
    }

    // Getters and Setters

    public function getId(): ?int 
    { 
        return $this->id; 
    }
	 
    public function getLabel(): ?string 
    { 
        return $this->label; 
    }
    
    public function setLabel(?string $label): self 
    { 
        $this->label = $label ? trim($label) : null; 
        return $this; 
    }

    public function getCurrency(): ?string 
    { 
        return $this->currency; 
    }
    
    public function setCurrency(?string $currency): self 
    { 
        $this->currency = $currency ? trim($currency) : null; 
        return $this; 
    }
     
    public function getAddedAt(): DateTime 
    { 
        return $this->addedAt; 
    }
    
    public function setAddedAt(DateTime $addedAt): self 
    { 
        $this->addedAt = $addedAt; 
        return $this; 
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
