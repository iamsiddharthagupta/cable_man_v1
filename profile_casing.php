<?php

  session_start();

  if(isset($_SESSION['user_level'])){
      $curr_user = ucwords($_SESSION['curr_user']);
      if($_SESSION['user_level'] != 1){
          header('Location: agent_panel.php');
      }
  } else {
    header('Location: index.php');
  }

  require_once 'connection.php';
  require_once 'organ.php';

  $user_id = $_GET['user_id'];

  $query = "
            SELECT
            cbl_user.user_id AS user_id,
            cbl_user.first_name AS first_name,
            cbl_user.last_name AS last_name,
            cbl_user.phone_no AS phone_no,
            cbl_user.address AS address,
            cbl_user.area AS area,
            cbl_user.doi AS doi,
            cbl_dev_stock.device_no AS device_no,
            cbl_dev_stock.device_mso AS device_mso,
            cbl_dev_stock.device_type AS device_type,
            cbl_dev_stock.package AS package

            FROM cbl_user_dev

            RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
            LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id

            WHERE cbl_user.user_id = '$user_id'";

  
  $result = mysqli_query($conn,$query);
  $data = mysqli_fetch_assoc($result);
  $dev_count = mysqli_num_rows($result);

?>

<!-- Breadcrumbs Starts -->
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
<!-- Breadcrumbs Ends -->

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          
          <div class="col-md-3">
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="common/avatar.png" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo $data['first_name']." ".$data['last_name']; ?></h3>

                <div class="btn-group btn-block" role="group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                      <a class="dropdown-item" href="profile_device_map.php?user_id=<?php echo $data['user_id']; ?>">Update User Profile</a>
                      <a class="dropdown-item" href="profile_device_map.php?user_id=<?php echo $data['user_id']; ?>">Map/Edit Device</a>
                      <a class="dropdown-item" href="profile_devices.php?user_id=<?php echo $data['user_id']; ?>">Renew</a>
                      <a class="dropdown-item" href="profile_ledger.php?user_id=<?php echo $data['user_id']; ?>">Ledger</a>
                    </div>
                </div>

              </div>
            </div>

            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Basic Details</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>

              <div class="card-body">

                  <span><strong>Phone:</strong> <span class="text-muted"><?php if(empty($data['phone_no'])){echo 'Unavailable';} else { echo $data['phone_no']; } ?></span></span><br>
                  <span><strong>Address:</strong> <span class="text-muted"><?php echo $data['address'].", ".$data['area']; ?></span></span><br>
                  <span><strong>Customer Since:</strong> <span class="text-muted"><?php echo date('jS M y',strtotime($data['doi'])); ?></span></span>

                    <hr>

                  <strong>Device and Package:</strong><br>

                  <?php
                    foreach ($result as $key => $data) {
                        ?>
                            <span>(Rs.<?php echo $data['package']; ?>) <strong><?php echo $data['device_mso']; ?></strong> <?php echo $data['device_no']; ?></span><br>
                        <?php
                    }
                  ?>
              </div>
            </div>
          </div>

