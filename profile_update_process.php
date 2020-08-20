<?php
    
    require_once 'connection.php';

// Getting all the variables from Update form by POST.
  $first_name = mysqli_real_escape_string($conn,$_POST['first_name']);
  $last_name = mysqli_real_escape_string($conn,$_POST['last_name']);
  $phone_no = mysqli_real_escape_string($conn,$_POST['phone_no']);
  $area = mysqli_real_escape_string($conn,$_POST['area']);
  $address = mysqli_real_escape_string($conn,$_POST['address']);
  $user_status = mysqli_real_escape_string($conn,$_POST['user_status']);
  $user_id = $_POST['user_id'];

    $query = "UPDATE cbl_user SET
    first_name = '$first_name',
    last_name = '$last_name',
    phone_no = '$phone_no',
    address = '$address',
    area = '$area',
    user_status = '$user_status'

    WHERE user_id = '$user_id'";

    $result = mysqli_query($conn,$query);
    if($result){

        $msg = 'Profile Updation Successful.';
        header('Location: profile_update.php?user_id='.$user_id.'&msg='.$msg);

        } else {
      
        $msg = 'Database Error.';
        header('Location: profile_update.php?user_id='.$user_id.'&msg='.$msg);

    }

?>