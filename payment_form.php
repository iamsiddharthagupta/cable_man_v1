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

	$ledger_id = $_GET['ledger_id'];

	$query = "
			SELECT * FROM cbl_user_dev

			RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
			LEFT JOIN cbl_ledger ON cbl_ledger.dev_id = cbl_user_dev.dev_id
			LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id
			
			WHERE cbl_ledger.ledger_id = '$ledger_id'
			";
	$result = mysqli_query($conn,$query);
	$data = mysqli_fetch_assoc($result);
	$user_id = $data['user_id'];
?>

<div class="container-fluid p-3">

<div class="row">		
	<div class="col-sm-4  mb-2">
		<form method="POST" action="<?php echo htmlspecialchars('payment_process.php'); ?>">
			<div class="card">
				<div class="card-header">Payment Panel:</div>
				  <ul class="list-group list-group-flush">
				    <li class="list-group-item"><span class="mr-2">Name:</span>
				    	<strong><a href="user_profile.php?user_id=<?php echo $data['user_id']; ?>"><?php echo $data['first_name']." ".$data['last_name']; ?></a></strong>
				    </li>
				    <li class="list-group-item"><span class="mr-2">Phone Number:</span>
				    	<strong><?php echo $data['phone_no']; ?></strong>
				    </li>
				    <li class="list-group-item"><span class="mr-2">Address:</span>
				    	<strong><?php echo $data['address']; ?></strong>
				    </li>
				    <li class="list-group-item"><span class="mr-2">Selected Device:</span>
				    	<strong><?php echo $data['device_no']." - ".$data['device_mso']; ?></strong>
				    </li>
				    <li class="list-group-item"><span class="mr-2">Invoice Details:</span>
				    	<strong><?php echo $data['invoice_no']." - ".$data['renew_month']; ?></strong>
				    </li>
				    <li class="list-group-item">
				    	<input type="number" name="pay_amount" class="form-control border-success" placeholder="Amount payable <?php echo $data['package']; ?>" value="<?php echo $data['package']; ?>">
				    </li>
				    <li class="list-group-item">
				    	<input type="date" name="pay_date" class="form-control" required>
				    </li>
				    <li class="list-group-item">
				    	<textarea name="note" placeholder="Notes" class="form-control"><?php echo $data['note']; ?></textarea>
				    </li>
				     <li class="list-group-item">
				    	<input type="hidden" name="ledger_id" value="<?php echo $data['ledger_id']; ?>">
				    	<input type="hidden" name="due_invoice" value="<?php echo $data['invoice_no']; ?>">
						<button type="submit" name="submit" class="btn btn-primary">Submit</button>
				    </li>
				  </ul>
			</div>
		</form>
	</div>

	<div class="col-sm-8">
		<?php include 'user_ledger.php'; ?>
	</div>

	</div>
</div>

<?php require_once 'common/footer.php'; ?>