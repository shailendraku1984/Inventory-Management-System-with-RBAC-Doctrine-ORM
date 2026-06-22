<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="row g-3">
    <div class="col-md-4">
        <div class="small-box text-bg-primary">
            <div class="inner">
                <h3>Admin</h3>
                <p><?= esc(session('auth_user_name') ?? 'User') ?></p>
            </div>
            <i class="small-box-icon bi bi-person-check"></i>
            <a href="<?= url_to('admin.profile') ?>" class="small-box-footer">
                View profile <i class="bi bi-arrow-right-circle"></i>
            </a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="small-box text-bg-success">
            <div class="inner">
                <h3>Doctrine</h3>
                <p>ORM authentication active</p>
            </div>
            <i class="small-box-icon bi bi-database-check"></i>
            <a href="<?= url_to('admin.profile') ?>" class="small-box-footer">
                Account summary <i class="bi bi-arrow-right-circle"></i>
            </a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="small-box text-bg-warning">
            <div class="inner">
                <h3>Filter</h3>
                <p>Protected admin routes</p>
            </div>
            <i class="small-box-icon bi bi-shield-lock"></i>
            <form action="<?= url_to('auth.logout') ?>" method="post">
                <?= csrf_field() ?>
                <button type="submit" class="small-box-footer border-0 w-100">
                    Logout <i class="bi bi-arrow-right-circle"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
