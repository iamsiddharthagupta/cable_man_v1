<?php

	require_once 'profile_casing.php';

?>
		
<div class="col-md">

	<?php if(isset($_GET['msg'])){ ?>
      <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <?php echo $_GET['msg']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php } ?>

	    <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Basic Details</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
              </button>
            </div>
          </div>

         <div class="card-body">
	    <form method="POST" action="<?php echo htmlspecialchars('profile_update_process.php'); ?>" autocomplete="off">
		    <div class=" form-row">
		        <div class="form-group col-sm">
		          <label>First Name: *</label>
		            <input type="text" class="form-control" name="first_name" value="<?php echo $data['first_name']; ?>" placeholder="First Name">
		        </div>
		        <div class="col-sm">
		          <label>Last Name:</label>
		            <input type="text" class="form-control" name="last_name" value="<?php echo $data['last_name'];?>" placeholder="Last Name">
		        </div>
		    </div>

	    	<div class="form-row">
	        	<div class="form-group col-sm">
	          		<label>Contact Number:</label>
	            	<input type="text" id="contactInput" class="form-control" name="phone_no" value="<?php echo $data['phone_no'];?>" placeholder="Contact Number">
	        	</div>

		        <div class="form-group col-sm">
		          <label>Area: *</label>
		            <select name="area" class="form-control">
		              <option value="" disabled>Select Area</option>
		              
		              <option value="Humayunpur" <?php if($data["area"]=='Humayunpur'){ echo "selected"; } ?>>Humayunpur</option>
		              
		              <option value="Arjun Nagar" <?php if($data["area"]=='Arjun Nagar'){ echo "selected"; } ?>>Arjun Nagar</option>
		              
		              <option value="Krishna Nagar" <?php if($data["area"]=='Krishna Nagar'){ echo "selected"; } ?>>Krishna Nagar</option>
		              
		              <option value="B-4" <?php if($data["area"]=='B-4'){ echo "selected"; } ?>>B-4</option>
		              
		              <option value="Other" <?php if($data["area"]=='Other'){ echo "selected"; }?>>Other</option>
		            </select>
		      	</div>
    		</div>

		    <div class="form-row">
		      <div class="form-group col-sm">
		          <label>Address</label>
		            <textarea class="form-control" name="address" placeholder="Complete Address with House Number and Floor"><?php echo $data['address'];?></textarea>
		        </div>
		    </div>
		    <div class="col-auto">
		    	<input type="hidden" name="user_id" value="<?php echo $data['user_id']; ?>">
        		<button type="submit" name="submit" class="btn btn-outline-primary">Update</button>
		    </div>
    		</form>
    	    </div>
         </div>
	   	</div>
	</div>
</section>

<?php require_once 'common/footer.php'; ?>