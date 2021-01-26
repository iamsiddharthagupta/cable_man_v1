<?php

    ob_start();
    session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

    $page = 'manage_package.php';

    require_once 'includes/top-nav.php';
    require_once 'includes/side-nav.php';

    $create->create_package();

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h4 class="text-dark">Package Management</h4>
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

<div class="container-fluid">
	<div class="card card-outline card-info">
		<div class="card-header">
			<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#exampleModal">
			  Add Package
			</button>

			<div class="card-tools">
			  <div class="input-group input-group-sm">
			    <input type="text" name="table_search" id="myInput" class="form-control float-right" placeholder="Search">
			  </div>
			</div>
		</div>

		<div class="card-body table-responsive p-0" style="height: 500px;">
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

<!-- Add -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Package</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off">
			<div class="form-group">
				<label>Name:</label>
				<input type="text" name="pack_name" placeholder="Package name" class="form-control">
			</div>
			<div class="form-row">
				<div class="form-group col-md">
					<label>Duration:</label>
					<input type="number" name="pack_duration" placeholder="Package duration" class="form-control">
				</div>
				<div class="form-group col-md">
					<label>Price:</label>
					<input type="number" name="pack_price" placeholder="Package price" class="form-control">
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md">
					<label>Type:</label>
					<select name="pack_type" class="form-control">
						<option value="">Package type:</option>
						<option value="SD">Standard Definition [SD]</option>
						<option value="HD">High Definition [HD]</option>
					</select>
				</div>
				<div class="form-group col-md">
					<label>MSO:</label>
						<?php

						  $msos = $read->fetch_mso_list();

						  echo "<select name='mso_id' class='form-control'>";
						  echo "<option value=''>Select MSO</option>";
						    foreach ($msos as $key => $mso) {
						      echo "<option value='$mso[mso_id]'>$mso[mso_name]</option>";
						    }
						  echo "</select>";

						?>
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