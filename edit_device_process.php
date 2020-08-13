<?php

	include '../common/connection.php';

	$dev_id = $_POST['dev_id'];
	$user_id = $_POST['user_id'];
	$device_no = $_POST['device_no'];
	$device_mso = $_POST['device_mso'];
	$device_type = $_POST['device_type'];
	$package = $_POST['package'];

	$query = "	UPDATE cbl_dev_stock
				SET
				device_no = '$device_no',
				device_mso = '$device_mso',
				device_type = '$device_type',
				package = '$package'

				WHERE dev_id = '$dev_id'
			";
	$result = mysqli_query($conn,$query);

	if($result == true){
		?>
            <script type="text/javascript">
            	alert('Device Updated Successfully');
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