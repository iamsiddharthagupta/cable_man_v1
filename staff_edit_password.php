<?php
	
	ob_start();
	session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

    require_once 'config/init.php';
	require_once 'includes/top-nav.php';
	require_once 'includes/side-nav.php';

	if(isset($_POST['submit'])) {

		$staff_id = $_SESSION['staff_id'];
        $current_pass = md5($_POST['current_pass']);
        $new_pass = md5($_POST['new_pass']);
        $confirm_pass = md5($_POST['confirm_pass']);

        $curr_valid = $organ->query("SELECT password FROM tbl_staff WHERE staff_id = '".$_SESSION['staff_id']."'")->fetch_assoc();

            if($current_pass != $curr_valid['password']) {

				$msg = 'You current password is invalid.';
				$code = 'error';
				header('Location: staff_edit_password.php?&msg='.$msg.'&code='.$code);

          } else {

			if($new_pass == $confirm_pass) {

				$array = array(
								"password" => $confirm_pass
							);

				$res = $organ->update('tbl_staff', $array, "staff_id = '$staff_id'");


			    $msg = 'Your password have been changed. Please Logout and Re-Login';
			    $code = 'success';
			    header('Location: staff_edit_password.php?&msg='.$msg.'&code='.$code);

			} else {

			  $msg = 'Your new and confirm password does not match.';
			  $code = 'warning';
			  header('Location: staff_edit_password.php?&msg='.$msg.'&code='.$code);

			}

        }

	}

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h4 class="m-0 text-dark">Edit password</h4>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Password Management</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-8">
			<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="needs-validation" novalidate>
				<div class="card card-info">
			        <div class="card-header">
			          <div class="card-tools">
			            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
			              <i class="fas fa-minus"></i></button>
			          </div>
			        </div>
					<div class="card-body">
						<div class="form-group col-md">
							<label>Current Password</label>
							<input type="password" name="current_pass" class="form-control" required="">
							<div class="invalid-feedback">
								Please type the password which you are using currently.
							</div>
						</div>
						<div class="form-group col-md">
							<label>New Password</label>
							<input type="password" name="new_pass" class="form-control" required="">
							<div class="invalid-feedback">
								Please type a new password.
							</div>
						</div>
						<div class="form-group col-md">
							<label>Confirm Password</label>
							<input type="password" name="confirm_pass" class="form-control" required="">
							<div class="invalid-feedback">
								Please type the new password again.
							</div>
						</div>
					</div>
					<div class="card-footer">
						<button type="submit" name="submit" class="btn btn-info float-right">Change</button>
					</div>
				</div>
			</form>
		</div>
		<div class="col-md-4">
			<ul class="list-group">
				<li class="list-group-item active">The password must contain at least three character categories among the following:</li>
				<li class="list-group-item">Uppercase characters (A-Z)</li>
				<li class="list-group-item">Lowercase characters (a-z)</li>
				<li class="list-group-item">Digits (0-9)</li>
				<li class="list-group-item">Special characters (~!@#$%^&*_-+=`|\(){}[]:;"'< >,.?/)</li>
			</ul>
		</div>
	</div>
</div>
<?php include 'includes/footer.php'; ?>