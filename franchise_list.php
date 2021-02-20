<?php

    ob_start();
    session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

    $page = 1.2;

    require_once 'includes/top-nav.php';
    require_once 'includes/side-nav.php';

    $create->create_branch();

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h4 class="text-dark">Franchise List</h4>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Franchise Management</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="container">
	<div class="card card-outline card-info">
		<div class="card-header">
			<a href="franchise_add.php" class="btn btn-sm btn-info">Add Franchise</a>
			<div class="card-tools">
			  <div class="input-group input-group-sm">
			    <input type="text" name="table_search" id="myInput" class="form-control float-right" placeholder="Search">
			  </div>
			</div>
		</div>

			<div class="card-body table-responsive p-0">
				<table class="table table-hover table-bordered table-sm table-head-fixed">
					<thead>
						<tr>
						  <th>Name</th>
						  <th>GST No</th>
						  <th>Contact No</th>
						  <th>Address</th>
						</tr>
					</thead>         
						<?php
							$result = $read->fetch_branch_list();
								if ($result->num_rows < 1) {
									echo "<tr><td colspan='4'>No branches added yet!</td><tr>";
								} else {
									foreach ($result as $key => $row) :
						?>
					<tbody id="myTable">
						<tr>
							<td><?php echo $row['branch_name']; ?></td>
							<td><?php echo $row['branch_gst']; ?></td>
							<td><?php echo $row['branch_landline'].', '.$row['branch_mobile']; ?></td>
							<td><?php echo $row['branch_address'].', '.$row['area_name']; ?></td>
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
</div>

<?php require_once 'includes/footer.php'; ?>