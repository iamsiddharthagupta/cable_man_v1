<?php

	require_once 'user_profile_base.php';

	$result = $user->user_profile_renewal_fetch($_GET['user_id'],$_GET['dev_id']);
	$row = mysqli_fetch_assoc($result);

	$extend = $user->user_profile_renewal();
?>

		<div class="col-md-9">
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Extend Panel</h3>
					<div class="card-tools">
					  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
					  </button>
					</div>
				</div>
				<div class="card-body">
				    <form method="POST">
					    <div class="card">
							<ul class="list-group list-group-flush">
							    <li class="list-group-item"><span class="mr-2">Device No:</span>
							      <strong>[<?php echo $row['device_mso']; ?>] <?php echo $row['device_no']; ?></strong>
							    </li>
							    <li class="list-group-item"><span class="mr-2">Package:</span>
							      <strong>Rs.<?php echo $row['package']; ?></strong>
							    </li>
							    <li class="list-group-item"><span class="mr-2">Last Renewal:</span>
							      <strong><?php echo date('jS M y',strtotime($row['renew_date'])).' - '.date('jS M y',strtotime($row['expiry_date'])); ?></strong>
							    </li>
							    <li class="list-group-item">
							      <input type="text" name="renew_date" value="<?php echo $row['expiry_date']; ?>" class="form-control">
							    </li>
							    <li class="list-group-item"><span class="mr-2">Renewal Term:</span>
							      <select class="form-control" name="renew_term" required="">
							      	<option value="">Select Term</option>
							      	<option value="1" selected="">Monthly</option>
							      	<option value="3">Quarterly</option>
							      	<option value="6">Half Yearly</option>
							      	<option value="12">Annually</option>
							      </select>
							    </li>
							    <li class="list-group-item">
							      <input type="hidden" name="invoice_no" value="<?php echo 'ALC'.date('Ymd').$row['user_id']; ?>">
							      <input type="hidden" name="package" value="<?php echo $row['package']; ?>">
							      <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
							      <input type="hidden" name="dev_id" value="<?php echo $row['dev_id']; ?>">
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