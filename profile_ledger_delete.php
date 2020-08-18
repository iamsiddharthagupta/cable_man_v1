<?php

	require_once 'connection.php';
	
	$query = "SELECT user_id FROM cbl_ledger WHERE ledger_id ='" . $_GET["ledger_id"] . "'";
	$result = mysqli_query($conn,$query);
	$data = mysqli_fetch_assoc($result);

	$user_id = $data['user_id'];

	$query = "DELETE FROM cbl_ledger WHERE ledger_id ='" . $_GET["ledger_id"] . "'";
	mysqli_query($conn,$query);

?>

	<script type="text/javascript">
      alert('Receipt Deleted Successfully!');
      window.open('user_profile.php?user_id=<?php echo $user_id; ?>','_self');
    </script>