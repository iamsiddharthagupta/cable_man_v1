<?php

    ob_start();
    session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

    $page = 'manage_mso.php';

    require_once 'includes/top-nav.php';
    require_once 'includes/side-nav.php';

    $create->create_mso();

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h4 class="text-dark">MSO Management</h4>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">MSO Management</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid pt-2">
	<div class="row">
			<div class="col-md-4">
				<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off">
					<div class="card card-outline card-info">
						<div class="card-header">
						  <h3 class="card-title">Add MSO</h3>

						  <div class="card-tools">
						    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						      <i class="fas fa-minus"></i></button>
						  </div>
						</div>

						<div class="card-body">
						  <div class="form-group">
						  	<label>MSO Name</label>
						    <input type="text" name="mso_name" placeholder="MSO Name" class="form-control">
						  </div>
						  <div class="form-group">
						  	<label>MSO Price</label>
						    <input type="text" name="mso_price" placeholder="MSO Price" class="form-control">
						  </div>
						</div>
						<div class="card-footer">
							<button type="submit" name="submit" class="btn btn-info float-right">Add</button>
						</div>
					</div>
				</form>
			</div>

			<div class="col-md-8">
				<div class="card card-outline card-info">
				<div class="card-header">
					<h3 class="card-title">MSOs</h3>

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
		              <th>MSO Name</th>
		              <th>MSO Price</th>
		            </tr>
		          </thead>         

					<?php

						$result = $read->fetch_mso_list();

						if ($result->num_rows < 1) {

						echo "<tr><td colspan='2'>No MSO added yet!</td><tr>";

						} else {

						foreach ($result as $key => $row) :

					?>
							<tbody id="myTable">
								<tr>
									<td><?php echo $row['mso_name']; ?></td>
									<td><?php echo $row['mso_price']; ?></td>
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
</div>

<?php require_once 'includes/footer.php'; ?>