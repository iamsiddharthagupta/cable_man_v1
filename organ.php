<?php

// Counting Functions of Badges.

  function CountUser(){
    require 'connection.php';
    $query = "SELECT COUNT(user_id) AS total_users FROM cbl_user";
    $result = mysqli_query($conn,$query);
    $value = mysqli_fetch_assoc($result);
    $num_rows = $value['total_users'];
    return $num_rows;
  }

  function CountActiveUser($date){
    require 'connection.php';
    $query = "SELECT
              COUNT(DISTINCT user_id) AS active_user
              FROM cbl_ledger
              WHERE '$date' BETWEEN renew_date AND expiry_date";
    $result = mysqli_query($conn,$query);
    $data = mysqli_fetch_assoc($result);
    return $data['active_user'];
    }


  function CountActiveDevice($date){
    require 'connection.php';
    $query = "SELECT
              COUNT(DISTINCT dev_id) AS active_dev FROM cbl_ledger
              WHERE '$date' BETWEEN renew_date AND expiry_date";
    $result = mysqli_query($conn,$query);
    $data = mysqli_fetch_assoc($result);
    return $data['active_dev'];
  }

  function CountUnpaid(){
    require 'connection.php';
    $query = "SELECT COUNT(user_id) AS count_unpaid FROM cbl_ledger
              WHERE ledger_status = 'Renewed'";
    $result = mysqli_query($conn,$query);
    $data = mysqli_fetch_assoc($result);
    return $data['count_unpaid'];
  }

   function CountPaid(){
    require 'connection.php';
    $query = "SELECT COUNT(ledger_id) AS count_paid FROM cbl_ledger WHERE ledger_status = 'Paid'";
    $result = mysqli_query($conn,$query);
    $data = mysqli_fetch_assoc($result);
    return $data['count_paid'];
  }

     function CountExpiring($date){
    require 'connection.php';
    $query = "SELECT COUNT(ledger_id) AS count_expiring FROM cbl_ledger WHERE expiry_date = '$date'";
    $result = mysqli_query($conn,$query);
    $data = mysqli_fetch_assoc($result);
    return $data['count_expiring'];
  }

// Dynamic Query Functions for Sidebar Lists.

  function UserList(){

    $query = "GROUP BY cbl_user.user_id ORDER BY cbl_user.doi DESC";

    return urlencode($query);
  }

  function ActiveList($user_status){

    $query = "WHERE cbl_user.user_status = '$user_status' GROUP BY cbl_user.user_id,cbl_user_dev.dev_id ORDER BY expiry_date ASC";

    return urlencode($query);
  }

  function OverdueList($ledger_status){

    $query = "WHERE cbl_ledger.ledger_status = '$ledger_status' GROUP BY cbl_ledger.ledger_id ORDER BY cbl_ledger.renew_month DESC";

    return urlencode($query);
  }

    function PaidList($ledger_status){

    $query = "WHERE cbl_ledger.ledger_status = '$ledger_status' AND cbl_ledger.renew_term = 1 GROUP BY cbl_ledger.ledger_id ORDER BY cbl_ledger.renew_month DESC";

    return urlencode($query);
  }

    function SchemeList($ledger_status){

    $query = "WHERE cbl_ledger.ledger_status = '$ledger_status' AND cbl_ledger.renew_term > 1 GROUP BY cbl_ledger.ledger_id ORDER BY cbl_ledger.renew_month DESC";

    return urlencode($query);
  }

    function ExpiringList($date){

    $query = "WHERE cbl_ledger.expiry_date = '$date' GROUP BY cbl_user.user_id,cbl_user_dev.dev_id ORDER BY expiry_date ASC";

    return urlencode($query);
  }

  // Dinamic Filter Function in User List.
    function UserFilter($area){

    $query = "WHERE cbl_user.area = '$area' GROUP BY cbl_user.user_id ORDER BY address ASC";

    return urlencode($query);
  }

  // Dinamic Filter Function in Active List.
    function ActiveFilter($area){

    $query = "WHERE cbl_user.area = '$area' GROUP BY cbl_user.user_id,cbl_user_dev.dev_id ORDER BY cbl_ledger.expiry_date ASC,cbl_user.address ASC";

    return urlencode($query);
  }

  // Dinamic Filter Function in User List.
    function OverdueFilter($area){

    $query = "WHERE cbl_ledger.ledger_status = 'Renewed' AND cbl_user.area = '$area' GROUP BY cbl_ledger.ledger_id ORDER BY cbl_ledger.renew_month DESC,cbl_user.address ASC";

    return urlencode($query);
  }

    include 'common/header.php';
?>

<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="dashboard.php" class="nav-link">Dashboard</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="add_user.php" class="nav-link"><i class="fas fa-plus-circle"></i></a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3" method="POST" action="<?php echo htmlspecialchars('search_process.php'); ?>">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="text" name="search_input" id="user_search" placeholder="Search" aria-label="Search" required>
        <div class="input-group-append">
          <button class="btn btn-navbar" name="submit" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge"><?php echo CountExpiring(date('Y-m-d')); ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header"><?php echo CountExpiring(date('Y-m-d')); ?> Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="active_list.php?query=<?php echo ExpiringList(date('Y-m-d')); ?>" class="dropdown-item">
            <i class="fas fa-hourglass-end mr-2"></i><?php echo CountExpiring(date('Y-m-d')); ?> Expiring Today
          </a>
        </div>
      </li>
      
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo $curr_user; ?>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="change_pass.php">Change Password</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php">Logout</a>
        </div>
      </li>

    </ul>
  </nav>
  <!-- /.navbar -->

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
