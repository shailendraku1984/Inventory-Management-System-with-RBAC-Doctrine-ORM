<?php

namespace App\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'product')]
class Product
{
    public const TYPE_KG = 'kg';
    public const TYPE_LITRE = 'litre';
    public const TYPE_QTY = 'qty';
    public const FOR_SALE = 'For sale';
    public const NOT_FOR_SALE = 'Not for sale';
    public const FOR_PURCHASE = 'For purchase';
    public const NOT_FOR_PURCHASE = 'Not for purchase';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 10)]
    private string $type = self::TYPE_QTY;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private string $name = '';

    #[ORM\Column(type: 'string', length: 80, unique: true)]
    private string $sku = '';

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(name: 'categoryId', type: 'integer')]
    private int $categoryId = 0;

    #[ORM\Column(name: 'branchId', type: 'integer')]
    private int $branchId = 0;

    #[ORM\Column(name: 'warehouseId', type: 'integer')]
    private int $warehouseId = 0;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 3)]
    private string $stock = '0.000';

    #[ORM\Column(type: 'decimal', precision: 12, scale: 2)]
    private string $price = '0.00';

    #[ORM\Column(name: 'tax_rate_id', type: 'integer')]
    private int $taxRateId = 0;

    #[ORM\Column(name: 'for_sale', type: 'string', length: 20)]
    private string $forSale = self::FOR_SALE;

    #[ORM\Column(name: 'for_purchase', type: 'string', length: 20)]
    private string $forPurchase = self::FOR_PURCHASE;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(name: 'meta_keyword', type: 'string', length: 255, nullable: true)]
    private ?string $metaKeyword = null;

    #[ORM\Column(name: 'meta_description', type: 'text', nullable: true)]
    private ?string $metaDescription = null;

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
    public function getType(): string { return $this->type; }
    public function setType(string $type): self { $this->type = $type; return $this; }
    public function getName(): string { return $this->name; }
    public function setName(string $name): self { $this->name = trim($name); return $this; }
    public function getSku(): string { return $this->sku; }
    public function setSku(string $sku): self { $this->sku = strtoupper(trim($sku)); return $this; }
    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): self { $this->description = $description ? trim($description) : null; return $this; }
    public function getCategoryId(): int { return $this->categoryId; }
    public function setCategoryId(int $categoryId): self { $this->categoryId = $categoryId; return $this; }
    public function getBranchId(): int { return $this->branchId; }
    public function setBranchId(int $branchId): self { $this->branchId = $branchId; return $this; }
    public function getWarehouseId(): int { return $this->warehouseId; }
    public function setWarehouseId(int $warehouseId): self { $this->warehouseId = $warehouseId; return $this; }
    public function getStock(): string { return $this->stock; }
    public function setStock(string $stock): self { $this->stock = number_format((float) $stock, 3, '.', ''); return $this; }
    public function getPrice(): string { return $this->price; }
    public function setPrice(string $price): self { $this->price = number_format((float) $price, 2, '.', ''); return $this; }
    public function getTaxRateId(): int { return $this->taxRateId; }
    public function setTaxRateId(int $taxRateId): self { $this->taxRateId = $taxRateId; return $this; }
    public function getForSale(): string { return $this->forSale; }
    public function setForSale(string $forSale): self { $this->forSale = $forSale; return $this; }
    public function getForPurchase(): string { return $this->forPurchase; }
    public function setForPurchase(string $forPurchase): self { $this->forPurchase = $forPurchase; return $this; }
    public function getImage(): ?string { return $this->image; }
    public function setImage(?string $image): self { $this->image = $image; return $this; }
    public function getMetaKeyword(): ?string { return $this->metaKeyword; }
    public function setMetaKeyword(?string $metaKeyword): self { $this->metaKeyword = $metaKeyword ? trim($metaKeyword) : null; return $this; }
    public function getMetaDescription(): ?string { return $this->metaDescription; }
    public function setMetaDescription(?string $metaDescription): self { $this->metaDescription = $metaDescription ? trim($metaDescription) : null; return $this; }
    public function getAddedAt(): DateTime { return $this->addedAt; }
    public function getModifyAt(): ?DateTime { return $this->modifyAt; }
    public function setModifyAt(?DateTime $modifyAt): self { $this->modifyAt = $modifyAt; return $this; }
    public function getDeletedAt(): ?DateTime { return $this->deletedAt; }
    public function setDeletedAt(?DateTime $deletedAt): self { $this->deletedAt = $deletedAt; return $this; }
}
