<?php

	require_once 'connection.php';
	
	$user_id = $_POST['user_id'];
	$device_no = $_POST['device_no'];
	$device_mso = $_POST['device_mso'];
	$device_type = $_POST['device_type'];
	$package = $_POST['package'];

	$query = "	INSERT INTO cbl_dev_stock
				(`device_no`,`device_mso`,`device_type`,`package`)
				VALUES
				('$device_no','$device_mso','$device_type','$package')
				";
	$result = mysqli_query($conn,$query);

	if($result == true){
		?>
            <script type="text/javascript">
            	window.open('map_device.php?user_id=<?php echo $user_id; ?>','_self');
            </script>
    	<?php
	} else {
		?>
            <script type="text/javascript">
              window.open('map_device.php?user_id=<?php echo $user_id; ?>','_self');
            </script>
    	<?php
	}
?>