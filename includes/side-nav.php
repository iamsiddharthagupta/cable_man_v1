  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="dashboard.php" class="brand-link">
      <img src="assets/images/logo.png" alt="Endeavour Logo" class="brand-image img-circle elevation-3">
      <span class="brand-text font-weight-light">Endeavour Tech.</span>
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="assets/images/avatar.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="staff_password_change.php" class="d-block"><?php echo $curr_user; ?></a>
        </div>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-header">User Center</li>
          <li class="nav-item menu-open">
            <a href="#" class="nav-link <?php if($page == 1){ echo 'active'; } ?>">
              <i class="nav-icon fas fa-user"></i>
              <p>
                User
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="user_profile_add.php" class="nav-link <?php if($page == 3.1){ echo 'active'; } ?>">
                  <i class="fas fa-user-plus nav-icon"></i>
                  <p>Add User</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="user_list.php" class="nav-link <?php if($page == 3.2){ echo 'active'; } ?>">
                  <i class="fas fa-users nav-icon"></i>
                  <p>Users</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-header">Control Center</li>
            <li class="nav-item">
              <a href="area_list.php" class="nav-link <?php if($page == 1.1){ echo 'active'; } ?>">
                <i class="nav-icon fas fa-building"></i>
                <p>Manage Area</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="franchise_list.php" class="nav-link <?php if($page == 1.2){ echo 'active'; } ?>">
                <i class="nav-icon fas fa-store"></i>
                <p>Manage Franchise</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="staff_list.php" class="nav-link <?php if($page == 1.3){ echo 'active'; } ?>">
                <i class="nav-icon fas fa-user-check"></i>
                <p>Manage Staff</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="package_list.php" class="nav-link <?php if($page == 1.4){ echo 'active'; } ?>">
                <i class="nav-icon fas fa-box-open"></i>
                <p>Manage Package</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="device_list.php" class="nav-link <?php if($page == 1.5){ echo 'active'; } ?>">
                <i class="nav-icon fas fa-hdd"></i>
                <p>Manage Device</p>
              </a>
            </li>

          <li class="nav-header">Report Center</li>
            <li class="nav-item">
              <a href="report_collection.php" class="nav-link <?php if($page == 2.1){ echo 'active'; } ?>">
                <i class="nav-icon fas fa-book"></i>
                <p>Collection Book</p>
              </a>
            </li>
        </ul>
      </nav>
    </div>
  </aside>

  <div class="content-wrapper">