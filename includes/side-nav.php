<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link">
      <img src="assets/images/logo.png" alt="Endeavour Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Endeavour Tech.</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="assets/images/avatar.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="admin_change_pass.php" class="d-block"><?php echo $curr_user; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <li class="nav-header">User Management</li>

          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon nav-icon fas fa-users"></i>
              <p>
                Manage Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="user_list.php" class="nav-link <?php if($page == 'user_list.php'){ echo 'active'; } ?>">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>User List</p>
                  <span class="right badge badge-danger"><?php echo mysqli_num_rows($user->user_list()); ?></span>
                </a>
              </li>
              <li class="nav-item">
                <a href="user_list_disconnect.php" class="nav-link <?php if($page == 'user_list_disconnect.php'){ echo 'active'; } ?>">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>Disconnected List</p>
                  <span class="right badge badge-danger"><?php echo mysqli_num_rows($user->user_list_disconnect()); ?></span>
                </a>
              </li>
              <li class="nav-item">
                <a href="user_list_active.php" class="nav-link <?php if($page == 'user_list_active.php'){ echo 'active'; } ?>">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>Active List</p>
                  <span class="right badge badge-danger"><?php echo mysqli_num_rows($user->user_list_active()); ?></span>
                </a>
              </li>
              <li class="nav-item">
                <a href="user_list_expired.php" class="nav-link <?php if($page == 'user_list_expired.php'){ echo 'active'; } ?>">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>Expired List</p>
                  <span class="right badge badge-danger"><?php echo mysqli_num_rows($user->user_list_expired()); ?></span>
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
                <a href="user_list_unpaid.php" class="nav-link <?php if($page == 'user_list_unpaid.php'){ echo 'active'; } ?>">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>Overdue List</p>
                  <span class="right badge badge-danger"><?php echo mysqli_num_rows($user->user_list_unpaid()); ?></span>
                </a>
              </li>
              <li class="nav-item">
                <a href="user_list_scheme.php" class="nav-link <?php if($page == 'user_list_scheme.php'){ echo 'active'; } ?>">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>Scheme List</p>
                  <span class="right badge badge-danger"><?php echo mysqli_num_rows($user->user_list_scheme()); ?></span>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-header">Reports</li>

          <li class="nav-item">
            <a href="collection_book.php" class="nav-link <?php if($page == 'collection_book.php'){ echo 'active'; } ?>">
              <i class="nav-icon fas fa-book"></i>
              <p>Collection Book</p>
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