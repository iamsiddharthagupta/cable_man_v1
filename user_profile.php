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
            cbl_ledger.status AS status,
            SUM(cbl_dev_stock.package) AS package,
            COUNT(cbl_user_dev.dev_id) AS devices,
            cbl_dev_stock.device_no AS device_no
            
            FROM cbl_user_dev

            RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
            LEFT JOIN cbl_ledger ON cbl_ledger.dev_id = cbl_user_dev.dev_id
            LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id

            WHERE cbl_user.user_id = '$user_id'";

  
  $result = mysqli_query($conn,$query);
  $data = mysqli_fetch_assoc($result);

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
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="common/avatar.png" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo $data['first_name']." ".$data['last_name']; ?></h3>

                <p class="text-muted text-center"><?php echo $data['address'].", ".$data['area']; ?></p>

                <a href="#" class="btn btn-primary btn-block"><b>Install Receipt</b></a>
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

                  <span><strong>Phone:</strong> <span class="text-muted"><?php echo $data['phone_no']; ?></span></span><br>
                  <span><strong>Devices:</strong> <span class="text-muted"><?php echo $data['devices']; ?></span></span><br>
                  <span><strong>Package:</strong> Rs.<span class="text-muted"><?php echo $data['package']; ?></span></span><br>
                  <span><strong>Customer Since:</strong> <span class="text-muted"><?php echo date('jS M y',strtotime($data['doi'])); ?></span></span>

                  <hr>

                  <strong>Devices:</strong>
                  <?php
                    foreach ($result as $key => $data) {
                      echo $data['device_no'];
                    }
                  ?>
              </div>
            </div>
          </div>

          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content">
                    
                  <div class="active tab-pane" id="activity">

                  </div>

                  <div class="tab-pane" id="timeline">
                  
                  </div>

                <div class="tab-pane" id="settings">
                  <form class="form-horizontal" method="POST" action="<?php echo htmlspecialchars('update_process.php'); ?>" autocomplete="off">
                  <div class="row">
                    <div class="col-sm">
                      <label>First Name: *</label>
                        <input type="text" class="form-control" name="first_name" value="<?php echo $data['first_name']; ?>" placeholder="First Name">
                    </div>
                    <div class="col-sm">
                      <label>Last Name:</label>
                        <input type="text" class="form-control" name="last_name" value="<?php echo $data['last_name'];?>" placeholder="Last Name">
                    </div>
                  </div>

                    <div class="row">
                        <div class="col-sm">
                          <label>Contact Number:</label>
                            <input type="text" id="contactInput" class="form-control" name="phone_no" value="<?php echo $data['phone_no'];?>" placeholder="Contact Number">
                        </div>

                        <div class="col-sm">
                          <label>Area: *</label>
                            <select name="area" class="form-control">
                              <option value="">Select Area</option>
                              
                              <option value="Humayunpur" <?php if($data["area"]=='Humayunpur'){ echo "selected"; } ?>>Humayunpur</option>
                              
                              <option value="Arjun Nagar" <?php if($data["area"]=='Arjun Nagar'){ echo "selected"; } ?>>Arjun Nagar</option>
                              
                              <option value="Krishna Nagar" <?php if($data["area"]=='Krishna Nagar'){ echo "selected"; } ?>>Krishna Nagar</option>
                              
                              <option value="B-4" <?php if($data["area"]=='B-4'){ echo "selected"; } ?>>B-4</option>
                              
                              <option value="Other" <?php if($data["area"]=='Other'){ echo "selected"; }?>>Other</option>
                            </select>
                      </div>
                    </div>

                    <div class="row mb-2">
                      <div class="col-sm">
                          <label>Address</label>
                            <textarea class="form-control" name="address" placeholder="Complete Address with House Number and Floor"><?php echo $data['address'];?></textarea>
                        </div>
                      </div>

                      <input type="hidden" name="user_id" value="<?php echo $data['user_id']; ?>">
                      <button type="submit" name="submit" class="btn btn-outline-primary">Update</button>
                    </form>
                  </div>

                </div>
              </div>
            </div>
          </div>

    </div>
  </div>
</section>

<?php require_once 'common/footer.php'; ?>