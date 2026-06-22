<?php

namespace App\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'department')]
class Department
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;
 
    #[ORM\Column(type: 'string', length: 180, nullable: true)]
    private ?string $label = null;

    #[ORM\Column(name: 'added_at', type: 'datetime')]
    private DateTime $addedAt;

    #[ORM\Column(name: 'modify_at', type: 'datetime', nullable: true)]
    private ?DateTime $modifyAt = null;

    #[ORM\Column(name: 'deleted_at', type: 'datetime', nullable: true)]
    private ?DateTime $deletedAt = null;

    public function __construct()
    {
        // Automatically sets the current time when creating a new Head
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
        // Trims the string and turns empty inputs into null safely
        $this->label = $label ? trim($label) : null; 
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
