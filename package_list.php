<?php

    ob_start();
    session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

    $page = 1.4;

    require_once 'includes/top-nav.php';
    require_once 'includes/side-nav.php';

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h4 class="text-dark">Package List</h4>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Package Management</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="container">
	<div class="card card-outline card-info">
		<div class="card-header">
			<a href="package_add.php" class="btn btn-sm btn-info">Add Package</a>
			<div class="card-tools">
			  <div class="input-group input-group-sm">
			    <input type="text" name="table_search" id="myInput" class="form-control float-right" placeholder="Search">
			  </div>
			</div>
		</div>

		<div class="card-body table-responsive p-0">
			<table class="table table-hover text-center table-bordered table-sm table-head-fixed text-nowrap">
	          <thead>
	            <tr>
	              <th>Name</th>
	              <th>Price</th>
	              <th>Type</th>
	              <th>Duration</th>
	              <th>MSO</th>
	            </tr>
	          </thead>         

				<?php
					$result = $read->fetch_package_list();
						if ($result->num_rows < 1) {
							echo "<tr><td colspan='5'>No package added yet!</td><tr>";
						} else {
							foreach ($result as $key => $row) :
				?>
						<tbody id="myTable">
							<tr>
								<td><?php echo $row['pack_name']; ?></td>
								<td><?php echo $row['pack_price']; ?></td>
								<td><?php echo $row['pack_type']; ?></td>
								<td><?php echo $row['pack_duration']; ?></td>
								<td><?php echo $row['mso_name']; ?></td>
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