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

	<div class="form-row justify-content-center mb-1">
		<div class="form-group col-md-6">
			<input id="myInput" class="form-control border-success text-center" placeholder="Search...">
		</div>
		<div class="col-auto">
			<div class="btn-group" role="group">
				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Filter Area
				</button>
				<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
				      <a class="dropdown-item" href="payment_list.php?query=<?php echo OverdueList('Renewed'); ?>">All</a>

				      <a class="dropdown-item" href="payment_list.php?query=<?php echo OverdueFilter('Humayunpur'); ?>">Humayunpur</a>
				      <a class="dropdown-item" href="payment_list.php?query=<?php echo OverdueFilter('Arjun Nagar'); ?>">Arjun Nagar</a>
				      <a class="dropdown-item" href="payment_list.php?query=<?php echo OverdueFilter('Krishna Nagar'); ?>">Krishna Nagar</a>
				      <a class="dropdown-item" href="payment_list.php?query=<?php echo OverdueFilter('B-4'); ?>">B-4</a>

				      <a class="dropdown-item" href="payment_list.php?query=<?php echo OverdueFilter('Other'); ?>">Other</a>
			    </div>
			</div>
		</div>
	</div>

	<div class="card-body table-responsive p-0" style="height: 600px;">
		<table class="table table-hover text-center table-bordered table-sm table-head-fixed text-nowrap">
			    <thead class="thead-light">
			      <tr>
			      	<th>Pay</th>
			      	<th>Device ID</th>
			      	<th>Name</th>
			        <th>Mobile No</th>
			        <th>Address</th>
			        <th>Area</th>
			      	<th>Duration</th>
			      	<th>Due Month</th>
			      	<th>Due Amount</th>
			      	<th>Paid Amount</th>
			      </tr>
				</thead>

		<?php
				
			$query = "
						SELECT
		                cbl_user.user_id AS user_id,
		                cbl_user.first_name AS first_name,
		                cbl_user.last_name AS last_name,
		                cbl_user.address AS address,
		                cbl_user.area AS area,
		                cbl_user.phone_no AS phone_no,
		                cbl_dev_stock.dev_id AS dev_id,
		                cbl_dev_stock.device_no AS device_no,
		                cbl_ledger.renew_date AS renew_date,
		                cbl_ledger.pay_amount AS pay_amount,
		                cbl_ledger.expiry_date AS expiry_date,
		                cbl_ledger.renew_month AS renew_month,
		                cbl_ledger.due_amount AS due_amount,
		                cbl_ledger.pay_amount AS pay_amount,
		                cbl_ledger.renew_term AS renew_term,
		                cbl_ledger.user_id AS user_id,
		                cbl_ledger.ledger_id AS ledger_id

		                FROM cbl_user_dev
		                RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
		                LEFT JOIN cbl_ledger ON cbl_ledger.dev_id = cbl_user_dev.dev_id
		                LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id ".$query;

	$result = mysqli_query($conn,$query);

	if (mysqli_num_rows($result) < 1){
		echo "<tr><td colspan='13'>No user yet.</td><tr>";
	} else {
		
		foreach ($result as $key => $data) :

			$urlMulti = "user_id={$data['user_id']}&ledger_id={$data['ledger_id']}&dev_id={$data['dev_id']}";

		?>

		<tbody id="myTable">
			<tr>

				<td>
					<?php if(empty($data['pay_amount'])){ ?>
						<button onclick="window.location.href='profile_payment.php?<?= $urlMulti; ?>'" class="btn btn-sm btn-danger">INR <?php echo $data['due_amount']; ?></button>
					<?php } else { ?>
						<form method="POST" action="receipt.php">
							<input type="hidden" name="ledger_id" value="<?php echo $data['ledger_id']; ?>">
							<input type="submit" class="btn btn-outline-success btn-sm" value="Receipt">
						</form>
                    <?php } ?>
				</td>

				<td><?php echo $data['device_no']; ?></td>
				
				<td>
					<a href="profile_ledger.php?user_id=<?php echo $data['user_id']; ?>">
						<strong><?php echo $data['first_name']." ".$data['last_name'];?></strong>
					</a>
				</td>

				<td><?php echo $data['phone_no'];?></td>

				<td><?php echo $data['address'];?></td>

				<td><?php echo $data['area'];?></td>

				<td><strong><span><?php echo date('jS M y',strtotime($data['renew_date']));?> - <?php echo date('jS M y',strtotime($data['expiry_date']));?></span></strong></td>

				<td><strong><?php echo $data['renew_month'];?> (x <?php echo $data['renew_term'];?>)</strong></td>
				
				<td><strong><?php echo $data['due_amount'];?></strong></td>
				
				<td><strong><?php echo $data['pay_amount'];?></strong></td>

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