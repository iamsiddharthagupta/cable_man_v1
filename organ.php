<?php

  function countUser(){
    include 'connection.php';
    $query = "SELECT COUNT(user_id) AS total_users FROM cbl_user";
    $result = mysqli_query($conn,$query);
    $value = mysqli_fetch_assoc($result);
    $num_rows = $value['total_users'];
    return $num_rows;
  }

  function countActiveUser(){
    include 'connection.php';
    $query = "SELECT COUNT(DISTINCT user_id) AS user_id FROM cbl_ledger";
    $result = mysqli_query($conn,$query);
    $data = mysqli_fetch_assoc($result);
    return $data['user_id'];
  }

  function countActiveDevice(){
    include 'connection.php';
    $query = "SELECT
              COUNT(DISTINCT dev_id) AS dev_id FROM cbl_ledger
              WHERE status = 'Renewed' OR 'Paid'";
    $result = mysqli_query($conn,$query);
    $data = mysqli_fetch_assoc($result);
    return $data['dev_id'];
  }

  function countUnpaid(){
    include 'connection.php';
    $query = "SELECT COUNT(user_id) AS count_unpaid FROM cbl_ledger
              WHERE status = 'Renewed'";
    $result = mysqli_query($conn,$query);
    $data = mysqli_fetch_assoc($result);
    return $data['count_unpaid'];
  }

   function countPaid(){
    include 'connection.php';
    $query = "SELECT COUNT(ledger_id) AS count_paid FROM cbl_ledger WHERE status = 'Paid'";
    $result = mysqli_query($conn,$query);
    $data = mysqli_fetch_assoc($result);
    return $data['count_paid'];
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
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
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
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
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
    <a href="index3.html" class="brand-link">
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
          <a href="#" class="d-block"><?php echo $curr_user; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

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
                <a href="#" class="nav-link">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>User List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>Active List</p>
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
                <a href="#" class="nav-link">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>Overdue List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>Paid List</p>
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
