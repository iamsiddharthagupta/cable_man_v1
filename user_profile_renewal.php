<?php

	require_once 'user_profile_base.php';

	$row = $organ->renewal_wizard($_GET['device_id'])->fetch_assoc();

	// $user->user_profile_renewal();

?>

		<div class="col-md-9">
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Renewal Wizard</h3>
					<div class="card-tools">
					  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
					  </button>
					</div>
				</div>
				<form method="POST" class="needs-validation" novalidate>
					<div class="card-body">
						<ul class="list-group">
							<li class="list-group-item"><span class="mr-2">Device #</span>
						      <strong><?php echo $row['mso_name']; ?><?php echo $row['device_no']; ?></strong>
						    </li>
						    <li class="list-group-item mb-2"><span class="mr-2">Package</span>
						      <strong><?php echo $row['pack_code']; ?></strong>
						    </li>
						</ul>
						<div class="form-row">
							<div class="form-group col-md">
								<label>Renewal date</label>
								<input type="date" name="start_date" value="<?php echo date('Y-m-d'); ?>" class="form-control" required="">
							</div>
							<div class="form-group col-md">
								<label>Duration</label>
								<input type="number" name="duration" class="form-control" required="">
							</div>
						</div>
					</div>
					<div class="card-footer">
						<input type="hidden" name="invoice_no" value="<?php echo 'ALC'.date('Ymd').$row['user_id']; ?>">
						<input type="hidden" name="pack_code" value="<?php echo $row['pack_code']; ?>">
						<input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
						<input type="hidden" name="device_id" value="<?php echo $row['device_id']; ?>">
						<button type="submit" name="submit" class="btn btn-primary float-right">Submit</button>
					</div>
				  	</form>
				</div>
			</div>
		</div>
	
	</div>
</div>

<?php require_once 'includes/footer.php'; ?>