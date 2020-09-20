<?php

	require_once 'connection.php';

	$search_input = $_POST['search_input'];

	$query = "SELECT user_id FROM cbl_user WHERE (SELECT CONCAT(first_name,' ',last_name) = '$search_input' OR first_name = '$search_input')";
	$result = mysqli_query($conn,$query);

	$data = mysqli_fetch_assoc($result);

	$user_id =  $data['user_id'];
?>

<script type="text/javascript">
	window.location.href='profile_ledger.php?user_id=<?php echo $user_id; ?>'
</script>