<?php

  session_start();

  if(isset($_SESSION['user_level'])) {
      $curr_user = ucwords($_SESSION['curr_user']);
      if($_SESSION['user_level'] != 1) {
          header('Location: agent_panel.php');
      }
  } else {
    header('Location: index.php');
  }
  
  require_once 'organ.php';
?>


<?php require_once 'assets/footer.php'; ?>