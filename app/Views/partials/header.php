<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="<?= url_to('admin.dashboard') ?>" class="nav-link">Dashboard</a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="<?= url_to('admin.profile') ?>" class="nav-link">Profile</a>
            </li>
        </ul>
		
          
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="<?= base_url($_SESSION['picture']) ?>" class="user-image rounded-circle shadow" alt="Admin user" />
                    <span class="d-none d-md-inline"><?= esc(session('auth_user_name') ?? 'Admin') ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header text-bg-primary">
                        <img src="<?= base_url($_SESSION['picture']) ?>" class="rounded-circle shadow" alt="Admin user" />
                        <p>
                            <?= esc(session('auth_user_name') ?? 'Admin') ?>
                            <small><?= esc(session('auth_user_email') ?? '') ?></small>
                        </p>
                    </li>
                    <li class="user-footer">
                        <a href="<?= url_to('admin.profile') ?>" class="btn btn-default btn-flat">Profile</a>
                        <form action="<?= url_to('auth.logout') ?>" method="post" class="d-inline">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-default btn-flat float-end">Sign out</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
