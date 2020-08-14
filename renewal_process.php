<?php

	require_once 'connection.php';

	// Setting up Indian timezone.
	date_default_timezone_set("Asia/Kolkata");

// Getting form indexes.
	$dev_id = $_POST['dev_id'];
	$invoice_no = $_POST['invoice_no'];
	$user_id = $_POST['user_id'];
	$renew_date = $_POST['renew_date'];
	$note = $_POST['note'];
	$current_month = date('F');

// Preparing Expiry date and Month to insert into the database.
	$format_renew = date_create($renew_date);
	$format_expiry = date_add($format_renew,date_interval_create_from_date_string("30 days"));

// Finalized after conversion.
	$renew_month = date('F',strtotime($renew_date));
	$expiry_date = date_format($format_expiry,'Y-m-d');
	$expiry_month = date('F',strtotime($expiry_date));

	if(!empty($dev_id)){


	foreach ($dev_id as $key => $dev_id) {

// Query.
	$query = "INSERT INTO cbl_ledger (`user_id`,`dev_id`,`renew_date`,`renew_month`,`expiry_month`,`expiry_date`,`note`,`invoice_no`) VALUES ('$user_id','$dev_id','$renew_date','$renew_month','$expiry_month','$expiry_date','$note','$invoice_no')";
	$result = mysqli_query($conn,$query);

	}

	if($result == true){
		?>
            <script type="text/javascript">
                  alert('Activated Successfully!');
                  window.open('renewal_form.php?user_id=<?php echo $user_id; ?>','_self');
            </script>
        <?php
	} else {
		?>
            <script type="text/javascript">
              alert('Database crashed!');
              window.open('renewal_form.php?user_id=<?php echo $user_id; ?>','_self');
            </script>
	   	<?php
	}

} else {
	?>
        <script type="text/javascript">
          alert('Please choose device!');
          window.open('renewal_form.php?user_id=<?php echo $user_id; ?>','_self');
        </script>
	<?php
}

?>