<?php require_once 'header.php' ?>

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
        <a href="user_profile_add.php" class="nav-link"><i class="fas fa-plus-circle"></i></a>
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