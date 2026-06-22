<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title mb-0">Employee List</h3>
		<?php if($_SESSION['auth_user_role']==='SUPER_ADMIN'): ?>
        <a href="<?= url_to('employee.create') ?>" class="btn btn-primary btn-sm ms-auto">
            <i class="bi bi-plus-circle me-1"></i>Add Employee
        </a>
		<?php elseif (in_array('employee.create', $userPermissions, true)): ?>
		<a href="<?= url_to('employee.create') ?>" class="btn btn-primary btn-sm ms-auto">
            <i class="bi bi-plus-circle me-1"></i>Add Employee
        </a>
		<?php endif;?>
		
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 80px;">ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Emp Code</th>
                    <th>Status</th>
                    <th>Added At</th>
                    <th class="text-end" style="width: 180px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <?php $profile = $profiles[(int) $item->getId()] ?? null; ?>
                    <tr>
                        <td><?= esc($item->getId()) ?></td>
                        <td class="fw-semibold"><?= esc($item->getName()) ?></td>
                        <td><?= esc($item->getEmail()) ?></td>
                        <td><?= esc(str_replace('_', ' ', $item->getRoleLabel())) ?></td>
                        <td><?= esc($profile?->getEmpCode() ?? '-') ?></td>
                        <td>
                            <span class="badge text-bg-<?= $item->getIsActive() ? 'success' : 'secondary' ?>">
                                <?= $item->getIsActive() ? 'Active' : 'Inactive' ?>
                            </span>
                        </td>
                        <td><?= esc($item->getCreatedAt()->format('d M Y, h:i A')) ?></td>
                        <td class="text-end">
						
						<?php if($_SESSION['auth_user_role']==='SUPER_ADMIN'): ?>
                            <a href="<?= url_to('employee.profile', $item->getId()) ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-person-lines-fill"></i></a>
						<?php elseif (in_array('employee.profile', $userPermissions, true)): ?>
							<a href="<?= url_to('employee.profile', $item->getId()) ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-person-lines-fill"></i></a>
                        <?php endif;?>
						
						<?php if($_SESSION['auth_user_role']==='SUPER_ADMIN'): ?>
                            <a href="<?= url_to('employee.edit', $item->getId()) ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil"></i></a>
						<?php elseif (in_array('employee.edit', $userPermissions, true)): ?>
						    <a href="<?= url_to('employee.edit', $item->getId()) ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil"></i></a>
						<?php endif;?>
						
						<?php if($_SESSION['auth_user_role']==='SUPER_ADMIN'): ?>
                            <form action="<?= url_to('employee.delete', $item->getId()) ?>" method="post" class="d-inline" onsubmit="return confirm('Delete this employee?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </form>
						<?php elseif (in_array('employee.delete', $userPermissions, true)): ?>
						    <form action="<?= url_to('employee.delete', $item->getId()) ?>" method="post" class="d-inline" onsubmit="return confirm('Delete this employee?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </form>
						<?php endif;?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if ($items === []): ?>
                    <tr><td colspan="8" class="text-center text-muted py-4">No employees found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
