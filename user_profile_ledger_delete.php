<?php

	require_once 'connection.php';

	$query = "SELECT user_id FROM cbl_ledger WHERE ledger_id ='" . $_GET["ledger_id"] . "'";
	$result = mysqli_query($conn,$query);
	$data = mysqli_fetch_assoc($result);

	$user_id = $_GET['user_id'];

	$query = "DELETE FROM cbl_ledger WHERE ledger_id ='" . $_GET["ledger_id"] . "'";
	mysqli_query($conn,$query);

	$msg = 'Entry Deleted Successfully.';
    header('Location: profile_ledger.php?user_id='.$user_id.'&msg='.$msg);

?>