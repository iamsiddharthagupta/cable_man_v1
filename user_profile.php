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
                cbl_user.first_name AS first_name,
                cbl_user.last_name AS last_name,
                cbl_user.phone_no AS phone_no,
                cbl_user.address AS address,
                cbl_user.area AS area,
                cbl_user.doi AS doi,
                cbl_ledger.status AS status,
                SUM(cbl_dev_stock.package) AS package
                
                FROM cbl_user_dev

                RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
				LEFT JOIN cbl_ledger ON cbl_ledger.dev_id = cbl_user_dev.dev_id
				LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id

				WHERE cbl_user.user_id = '$user_id'
            ";

	
	$result = mysqli_query($conn,$query);
	$data = mysqli_fetch_assoc($result);
?>

<div class="container-fluid p-3">
    <div class="container p-1 mt-2 emp-profile">
        <div class="row">
            <div class="col-sm-10">
                <div class="profile-head"> 
                    
                    <h5>
                    	<?php echo $data['first_name']." ".$data['last_name']; ?>
                    </h5>
                    <h6>Phone No: <strong><?php echo $data['phone_no']; ?></strong></h6>
                    <h6>Address: <strong><?php echo $data['address'].", ".$data['area']; ?></strong></h6>
                    <h6>Package: <strong>Rs.<?php echo $data['package']; ?></strong></h6>
                    <h6>Customer Since: <strong><?php echo date('jS M y',strtotime($data['doi'])); ?></strong></h6>

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Devices</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#ledger" role="tab" aria-controls="profile" aria-selected="false">ledger Book</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-2 mb-1">
            	<a href="update_form.php?user_id=<?php echo $user_id; ?>" class="btn btn-light btn-sm">Edit Profile</a>
            </div>
        </div>
        <div class="row border">
            <div class="col-sm-3 border">
                <div class="profile-work p-4">
                    <p>User Actions</p>
                    <a href="map_device.php?user_id=<?php echo $user_id; ?>">Add/Edit Device</a><br/>
                    <a href="user_ledger_summarized.php?user_id=<?php echo $user_id; ?>">Add Payment</a>
                </div>
            </div>
            <div class="col-sm-9 p-1">
                <div class="tab-content profile-tab" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row">
                            <div class="col-sm">
                                <?php include 'user_devices.php'; ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="ledger" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row">
                            <div class="col-sm">
                                <?php include 'profile_ledger.php'; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'common/footer.php'; ?>