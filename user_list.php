<?php

  ob_start();
  session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);
  
	$page = 1;
	
	require_once 'includes/top-nav.php';
	require_once 'includes/side-nav.php';
	$create->user_profile_add();

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h4 class="text-dark">Area Management</h4>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Area Management</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="container">
	<div class="card card-outline card-info">
		<div class="card-header">
			<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#staticBackdrop">
			  Add Customer
			</button>
			<div class="card-tools">
			  <div class="input-group input-group-sm">
			    <input type="text" name="table_search" id="myInput" class="form-control float-right" placeholder="Search">
			  </div>
			</div>
		</div>
		<div class="card-body table-responsive p-0">
			<table class="table table-hover text-center table-bordered table-sm table-head-fixed text-nowrap">
			    <thead class="thead-light">
			      <tr>
			      	<th>Action</th>
			        <th>Name</th>
			        <th>Address</th>
			        <th>Phone</th>
			        <th>Box</th>
			        <th>Rate</th>
			        <th>Install Date</th>
			      </tr>
				</thead>
				<?php
					$result = $read->fetch_list_customer();
					if($result->num_rows < 1) {
						echo "<tr><td colspan='10'>No customer yet!</td><tr>";
					} else {
						foreach ($result as $key => $row) :
				?>
				<tbody id="myTable">
					<tr>
						<td>
							<div class="btn-group" role="group">
		    					<button type="button" class="btn btn-dark btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		      						Action
		    					</button>
			    				<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
			    					<?php if(empty($row['dev_id'])){ ?>
			    						<a class="dropdown-item" href="profile_device_map.php?cust_id=<?php echo $row['cust_id']; ?>">Assign Device</a>
			    					<?php } elseif(!empty($row['dev_id'])){ ?>
			    						<a class="dropdown-item" href="user_profile_select_device.php?cust_id=<?php echo $row['cust_id']; ?>">Start</a>
			    					<?php } ?>
			    					<a class="dropdown-item" href="user_profile_ledger.php?cust_id=<?php echo $row['cust_id']; ?>">Ledger Book</a>
									<a class="dropdown-item" href="user_profile_update.php?cust_id=<?php echo $row['cust_id']; ?>">Update Profile</a>
									<a class="dropdown-item" href="user_profile_device_map.php?cust_id=<?php echo $row['cust_id']; ?>">Map/Edit Device</a>
							    </div>
					  		</div>
						</td>
						<td><a href="profile_ledger.php?cust_id=<?php echo htmlentities($row['cust_id']); ?>"><?php echo $row['first_name']." ".$row['last_name'];?></a></td>
						<td><?php echo $row['address'];?>, <strong><?php echo $row['area_name'] ?></strong></td>
						<td><?php echo $row['phone_no'];?></td>
						<td>2</td>
						<td>500</td>
						<td><?php echo date('jS M y',strtotime($row['install_date'])); ?></td>
					</tr>
				</tbody>
			<?php
					endforeach;
					$result->free_result();
				}
			?>
			</table>
		</div>
	</div>
</div>

<?php require_once 'includes/footer.php'; ?>

<!-- Add -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Add Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off">
	        <div class="form-row">
	            <div class="form-group col-md">
	              <label>First Name: <span class="text-danger">*</span></label>
	                <input type="text" class="form-control" name="first_name" placeholder="First Name" required="">
	            </div>
	            <div class="form-group col-md">
	              <label>Last Name:</label>
	                <input type="text" class="form-control" name="last_name" placeholder="Last Name" required="">
	            </div>
	        </div>

	        <div class="form-row">
	          <div class="form-group col-md">
	            <label>Phone Number: <span class="text-danger">*</span></label>
	              <input type="text" class="form-control" name="phone_no" id="phone" placeholder="Phone Number" required="">
	          </div>
	          <div class="form-group col-md">
	            <label>Installation Date:</label>
	              <input type="text" class="form-control" id="today" name="install_date">
	          </div>
	        </div>

	        <div class="form-row">
	          <div class=" form-group col-md">
	            <label>Address: <span class="text-danger">*</span></label>
	            <input type="text" name="address" class="form-control" placeholder="Complete Address" required="">
	          </div>
	          <div class="form-group col-md">
	            <label>Area: <span class="text-danger">*</span></label>
	            <?php

	              $areas = $read->fetch_area_list();

	              echo "<select name='area_id' class='form-control' required>";
	              echo "<option value=''>Select Area</option>";
	                foreach ($areas as $key => $area) {
	                  echo "<option value='$area[area_id]'>$area[area_name]</option>";
	                }
	              echo "</select>";

	            ?>
	          </div>
	        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-primary">Add</button>
    </form>
      </div>
    </div>
  </div>
</div>