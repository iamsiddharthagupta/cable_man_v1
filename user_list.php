<?php

	ob_start();
	session_start();

	(!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

	$page = 3.2;

	require_once 'config/init.php';
	require_once 'includes/top-nav.php';
	require_once 'includes/side-nav.php';

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h4 class="text-dark">User List</h4>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">User Management</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="container">
	<div class="card card-outline card-info">
		<div class="card-header">
			<div class="card-tools">
			  <div class="input-group input-group-sm">
			    <input type="text" name="table_search" id="myInput" class="form-control float-right" placeholder="Search">
			  </div>
			</div>
		</div>
		<div class="card-body table-responsive p-0" style="height:200px;">
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
			    						<a class="dropdown-item" href="user_profile_device_map.php?user_id=<?php echo $row['user_id']; ?>">Assign Device</a>
			    					<?php } elseif(!empty($row['dev_id'])){ ?>
			    						<a class="dropdown-item" href="user_profile_select_device.php?user_id=<?php echo $row['user_id']; ?>">Start</a>
			    					<?php } ?>
			    					<a class="dropdown-item" href="user_profile_ledger.php?user_id=<?php echo $row['user_id']; ?>">Ledger Book</a>
									<a class="dropdown-item" href="user_profile_update.php?user_id=<?php echo $row['user_id']; ?>">Update Profile</a>
									<a class="dropdown-item" href="user_profile_device_map.php?user_id=<?php echo $row['user_id']; ?>">Map/Edit Device</a>
							    </div>
					  		</div>
						</td>
						<td><a href="user_profile_ledger.php?user_id=<?php echo htmlentities($row['user_id']); ?>"><?php echo $row['first_name']." ".$row['last_name'];?></a></td>
						<td><?php echo $row['address'];?>, <strong><?php echo $row['a_name'] ?></strong></td>
						<td><?php echo $row['mobile_no'];?></td>
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