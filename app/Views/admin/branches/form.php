<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php $isEdit = $item !== null; ?>
<div class="card">
    <form action="<?= $isEdit ? url_to('branches.update', $item->getId()) : url_to('branches.store') ?>" method="post">
        <?= csrf_field() ?>
        <div class="card-body">
            <div class="mb-3">
                <label for="name" class="form-label">Branch Name</label>
                <input type="text" name="name" id="name" class="form-control" value="<?= old('name', $isEdit ? $item->getName() : '') ?>" required />
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea name="address" id="address" class="form-control" rows="3" required><?= old('address', $isEdit ? $item->getAddress() : '') ?></textarea>
            </div>
        </div>
        <div class="card-footer d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Save</button>
            <a href="<?= url_to('branches.index') ?>" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
