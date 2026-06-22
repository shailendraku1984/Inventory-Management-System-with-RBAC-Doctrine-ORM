<?php

namespace App\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'product_update_history')]
class ProductUpdateHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'product_id', type: 'integer')]
    private int $productId = 0;

    #[ORM\Column(name: 'product_name', type: 'string', length: 180)]
    private string $productName = '';

    #[ORM\Column(type: 'string', length: 10)]
    private string $type = Product::TYPE_QTY;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 3)]
    private string $stock = '0.000';

    #[ORM\Column(name: 'added_at', type: 'datetime')]
    private DateTime $addedAt;

    public function __construct()
    {
        $this->addedAt = new DateTime();
    }

    public function getId(): ?int { return $this->id; }
    public function getProductId(): int { return $this->productId; }
    public function setProductId(int $productId): self { $this->productId = $productId; return $this; }
    public function getProductName(): string { return $this->productName; }
    public function setProductName(string $productName): self { $this->productName = $productName; return $this; }
    public function getType(): string { return $this->type; }
    public function setType(string $type): self { $this->type = $type; return $this; }
    public function getStock(): string { return $this->stock; }
    public function setStock(string $stock): self { $this->stock = number_format((float) $stock, 3, '.', ''); return $this; }
    public function getAddedAt(): DateTime { return $this->addedAt; }
}
