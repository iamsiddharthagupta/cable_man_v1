<?php
	
	ob_start();
	session_start();

	$curr_user = $_SESSION['curr_user'];
	$user_level = $_SESSION['user_level'];


	require_once 'includes/top-nav.php';
	require_once 'includes/side-nav.php';

	$result = $security->session($curr_user, $user_level);

	$result = $admin->admin_profile_fetch($curr_user);
	$row = mysqli_fetch_assoc($result);

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Control Centre</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Admin Settings</li>
        </ol>
      </div>
    </div>
  </div>
</div>

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
	              <img class="profile-user-img img-fluid img-circle" src="assets/images/avatar.png" alt="User profile picture">
	            </div>

	            <h3 class="profile-username text-center"><?php echo $row['full_name']; ?></h3>

		          <ul class="list-group list-group-unbordered mb-3">
		            <li class="list-group-item">
		              <b>Access Level:</b> <a class="float-right"><?php echo $row['user_level']; ?></a>
		            </li>
		            <li class="list-group-item">
		              <b>Phone:</b> <a class="float-right"><?php echo $row['contact_no']; ?></a>
		            </li>
		          </ul>

	            <div class="btn-group btn-block" role="group">
	                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                    Action
	                </button>
	                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
	                  <a class="dropdown-item" href="admin_change_pass.php">Change Password</a>
	                  <a class="dropdown-item" href="admin_role_assign.php">Assign Role</a>
	                </div>
	            </div>

	          </div>
	        </div>

	    </div>