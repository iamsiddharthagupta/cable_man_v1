<?php

  ob_start();
  session_start();

  if(isset($_SESSION['user_level'])){
      $curr_user = ucwords($_SESSION['curr_user']);
      if($_SESSION['user_level'] != 1){
          header('Location: agent_panel.php');
      }
  } else {
    header('Location: index.php');
  }

	$page = 'device_history.php';

	require_once 'includes/top-nav.php';
	require_once 'includes/side-nav.php';

?>

<?php require_once 'includes/footer.php'; ?>