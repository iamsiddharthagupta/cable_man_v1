<?php
	require_once 'admin_base.php';
	$result = $admin->admin_change_pass($curr_user);
?>

		<div class="col-md-9">
			<form method="POST" autocomplete="off">
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
</div>
<?php include 'assets/footer.php'; ?>