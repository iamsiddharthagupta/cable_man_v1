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

	if($pay_amount < $due_amount){

		$due = $pay_amount - $due_amount;

		$bal = $due;
	
	} elseif($pay_amount > $due_amount) {

		$adv = $pay_amount - $due_amount;

		$bal = $adv;

	} elseif ($pay_amount == $due_amount){

		$clear = $pay_amount - $due_amount;

		$bal = $clear;

	}

	$query = "
				UPDATE cbl_ledger SET
				pay_amount = '$pay_amount',
				pay_balance = '$bal',
				pay_date = '$pay_date',
				pay_month = '$pay_month',
				status = 'Paid'

				WHERE ledger_id = '$ledger_id' AND invoice_no = '$due_invoice'
			";
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