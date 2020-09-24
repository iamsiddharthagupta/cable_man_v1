<?php
// Database Connection.
    $conn = mysqli_connect('localhost','u189374615_redundant','7N~awOB:W=^q','u189374615_redundant');

	// Check Connection
	if(mysqli_connect_errno()){
		// Connection Failed
		echo 'Failed to Connect to Database '. mysqli_connect_error();
	}

?>