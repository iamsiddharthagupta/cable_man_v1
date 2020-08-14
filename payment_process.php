<?php
	
	require_once 'connection.php';

	$ledger_id = $_POST['ledger_id'];
	$pay_amount = $_POST['pay_amount'];
	$pay_date = $_POST['pay_date'];
	$note = $_POST['note'];
	$due_invoice = $_POST['due_invoice'];
	$pay_month = date('F',strtotime($pay_date));

	$query = "
				UPDATE cbl_ledger
				SET
				`pay_amount` = '$pay_amount',
				`pay_date` = '$pay_date',
				`pay_month` = '$pay_month',
				`note` = '$note',
				`status` = 'Paid'

				WHERE ledger_id = '$ledger_id' AND invoice_no = '$due_invoice'
			";
	$result = mysqli_query($conn,$query);

	if($result == true){
	?>
            <script type="text/javascript">
              alert('Payment Added for Selected Month!');
              window.open('payment_form.php?ledger_id=<?php echo $ledger_id; ?>','_self');
            </script>
    <?php
	} else {
	?>
            <script type="text/javascript">
              alert('Database Error.');
              window.open('unpaid_list.php','_self');
            </script>
    <?php
	}
?>