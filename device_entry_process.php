<?php

	require_once 'connection.php';
	
	$user_id = $_POST['user_id'];
	$device_no = mysqli_real_escape_string($conn,$_POST['device_no']);
	$device_mso = mysqli_real_escape_string($conn,$_POST['device_mso']);
	$device_type = mysqli_real_escape_string($conn,$_POST['device_type']);
	$package = mysqli_real_escape_string($conn,$_POST['package']);

	$query = "	INSERT INTO cbl_dev_stock
				(device_no,device_mso,device_type,package)
				VALUES
				('$device_no','$device_mso','$device_type','$package')";
	$result = mysqli_query($conn,$query);

	if($result == true){

		$msg = 'Device Entry Successfull.';
        header('Location: device_entry.php?msg='.$msg);
	
	} else {

		$msg = 'Database Error.';
        header('Location: device_entry.php?msg='.$msg);
	
	}
?>