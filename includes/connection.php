<?php
// Database Connection.
    $conn = mysqli_connect('localhost','root','','cable_db');

	// Check Connection
	if(mysqli_connect_errno()){
		// Connection Failed
		echo 'Failed to Connect to Database '. mysqli_connect_error();
	}

?>