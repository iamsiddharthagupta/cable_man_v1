<?php
	require_once 'admin_base.php';
	$result = $admin->admin_role_assign();
?>
		
	<div class="col-md-9">
		<div class="card card-primary">
	        <div class="card-header">
		          <h3 class="card-title">Assign Roles</h3>
		          <div class="card-tools">
		            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
		              <i class="fas fa-minus"></i></button>
		          </div>
	        </div>
	        <div class="card-body">
				<form method="POST" autocomplete="off">
					<div class="form-group">
						<input type="text" name="username" class="form-control" placeholder="Set Username" required="">
					</div>
					<div class="form-group">
						<input type="password" name="password" class="form-control" placeholder="Set Password" required="">
					</div>		
					<div class="form-group">
						<input type="text" name="full_name" class="form-control" placeholder="Full Name" required="">
					</div>
					<div class="form-group">
						<input type="text" name="contact_no" class="form-control" placeholder="Contact Number" required="">
					</div>
					<div class="form-group">
						<select name="user_level" class="custom-select" required="">
					        <option value="">Select Role</option>
					        <option value="1">Admin</option>
					        <option value="2">Collection Boy</option>
	      				</select>
					</div>
					<button type="submit" name="submit" class="btn btn-outline-primary">Submit</button>
				</form>		
			</div>
		</div>
	</div>

	</div>
</div>

<?php include 'assets/footer.php'; ?>