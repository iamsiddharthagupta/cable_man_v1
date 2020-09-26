<?php
  
  ob_start();
  session_start();

  if(isset($_SESSION['user_level'])){
      $curr_user = ucwords($_SESSION['curr_user']);
      if($_SESSION['user_level'] != 1){
          header('Location: agent_panel.php');
      }
  } else {
    header('Location: index.php');
  }

  require_once 'organ.php';

  $user = new User();
  $result = $user->user_profile_base_fetch($_GET['user_id']);
  $row = mysqli_fetch_assoc($result);

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

      <div class="container-fluid">
        <div class="row">
          
          <div class="col-md-3">

            <?php if(isset($_GET['msg'])){ ?>
              <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?php echo $_GET['msg']; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <?php } ?>

            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="assets/avatar.png" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo $row['first_name']." ".$row['last_name']; ?></h3>

                <div class="btn-group btn-block" role="group">
                    <button type="button" class="btn <?php if($row['user_status'] == 0 OR empty($row['dev_id'])){ ?> btn-danger <?php } else { ?> btn-success <?php } ?> dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                      <a class="dropdown-item" href="user_profile_select_device.php?user_id=<?php echo $row['user_id']; ?>">Renew</a>
                      <a class="dropdown-item" href="user_profile_ledger.php?user_id=<?php echo $row['user_id']; ?>">Ledger</a>
                      <a class="dropdown-item" href="user_profile_update.php?user_id=<?php echo $row['user_id']; ?>">Update Profile</a>
                      <a class="dropdown-item" href="user_profile_device_map.php?user_id=<?php echo $row['user_id']; ?>">Edit Device</a>
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
                  <span><strong>Phone:</strong> <span class="text-muted"><?php if(empty($row['phone_no'])){echo 'Unavailable';} else { echo $row['phone_no']; } ?></span></span><br>
                  <span><strong>Address:</strong> <span class="text-muted"><?php echo $row['address'].", ".$row['area']; ?></span></span><br>
                  <span><strong>Customer Since:</strong> <span class="text-muted"><?php echo date('jS M y',strtotime($row['doi'])); ?></span></span>

                    <hr>

                  <strong>Device and Package:</strong><br>

                  <?php
                    foreach ($result as $key => $row) {
                        ?>
                            <span><?php echo $row['device_details']; ?><a href="device_edit.php?dev_id=<?php echo $row['dev_id']; ?>&user_id=<?php echo $row['user_id']; ?>">
                          <?php echo $row['device_no']; ?>
                        </a></span><br>
                        <?php
                    }
                  ?>
              </div>
            </div>

          </div>

