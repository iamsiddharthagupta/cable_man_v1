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

	$query = $_GET['query'];

	require_once 'connection.php';
	require_once 'organ.php';

?>

<div class="container-fluid p-2">

	<div class="row justify-content-center">
		<div class="col-sm-6">
			<input id="myInput" class="form-control border-success text-center mb-2" placeholder="Active List, Search...">
		</div>
	</div>

	<div class="card-body table-responsive p-0" style="height: 600px;">
		<table class="table table-hover text-center table-bordered table-sm table-head-fixed text-nowrap">
			    <thead class="thead-light">
			      <tr>
			      	<th>Action</th>
			      	<th>Name</th>
			      	<th>Device</th>
			      	<th>Duration</th>
			        <th>Mobile No</th>
			        <th>Address</th>
			        <th>Package</th>
			      </tr>
				</thead>

<?php

	$query = "
				SELECT
				cbl_user.user_id AS user_id,
				cbl_user.first_name AS first_name,
				cbl_user.last_name AS last_name,
				cbl_user.phone_no AS phone_no,
				cbl_user.address AS address,
				cbl_user.area AS area,
				cbl_dev_stock.package AS package,
				cbl_dev_stock.device_no AS device_no,
				cbl_dev_stock.device_mso AS device_mso,
				MAX(cbl_ledger.renew_date) AS renew_date,
				MAX(cbl_ledger.expiry_date) AS expiry_date,
				cbl_ledger.ledger_id AS ledger_id

				FROM cbl_user_dev
				RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
				RIGHT JOIN cbl_ledger ON cbl_ledger.dev_id = cbl_user_dev.dev_id
				LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id ".$query;

	$result = mysqli_query($conn,$query);

	if (mysqli_num_rows($result) < 1) {
		echo "<tr><td colspan='13'>No user yet.</td><tr>";
	} else {

		foreach ($result as $key => $data) :

		$current_date = date_create(date('Y-m-d'));
		$end_date = date_create($data['expiry_date']);

?>
		<tbody id="myTable">
			<tr>

				<td>
					<div class="btn-group" role="group">
    					<button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      						Action
    					</button>
	    				<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
						      <a class="dropdown-item" href="renewal_form.php?user_id=<?php echo $data['user_id']; ?>">Renew</a>
						      <a class="dropdown-item" href="user_ledger_summarized.php?user_id=<?php echo $data['user_id']; ?>">Add Payment</a>
					    </div>
				  	</div>
				</td>

				<td>
					<a href="user_profile.php?user_id=<?php echo $data['user_id']; ?>">
					<?php if($current_date > $end_date){ ?>
						<div>
							<strong><span class="mr-1"><?php echo $data['first_name']." ".$data['last_name'];?></span><span class="text-danger">[Expired]</span></strong>
						</div>
					<?php } elseif($current_date == $end_date) { ?>
							<strong><span class="mr-1"><?php echo $data['first_name']." ".$data['last_name'];?></span><span class="text-warning">[Expiring]</span></strong>
					<?php } else { ?>
							<strong>
								<span class="mr-1"><?php echo $data['first_name']." ".$data['last_name'];?></span>
							</strong>
					<?php } ?>
					</a>
				</td>

				<td><strong><?php echo $data['device_mso']; ?></strong> - <span><?php echo $data['device_no']; ?></span></td>

				<td>
					<strong><?php echo date('j F',strtotime($data['renew_date'])); ?><span> - </span><?php echo date('j F',strtotime($data['expiry_date'])); ?>
					</strong>
				</td>

				<td><?php echo $data['phone_no'];?></td>

				<td><span class="mr-2"><?php echo $data['address'];?>,</span><strong><?php echo $data['area'];?></strong></td>

				<td><span>Rs.</span><?php echo $data['package'];?></td>

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