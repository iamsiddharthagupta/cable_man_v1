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

          <li class="nav-header">Customer Center</li>

          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                User
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="user_list.php" class="nav-link <?php if($page == 1){ echo 'active'; } ?>">
                  <i class="fas fa-users nav-icon"></i>
                  <p>User List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="user_list_active.php" class="nav-link <?php if($page == 2){ echo 'active'; } ?>">
                  <i class="fas fa-user-check nav-icon"></i>
                  <p>Active List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="user_list_expired.php" class="nav-link <?php if($page == 3){ echo 'active'; } ?>">
                  <i class="fas fa-user-times nav-icon"></i>
                  <p>Expired List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="user_list_unpaid.php" class="nav-link <?php if($page == 4){ echo 'active'; } ?>">
                  <i class="nav-icon fas fa-rupee-sign"></i>
                  <p>Manage Bills</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-header">Control Center</li>
          <li class="nav-item">
            <a href="manage_area.php" class="nav-link <?php if($page == 'manage_area.php'){ echo 'active'; } ?>">
              <i class="nav-icon fas fa-building"></i>
              <p>Manage Area</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="manage_branch.php" class="nav-link <?php if($page == 'manage_branch.php'){ echo 'active'; } ?>">
              <i class="nav-icon fas fa-code-branch"></i>
              <p>Manage Branch</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="manage_staff.php" class="nav-link <?php if($page == 'manage_staff.php'){ echo 'active'; } ?>">
              <i class="nav-icon fas fa-user-check"></i>
              <p>Manage Staff</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="manage_package.php" class="nav-link <?php if($page == 'manage_package.php'){ echo 'active'; } ?>">
              <i class="nav-icon fas fa-box-open"></i>
              <p>Manage Package</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="manage_device.php" class="nav-link <?php if($page == 'manage_device.php'){ echo 'active'; } ?>">
              <i class="nav-icon fas fa-hdd"></i>
              <p>Manage Device</p>
            </a>
          </li>

          <li class="nav-header">Report Center</li>

          <li class="nav-item">
            <a href="report_collection.php" class="nav-link <?php if($page == 'report_collection.php'){ echo 'active'; } ?>">
              <i class="nav-icon fas fa-book"></i>
              <p>Collection Book</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <div class="content-wrapper">