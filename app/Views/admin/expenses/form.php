<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php $isEdit = $item !== null; ?>
<div class="card">
    <form action="<?= $isEdit ? url_to('expenses.update', $item->getId()) : url_to('expenses.store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="headId" class="form-label">Head</label>
                    <select name="headId" id="headId" class="form-select" required>
                        <?php foreach ($options as $head): ?>
                            <option value="<?= esc($head->getId()) ?>" <?= esc(old('headId', $isEdit ? $item->getHeadId() : '')) === $head->getId() ? 'selected' : '' ?>>
                                <?= esc(strtoupper($head->getLabel())) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
				
				
				<div class="col-md-4">
                    <label for="departmentId" class="form-label">Department</label>
                    <select name="departmentId" id="departmentId" class="form-select" required>
                        <?php foreach ($depart as $dep): ?>
                            <option value="<?= esc($dep->getId()) ?>" <?= esc(old('departmentId', $isEdit ? $item->getDepartmentId() : '')) === $dep->getId() ? 'selected' : '' ?>>
                                <?= esc(strtoupper($dep->getLabel())) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
				
				
				<div class="col-md-4">
                    <label for="accountId" class="form-label">Account</label>
                    <select name="accountId" id="accountId" class="form-select" required>
                        <?php foreach ($account as $accounts): ?>
                            <option value="<?= esc($accounts->getId()) ?>" <?= esc(old('accountId', $isEdit ? $item->getAccountId() : '')) === $accounts->getId() ? 'selected' : '' ?>>
                                <?= esc(strtoupper($accounts->getLabel())) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
				
				 
				<div class="col-md-3">
					<label for="valueDate" class="form-label">Select Date</label>
					<div class="input-group">
						<span class="input-group-text">
							<i class="bi bi-calendar-event"></i>
						</span>
						 
						 
						<input type="date" class="form-control" name="value_date" id="value_date" value="<?= esc(old('value_date', (isset($item) && $item->getValueDate()) ? $item->getValueDate()->format('Y-m-d') : '')) ?>" required />


					</div>
				</div>
				
				
				
                <div class="col-md-3">
                    <label for="label" class="form-label">Label</label>
                    <input type="text" name="label" id="label" class="form-control" value="<?= esc(old('label', $isEdit ? $item->getLabel() : '')) ?>" required />
                </div>
				
				
				<div class="col-md-3">
                    <label for="price" class="form-label">Amount</label>
                    <input type="text" name="price" id="price" class="form-control" value="<?= esc(old('price', $isEdit ? $item->getPrice() : '')) ?>" required />
                </div>
				
				<div class="col-md-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/png,image/jpeg,image/webp" />
                </div>
                 
				 
				
 
                <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3"><?= esc(old('description', $isEdit ? $item->getDescription() : '')) ?></textarea>
                </div>
				
				 <!-- Check if $item exists and has an image BEFORE trying to call get() methods -->
				<?php if (isset($item) && $item && $item->getImage() && file_exists(FCPATH . 'uploads/expenses/' . $item->getImage())): ?>
					<img src="<?= base_url('uploads/expenses/' . esc($item->getImage())) ?>" 
						 alt="Expense Receipt" 
						 class="rounded border" 
						 style="width: 96px; height: 96px; object-fit: cover;" />
				<?php else: ?>
					<!-- Display this clean placeholder when creating a new expense -->
					<div class="rounded border bg-light d-flex align-items-center justify-content-center text-muted" 
						 style="width: 96px; height: 96px; font-size: 12px;">
						No Image
					</div>
				<?php endif; ?>

				
            </div>
        </div>
        <div class="card-footer d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Save</button>
            <a href="<?= url_to('expenses.index') ?>" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
