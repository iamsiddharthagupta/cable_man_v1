<?php

	require_once 'user_profile_base.php';

?>
		<div class="col-md-9">
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Edit details</h3>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
				<div class="card-body">
		        	<form method="POST" autocomplete="off">
		        		<div class="form-row">
							<div class="form-group col-md">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">First name</span>
									</div>
										<input type="text" class="form-control">
								</div>
							</div>
							<div class="form-group col-md">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">Last name</span>
									</div>
										<input type="text" class="form-control">
								</div>
							</div>
		        		</div>
				</div>
				    <div class="card-footer">
				    	<input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
		        		<button type="submit" name="submit" class="btn btn-primary float-right">Update</button>
				    </div>
		    	    </form>
		    </div>
		</div>

	</div>
</div>

<?php require_once 'includes/footer.php'; ?>