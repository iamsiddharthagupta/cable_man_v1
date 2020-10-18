<?php
	require_once 'admin_base.php';
	$result = $admin->admin_change_pass($curr_user);
?>

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