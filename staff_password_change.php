<?php
	
	ob_start();
	session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

	require_once 'includes/top-nav.php';
	require_once 'includes/side-nav.php';

	$row = $read->fetch_staff_details($_SESSION['staff_id'])->fetch_assoc();
	$update->admin_change_pass($curr_user);
?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h4 class="m-0 text-dark">Password Manager</h4>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Password Manager</li>
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
	            	<p class="text-danger text-center"><i class="fas fa-lock mr-1"></i><?php echo $row['staff_position']; ?></p>
		          <ul class="list-group list-group-unbordered">
		            <li class="list-group-item">
		              <b>Branch:</b> <a class="float-right">Aalishan Cable TV</a>
		            </li>
		            <li class="list-group-item">
		              <b>Location:</b> <a class="float-right">XYZ</a>
		            </li>
		          </ul>
	          </div>
	        </div>

	    </div>
	    <div class="col-md-9">
		<div class="card card-primary">
	        <div class="card-header">
	          <h3 class="card-title">Change Password</h3>
	          <div class="card-tools">
	            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
	              <i class="fas fa-minus"></i></button>
	          </div>
	        </div>
	        <div class="card-body">
				<form method="POST" autocomplete="off">
					<div class="form-group">
						<input type="password" name="current_pass" class="form-control" placeholder="Enter your current password">
					</div>
					<div class="form-group">
						<input type="password" name="new_pass" class="form-control" placeholder="Enter your new password">
					</div>
					<div class="form-group">
						<input type="password" name="confirm_pass" class="form-control mb-2" placeholder="Confirm your new password">
					</div>
					<div class="form-group">
						<button type="submit" name="submit" class="btn btn-outline-primary">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	</div>
</div>
<?php include 'includes/footer.php'; ?>