<?php include 'header.php';

  function countUser(){
    include '../common/connection.php';
    $query = "SELECT COUNT(user_id) AS total_users FROM cbl_user";
    $result = mysqli_query($conn,$query);
    $value = mysqli_fetch_assoc($result);
    $num_rows = $value['total_users'];
    return $num_rows;
  }

  function countActiveUser(){
    include '../common/connection.php';
    $query = "
              SELECT
              COUNT(DISTINCT user_id) AS user_id FROM cbl_ledger
              ";
    $result = mysqli_query($conn,$query);
    $data = mysqli_fetch_assoc($result);
    return $data['user_id'];
  }

  function countActiveDevice(){
    include '../common/connection.php';
    $query = "
              SELECT
              COUNT(DISTINCT dev_id) AS dev_id FROM cbl_ledger WHERE status = 'Renewed' OR 'Paid'
              ";
    $result = mysqli_query($conn,$query);
    $data = mysqli_fetch_assoc($result);
    return $data['dev_id'];
  }

  function countUnpaid(){
    include '../common/connection.php';
    $query = "SELECT COUNT(user_id) AS count_unpaid FROM cbl_ledger
              WHERE status = 'Renewed'";
    $result = mysqli_query($conn,$query);
    $data = mysqli_fetch_assoc($result);
    return $data['count_unpaid'];
  }

   function countPaid(){
    include '../common/connection.php';
    $query = "SELECT COUNT(ledger_id) AS count_paid FROM cbl_ledger

              WHERE status = 'Paid'";
    $result = mysqli_query($conn,$query);
    $data = mysqli_fetch_assoc($result);
    return $data['count_paid'];
  }

?>

<div class="d-flex" id="wrapper">

  <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      
      <div class="sidebar-heading bg-danger text-light">
        Manage Users
      </div>
      
      <div class="list-group list-group-flush">

        <li class="list-group-item d-flex list-group-item-action bg-light justify-content-between align-items-center">
          <form method="POST" action="<?php echo htmlspecialchars('search_process.php'); ?>">
            <div class="input-group">
              <input type="text" class="form-control" name="search_input" id="user_search" placeholder="Search User" required>
              <div class="input-group-append">
                <button class="btn btn-danger" name="submit" type="submit"><i class="fas fa-search"></i></button>
              </div>
            </div>
          </form>
        </li>

        <a href="dashboard.php" class="list-group-item list-group-item-action bg-light">Dashboard
        </a>

        <a href="user_list.php" class="list-group-item d-flex list-group-item-action bg-light justify-content-between align-items-center">User List
          <span class="badge badge-primary badge-pill">
              <?php echo countUser(); ?>
          </span>
        </a>
        
        <a href="active_list.php" class="list-group-item d-flex list-group-item-action bg-light justify-content-between align-items-center">Active/Inactive List
          <span class="badge badge-success badge-pill">
              <?php echo countActiveUser(); ?>
          </span>
        </a>

        <a href="unpaid_list.php" class="list-group-item d-flex list-group-item-action bg-light justify-content-between align-items-center">Unpaid List
          <span class="badge badge-danger badge-pill">
              <?php echo countUnpaid(); ?>
          </span>
        </a>

        <a href="paid_list.php" class="list-group-item d-flex list-group-item-action bg-light justify-content-between align-items-center">Paid List
          <span class="badge badge-success badge-pill">
              <?php echo countPaid(); ?>
          </span>
        </a>
        
        <a href="setting.php" class="list-group-item list-group-item-action bg-light">Settings
        </a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
    
    <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <button class="btn btn-outline-danger" id="menu-toggle">&#9776;</button>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item active">
              <a class="nav-link" href="../cable_erp/add_user.php"><i class="fas fa-user-plus"></i><span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo $curr_user; ?>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="change_pass.php">Change Password</a>
                <a class="dropdown-item" href="../internet_erp">Switch to Internet ERP</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">Logout</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>
