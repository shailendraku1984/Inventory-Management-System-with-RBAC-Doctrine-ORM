<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <title><?= esc($title ?? 'Admin Login') ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="<?= base_url('adminlte/css/adminlte.css') ?>" />
    <style>
        .login-page { min-height: 100vh; }
        .login-box { width: min(420px, calc(100vw - 2rem)); }
        .login-card-body { border-top: 4px solid var(--bs-primary); }
    </style>
</head>
<body class="login-page bg-body-secondary">
<div class="login-box">
    <div class="login-logo">
        <a href="<?= url_to('auth.login') ?>"><b>Order</b>Doctrine</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body login-card-body">
            <p class="login-box-msg mb-4">Sign in to your admin account</p>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success" role="alert">
                    <i class="bi bi-check-circle me-2"></i><?= esc(session()->getFlashdata('success')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i><?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <form action="<?= url_to('auth.login.attempt') ?>" method="post" autocomplete="off">
                <?= csrf_field() ?>
                <div class="input-group mb-3">
                    <input
                        type="email"
                        name="email"
                        value="<?= old('email') ?>"
                        class="form-control"
                        placeholder="Email"
                        required
                        autofocus
                    />
                    <div class="input-group-text">
                        <span class="bi bi-envelope"></span>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Password"
                        required
                    />
                    <div class="input-group-text">
                        <span class="bi bi-lock-fill"></span>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Sign In
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('adminlte/js/adminlte.js') ?>"></script>
</body>
</html>
