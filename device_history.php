<?php

	session_start();

	$curr_user = $_SESSION['curr_user'];
	$user_level = $_SESSION['user_level'];

	$page = 'device_history.php';
	require_once 'includes/top-nav.php';
	require_once 'includes/side-nav.php';

	$result = $security->session($curr_user, $user_level);

?>

<?php require_once 'includes/footer.php'; ?>