<?php

	require_once 'profile_casing.php';

	$ledger_id = $_GET['ledger_id'];
	$query = "	SELECT
				cbl_dev_stock.device_no AS device_no,
				cbl_dev_stock.device_mso AS device_mso,
				cbl_ledger.renew_date AS renew_date,
				cbl_ledger.expiry_date AS expiry_date,
				cbl_ledger.renew_month AS renew_month,
				cbl_ledger.invoice_no AS invoice_no,
				cbl_ledger.due_amount AS due_amount,
				cbl_ledger.pay_balance AS pay_balance,
				cbl_ledger.ledger_id AS ledger_id,
				cbl_ledger.user_id AS user_id

				FROM cbl_user_dev

				RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
				LEFT JOIN cbl_ledger ON cbl_ledger.dev_id = cbl_user_dev.dev_id
				LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id

				WHERE cbl_ledger.ledger_id = '$ledger_id'";
	$result = mysqli_query($conn,$query);
	$data = mysqli_fetch_assoc($result);
	
	$user_id = $data['user_id'];

?>
		<div class="col-md-3">
          	<div class="container-fluid">

		        <form method="POST" action="<?php echo htmlspecialchars('profile_payment_process.php'); ?>">
					<div class="card">
						<div class="card-header">Payment Panel:</div>
						  <ul class="list-group list-group-flush">
						    <li class="list-group-item"><span class="mr-2">Device:</span>
						    	<strong><?php echo $data['device_no']." - ".$data['device_mso']; ?></strong>
						    </li>
						    <li class="list-group-item"><span class="mr-2">Duration:</span>
						    	<strong><?php echo date('jS M',strtotime($data['renew_date'])); ?> - <?php echo date('jS M',strtotime($data['expiry_date'])); ?></strong>
						    </li>
						    <li class="list-group-item"><span class="mr-2">Invoice:</span>
						    	<strong><?php echo $data['invoice_no']." - ".$data['renew_month']; ?></strong>
						    	<input type="hidden" name="ledger_id" value="<?php echo $data['ledger_id']; ?>">
						    	<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
						    	<input type="hidden" name="due_invoice" value="<?php echo $data['invoice_no']; ?>">
						    	<input type="hidden" name="due_amount" value="<?php echo $data['due_amount']; ?>">
						    </li>
						    <li class="list-group-item">
						    	<input type="number" name="pay_amount" class="form-control border-success" value="<?php echo $data['due_amount']; ?>">
						    </li>
						    <li class="list-group-item">
						    	<input type="date" name="pay_date" class="form-control" required>
						    </li>
						     <li class="list-group-item">
						    	
								<button type="submit" name="submit" class="btn btn-primary">Submit</button>
						    </li>
						  </ul>
					</div>
				</form>

          	</div>
		</div>
		<div class="col-md-6">
			<div class="card-body table-responsive p-0" style="height: 490px;">
		        <table class="table table-hover text-center table-bordered table-sm table-head-fixed">
		                  <thead>
		                    <tr>
		                      <th>Device</th>
		                      <th>Month</th>
		                      <th>Due</th>
		                      <th>Amount</th>
		                      <th>Balance</th>
		                      <th>Status</th>
		                      <th>Payment</th>
		                    </tr>
		                </thead>

		        <?php
		        

				$query = "	SELECT * FROM cbl_user_dev
				            RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
				            LEFT JOIN cbl_ledger ON cbl_ledger.dev_id = cbl_user_dev.dev_id
				            LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id

				            WHERE cbl_ledger.user_id = '$user_id'
				            ORDER BY renew_date DESC";

				$result = mysqli_query($conn,$query);

				if (mysqli_num_rows($result) < 1){
				echo "<tr><td colspan='7'>Not Yet Active!</td><tr>";
				} else {

				foreach ($result as $key => $data) :

				    $urlMulti = "user_id={$user_id}&ledger_id={$data['ledger_id']}";

				?>

		            <tbody>
		              <tr>
		                
		                <td><?php echo $data['device_no']; ?></td>

		                <td>
		                  <strong><?php echo $data['renew_month']; ?></strong>
		                </td>

		                <td><?php echo $data['due_amount']; ?></td>

		                <td><?php echo $data['pay_amount']; ?></td>
		                
		                <td><?php echo $data['pay_balance']; ?></td>
		                
		                <td><?php echo $data['status']; ?></td>
		                
		                <td>
		                  <?php if($data['pay_date'] == NULL){ ?>
		                    <div class="text-danger">Unpaid</div>
		                  <?php } else { ?>
		                    <div><?php echo date('j F y',strtotime($data['pay_date'])); ?></div>
		                  <?php } ?>
		                </td>

		              </tr>
		            </tbody>
		            <?php
		              endforeach;
		            }
		          ?>
		        </table>
	      </div>
	</div>

</div>

</section>

<?php require_once 'common/footer.php'; ?>