<?php

    ob_start();
    session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

    $page = 'manage_staff.php';

    require_once 'includes/top-nav.php';
    require_once 'includes/side-nav.php';

    $create->create_staff();

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h4 class="text-dark">Staff Management</h4>
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

<div class="container-fluid pt-2">
	<div class="col-md">
		<div class="card card-info card-outline">
			<div class="card-header">
				<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#exampleModal">
					Add Staff
				</button>
				<div class="card-tools">
				  <div class="input-group input-group-sm">
				    <input type="text" name="table_search" id="myInput" class="form-control float-right" placeholder="Search">
				  </div>
				</div>
			</div>

			<div class="card-body table-responsive p-0" style="height:500px;">
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
						<td><?php echo $row['phone_no']; ?></td>
						<td><?php echo $row['branch_name']; ?></td>
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
        <h5 class="modal-title" id="exampleModalLabel">Add Staff</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off">
			<div class="form-row">
				<div class="form-group col-md">
					<label>Username:</label>
					<input type="text" name="username" placeholder="Username" class="form-control">
				</div>
				<div class="form-group col-md">
					<label>Password:</label>
					<input type="password" name="password" placeholder="Password" class="form-control">
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md">
					<label>First Name:</label>
					<input type="text" name="first_name" placeholder="First Name" class="form-control">
				</div>
				<div class="form-group col-md">
					<label>Last Name:</label>
					<input type="text" name="last_name" placeholder="Last Name" class="form-control">
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md">
					<label>Phone No:</label>
					<input type="text" name="phone_no" id="phone" placeholder="Phone Number" class="form-control">
				</div>
				<div class="form-group col-md">
					<label>Staff Position:</label>
					<select class="form-control" name="staff_position">
						<option value="">Select Position</option>
						<option value="1">Admin</option>
						<option value="2">Agent</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label>Branch:</label>
		            <?php

		              $branches = $read->fetch_branch_list_all();

		              echo "<select name='branch_id' class='form-control'>";
		              echo "<option value=''>Select Branch</option>";
		                foreach ($branches as $key => $branch) {
		                  echo "<option value='$branch[branch_id]'>$branch[branch_name]</option>";
		                }
		              echo "</select>";

		            ?>
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>