<?php

	require_once 'user_profile_base.php';

	$sql = "
			SELECT
			m.user_id,
			d.device_id,
			d.device_no,
			d.device_type,
			pc.mso_name,
			pc.pack_code

			FROM tbl_mapping m

			LEFT JOIN tbl_device d ON d.device_id = m.device_id
			LEFT JOIN tbl_package pc ON pc.package_id = d.package_id
			WHERE m.device_id = '". $_GET['device_id'] ."'";

	$row = $organ->query($sql)->fetch_assoc();

    if(isset($_POST['submit'])) {

	        $dev_id = $_POST['dev_id'];
	        $user_id = $_POST['user_id'];
	        $invoice_no = $_POST['invoice_no'];
	        $package = $_POST['package'];
	        $renew_date = $_POST['renew_date'];
	        $renew_term = $_POST['renew_term'];

	        $renew_term_month = $renew_term." "."months";
	        $due_amount = $package * $renew_term;


	        // Preparing Expiry date and Month to insert into the database.
	        $format_renew = date_create($renew_date);
	        $format_expiry = date_add($format_renew,date_interval_create_from_date_string($renew_term_month));

	        // Finalized after conversion.
	        $renew_month = date('F',strtotime($renew_date));
	        $expiry_date = date_format($format_expiry,'Y-m-d');
	        $expiry_month = date('F',strtotime($expiry_date));

          $array = array(
              "area" => $area,
              "district" => $district,
              "city" => $city,
              "state" => $state,
              "pincode" => $pincode,
              "country" => $country
            );

      $res = $organ->insert('tbl_area', $array);

      if($res) {

                $msg = 'Area added successfully.';
                $code = 'success';
                header('Location: area_list.php?msg='.$msg.'&code='.$code);

      } else {

          $msg = 'Database Error.';
          $code = 'error';
          header('Location: area_list.php?msg='.$msg.'&code='.$code);

      }
    }

?>

		<div class="col-md-9">
            <div class="callout callout-info">
              <h5><i class="fas fa-info"></i> Note:</h5>
              <p>This device already having an active session till <span class="badge badge-danger">15-03-2021</span> If you want to reschedule then you can select the date below.</p>
            </div>
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
							<li class="list-group-item"><span class="mr-2">Device #:</span>
						      <strong><?php echo $row['device_no']; ?></strong>
						    </li>
							<li class="list-group-item"><span class="mr-2">MSO:</span>
						      <strong><?php echo $row['mso_name']; ?></strong>
						    </li>
						    <li class="list-group-item mb-2"><span class="mr-2">Package:</span>
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