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

?>

<div class="container-fluid p-2">

	<div class="form-row justify-content-center mb-1">
		<div class="form-group col-md-6">
			<input id="myInput" class="form-control border-success text-center" placeholder="Search...">
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
	
	$result = $user->user_list_unpaid();

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

<?php require_once 'assets/footer.php'; ?>