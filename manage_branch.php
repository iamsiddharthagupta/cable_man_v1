<?php

    ob_start();
    session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

    $page = 'manage_branch.php';

    require_once 'includes/top-nav.php';
    require_once 'includes/side-nav.php';

    $create->create_branch();

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h4 class="text-dark">Branch Management</h4>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Branch Management</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid pt-2">
	<div class="card card-outline card-info">
		<div class="card-header">
			<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#exampleModal">
			  Add Branch
			</button>
			<div class="card-tools">
			  <div class="input-group input-group-sm">
			    <input type="text" name="table_search" id="myInput" class="form-control float-right" placeholder="Search">
			  </div>
			</div>
		</div>

			<div class="card-body table-responsive p-0" style="height:500px;">
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

<!-- Add Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Branch</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off">
			<div class="form-group">
				<label>Name:</label>
				<input type="text" name="branch_name" placeholder="Branch name" class="form-control" required="">
			</div>
			<div class="form-row">
				<div class="form-group col-md">
					<label>Landline No:</label>
					<input type="text" name="branch_landline" placeholder="Lanline No" class="form-control" required="">
				</div>
				<div class="form-group col-md">
					<label>Mobile No:</label>
					<input type="text" name="branch_mobile" placeholder="Mobile No" id="phone" class="form-control" required="">
				</div>
			</div>
			<div class="form-row">
				<div class="form-group">
					<label>GST No:</label>
					<input type="text" name="branch_gst" placeholder="15 digit GST number" class="form-control" required="">
				</div>
				<div class="form-group col-md">
					<label>Area:</label>
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
			<div class="form-row">
				<div class="form-group col-md">
					<label>Address:</label>
					<input type="text" name="branch_address" placeholder="Address" class="form-control" required="">
				</div>
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
    </form>
      </div>
    </div>
  </div>
</div>