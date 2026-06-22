<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title mb-0">Expenses List</h3>
		<?php if($_SESSION['auth_user_role']==='SUPER_ADMIN'): ?>
        <a href="<?= url_to('expenses.create') ?>" class="btn btn-primary btn-sm ms-auto">
            <i class="bi bi-plus-circle me-1"></i>Add Expense
        </a>
		<?php elseif (in_array('expenses.create', $userPermissions, true)): ?>
		<a href="<?= url_to('expenses.create') ?>" class="btn btn-primary btn-sm ms-auto">
            <i class="bi bi-plus-circle me-1"></i>Add Expense
        </a>
		<?php endif; ?>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 80px;">ID</th>
                    <th>Label</th> <!-- Fixed: Removed the duplicate "Name" column header -->
					<th>Amount</th>
                    <th>Added At</th>
                    <th class="text-end" style="width: 180px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= esc($item->getId()) ?></td>
                        <td class="fw-semibold"><?= esc($item->getLabel()) ?></td>
						<td class="fw-semibold">
						<span class="fw-bold badge text-bg-info">&#8377;<?= esc(number_format((float)$item->getPrice())) ?></span>
						</td>
                        <td><?= esc($item->getAddedAt()->format('d M Y, h:i A')) ?></td>
                        <td class="text-end">
						<?php if($_SESSION['auth_user_role']==='SUPER_ADMIN'): ?>
                            <a href="<?= url_to('expenses.edit', $item->getId()) ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil"></i></a>
						<?php elseif (in_array('expenses.edit', $userPermissions, true)): ?>
						    <a href="<?= url_to('expenses.edit', $item->getId()) ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil"></i></a>
                        <?php endif;?>
						
						<?php if($_SESSION['auth_user_role']==='SUPER_ADMIN'): ?>
                            <form action="<?= url_to('expenses.delete', $item->getId()) ?>" method="post" class="d-inline" onsubmit="return confirm('Delete this expenses?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </form>
						<?php elseif (in_array('expenses.delete', $userPermissions, true)): ?>
						    <form action="<?= url_to('expenses.delete', $item->getId()) ?>" method="post" class="d-inline" onsubmit="return confirm('Delete this expenses?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </form>
                        <?php endif; ?>
						
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if ($items === []): ?>
                    <tr><td colspan="4" class="text-center text-muted py-4">No expenses found.</td></tr> <!-- Fixed colspan from 5 to 4 -->
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
