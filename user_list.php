<?php

  session_start();

  if(isset($_SESSION['user_level'])) {
      $curr_user = ucwords($_SESSION['curr_user']);
      if($_SESSION['user_level'] != 1) {
          header('Location: agent_panel.php');
      }
  } else {
    header('Location: index.php');
  }

  require_once 'connection.php';
  require_once 'organ.php';

?>

<div class="container-fluid p-2">

	<div class="form-row justify-content-center">
		<div class="form-group col-md-6">
			<input id="myInput" class="form-control text-center" placeholder="Search...">
		</div>
		<div class="col-auto">
			<form method="post" action="export_data.php">
	      		<input type="submit" name="export" class="btn btn-outline-success mb-2 mr-sm-2" value="export xls">
    		</form>
		</div>
	</div>

	<div class="card-body table-responsive p-0" style="height: 600px;">
		<table class="table table-hover text-center table-bordered table-sm table-head-fixed text-nowrap">
		    <thead class="thead-light">
		      <tr>
		      	<th>Action</th>
		      	<th>Notification</th>
		        <th>Name</th>
		        <th>Address</th>
		        <th>Mobile No</th>
		        <th>Connection(s)</th>
		        <th>Package</th>
		      </tr>
			</thead>

<?php

	$user = new User();
	$result = $user->user_list();

	if(mysqli_num_rows($result) < 1){
		
		echo "<tr><td colspan='10'>No user yet! Start feeding them from <a href='user_profile_add.php'>here</a></td><tr>";
	
	} else {

		foreach ($result as $key => $data) : ?>

			<tbody id="myTable">
				<tr>

					<td>
						<div class="btn-group" role="group">
	    					<button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	      						Action
	    					</button>
		    				<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
								<?php if($data['user_status'] == 0){ ?>
									<a class="dropdown-item" href="user_profile_update.php?user_id=<?php echo $data['user_id']; ?>">Activate</a>
								<?php } elseif($data['user_status'] == 1 AND !empty($data['dev_id'])){ ?>
									<a class="dropdown-item" href="user_profile_devices.php?user_id=<?php echo $data['user_id']; ?>">Activate</a>
								<?php } elseif(empty($data['dev_id'])) { ?>
									<a class="dropdown-item" href="user_profile_device_map.php?user_id=<?php echo $data['user_id']; ?>">Assign Device</a>
								<?php } ?>
								<a class="dropdown-item" href="user_profile_update.php?user_id=<?php echo $data['user_id']; ?>">Update Profile</a>
						    </div>
				  		</div>
					</td>

					<td>
						<?php echo $data['user_status']; ?>
					</td>

					<td><a href="user_profile_ledger.php?user_id=<?php echo $data['user_id']; ?>"><strong><?php echo $data['first_name']." ".$data['last_name'];?></strong></a></td>

					<td><?php echo $data['address'];?>, <strong><?php echo $data['area'] ?></strong></td>

					<td><?php echo $data['phone_no'];?></td>

					<td><?php echo $data['device_count']; ?></td>
					
					<td><?php echo $data['package'];?></td>
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