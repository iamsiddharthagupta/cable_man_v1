<?php
// Database Connection.
    $conn = mysqli_connect('localhost','root','','portal_db');

	// Check Connection
	if(mysqli_connect_errno()){
		// Connectio Failed
		echo 'Failed to Connect to Database '. mysqli_connect_errno();
	}

?>