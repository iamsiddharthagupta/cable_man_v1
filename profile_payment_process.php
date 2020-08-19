<?php
	
	require_once 'connection.php';

	$user_id = $_POST['user_id'];
	$ledger_id = $_POST['ledger_id'];
	$due_amount = $_POST['due_amount'];
	$pay_amount = $_POST['pay_amount'];
	$pay_date = $_POST['pay_date'];
	$due_invoice = $_POST['due_invoice'];
	$pay_month = date('F',strtotime($pay_date));

// Payment Logic.

	$bal = '';
	$msg = '';

	if($pay_amount < $due_amount){

		$due = $pay_amount - $due_amount;

		$bal = $due;
		$msg = 'Balance';
	
	} elseif($pay_amount > $due_amount) {

		$adv = $pay_amount - $due_amount;

		$bal = $adv;
		$msg = 'Advance';

	} elseif ($pay_amount == $due_amount){

		$clear = $pay_amount - $due_amount;

		$bal = $clear;
		$msg = 'Clear';

	}

	$query = "
				UPDATE cbl_ledger SET
				pay_amount = '$pay_amount',
				pay_balance = '$bal',
				pay_status = '$msg',
				pay_date = '$pay_date',
				pay_month = '$pay_month',
				status = 'Paid'

				WHERE ledger_id = '$ledger_id' AND invoice_no = '$due_invoice'
			";
	$result = mysqli_query($conn,$query);

	if($result == true){
	
		$msg = 'Payment Added Successfully.';
        header('Location: profile_ledger.php?user_id='.$user_id.'&msg='.$msg);

	} else {
	
		$msg = 'Database Error.';
        header('Location: profile_ledger.php?user_id='.$user_id.'&msg='.$msg);

	}


?>