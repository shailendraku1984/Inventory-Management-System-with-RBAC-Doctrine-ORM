<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title mb-0">Product Update History</h3>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 80px;">ID</th>
                    <th>Product Name</th>
                    <th>Type</th>
                    <th>Stock</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($history as $row): ?>
                    <tr>
                        <td><?= esc($row->getId()) ?></td>
                        <td class="fw-semibold"><?= esc($row->getProductName()) ?></td>
                        <td><span class="badge text-bg-info"><?= esc($row->getType()) ?></span></td>
                        <td><?= esc($row->getStock()) ?></td>
                        <td><?= esc($row->getAddedAt()->format('d M Y, h:i A')) ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if ($history === []): ?>
                    <tr><td colspan="5" class="text-center text-muted py-4">No product history found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
