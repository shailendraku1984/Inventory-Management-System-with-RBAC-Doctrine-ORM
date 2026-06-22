<?php

namespace App\Services;

use App\Entities\Product;
use App\Entities\ProductUpdateHistory;
use App\Interfaces\Repository\BranchRepositoryInterface;
use App\Interfaces\Repository\CategoryRepositoryInterface;
use App\Interfaces\Repository\ProductRepositoryInterface;
use App\Interfaces\Repository\ProductUpdateHistoryRepositoryInterface;
use App\Interfaces\Repository\TaxRateRepositoryInterface;
use App\Interfaces\Repository\WarehouseRepositoryInterface;
use App\Interfaces\Service\ProductServiceInterface;
use CodeIgniter\HTTP\Files\UploadedFile;
use DateTime;
use InvalidArgumentException;

class ProductService implements ProductServiceInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $products,
        private readonly CategoryRepositoryInterface $categories,
        private readonly BranchRepositoryInterface $branches,
        private readonly WarehouseRepositoryInterface $warehouses,
        private readonly TaxRateRepositoryInterface $taxRates,
        private readonly ProductUpdateHistoryRepositoryInterface $history
    ) {
    }

    public function list(): array
    {
        return $this->products->allActive();
    }

    public function find(int $id): ?object
    {
        return $this->products->findActive($id);
    }

    public function save(array $data, ?int $id = null): object
    {
        return $this->saveWithImage($data, null, $id);
    }

    public function saveWithImage(array $data, ?UploadedFile $image = null, ?int $id = null): object
    {
        $product = $id ? $this->products->findActive($id) : new Product();

        if ($product === null) {
            throw new InvalidArgumentException('Product not found.');
        }

        $type = (string) ($data['type'] ?? '');
        if (! in_array($type, [Product::TYPE_KG, Product::TYPE_LITRE, Product::TYPE_QTY], true)) {
            throw new InvalidArgumentException('Invalid product type.');
        }

        $name = trim((string) ($data['name'] ?? ''));
        $sku = strtoupper(trim((string) ($data['sku'] ?? '')));
        if ($name === '' || $sku === '') {
            throw new InvalidArgumentException('Name and SKU are required.');
        }

        if ($this->products->findByName($name, $id) !== null) {
            throw new InvalidArgumentException('Product name already exists.');
        }

        if ($this->products->findBySku($sku, $id) !== null) {
            throw new InvalidArgumentException('Product SKU already exists.');
        }

        $stock = $this->normalizeStock($type, (string) ($data['stock'] ?? '0'));
        $imagePath = $this->storeImage($image) ?? $product->getImage();

        $product
            ->setType($type)
            ->setName($name)
            ->setSku($sku)
            ->setDescription($data['description'] ?? null)
            ->setCategoryId((int) ($data['categoryId'] ?? 0))
            ->setBranchId((int) ($data['branchId'] ?? 0))
            ->setWarehouseId((int) ($data['warehouseId'] ?? 0))
            ->setStock($stock)
            ->setPrice((string) ($data['price'] ?? '0'))
            ->setTaxRateId((int) ($data['tax_rate_id'] ?? 0))
            ->setForSale((string) ($data['for_sale'] ?? Product::FOR_SALE))
            ->setForPurchase((string) ($data['for_purchase'] ?? Product::FOR_PURCHASE))
            ->setImage($imagePath)
            ->setMetaKeyword($data['meta_keyword'] ?? null)
            ->setMetaDescription($data['meta_description'] ?? null);

        if ($id !== null) {
            $product->setModifyAt(new DateTime());
        }

        $this->products->save($product);
        $this->recordHistory($product);

        return $product;
    }

    public function delete(int $id): void
    {
        $product = $this->products->findActive($id);

        if ($product === null) {
            throw new InvalidArgumentException('Product not found.');
        }

        $this->products->softDelete($product);
    }

    public function formOptions(): array
    {
        return [
            'categories' => $this->categories->allActive(),
            'branches' => $this->branches->allActive(),
            'warehouses' => $this->warehouses->allActive(),
            'taxRates' => $this->taxRates->allActive(),
            'types' => [Product::TYPE_KG, Product::TYPE_LITRE, Product::TYPE_QTY],
            'saleOptions' => [Product::FOR_SALE, Product::NOT_FOR_SALE],
            'purchaseOptions' => [Product::FOR_PURCHASE, Product::NOT_FOR_PURCHASE],
        ];
    }

    public function history(): array
    {
        return $this->history->allLatest();
    }

    private function normalizeStock(string $type, string $stock): string
    {
        if (! is_numeric($stock) || (float) $stock < 0) {
            throw new InvalidArgumentException('Stock must be a positive number.');
        }

        if ($type === Product::TYPE_QTY && preg_match('/^\d+$/', $stock) !== 1) {
            throw new InvalidArgumentException('Quantity stock must be a whole number.');
        }

        return number_format((float) $stock, 3, '.', '');
    }

    private function storeImage(?UploadedFile $image): ?string
    {
        if ($image === null || ! $image->isValid() || $image->getSize() === 0) {
            return null;
        }

        $mime = $image->getMimeType();
        $source = match ($mime) {
            'image/jpeg', 'image/jpg' => imagecreatefromjpeg($image->getTempName()),
            'image/png' => imagecreatefrompng($image->getTempName()),
            'image/webp' => imagecreatefromwebp($image->getTempName()),
            default => false,
        };

        if ($source === false) {
            throw new InvalidArgumentException('Product image must be JPG, PNG, or WEBP.');
        }

        $directory = FCPATH . 'uploads/products';
        if (! is_dir($directory)) {
            mkdir($directory, 0775, true);
        }

        $fileName = uniqid('product_', true) . '.webp';
        $target = $directory . DIRECTORY_SEPARATOR . $fileName;
        imagepalettetotruecolor($source);
        imagewebp($source, $target, 85);
        imagedestroy($source);

        return 'uploads/products/' . $fileName;
    }

    private function recordHistory(Product $product): void
    {
        $history = (new ProductUpdateHistory())
            ->setProductId((int) $product->getId())
            ->setProductName($product->getName())
            ->setType($product->getType())
            ->setStock($product->getStock());

        $this->history->save($history);
    }
}
