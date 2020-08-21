<?php
    
    require_once 'connection.php';

    $first_name = mysqli_real_escape_string($conn,$_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn,$_POST['last_name']);
    $phone_no = mysqli_real_escape_string($conn,$_POST['phone_no']);
    $area = mysqli_real_escape_string($conn,$_POST['area']);
    $address = mysqli_real_escape_string($conn,$_POST['address']);

    if(!empty($first_name) && !empty($phone_no) && !empty($address)){

    $query = "INSERT INTO cbl_user
              (first_name,last_name,phone_no,area,address)
              VALUES
              ('$first_name','$last_name','$phone_no','$area','$address')";

    $result = mysqli_query($conn,$query) or die(mysqli_error($conn));

    if($result){
      ?>
            <script type="text/javascript">
              window.open('profile_device_map.php?user_id=<?php echo mysqli_insert_id($conn); ?>','_self');
            </script>
    <?php
    } else {

      $msg = 'Database Error.';
      header('Location: add_user.php?msg='.$msg);
    
    }

  } else {

      $msg = 'Please Fill Details.';
      header('Location: add_user.php?msg='.$msg);

  }

?>