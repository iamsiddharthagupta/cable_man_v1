<?php
    
    require_once 'connection.php';

// Getting all the variables from Update form by POST.
  $first_name = mysqli_real_escape_string($conn,$_POST['first_name']);
  $last_name = mysqli_real_escape_string($conn,$_POST['last_name']);
  $phone_no = mysqli_real_escape_string($conn,$_POST['phone_no']);
  $area = mysqli_real_escape_string($conn,$_POST['area']);
  $address = mysqli_real_escape_string($conn,$_POST['address']);
  $user_id = $_POST['user_id'];

    $query = "UPDATE cbl_user SET
    first_name = '$first_name',
    last_name = '$last_name',
    phone_no = '$phone_no',
    address = '$address',
    area = '$area'

    WHERE user_id = '$user_id'";

    $result = mysqli_query($conn,$query);
    if($result == true){
      ?>
        <script type="text/javascript">
              window.open('profile_update.php?user_id=<?php echo $user_id;?>','_self');
        </script>
      <?php
        } else {
      ?>
        <script type="text/javascript">
              alert('Database Error.');
              window.open('profile_update.php?user_id=<?php echo $user_id;?>','_self');
        </script>
      <?php
    }

?>