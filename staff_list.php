<?php

    ob_start();
    session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

    $page = 1.3;

    require_once 'includes/top-nav.php';
    require_once 'includes/side-nav.php';

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h4 class="text-dark">Staff List</h4>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Staff Management</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="container">
	<div class="card card-info card-outline">
		<div class="card-header">
			<a href="staff_add.php" class="btn btn-sm btn-info">Add Staff</a>
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
					<th>Position</th>
					<th>Username</th>
					<th>Name</th>
					<th>Phone</th>
					<th>Branch</th>
			    </tr>
			</thead>         
			<?php
				$result = $read->fetch_staff_detail_list();
					if ($result->num_rows < 1) {
						echo "<tr><td colspan='5'>No MSO Yet!</td><tr>";
					} else {
						foreach ($result as $key => $row) :
			?>
			<tbody id="myTable">
				<tr>
					<td><span class="badge badge-danger"><?php echo $row['staff_position']; ?></span></td>
					<td><?php echo $row['username']; ?></td>
					<td><?php echo $row['full_name']; ?></td>
					<td><?php echo $row['mobile_no']; ?></td>
					<td><?php echo $row['fr_name']; ?></td>
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