<?php

	session_start();

	if(isset($_SESSION['user_level'])) {
	  $curr_user = ucwords($_SESSION['curr_user']);
	  if($_SESSION['user_level'] != 1){
	      header('Location: agent_panel.php');
	  }
	} else {
	header('Location: index.php');
	}

	$page = 'user_list_expired.php';

	require_once 'organ.php';
?>

<div class="container-fluid p-2">

	<div class="form-row justify-content-center">
		<div class="form-group col-md-6">
			<input id="myInput" class="form-control text-center" placeholder="Search...">
		</div>
	</div>

	<div class="card-body table-responsive p-0" style="height: 600px;">
		<table class="table table-hover text-center table-bordered table-sm table-head-fixed text-nowrap">
			    <thead class="thead-light">
			      <tr>
			      	<th>Action</th>
			      	<th>Name</th>
			      	<th>Device</th>
			      	<th>Status</th>
			        <th>Phone</th>
			        <th>Address</th>
			        <th>Rate</th>
			      </tr>
				</thead>

<?php
	
	$result = $user->user_list_expired();

	if (mysqli_num_rows($result) < 1) {
		echo "<tr><td colspan='13'>No user yet.</td><tr>";
	} else {

		foreach ($result as $key => $row) :

		$current_date = date_create(date('Y-m-d'));
		$end_date = date_create($row['expiry_date']);

?>
		<tbody id="myTable">
			<tr>

				<td>
					<div class="btn-group" role="group">
    					<button type="button" class="btn btn-dark btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      						Action
    					</button>
	    				<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
						      <a class="dropdown-item" href="user_profile_select_device.php?user_id=<?php echo $row['user_id']; ?>">Renew</a>
						      <a class="dropdown-item" href="user_profile_update.php?user_id=<?php echo $row['user_id']; ?>">Update Profile</a>
						      <a class="dropdown-item" href="user_profile_ledger.php?user_id=<?php echo $row['user_id']; ?>">Add Payment</a>
					    </div>
				  	</div>
				</td>

				<td>
					<strong>
						<a href="user_profile_ledger.php?user_id=<?php echo $row['user_id']; ?>"><?php echo $row['first_name']." ".$row['last_name'];?></a>
					</strong>
				</td>

				<td><strong><?php echo $row['device_mso']; ?></strong> - <span><?php echo $row['device_no']; ?></span></td>

				<td>
					<strong class="text-danger">Expired On: <?php echo date('j M',strtotime($row['expiry_date'])); ?></strong>
				</td>

				<td><?php echo $row['phone_no'];?></td>

				<td><?php echo $row['address'];?>, <strong><?php echo $row['area'];?></strong></td>

				<td><span>Rs.</span><?php echo $row['package'];?></td>

			</tr>
		</tbody>
		<?php
			endforeach;
		}
	?>
		</table>
	</div>
</div>

<?php require_once 'assets/footer.php'; ?>