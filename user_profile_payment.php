<?php

	require_once 'user_profile_base.php';

	$ledger_id = $_GET['ledger_id'];
	
	$result = $user->user_profile_payment_fetch($_GET['ledger_id']);
	$row = mysqli_fetch_assoc($result);

	$result = $user->user_profile_payment();
?>
		<div class="col-md">
	        <form method="POST">
				<div class="card">
					<div class="card-header">Payment Panel:</div>
					  <ul class="list-group list-group-flush">
					    <li class="list-group-item"><span class="mr-2">Device:</span>
					    	<strong>[<?php echo $row['device_mso']; ?>] <?php echo $row['device_no']; ?></strong>
					    </li>
					    <li class="list-group-item"><span class="mr-2">Duration:</span>
					    	<strong><?php echo date('jS M',strtotime($row['renew_date'])); ?> - <?php echo date('jS M',strtotime($row['expiry_date'])); ?></strong>
					    </li>
					    <li class="list-group-item"><span class="mr-2">Invoice:</span>
					    	<strong><?php echo $row['invoice_no']." - ".$row['renew_month']; ?></strong>
					    	<input type="hidden" name="ledger_id" value="<?php echo $row['ledger_id']; ?>">
					    	<input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
					    	<input type="hidden" name="due_invoice" value="<?php echo $row['invoice_no']; ?>">
					    	<input type="hidden" name="due_amount" value="<?php echo $row['due_amount']; ?>">
					    </li>
					    <li class="list-group-item">
					    	<div class="form-row">
					    		<div class="form-group col-md">
					    			<input type="number" name="pay_amount" class="form-control" value="<?php echo $row['due_amount']; ?>">
					    		</div>
					    		<div class="form-group col-md">
					    			<input type="number" name="pay_discount" class="form-control" placeholder="Discount">
					    		</div>
					    	</div>
					    </li>
					    <li class="list-group-item">
					    	<input type="text" name="pay_date" class="form-control curr_date" required>
					    </li>
					     <li class="list-group-item">
					    	
							<button type="submit" name="submit" class="btn btn-primary">Submit</button>
					    </li>
					  </ul>
				</div>
			</form>
		</div>
	
	</div>
</div>

<?php require_once 'assets/footer.php'; ?>