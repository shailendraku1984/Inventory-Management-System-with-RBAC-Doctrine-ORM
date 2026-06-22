<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile text-center">
                <form
                    id="profile-picture-form"
                    action="<?= url_to('admin.profile.picture') ?>"
                    method="post"
                    enctype="multipart/form-data"
                    class="d-inline-block position-relative"
                >
                    <?= csrf_field() ?>
                    <input
                        type="file"
                        name="picture"
                        id="profile-picture-input"
                        class="d-none"
                        accept="image/png,image/jpeg,image/jpg,image/gif,image/webp"
                    />
                    <label for="profile-picture-input" class="profile-picture-label mb-3 d-inline-block" title="Click to change profile picture" style="cursor: pointer;">
                        <img
                            class="profile-user-img img-fluid img-circle"
                            src="<?= base_url(session('picture') ?? 'uploads/user_profiles/default.png') ?>"
                            alt="Admin profile"
                        />
                        <span class="profile-picture-overlay position-absolute top-50 start-50 translate-middle text-white small fw-semibold">
                            <i class="bi bi-camera"></i> Change
                        </span>
                    </label>
                </form>
                <h3 class="profile-username text-center mb-1"><?= esc($user->getName()) ?></h3>
                <p class="text-muted text-center mb-3"><?php //echo esc($user->getRole()) ?>&nbsp;</p>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success py-2 small"><?= esc(session()->getFlashdata('success')) ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger py-2 small"><?= esc(session()->getFlashdata('error')) ?></div>
                <?php endif; ?>

                <div class="d-grid gap-2">
                    <a href="mailto:<?= esc($user->getEmail()) ?>" class="btn btn-primary">
                        <i class="bi bi-envelope me-1"></i><?= esc($user->getEmail()) ?>
                    </a>
                    <form action="<?= url_to('auth.logout') ?>" method="post">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-box-arrow-right me-1"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title mb-0">Account Summary</h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="profile-stat p-3 bg-body-tertiary">
                            <div class="text-muted small">Name</div>
                            <div class="fw-semibold"><?= esc($user->getName()) ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-stat p-3 bg-body-tertiary">
                            <div class="text-muted small">Email</div>
                            <div class="fw-semibold"><?= esc($user->getEmail()) ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-stat p-3 bg-body-tertiary">
                            <div class="text-muted small">Status</div>
                            <div class="fw-semibold">
                                <span class="badge text-bg-success">Active</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-stat p-3 bg-body-tertiary">
                            <div class="text-muted small">Last Login</div>
                            <div class="fw-semibold">
                                <?= $user->getLastLogin() ? esc($user->getLastLogin()->format('d M Y, h:i A')) : 'First login' ?>
                            </div>
                        </div>
                    </div>
                </div>

                <hr />

                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="mb-1">Admin session is protected</h5>
                        <p class="text-muted mb-0">This page is only available through the auth filter.</p>
                    </div>
                    <a href="<?= url_to('admin.dashboard') ?>" class="btn btn-outline-primary">
                        <i class="bi bi-speedometer2 me-1"></i>Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-picture-label {
        position: relative;
    }
    .profile-picture-label .profile-user-img {
        transition: opacity 0.2s ease;
    }
    .profile-picture-overlay {
        opacity: 0;
        pointer-events: none;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.8);
    }
    .profile-picture-label:hover .profile-user-img {
        opacity: 0.75;
    }
    .profile-picture-label:hover .profile-picture-overlay {
        opacity: 1;
    }
</style>

<script>
    document.getElementById('profile-picture-input').addEventListener('change', function () {
        if (this.files && this.files.length > 0) {
            document.getElementById('profile-picture-form').submit();
        }
    });
</script>
<?= $this->endSection() ?>
