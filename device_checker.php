<?php

	require_once 'includes/header.php';

	if(!empty($_POST["dev_no"])) {
	  
	  $sql = "
				SELECT
				dv.dev_no,
				dv.dev_type,
				u.first_name,
				u.last_name
				FROM
				tbl_mapping m
				LEFT JOIN tbl_user u ON u.user_id = m.user_id
				RIGHT JOIN tbl_device dv ON dv.dev_id = m.dev_id
				WHERE dv.dev_no ='" . $_POST["dev_no"] . "'";
	  
	  $row = $organ->query($sql)->fetch_assoc();
	  
	  if(empty($row['first_name'])) {

	      echo "<strong class='text-danger'>Device not available.</strong>";

	  } else {

	      echo "<strong class='text-success'>Device available.</strong>";

	  }

	}

?>