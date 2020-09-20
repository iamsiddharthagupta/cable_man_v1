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

?>

<?php
// Empty variable for Notification LED above the form.
	$msg = '';

	if(isset($_POST['submit'])){

		$current_pass = $_POST['current_pass'];
		$new_pass = $_POST['new_pass'];
		$confirm_pass = $_POST['confirm_pass'];
// Hashing Passkeys
		$current_pass = md5($current_pass);
		$new_pass = md5($new_pass);
		$confirm_pass = md5($confirm_pass);
// Fetching current password from database to validate password input.
		$sql = "SELECT password FROM tbl_auth WHERE full_name = '$curr_user'";
		$result = mysqli_query($conn,$sql) or die (mysqli_error($conn));
		$curr_valid = mysqli_fetch_assoc($result);
// Logic
			if($current_pass == $curr_valid['password']) {
			if($new_pass == $confirm_pass){
					$sql = "UPDATE tbl_auth SET password = '$confirm_pass' WHERE full_name = '$curr_user'";
					$result = mysqli_query($conn,$sql);
					$msg = 'Congrats you password has been changed. <a href="logout.php">Logout</a> and Login again';
			} else {
				$msg = 'Your new and confirm password does not match.';
			}
		} else {
			$msg = 'You current password is empty or invalid.';
	}

}	
?>

<div class="container p-5">
		<?php
			$result = mysqli_query($conn,"SELECT * FROM tbl_auth WHERE full_name = '$curr_user'");
			$data = mysqli_fetch_assoc($result);
		?>
	<div class="row">
		<div class="col-sm">
			<h2>Change Profile Password</h2>
			<hr size="3" noshade>
			<div class="text-danger"><?php echo $msg; ?></div>
				<form class="form-group" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<label>Current Password:</label>
					<input type="password" name="current_pass" class="form-control" placeholder="Enter your current password">
					<label>New Password:</label>
					<input type="password" name="new_pass" class="form-control" placeholder="Enter your new password">
					<label>Confirm Password:</label>
					<input type="password" name="confirm_pass" class="form-control mb-2" placeholder="Confirm your new password">
					<button type="submit" name="submit" class="btn btn-outline-primary">Submit</button>
				</form>
		</div>
		<div class="col-md-4">
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-info">
                <h3 class="widget-user-username"><?php echo $data['full_name']; ?></h3>
                <h5 class="widget-user-desc"><?php echo $data['user_level']; ?></h5>
              </div>
              <div class="widget-user-image">
                <img class="img-circle elevation-2" src="common/avatar.png" alt="User Avatar">
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm">
                    <div class="description-block">
                      <h5 class="description-header">Phone: <?php echo $data['contact_no']; ?></h5>
                      <a href="setting.php">Assign Users</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
	</div>

<?php
	include 'common/footer.php';
?>