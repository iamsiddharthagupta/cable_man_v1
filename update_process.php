<?php
    
    include '../common/connection.php';

// Getting all the variables from Update form by POST.
  if(filter_has_var(INPUT_POST, 'submit')){
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $phone_no = $_POST['phone_no'];
  $area = $_POST['area'];
  $address = $_POST['address'];
  $user_id = $_POST['user_id'];

// Query block for Update Form.
  if(!empty($first_name)) {

    $query = "UPDATE `cbl_user` SET
    `first_name` = '$first_name',
    `last_name` = '$last_name',
    `phone_no` = '$phone_no',
    `address` = '$address',
    `area` = '$area'

    WHERE `user_id` = '$user_id'";

    $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    if($result == true){
      ?>
        <script type="text/javascript">
              alert('Details Updated!');
              window.open('user_profile.php?user_id=<?php echo $user_id;?>','_self');
        </script>
      <?php
        } else {
      ?>
        <script type="text/javascript">
              alert('Database Crashed!');
              window.open('update_form.php?user_id=<?php echo $user_id;?>','_self');
        </script>
      <?php
    }
  } else {
    ?>
      <script type="text/javascript">
            alert('Please fill complete details.');
            window.open('update_form.php?id=<?php echo $user_id;?>','_self');
      </script>
    <?php
  }
}

?>