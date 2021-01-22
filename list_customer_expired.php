<?php

  ob_start();
  session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

	$page = 'list_customer_expired.php';

	require_once 'includes/top-nav.php';
	require_once 'includes/side-nav.php';

?>

<div class="container-fluid p-2">

	<div class="form-row justify-content-center">
		<div class="form-group col-md-6">
			<input id="myInput" class="form-control text-center" placeholder="Quick Search">
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
	
	$result = $read->user_list_expired();

	if ($result->num_rows < 1) {
		
		echo "<tr><td colspan='7'>No user yet.</td><tr>";
	
	} else {

		foreach ($result as $key => $row) : ?>
		<tbody id="myTable">
			<tr>

				<td>
					<div class="btn-group" role="group">
    					<button type="button" class="btn btn-dark btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      						Action
    					</button>
	    				<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
						      <a class="dropdown-item" href="user_profile_renewal.php?user_id=<?php echo $row['user_id']; ?>&dev_id=<?php echo $row['dev_id']; ?>">Renew</a>
						      <a class="dropdown-item" href="user_profile_update.php?user_id=<?php echo $row['user_id']; ?>">Update Profile</a>
						      <a class="dropdown-item" href="user_profile_ledger.php?user_id=<?php echo $row['user_id']; ?>">Ledger Book</a>
					    </div>
				  	</div>
				</td>

				<td>
					<strong><?php echo $row['first_name']." ".$row['last_name'];?></strong>
				</td>

				<td><strong><?php echo $row['device_mso']; ?></strong> - <span><?php echo $row['device_no']; ?></span></td>

				<td><strong class="text-danger">Expiry: <?php echo date('j M',strtotime($row['expiry'])); ?></strong></td>

				<td><?php echo $row['phone_no'];?></td>

				<td><?php echo $row['address'];?>, <strong><?php echo $row['area'];?></strong></td>

				<td><span>Rs.</span><?php echo $row['package'];?></td>

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

<?php require_once 'includes/footer.php'; ?>