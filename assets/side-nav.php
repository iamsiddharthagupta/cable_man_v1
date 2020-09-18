  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link">
      <img src="common/logo.png" alt="Endeavour Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Endeavour Tech.</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="common/avatar.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="change_pass.php" class="d-block"><?php echo $curr_user; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-header">User Management</li>

          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon nav-icon fas fa-user-edit"></i>
              <p>
                Manage Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="add_user.php" class="nav-link">
                  <i class="fas fa-user-plus nav-icon"></i>
                  <p>Add User</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="device_entry.php" class="nav-link">
                  <i class="fas fa-hdd nav-icon"></i>
                  <p>Manage Device</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-header">Filter Users</li>

          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon nav-icon fas fa-users"></i>
              <p>
                Filter Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="user_list.php?query=<?php echo UserList(); ?>" class="nav-link">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>User List</p>
                  <span class="right badge badge-danger"><?php echo CountUser(); ?></span>
                </a>
              </li>
              <li class="nav-item">
                <a href="active_list.php?query=<?php echo ActiveList('ac'); ?>" class="nav-link">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>Active/Expired List</p>
                  <span class="right badge badge-danger"><?php echo CountActiveDevice(date('Y-m-d')); ?></span>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-header">Payments</li>

          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-rupee-sign"></i>
              <p>
                Manage Payments
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="payment_list.php?query=<?php echo OverdueList('Renewed'); ?>" class="nav-link">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>Overdue List</p>
                  <span class="right badge badge-danger"><?php echo CountUnpaid(); ?></span>
                </a>
              </li>
              <li class="nav-item">
                <a href="payment_list.php?query=<?php echo PaidList('Paid'); ?>" class="nav-link">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>Paid List</p>
                  <span class="right badge badge-danger"><?php echo CountPaid(); ?></span>
                </a>
              </li>
              <li class="nav-item">
                <a href="payment_list.php?query=<?php echo SchemeList('Paid'); ?>" class="nav-link">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>Scheme List</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-header">Reports</li>

          <li class="nav-item">
            <a href="collection_book.php" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>Collection Book</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="setting.php" class="nav-link">
              <i class="nav-icon fas fa-user-cog"></i>
              <p>Settings</p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">