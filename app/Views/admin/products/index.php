<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php
$categoryNames = [];
foreach ($options['categories'] as $category) {
    $categoryNames[$category->getId()] = $category->getName();
}
$branchNames = [];
foreach ($options['branches'] as $branch) {
    $branchNames[$branch->getId()] = $branch->getName();
}
$warehouseNames = [];
foreach ($options['warehouses'] as $warehouse) {
    $warehouseNames[$warehouse->getId()] = $warehouse->getName();
}
$taxLabels = [];
foreach ($options['taxRates'] as $taxRate) {
    $taxLabels[$taxRate->getId()] = $taxRate->getLabel();
}
?>
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title mb-0">Product List</h3>
		<?php if($_SESSION['auth_user_role']==='SUPER_ADMIN'): ?>
        <a href="<?= url_to('products.create') ?>" class="btn btn-primary btn-sm ms-auto">
            <i class="bi bi-plus-circle me-1"></i>Add Product
        </a>
		<?php elseif (in_array('products.create', $userPermissions, true)): ?>
		<a href="<?= url_to('products.create') ?>" class="btn btn-primary btn-sm ms-auto">
            <i class="bi bi-plus-circle me-1"></i>Add Product
        </a>
		<?php endif; ?>
		
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 72px;">Image</th>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Type</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Branch</th>
                    <th>Store</th>
                    <th>Tax</th>
                    <th class="text-end" style="width: 180px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td>
                            <?php if ($product->getImage()): ?>
                                <img src="<?= base_url($product->getImage()) ?>" alt="<?= esc($product->getName()) ?>" class="rounded" style="width: 48px; height: 48px; object-fit: cover;" />
                            <?php else: ?>
                                <span class="btn btn-light btn-sm disabled"><i class="bi bi-image"></i></span>
                            <?php endif; ?>
                        </td>
                        <td class="fw-semibold"><?= esc($product->getName()) ?></td>
                        <td><?= esc($product->getSku()) ?></td>
                        <td><span class="badge text-bg-info"><?= esc($product->getType()) ?></span></td>
                        <td><?= esc($product->getStock()) ?></td>
                        <td><?= esc($product->getPrice()) ?></td>
                        <td><?= esc($categoryNames[$product->getCategoryId()] ?? '-') ?></td>
                        <td><?= esc($branchNames[$product->getBranchId()] ?? '-') ?></td>
                        <td><?= esc($warehouseNames[$product->getWarehouseId()] ?? '-') ?></td>
                        <td><?= esc($taxLabels[$product->getTaxRateId()] ?? '-') ?></td>
                        <td class="text-end">
						
						<?php if($_SESSION['auth_user_role']==='SUPER_ADMIN'): ?>
                            <a href="<?= url_to('products.edit', $product->getId()) ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil"></i></a>
						<?php elseif (in_array('products.edit', $userPermissions, true)): ?>
						    <a href="<?= url_to('products.edit', $product->getId()) ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil"></i></a>
                        <?php endif; ?> 			
						
						<?php if($_SESSION['auth_user_role']==='SUPER_ADMIN'): ?>
                            <form action="<?= url_to('products.delete', $product->getId()) ?>" method="post" class="d-inline" onsubmit="return confirm('Delete this product?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </form>
						<?php elseif (in_array('products.delete', $userPermissions, true)): ?>
						    <form action="<?= url_to('products.delete', $product->getId()) ?>" method="post" class="d-inline" onsubmit="return confirm('Delete this product?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </form>
                        <?php endif;?> 						
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if ($products === []): ?>
                    <tr><td colspan="11" class="text-center text-muted py-4">No products found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
