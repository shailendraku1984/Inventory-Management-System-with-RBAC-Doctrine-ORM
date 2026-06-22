<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php $isEdit = $product !== null; ?>
<div class="card">
    <form action="<?= $isEdit ? url_to('products.update', $product->getId()) : url_to('products.store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="type" class="form-label">Type</label>
                    <select name="type" id="type" class="form-select" required>
                        <?php foreach ($options['types'] as $type): ?>
                            <option value="<?= esc($type) ?>" <?= old('type', $isEdit ? $product->getType() : 'qty') === $type ? 'selected' : '' ?>>
                                <?= esc(strtoupper($type)) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?= old('name', $isEdit ? $product->getName() : '') ?>" required />
                </div>
                <div class="col-md-4">
                    <label for="sku" class="form-label">SKU</label>
                    <input type="text" name="sku" id="sku" class="form-control" value="<?= old('sku', $isEdit ? $product->getSku() : '') ?>" required />
                </div>

                <div class="col-md-4">
                    <label for="categoryId" class="form-label">Category</label>
                    <select name="categoryId" id="categoryId" class="form-select" required>
                        <option value="">Select category</option>
                        <?php foreach ($options['categories'] as $category): ?>
                            <option value="<?= esc($category->getId()) ?>" <?= (int) old('categoryId', $isEdit ? $product->getCategoryId() : 0) === (int) $category->getId() ? 'selected' : '' ?>>
                                <?= esc($category->getName()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="branchId" class="form-label">Branch</label>
                    <select name="branchId" id="branchId" class="form-select" required>
                        <option value="">Select branch</option>
                        <?php foreach ($options['branches'] as $branch): ?>
                            <option value="<?= esc($branch->getId()) ?>" <?= (int) old('branchId', $isEdit ? $product->getBranchId() : 0) === (int) $branch->getId() ? 'selected' : '' ?>>
                                <?= esc($branch->getName()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="warehouseId" class="form-label">Store</label>
                    <select name="warehouseId" id="warehouseId" class="form-select" required>
                        <option value="">Select Store</option>
                        <?php foreach ($options['warehouses'] as $warehouse): ?>
                            <option value="<?= esc($warehouse->getId()) ?>" <?= (int) old('warehouseId', $isEdit ? $product->getWarehouseId() : 0) === (int) $warehouse->getId() ? 'selected' : '' ?>>
                                <?= esc($warehouse->getName()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" name="stock" id="stock" class="form-control" value="<?= old('stock', $isEdit ? $product->getStock() : '0') ?>" min="0" step="0.001" required />
                </div>
                <div class="col-md-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" name="price" id="price" class="form-control" value="<?= old('price', $isEdit ? $product->getPrice() : '0.00') ?>" min="0" step="0.01" required />
                </div>
                <div class="col-md-3">
                    <label for="tax_rate_id" class="form-label">Tax Rate</label>
                    <select name="tax_rate_id" id="tax_rate_id" class="form-select" required>
                        <?php foreach ($options['taxRates'] as $taxRate): ?>
                            <option value="<?= esc($taxRate->getId()) ?>" <?= (int) old('tax_rate_id', $isEdit ? $product->getTaxRateId() : 0) === (int) $taxRate->getId() ? 'selected' : '' ?>>
                                <?= esc($taxRate->getLabel()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/png,image/jpeg,image/webp" />
                </div>

                <div class="col-md-6">
                    <label for="for_sale" class="form-label">Sale Status</label>
                    <select name="for_sale" id="for_sale" class="form-select" required>
                        <?php foreach ($options['saleOptions'] as $option): ?>
                            <option value="<?= esc($option) ?>" <?= old('for_sale', $isEdit ? $product->getForSale() : 'For sale') === $option ? 'selected' : '' ?>><?= esc($option) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="for_purchase" class="form-label">Purchase Status</label>
                    <select name="for_purchase" id="for_purchase" class="form-select" required>
                        <?php foreach ($options['purchaseOptions'] as $option): ?>
                            <option value="<?= esc($option) ?>" <?= old('for_purchase', $isEdit ? $product->getForPurchase() : 'For purchase') === $option ? 'selected' : '' ?>><?= esc($option) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3"><?= old('description', $isEdit ? $product->getDescription() : '') ?></textarea>
                </div>
                <div class="col-md-6">
                    <label for="meta_keyword" class="form-label">Meta Keyword</label>
                    <input type="text" name="meta_keyword" id="meta_keyword" class="form-control" value="<?= old('meta_keyword', $isEdit ? $product->getMetaKeyword() : '') ?>" />
                </div>
                <div class="col-md-6">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <input type="text" name="meta_description" id="meta_description" class="form-control" value="<?= old('meta_description', $isEdit ? $product->getMetaDescription() : '') ?>" />
                </div>

                <?php if ($isEdit && $product->getImage()): ?>
                    <div class="col-12">
                        <img src="<?= base_url($product->getImage()) ?>" alt="<?= esc($product->getName()) ?>" class="rounded border" style="width: 96px; height: 96px; object-fit: cover;" />
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="card-footer d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Save</button>
            <a href="<?= url_to('products.index') ?>" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
