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

	<div class="form-row">
		<div class="form-group col-md">
			<input id="myInput" class="form-control border-success text-center" placeholder="Search...">
		</div>
		<div class="form-group col-md">
			<select class="form-control">
				<option value="">ABC</option>
				<option value="">DEF</option>
			</select>
		</div>
		<div class="col-auto">
			<button class="btn btn-primary">Filter</button>
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
			cbl_dev_stock.device_no AS device_no,
			cbl_ledger.renew_date AS renew_date,
			cbl_ledger.status AS status,
			COUNT(cbl_user_dev.dev_id) AS device_count

			FROM cbl_user_dev

			RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
			LEFT JOIN cbl_ledger ON cbl_ledger.dev_id = cbl_user_dev.dev_id
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
								<?php if(!empty($data['device_no']) && empty($data['status'])){ ?>
									<a class="dropdown-item" href="profile_devices.php?user_id=<?php echo $data['user_id']; ?>">Activate</a>
								<?php } elseif(!empty($data['status'])) { ?>
									<a class="dropdown-item" href="profile_renewal.php?user_id=<?php echo $data['user_id']; ?>">Renew</a>
								<?php } else { ?>
								<a class="dropdown-item" href="profile_device_map.php?user_id=<?php echo $data['user_id']; ?>">Assign Device</a>
								<?php } ?>
						    </div>
				  		</div>
					</td>

					<td>
						<?php if(empty($data['device_no'])){ ?>
							<div class="text-warning"><strong>Device Unassigned</strong></div>
						<?php } elseif(!empty($data['device_no']) && empty($data['status'])) { ?>
							<div class="text-danger"><strong>Activation Pending</strong></div>
						<?php } else { ?>
							<div class="text-success"><strong>Active</strong></div>
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