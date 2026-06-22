<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php
$isEdit = $item !== null;
$selectedRole = old('role', $isEdit ? $item->getRole() : '4');
$selectedBranch = (int) old('branch_id', $isEdit ? ($item->getBranchId() ?? 0) : 0);
?>
<div class="card">
    <form action="<?= $isEdit ? url_to('employee.update', $item->getId()) : url_to('employee.store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Employee Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?= old('name', $isEdit ? $item->getName() : '') ?>" required />
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?= old('email', $isEdit ? $item->getEmail() : '') ?>" required />
                </div>

                <div class="col-md-4">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="role" class="form-select" required>
                        <?php foreach ($options['roles'] as $role): ?>
                            <option value="<?= esc($role->getId()) ?>" <?= (string) $selectedRole === (string) $role->getId() ? 'selected' : '' ?>>
                                <?= esc(str_replace('_', ' ', $role->getName())) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4 employee-only">
                    <label for="branch_id" class="form-label">Branch</label>
                    <select name="branch_id" id="branch_id" class="form-select">
                        <option value="">Select branch</option>
                        <?php foreach ($options['branches'] as $branch): ?>
                            <option value="<?= esc($branch->getId()) ?>" <?= $selectedBranch === (int) $branch->getId() ? 'selected' : '' ?>>
                                <?= esc($branch->getName()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="is_active" class="form-label">Status</label>
                    <select name="is_active" id="is_active" class="form-select">
                        <option value="1" <?= (int) old('is_active', $isEdit ? (int) $item->getIsActive() : 1) === 1 ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= (int) old('is_active', $isEdit ? (int) $item->getIsActive() : 1) === 0 ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" <?= $isEdit ? '' : 'required' ?> autocomplete="new-password" />
                </div>

                <div class="col-md-6">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" <?= $isEdit ? '' : 'required' ?> autocomplete="new-password" />
                </div>

                <div class="col-md-4 employee-only">
                    <label for="emp_code" class="form-label">Employee Code</label>
                    <input type="text" name="emp_code" id="emp_code" class="form-control" value="<?= old('emp_code', $profile?->getEmpCode() ?? '') ?>" />
                </div>

                <div class="col-md-4 employee-only">
                    <label for="salary" class="form-label">Salary</label>
                    <input type="number" name="salary" id="salary" class="form-control" value="<?= old('salary', $profile?->getSalary() ?? '') ?>" min="0" step="0.01" />
                </div>

                <div class="col-md-4">
                    <label for="picture" class="form-label">Profile Picture</label>
                    <input type="file" name="picture" id="picture" class="form-control" accept="image/png,image/jpeg,image/gif,image/webp" />
                </div>

                <div class="col-12">
                    <label for="address" class="form-label">Address</label>
                    <textarea name="address" id="address" class="form-control" rows="3"><?= old('address', $profile?->getAddress() ?? '') ?></textarea>
                </div>

                <?php if ($isEdit && $profile?->getPicture()): ?>
                    <div class="col-12">
                        <img src="<?= base_url($profile->getPicture()) ?>" alt="<?= esc($item->getName()) ?>" class="rounded border" style="width: 96px; height: 96px; object-fit: cover;" />
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="card-footer d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Save</button>
            <a href="<?= url_to('employee.index') ?>" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
    const role = document.getElementById('role');
    const employeeFields = document.querySelectorAll('.employee-only');

    function syncEmployeeFields() {
        const isEmployee = role.value === '3';
        employeeFields.forEach((field) => field.classList.toggle('d-none', !isEmployee));
        document.getElementById('branch_id').required = isEmployee;
        document.getElementById('salary').required = isEmployee;
    }

    role.addEventListener('change', syncEmployeeFields);
    syncEmployeeFields();
</script>
<?= $this->endSection() ?>
