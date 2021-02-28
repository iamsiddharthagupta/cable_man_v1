<?php

    ob_start();
    session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

    $page = 1;

    require_once 'config/init.php';
    require_once 'includes/top-nav.php';
    require_once 'includes/side-nav.php';

    $profile_base = "
                    SELECT
                    u.user_id,
                    u.first_name,
                    u.last_name,
                    u.mobile_no,
                    u.address,
                    u.install_date,
                    ar.area
                    FROM tbl_user u
                    LEFT JOIN tbl_area ar ON ar.area_id = u.area_id
                    WHERE user_id = '". $_GET['user_id'] ."'";

    $row = $organ->query($profile_base)->fetch_assoc();

    $mapped_devs = "
                    SELECT
                    m.mapped_id,
                    dv.device_id,
                    u.user_id,
                    dv.device_no,
                    CASE
                    WHEN dv.device_type = 1 THEN 'SD'
                    WHEN dv.device_type = 2 THEN 'HD'
                    END AS device_type,
                    pc.mso_name
                    FROM
                    tbl_mapping m
                    LEFT JOIN tbl_user u ON u.user_id = m.user_id
                    RIGHT JOIN tbl_device dv ON dv.device_id = m.device_id
                    RIGHT JOIN tbl_package pc ON pc.package_id = dv.package_id
                    WHERE m.user_id = '" .$_GET['user_id']. "'";

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
                <h3 class="profile-username text-center"><?php echo $row['first_name'].' '.$row['last_name']; ?></h3>
                <p class="text-success text-center"><?php echo $row['area']; ?></p>
                <div class="btn-group btn-block" role="group">
                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Action
                  </button>
                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a class="dropdown-item" href="user_profile_device_select.php?user_id=<?php echo $row['user_id']; ?>">Activate</a>
                    <a class="dropdown-item" href="user_profile_ledger.php?user_id=<?php echo $row['user_id']; ?>">Ledger Book</a>
                    <a class="dropdown-item" href="user_profile_update.php?user_id=<?php echo $row['user_id']; ?>">Update Profile</a>
                    <a class="dropdown-item" href="user_profile_device_map.php?user_id=<?php echo $row['user_id']; ?>">Manage Device</a>
                  </div>
                </div>
              </div>
            </div>

            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">About</h3>
              </div>
              <div class="card-body">
                <strong><i class="fas fa-phone-alt mr-1"></i>Phone</strong>

                <p class="text-muted">
                  <?php echo (empty($row['mobile_no'])) ? 'Unavailable' : $row['mobile_no']; ?>
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i>Location</strong>

                <p class="text-muted"><?php echo $row['address'].", ".$row['area']; ?></p>

                <hr>

                <strong><i class="fas fa-hdd mr-1"></i>Devices</strong>

                <p class="text-muted">
                  <?php
                      $res = $organ->query($mapped_devs);
                      if ($res->num_rows < 1) { ?>
                        <span class="text-muted ml-1">No device available</span>
                  <?php } else {
                      foreach ($res as $key => $row) :
                  ?>
                        <span class="text-muted ml-1">
                          <?php echo $row['device_no'].' - '.$row['mso_name'].' '.$row['device_type']; ?>
                        </span><br>
                  <?php
                      endforeach;
                    }
                  ?>
                </p>
              </div>
            </div>

          </div>

