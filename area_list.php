<?php

  ob_start();
  session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

	$page = 1.1;

	require_once 'includes/top-nav.php';
	require_once 'includes/side-nav.php';

	$create->create_area();

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h4 class="text-dark">Area List</h4>
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
			<a href="area_add.php" class="btn btn-info btn-sm">Add Area</a>

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
			        <?php
			        	$result = $read->fetch_area_list();
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

<?php require_once 'includes/footer.php'; ?>