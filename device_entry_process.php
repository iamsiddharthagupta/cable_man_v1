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
				('$device_no','$device_mso','$device_type','$package')
				";
	$result = mysqli_query($conn,$query);

	if($result == true){
		?>
            <script type="text/javascript">
            	window.open('device_entry.php','_self');
            </script>
    	<?php
	} else {
		?>
            <script type="text/javascript">
              window.open('device_entry.php','_self');
            </script>
    	<?php
	}
?>