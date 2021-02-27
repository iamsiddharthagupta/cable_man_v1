<?php

  ob_start();
  session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

	$page = 'report_device_history.php';

	require_once 'config/init.php';
	require_once 'includes/top-nav.php';
	require_once 'includes/side-nav.php';

?>

<?php require_once 'includes/footer.php'; ?>