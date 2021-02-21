<?php

	require_once 'includes/header.php';

	if(!empty($_POST["dev_no"])) {
	  
	  $query = "SELECT * FROM tbl_device WHERE dev_no ='" . $_POST["dev_no"] . "'";
	  
	  $user_count = $organ->numRows($query);
	  
	  if($user_count > 0) {

	      echo "<strong class='text-danger'> Device not available.</strong>";
	  } else {

	      echo "<strong class='text-success'> Device available.</strong>";

	  }

	}

?>