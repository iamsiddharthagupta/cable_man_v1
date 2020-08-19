<?php

	require_once 'connection.php';

	$query = "DELETE FROM cbl_user_dev WHERE assign_id ='" . $_GET["assign_id"] . "'";

	$result = mysqli_query($conn,$query);
			
		if($result == true){

			header('Location: device_entry.php');

		} else {
		?>
			<script type="text/javascript">
		      alert('User Released Already!');
		      window.open('device_entry.php','_self');
		    </script>
	    <?php
		}