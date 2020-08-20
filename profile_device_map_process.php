<?php

	require_once 'connection.php';

// Variables from Form.
	$user_id = $_POST['user_id'];
	$device_no = $_POST['device_no'];

// This is a Parameter for Entering New Device dev_id.
	$result = mysqli_query($conn,"SELECT * FROM cbl_dev_stock WHERE device_no = '$device_no'");
	$data = mysqli_fetch_assoc($result);

	if(!empty($data['dev_id'])){

	$dev_id = $data['dev_id'];

	$query = "
			INSERT INTO cbl_user_dev
			(user_id,dev_id)
			VALUES
			('$user_id','$dev_id')
			";
	$result = mysqli_query($conn,$query);

	$msg = 'Device Mapped Successfully.';
    header('Location: profile_device_map.php?user_id='.$user_id.'&msg='.$msg);

} else {

	$msg = 'Please insert valid device number!';
    header('Location: profile_device_map.php?user_id='.$user_id.'&msg='.$msg);
    
}

?>