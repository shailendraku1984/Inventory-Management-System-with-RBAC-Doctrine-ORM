<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="card border-0 shadow-sm">
    <!-- Clean, tinted structural heading container -->
    <div class="card-header bg-light-subtle py-3 border-bottom border-light-dark">
        <h5 class="card-title mb-0 fw-bold text-dark d-flex align-items-center">
            <i class="bi bi-shield-lock me-2 text-primary"></i> Role-Based Access Control
        </h5>
    </div>
    <div class="card-body p-0">
        <table class="table align-middle">
            <thead class="table-light text-uppercase small text-secondary border-bottom border-2">
				<tr>
					<th class="ps-4 py-3" style="letter-spacing: 0.5px; font-weight: 700;">Role Name</th>
					<th class="py-3" style="letter-spacing: 0.5px; font-weight: 700;">Assigned Permissions</th>
					<th class="pe-4 py-3 text-end" style="letter-spacing: 0.5px; font-weight: 700;">Action</th>
				</tr>
			</thead>

            <tbody>
			
                <?php if (!empty($items)): ?>
                    <?php foreach ($items as $item): 
					  
					?>
                        <tr>
                             
                            <td class="fw-semibold text-capitalize"><?= esc($item['name']); ?></td>
							<td class="w-50">
								<?php if (!empty($item['permissions_string'])): ?>
									<?= $item['permissions_string'] ?>
								<?php else: ?>
									<span class="text-muted small italic-style"><i class="bi bi-shield-x me-1"></i>No permissions assigned</span>
								<?php endif; ?>
							</td>
							
                             
                            <td class="text-end">
							<?php if($_SESSION['auth_user_role']==='SUPER_ADMIN'): ?> 
							<a href="<?= url_to('roles.edit', $item['id']); ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-pencil"></i>
                            </a>
							 
							<?php elseif (in_array('roles.edit', $userPermissions, true)): ?>
                                <a href="<?= url_to('roles.edit', $item['id']); ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            <?php endif; ?>
							 
							
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">No roles found in system configuration.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
