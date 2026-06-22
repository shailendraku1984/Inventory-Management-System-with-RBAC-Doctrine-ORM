<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <?php if ($profile?->getPicture()): ?>
                    <img src="<?= base_url($profile->getPicture()) ?>" alt="<?= esc($item->getName()) ?>" class="rounded-circle border mb-3" style="width: 128px; height: 128px; object-fit: cover;" />
                <?php else: ?>
                    <div class="rounded-circle border bg-body-secondary d-inline-flex align-items-center justify-content-center mb-3" style="width: 128px; height: 128px;">
                        <i class="bi bi-person fs-1 text-secondary"></i>
                    </div>
                <?php endif; ?>
                <h4 class="mb-1"><?= esc($item->getName()) ?></h4>
                <div class="text-muted"><?= esc($item->getEmail()) ?></div>
                <span class="badge text-bg-primary mt-3"><?= esc(str_replace('_', ' ', $item->getRoleLabel())) ?></span>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h3 class="card-title mb-0">Profile Details</h3>
                <a href="<?= url_to('employee.edit', $item->getId()) ?>" class="btn btn-outline-primary btn-sm ms-auto">
                    <i class="bi bi-pencil me-1"></i>Edit
                </a>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="text-muted small">Employee Code</div>
                        <div class="fw-semibold"><?= esc($profile?->getEmpCode() ?? '-') ?></div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small">Salary</div>
                        <div class="fw-semibold"><?= $profile?->getSalary() ? esc(number_format((float) $profile->getSalary(), 2)) : '-' ?></div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small">Status</div>
                        <div class="fw-semibold"><?= $item->getIsActive() ? 'Active' : 'Inactive' ?></div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small">Joined</div>
                        <div class="fw-semibold"><?= esc($item->getCreatedAt()->format('d M Y, h:i A')) ?></div>
                    </div>
                    <div class="col-12">
                        <div class="text-muted small">Address</div>
                        <div class="fw-semibold"><?= esc($profile?->getAddress() ?? '-') ?></div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="<?= url_to('employee.index') ?>" class="btn btn-outline-secondary">Back</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
