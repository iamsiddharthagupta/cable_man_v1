<?php

	require_once 'user_profile_base.php';

	$sql = "
			SELECT
			d.device_no,
			d.device_mso,
			l.renew_date,
			l.expiry_date,
			l.renew_month,
			l.invoice_no,
			l.due_amount,
			l.pay_balance,
			l.ledger_id,
			l.user_id

			FROM cbl_user_dev ud

			RIGHT JOIN cbl_user u ON u.user_id = ud.user_id
			LEFT JOIN cbl_ledger l ON l.dev_id = ud.dev_id
			LEFT JOIN cbl_dev_stock d ON d.dev_id = ud.dev_id

			WHERE l.ledger_id = '" .$_GET['ledger_id']. "'";

	$row = $organ->query($sql)->fetch_assoc();

	// $organ->user_profile_payment();

?>
		<div class="col-md-9">
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Payment Wizard</h3>
					<div class="card-tools">
					  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
					  </button>
					</div>
				</div>
				<div class="card-body">
		        <form method="POST">
					<div class="card">
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

	</div>
</div>

<?php require_once 'includes/footer.php'; ?>