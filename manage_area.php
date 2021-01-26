<?php

  ob_start();
  session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);
  
	$page = 'manage_area.php';
	
	require_once 'includes/top-nav.php';
	require_once 'includes/side-nav.php';

	$create->create_area();

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

<div class="container-fluid pt-2">
	<div class="row">
			<div class="col-md-4">
				<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off">
					<div class="card card-info">
						<div class="card-header">
						  <h3 class="card-title">Add Area</h3>
						  <div class="card-tools">
						    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						      <i class="fas fa-minus"></i></button>
						  </div>
						</div>
						<div class="card-body">
						  <div class="form-group">
						    <input type="text" name="area_name" placeholder="Area" class="form-control">
						  </div>
						  <div class="form-group">
						    <input type="text" name="area_district" placeholder="District" value="South-West Delhi" class="form-control">
						  </div>
						  <div class="form-group">
						    <input type="text" name="area_city" placeholder="City" value="New Delhi" class="form-control">
						  </div>
						  <div class="form-group">
						    <input type="text" name="area_state" placeholder="State" value="Delhi" class="form-control">
						  </div>
						  <div class="form-group">
						    <input type="text" name="area_pin" placeholder="Pin" value="110029" class="form-control">
						  </div>
						  <div class="form-group">
						    <input type="text" name="area_country" placeholder="Country" value="India" class="form-control">
						  </div>
						</div>
						<div class="card-footer">
							<button type="submit" name="submit" class="btn btn-info float-right">Submit</button>
						</div>
					</div>
				</form>
			</div>

			<div class="col-md-8">
<<<<<<< Updated upstream
				<div class="card card-outline card-info">
				<div class="card-header">
					<h3 class="card-title">Areas</h3>

					<div class="card-tools">
					  <div class="input-group input-group-sm">
					    <input type="text" name="table_search" id="myInput" class="form-control float-right" placeholder="Search">
					  </div>
					</div>
				</div>

				<div class="card-body table-responsive p-0">
				<table class="table table-hover text-center table-bordered table-sm">
		          <thead>
		            <tr>
		              <th>Area</th>
		              <th>District</th>
		              <th>City</th>
		              <th>State</th>
		              <th>Pincode</th>
		              <th>Country</th>
		            </tr>
		          </thead>         

		        <?php $result = $read->fetch_area_list();

		              if ($result->num_rows < 1) {
		                
		                echo "<tr><td colspan='6'>No areas added yet!</td><tr>";
		              
		              } else {
		               
		                foreach ($result as $key => $row) :
		        ?>

							<tbody id="myTable">

								<tr>

									<td><?php echo $row['area_name']; ?></td>

									<td><?php echo $row['area_district']; ?></td>

									<td><?php echo $row['area_city']; ?></td>

									<td><?php echo $row['area_state']; ?></td>

									<td><?php echo $row['area_pin']; ?></td>

									<td><?php echo $row['area_country']; ?></td>

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
=======
				<div class="table-responsive p-0" style="height:500px;">
					<table class="table table-hover text-center table-bordered table-sm">
						<thead class="thead-dark">
							<tr>
								<th>Area</th>
								<th>District</th>
								<th>City</th>
								<th>State</th>
								<th>Pincode</th>
								<th>Country</th>
							</tr>
						</thead>         

							<?php $result = $read->fetch_area_list();
								if ($result->num_rows < 1) {
								echo "<tr><td colspan='6'>No areas added yet!</td><tr>";
								} else {
								foreach ($result as $key => $row) :
							?>

						<tbody id="myTable">
							<tr>
								<td><?php echo $row['area_name']; ?></td>
								<td><?php echo $row['area_district']; ?></td>
								<td><?php echo $row['area_city']; ?></td>
								<td><?php echo $row['area_state']; ?></td>
								<td><?php echo $row['area_pin']; ?></td>
								<td><?php echo $row['area_country']; ?></td>
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
>>>>>>> Stashed changes
	</div>
</div>

<?php require_once 'includes/footer.php'; ?>