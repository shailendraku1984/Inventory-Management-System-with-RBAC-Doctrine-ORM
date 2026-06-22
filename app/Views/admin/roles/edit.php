<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-3">
    <h1 class="mb-4"><?= esc($title) ?></h1>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="<?= url_to('roles.update', $role['id']); ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-4">
                    <label class="form-label fw-bold text-secondary">Role Name</label>
                    <input type="text" class="form-control bg-light" value="<?= esc($role['name']) ?>" readonly>
                </div>

                <h5 class="mb-3 border-bottom pb-2 text-primary fw-bold">Select Active Permissions</h5>
                
                <div class="row g-3">
                    <?php foreach ($allPermissions as $per): ?>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-check form-switch p-2 border rounded bg-light-subtle ps-5">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="permissions[]" 
                                       value="<?= $per['id'] ?>" 
                                       id="per_<?= $per['id'] ?>"
                                       <?= in_array($per['id'], $activePermissionIds) ? 'checked' : '' ?>>
                                <label class="form-check-label fw-semibold text-dark small ms-2" for="per_<?= $per['id'] ?>">
                                    <?= esc($per['name']) ?>
                                </label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-success px-4 rounded-1">Save Rules</button>
                    <a href="<?= url_to('roles.index'); ?>" class="btn btn-outline-secondary px-4 rounded-1 ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
