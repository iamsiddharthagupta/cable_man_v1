<?php

	require_once 'connection.php';

	$dev_id = $_POST['dev_id'];
	$user_id = $_POST['user_id'];
	$device_no = mysqli_real_escape_string($conn,$_POST['device_no']);
	$device_mso = mysqli_real_escape_string($conn,$_POST['device_mso']);
	$device_type = mysqli_real_escape_string($conn,$_POST['device_type']);
	$package = mysqli_real_escape_string($conn,$_POST['package']);

	$query = "	UPDATE cbl_dev_stock
				SET
				device_no = '$device_no',
				device_mso = '$device_mso',
				device_type = '$device_type',
				package = '$package'

				WHERE dev_id = '$dev_id'
			";
	$result = mysqli_query($conn,$query);

	if($result){
		
		$msg = 'Device Updation Successful.';
        header('Location: device_entry.php?msg='.$msg);

	} else {
		
		$msg = 'Database Error.';
        header('Location: device_entry.php?msg='.$msg);

	}

?>