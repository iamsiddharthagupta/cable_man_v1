<?php
// Session starts here. It can be used in any page.
	session_start();
	if(isset($_SESSION['curr_user'])){
	$curr_user = ucwords($_SESSION['curr_user']);
	} else {
	header('location:index.php');
	}
	include '../common/cable_organ.php';
	include '../common/connection.php';
?>

<?php

	$msg = '';
	$msgClass = '';

	if(filter_has_var(INPUT_POST, 'submit')){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$full_name = $_POST['full_name'];
		$contact_no = $_POST['contact_no'];
		$user_role = $_POST['user_role'];
		$password = md5($password);

		if(!empty($username) && !empty($password) && !empty($contact_no) && !empty($full_name) && !empty($user_role)){

			$sql = "INSERT INTO `tbl_auth` (`username`,`password`,`full_name`,`contact_no`,`user_role`) VALUES ('$username','$password','$full_name','$contact_no','$user_role')";
			$result = mysqli_query($conn,$sql);
			if($result = true) {
				$msg = 'User Created Successfully! You are getting logout in 2 seconds.';
				$msgClass = 'alert-success';
				header("refresh:2;url='logout.php'");
			} else {
				$msg = 'Oops! Something\'s wrong with the database';
				$msgClass = 'alert-danger';
			}

		} else {
			$msg = 'Please enter details';
			$msgClass = 'alert-warning';
		}
	}
?>

<div class="container p-5">
	<div class="row justify-content-between">
		<div class="col-sm-6">
			<h4>Add role</h4>
			<?php if($msg != ''): ?>
				<div class="alert <?php echo $msgClass ?>"><?php echo $msg; ?></div>
			<?php endif; ?>
			<form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" autocomplete="off">
				<div class="form-group">
					<input type="text" name="username" class="form-control" placeholder="Set Username" value="<?php echo isset($_POST['username']) ? $username : ''; ?>">
				</div>
				<div class="form-group">
					<input type="password" name="password" class="form-control" placeholder="Set Password">
				</div>		
				<div class="form-group">
					<input type="text" name="full_name" class="form-control" placeholder="Full Name" value="<?php echo isset($_POST['full_name']) ? $full_name : ''; ?>">
				</div>
				<div class="form-group">
					<input type="text" name="contact_no" class="form-control" placeholder="Contact Number" value="<?php echo isset($_POST['contact_no']) ? $contact_no : ''; ?>">
				</div>
				<div class="form-group">
					<select name="user_role" class="custom-select">
				        <option value="">Select Role</option>
				        <option value="admin">Admin</option>
				        <option value="collector">Collection Boy</option>
      				</select>
				</div>
				<button type="submit" name="submit" class="btn btn-outline-primary mb-2">Submit</button>
			</form>		
		</div>

		<?php
			$result = mysqli_query($conn,"SELECT * FROM tbl_auth WHERE full_name = '$curr_user'");
			$data = mysqli_fetch_assoc($result);
		?>
		<div class="card text-white bg-primary align-self-start col-sm-4">
			<div class="card-header">Current User</div>
	  		<div class="card-body">
	    		<h5 class="card-title">Name: <?php echo $data['full_name']; ?> - [<?php echo $data['user_role']; ?>]</h5>
	    		<h5 class="card-title">Phone: <?php echo $data['contact_no']; ?></h5>
	  		</div>
		</div>
	</div>
</div>

<?php
	include '../common/footer.php';
?>