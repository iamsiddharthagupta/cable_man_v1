<?php

	class Admin extends Connection {

    public function admin_profile_fetch($curr_user) {

        $sql = "
                SELECT

                full_name,
                contact_no,
                CASE
                  WHEN user_level = 1 THEN 'Admin'
                  ELSE 'Agent'
                END AS user_level

                FROM tbl_auth
                WHERE full_name = '$curr_user'
                ";

        $result = mysqli_query($this->conn,$sql);
        return $result;

    }

    public function admin_change_pass($curr_user) {

        if(isset($_POST['submit'])) {

        $current_pass = $_POST['current_pass'];
        $new_pass = $_POST['new_pass'];
        $confirm_pass = $_POST['confirm_pass'];
    // Hashing Passkeys
        $current_pass = md5($current_pass);
        $new_pass = md5($new_pass);
        $confirm_pass = md5($confirm_pass);
    // Fetching current password from database to validate password input.
        $sql = "SELECT password FROM tbl_auth WHERE full_name = '$curr_user'";
        $result = mysqli_query($this->conn,$sql);
        $curr_valid = mysqli_fetch_assoc($result);
    // Logic
          if($current_pass == $curr_valid['password']) {
          if($new_pass == $confirm_pass){
              $sql = "UPDATE tbl_auth SET password = '$confirm_pass' WHERE full_name = '$curr_user'";
              $result = mysqli_query($this->conn,$sql);
              
              $msg = 'Congrats you password has been changed. <a href="logout.php">Logout</a> and Login again';
              header('Location: admin_change_pass.php?msg='.$msg);
          
          } else {
            
            $msg = 'Your new and confirm password does not match.';
            header('Location: admin_change_pass.php?msg='.$msg);

          }
        } else {
          
          $msg = 'You current password is empty or invalid.';
          header('Location: admin_change_pass.php?msg='.$msg);

      }
    }
  }

  public function admin_role_assign() {

      if(isset($_POST['submit'])){

        $username = $_POST['username'];
        $password = $_POST['password'];
        $full_name = $_POST['full_name'];
        $contact_no = $_POST['contact_no'];
        $user_level = $_POST['user_level'];
        $password = md5($password);

        if(!empty($username) && !empty($password) && !empty($contact_no) && !empty($full_name) && !empty($user_level)){

          $sql = "INSERT INTO tbl_auth (username,password,full_name,contact_no,user_level) VALUES ('$username','$password','$full_name','$contact_no','$user_level')";
          
          if(mysqli_query($this->conn,$sql)) {
            
            $msg = 'User Created Successfully!';
            header('Location: admin_role_assign.php?msg='.$msg);
          
          } else {
            
            $msg = 'Database Error.';
            header('Location: admin_role_assign.php?msg='.$msg);
          
          }

        } else {
          
          $msg = 'Please enter details';
          header('Location: admin_role_assign.php?msg='.$msg);
        
        }
      }
    }

}