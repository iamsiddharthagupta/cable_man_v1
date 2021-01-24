<?php

    ob_start();
    session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

    require_once 'includes/top-nav.php';
    require_once 'includes/side-nav.php';

    $row = $read->fetch_profile_base($_GET['cust_id'])->fetch_assoc();

?>

  <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h4 class="text-dark">Profile</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

      <div class="container-fluid">
        <div class="row">

          <div class="col-md-3">
            <div class="card card-info card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="assets/images/avatar.png" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo $row['full_name']; ?></h3>

                <div class="btn-group btn-block" role="group">
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                      <a class="dropdown-item" href="user_profile_select_device.php?cust_id=<?php echo $row['cust_id']; ?>">Renew/Extend</a>
                      <a class="dropdown-item" href="user_profile_ledger.php?cust_id=<?php echo $row['cust_id']; ?>">Ledger Book</a>
                      <a class="dropdown-item" href="user_profile_update.php?cust_id=<?php echo $row['cust_id']; ?>">Update Profile</a>
                      <a class="dropdown-item" href="user_profile_device_map.php?cust_id=<?php echo $row['cust_id']; ?>">Map/Edit Device</a>
                    </div>
                </div>

              </div>
            </div>

            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Basic Details</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>

              <div class="card-body">
                  <span>
                    <strong>Phone:</strong> <span class="text-muted"><?php echo (empty($row['phone_no'])) ? 'Unavailable' : $row['phone_no']; ?></span>
                  </span><br>

                  <span>
                    <strong>Address:</strong> <span class="text-muted"><?php echo $row['address'].", ".$row['area_name']; ?></span>
                  </span><br>
                  
                  <span>
                    <strong>Customer Since:</strong> <span class="text-muted"><?php echo date('jS M y',strtotime($row['install_date'])); ?></span>
                  </span>
              </div>
            </div>

          </div>

