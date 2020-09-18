<?php

  session_start();
  
  require_once 'connection.php';

  if(filter_has_var(INPUT_POST, 'submit')){
    $username = stripcslashes($_POST['username']);
    $password = stripcslashes($_POST['password']);
    $username = mysqli_real_escape_string($conn,$username);
    $password = mysqli_real_escape_string($conn,$password);

// Hashing Passkeys    
    $password = md5($password);

    if(!empty($username) && !empty($password)){

      $query = "SELECT * FROM tbl_auth WHERE username = '$username' AND password = '$password'";
      $result = mysqli_query($conn,$query);
      $row = mysqli_num_rows($result);
      $data = mysqli_fetch_assoc($result);

// Converting fetched data into var.
      $user_level = intval($data['user_level']);
      $curr_user = $data['full_name'];

        if($row == 1){

        if($user_level == 1){
          $_SESSION['curr_user'] = $curr_user;
          $_SESSION['user_level'] = $user_level;
          header('Location: dashboard.php');
        } 
          else if($user_level == 2){
          $_SESSION['curr_user'] = $curr_user;
          $_SESSION['user_level'] = $user_level;
          header('Location: agent_panel.php');

      } else {
        $msg = 'Failed to authenticate user level.';
        header('Location: index.php?msg='.$msg);
      }

    } else {
        $msg = 'Failed to authenticate.';
        header('Location: index.php?msg='.$msg);
    }

  } else {
        $msg = 'Please enter credentials.';
        header('Location: index.php?msg='.$msg);
  }

}

?>