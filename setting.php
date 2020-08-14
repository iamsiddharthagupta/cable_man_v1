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

	$msg = '';
	$msgClass = '';

	if(filter_has_var(INPUT_POST, 'submit')){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$full_name = $_POST['full_name'];
		$contact_no = $_POST['contact_no'];
		$user_level = $_POST['user_level'];
		$password = md5($password);

		if(!empty($username) && !empty($password) && !empty($contact_no) && !empty($full_name) && !empty($user_level)){

			$query = "INSERT INTO tbl_auth (username,password,full_name,contact_no,user_level) VALUES ('$username','$password','$full_name','$contact_no','$user_level')";
			$result = mysqli_query($conn,$query);
			
			if($result = true) {
				$msg = 'User Created Successfully!';
				$msgClass = 'alert-success';
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
		<div class="col-sm-6 rounded border-primary mb-5">
			<h4>Add role</h4>
			<?php if($msg != ''): ?>
				<div class="alert <?php echo $msgClass ?>"><?php echo $msg; ?></div>
			<?php endif; ?>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="off">
				<div class="form-group">
					<input type="text" name="username" class="form-control" placeholder="Set Username">
				</div>
				<div class="form-group">
					<input type="password" name="password" class="form-control" placeholder="Set Password">
				</div>		
				<div class="form-group">
					<input type="text" name="full_name" class="form-control" placeholder="Full Name">
				</div>
				<div class="form-group">
					<input type="text" name="contact_no" class="form-control" placeholder="Contact Number">
				</div>
				<div class="form-group">
					<select name="user_level" class="custom-select">
				        <option value="">Select Role</option>
				        <option value="1">Admin</option>
				        <option value="2">Collection Boy</option>
      				</select>
				</div>
				<button type="submit" name="submit" class="btn btn-primary">Submit</button>
			</form>		
		</div>
		<?php
			$result = mysqli_query($conn,"SELECT * FROM tbl_auth WHERE full_name = '$curr_user'");
			$data = mysqli_fetch_assoc($result);
		?>
		<div class="card text-white bg-primary align-self-start col-sm-4">
			<div class="card-header">Current User</div>
	  		<div class="card-body">
	    		<h5 class="card-title">Name: <?php echo $data['full_name']; ?> - [<?php echo $data['user_level']; ?>]</h5>
	    		<h5 class="card-title">Phone: <?php echo $data['contact_no']; ?></h5>
	  		</div>
		</div>
	</div>
</div>
<?php
	include 'common/footer.php';
?>