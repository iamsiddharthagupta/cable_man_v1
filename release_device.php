<?php

	require_once 'connection.php';

	$query = "DELETE FROM cbl_user_dev WHERE assign_id ='" . $_POST["assign_id"] . "'";
	
	$result = mysqli_query($conn,$query);
			
		if($result == true){
		
			header('Location: user_profile.php?user_id='.$_POST['user_id']);
		
		} else {
		?>
			<script type="text/javascript">
		      alert('User Released Already!');
		      window.open('map_device.php?user_id=<?php echo $_POST['user_id']; ?>','_self');
		    </script>
	    <?php
		}