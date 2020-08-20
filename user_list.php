<?php

  session_start();

  if(isset($_SESSION['user_level'])){
      $curr_user = ucwords($_SESSION['curr_user']);
      if($_SESSION['user_level'] != 1){
          header('Location: agent_panel.php');
      }
  } else {
    header('Location: index.php');
  }

  require_once 'connection.php';
  require_once 'organ.php';

  $query = $_GET['query'];

?>

<div class="container-fluid p-2">

	<div class="form-row justify-content-center">
		<div class="form-group col-md-6">
			<input id="myInput" class="form-control border-success text-center" placeholder="Search...">
		</div>
		<div class="col-auto">
			<div class="btn-group" role="group">
				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Filter Area
				</button>
				<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
				      <a class="dropdown-item" href="user_list.php?query=<?php echo UserList(); ?>">All</a>

				      <a class="dropdown-item" href="user_list.php?query=<?php echo UserFilter('Humayunpur'); ?>">Humayunpur</a>
				      <a class="dropdown-item" href="user_list.php?query=<?php echo UserFilter('Arjun Nagar'); ?>">Arjun Nagar</a>
				      <a class="dropdown-item" href="user_list.php?query=<?php echo UserFilter('Krishna Nagar'); ?>">Krishna Nagar</a>
				      <a class="dropdown-item" href="user_list.php?query=<?php echo UserFilter('B-4'); ?>">B-4</a>

				      <a class="dropdown-item" href="user_list.php?query=<?php echo UserFilter('Other'); ?>">Other</a>
			    </div>
			</div>
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

	$query ="
			SELECT
			cbl_user.user_id AS user_id,
			cbl_user.first_name AS first_name,
			cbl_user.last_name AS last_name,
			cbl_user.address AS address,
			cbl_user.area AS area,
			cbl_user.phone_no AS phone_no,
			SUM(cbl_dev_stock.package) AS package,
			COUNT(cbl_user_dev.dev_id) AS device_count,
			cbl_user_dev.dev_id AS dev_id

			FROM cbl_user_dev

			RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
			LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id ".$query;
	$result = mysqli_query($conn,$query);

	if(mysqli_num_rows($result) < 1){
		echo "<tr><td colspan='10'>No user yet! Start feeding them from <a href='add_user.php'>here</a></td><tr>";
	} else {
		$i = 0;
		foreach ($result as $key => $data) : $i++; ?>

			<tbody id="myTable">
				<tr>
					<td>
						<div class="btn-group" role="group">
	    					<button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	      						Action
	    					</button>
		    				<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
								<?php if(!empty($data['dev_id'])){ ?>
									<a class="dropdown-item" href="profile_devices.php?user_id=<?php echo $data['user_id']; ?>">Activate</a>
								<?php } else { ?>
								<a class="dropdown-item" href="profile_device_map.php?user_id=<?php echo $data['user_id']; ?>">Assign Device</a>
								<?php } ?>
								<a class="dropdown-item" href="profile_update.php?user_id=<?php echo $data['user_id']; ?>">Update Profile</a>
						    </div>
				  		</div>
					</td>

					<td>
						<?php if(empty($data['dev_id'])){ ?>
							<div class="text-danger"><strong>Device Unmapped</strong></div>
						<?php } else { ?>
							<div class="text-success"><strong>Ready</strong></div>
						<?php } ?>
					</td>

					<td><a href="profile_ledger.php?user_id=<?php echo $data['user_id']; ?>"><strong><?php echo $data['first_name']." ".$data['last_name'];?></strong></a></td>

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

<?php require_once 'common/footer.php'; ?>