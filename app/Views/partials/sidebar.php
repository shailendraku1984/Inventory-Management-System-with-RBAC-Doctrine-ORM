<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="<?= url_to('admin.dashboard') ?>" class="brand-link">
            <img src="<?= base_url('adminlte/assets/img/AdminLTELogo.png') ?>" alt="AdminLTE" class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">Order Doctrine</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
			
		    <li class="nav-item <?= ($menuSelection['tabname'] === 'Settings') ? 'menu-open' : '' ?>">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-gear"></i>
                  <p>
                    Settings
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= url_to('admin.dashboard') ?>" class="nav-link <?php echo ($menuSelection['action'] === 'admin.dashboard') ? 'active' : ''; ?>">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
					
                  </li>
                  <li class="nav-item">
                    <a href="<?= url_to('admin.profile') ?>" class="nav-link <?php echo ($menuSelection['action'] === 'admin.profile') ? 'active' : ''; ?>">
                        <i class="nav-icon bi bi-person-badge"></i>
                        <p>Profile</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <form action="<?= url_to('auth.logout') ?>" method="post" class="px-3 py-2">
                        <?= csrf_field() ?>
                        <button type="submit" class="nav-link">
                            <i class="bi bi-box-arrow-left me-2"></i>Logout
                        </button>
                    </form>
                  </li>
                </ul>
              </li>
			  
              <li class="nav-item <?= ($menuSelection['tabname'] === 'INVENTORY') ? 'menu-open' : '' ?>">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-box-seam"></i>
                  <p>
                    INVENTORY
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="<?= url_to('categories.index') ?>" class="nav-link <?php echo ($menuSelection['action'] === 'categories.index') ? 'active' : ''; ?>">
							<i class="nav-icon bi bi-tags"></i>
							<p>Categories</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= url_to('products.index') ?>" class="nav-link <?php echo ($menuSelection['action'] === 'products.index') ? 'active' : ''; ?>">
							<i class="nav-icon bi bi-box-seam"></i>
							<p>Products</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= url_to('branches.index') ?>" class="nav-link <?php echo ($menuSelection['action'] === 'branches.index') ? 'active' : ''; ?>">
							<i class="nav-icon bi bi-diagram-3"></i>
							<p>Branches</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= url_to('warehouses.index') ?>" class="nav-link <?php echo ($menuSelection['action'] === 'warehouses.index') ? 'active' : ''; ?>">
							<i class="nav-icon bi bi-buildings"></i>
							<p>Stores</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= url_to('product-history.index') ?>" class="nav-link <?php echo ($menuSelection['action'] === 'product-history.index') ? 'active' : ''; ?>">
							<i class="nav-icon bi bi-clock-history"></i>
							<p>Product History</p>
						</a>
					</li>
				  </ul>
                </li>

                <li class="nav-item <?= ($menuSelection['tabname'] === 'RBCA') ? 'menu-open' : '' ?>">
					<a href="#" class="nav-link">
					  <i class="nav-icon bi bi-diagram-3"></i>
					  <p>
						RBCA & ACL CONFIG
						<i class="nav-arrow bi bi-chevron-right"></i>
					  </p>
					</a>
					<ul class="nav nav-treeview"> 				
				 
					<li class="nav-item">
						<a href="<?= url_to('roles.index') ?>" class="nav-link <?php echo ($menuSelection['action'] === 'roles.index') ? 'active' : ''; ?>">
							<i class="nav-icon bi bi-key"></i>
							<p>Roles</p>
							<a href="<?= url_to('employee.index') ?>" class="nav-link <?php echo ($menuSelection['action'] === 'employee.index') ? 'active' : ''; ?>">
							<i class="nav-icon bi bi-people"></i>
							<p>Users</p>
							
						</a>
					</li>
				  </ul>
				</li>
				
				 
                 
				
            </ul>
        </nav>
    </div>
</aside>
