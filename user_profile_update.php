<?php

	require_once 'user_profile_base.php';

	$result = $user->user_profile_update();

?>
		
		<div class="col-md">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Basic Details</h3>
						<div class="card-tools">
						  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
						  </button>
						</div>
					</div>
				<div class="card-body">
		        <form method="POST" autocomplete="off">
				    
				    <div class="form-row">
				        <div class="form-group col-md">
				          <label>First Name:</label>
				            <input type="text" class="form-control" name="first_name" value="<?php echo $row['first_name']; ?>" placeholder="First Name">
				        </div>
				        <div class="form-group col-md">
				          <label>Last Name:</label>
				            <input type="text" class="form-control" name="last_name" value="<?php echo $row['last_name'];?>" placeholder="Last Name">
				        </div>
				    </div>

			    	<div class="form-row">
			        	<div class="form-group col-md">
			          		<label>Contact Number:</label>
			            	<input type="text" id="contactInput" class="form-control" name="phone_no" value="<?php echo $row['phone_no'];?>" placeholder="Contact Number">
			        	</div>

				        <div class="form-group col-md">
				          <label>Area:</label>
				            <select name="area" class="form-control" required="">
				              
				              <option value="">Select Area</option>
				              <option value="Humayunpur" <?php if($row["area"] == 'Humayunpur'){ echo "selected"; } ?>>Humayunpur</option>
				              <option value="Arjun Nagar" <?php if($row["area"] == 'Arjun Nagar'){ echo "selected"; } ?>>Arjun Nagar</option>
				              <option value="Krishna Nagar" <?php if($row["area"] == 'Krishna Nagar'){ echo "selected"; } ?>>Krishna Nagar</option>
				              <option value="B-4" <?php if($row["area"] == 'B-4'){ echo "selected"; } ?>>B-4</option>
				              <option value="Other" <?php if($row["area"] == 'Other'){ echo "selected"; }?>>Other</option>
				            
				            </select>
				      	</div>
		    		</div>

				    <div class="form-row">
				    	<div class="form-group col-md">
				    		<label>User Status:</label>
				    		<select class="form-control" name="user_status">
				    			<option value="" disabled>Select Status</option>
				    			<option value="1" <?php if($row["user_status"] == '1'){ echo "selected"; } ?>>Active</option>
				    			<option value="0" <?php if($row["user_status"] == '0'){ echo "selected"; } ?>>Disconnect</option>
				    		</select>
				    	</div>
				      	<div class="form-group col-md">
				          <label>Address:</label>
				            <input type="text" name="address" class="form-control" value="<?php echo $row['address'];?>">
				        </div>
				    </div>
				    <div class="form-row">
				    	<input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
		        		<button type="submit" name="submit" class="btn btn-outline-primary">Update</button>
				    </div>
		    	    </form>
		    	</div>
		    </div>
		</div>

	</div>
</div>

<?php require_once 'assets/footer.php'; ?>