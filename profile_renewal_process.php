<?php

	require_once 'connection.php';

	// Setting up Indian timezone.
	date_default_timezone_set("Asia/Kolkata");

// Getting form indexes.
	$dev_id = $_POST['dev_id'];
	$user_id = $_POST['user_id'];
	$invoice_no = $_POST['invoice_no'];
	$package = $_POST['package'];
	$renew_date = $_POST['renew_date'];
	$renew_term = $_POST['renew_term'];
	

	$renew_term_months = $renew_term." "."months";
	$due_amount = $package * $renew_term;


// Preparing Expiry date and Month to insert into the database.
	$format_renew = date_create($renew_date);
	$format_expiry = date_add($format_renew,date_interval_create_from_date_string($renew_term_months));

// Finalized after conversion.
	$renew_month = date('F',strtotime($renew_date));
	$expiry_date = date_format($format_expiry,'Y-m-d');
	$expiry_month = date('F',strtotime($expiry_date));

// Query.
	$query = "	INSERT INTO cbl_ledger (user_id,dev_id,renew_date,renew_month,expiry_month,expiry_date,renew_term,renew_term_month,invoice_no,due_amount) VALUES ('$user_id','$dev_id','$renew_date','$renew_month','$expiry_month','$expiry_date','$renew_term','$renew_term_days','$invoice_no','$due_amount')";
	$result = mysqli_query($conn,$query);

	if($result == true){
		?>
            <script type="text/javascript">
                  window.open('profile_ledger.php?user_id=<?php echo $user_id; ?>','_self');
            </script>
        <?php
	} else {
		?>
            <script type="text/javascript">
	              alert('Database Error.');
	              window.open('profile_ledger.php?user_id=<?php echo $user_id; ?>','_self');
            </script>
	   	<?php
	}

?>