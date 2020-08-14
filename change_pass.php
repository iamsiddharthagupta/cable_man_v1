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
		$sql = "SELECT password FROM tbl_auth WHERE full_name = '$curr_prof'";
		$result = mysqli_query($conn,$sql) or die (mysqli_error($conn));
		$curr_valid = mysqli_fetch_assoc($result);
// Logic
			if($current_pass == $curr_valid['password']) {
			if($new_pass == $confirm_pass){
					$sql = "UPDATE tbl_auth SET password = '$confirm_pass' WHERE full_name = '$curr_prof'";
					$result = mysqli_query($conn,$sql);
					$msg = 'Congrats you password has been changed and logging out in 5 seconds.';
					header('refresh:5;url=logout.php');
			} else {
				$msg = 'Your new and confirm password does not match.';
			}
		} else {
			$msg = 'You current password is invalid.';
	}

}	
?>

	<div class="container p-5 d-flex justify-content-center">
		<div class="col-sm-4">
			<h1>Change Password</h1>
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
	</div>

<?php require_once 'common/footer.php'; ?>