<?php

	require_once 'config/init.php';

	if(!empty($_POST["device_no"])) {
	  
	  $sql = "
				SELECT
				dv.device_no,
				dv.device_type,
				u.user_id,
				u.first_name,
				u.last_name
				FROM
				tbl_mapping m
				LEFT JOIN tbl_user u ON u.user_id = m.user_id
				RIGHT JOIN tbl_device dv ON dv.device_id = m.device_id
				WHERE dv.device_no = '" . $_POST["device_no"] . "'
			";
	  
	  $row = $organ->query($sql)->fetch_assoc();
	  
		if($_POST["device_no"] != isset($row['device_no'])) {

			echo "<strong class='text-danger'>Please enter a valid device number or make fresh registration of this device.</strong>";

		} elseif(!empty($row['user_id'])) {

		  echo "<strong class='text-warning'>Device is already assigned to ".$row['first_name'].' '.$row['last_name']."</strong>";

		} else {

		  echo "<strong class='text-success'>Device available.</strong>";

		}
	}


?>