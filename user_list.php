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
  require_once 'organ.php';
?>

<div class="container-fluid p-2">

	<div class="form-row justify-content-center">
		<div class="form-group col-md-6">
			<input id="myInput" class="form-control text-center" placeholder="Search...">
		</div>
		<div class="col-auto">
			<form method="POST" action="export_data.php">
	      		<input type="submit" name="export" class="btn btn-outline-success mb-2 mr-sm-2" value="export xls">
    		</form>
		</div>
	</div>

	<div class="card-body table-responsive p-0" style="height: 600px;">
		<table class="table table-hover text-center table-bordered table-sm table-head-fixed text-nowrap">
		    <thead class="thead-light">
		      <tr>
		      	<th>Action</th>
		      	<th>Status</th>
		        <th>Name</th>
		        <th>Address</th>
		        <th>Phone</th>
		        <th>Conn(s)</th>
		        <th>Rate</th>
		      </tr>
			</thead>

<?php

	$result = $user->user_list();

	if(mysqli_num_rows($result) < 1){
		
		echo "<tr><td colspan='10'>No user yet! Start feeding them from <a href='user_profile_add.php'>here</a></td><tr>";
	
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
								
		    					<?php if(empty($row['dev_id'])){ ?>
		    						<a class="dropdown-item" href="user_profile_device_map.php?user_id=<?php echo $row['user_id']; ?>">Assign Device</a>
		    					<?php } elseif(!empty($row['dev_id'])){ ?>
		    						<a class="dropdown-item" href="user_profile_devices.php?user_id=<?php echo $row['user_id']; ?>">Activate</a>
		    					<?php } ?>
								<a class="dropdown-item" href="user_profile_update.php?user_id=<?php echo $row['user_id']; ?>">Update Profile</a>
						    </div>
				  		</div>
					</td>

					<td>
						<?php echo $row['user_status']; ?>
					</td>

					<td><a href="user_profile_ledger.php?user_id=<?php echo $row['user_id']; ?>"><strong><?php echo $row['first_name']." ".$row['last_name'];?></strong></a></td>

					<td><?php echo $row['address'];?>, <strong><?php echo $row['area'] ?></strong></td>

					<td><?php echo $row['phone_no'];?></td>

					<td><?php echo $row['device_count']; ?></td>
					
					<td><?php echo $row['package'];?></td>
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