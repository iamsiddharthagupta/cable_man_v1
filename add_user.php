<?php

  session_start();

  if(isset($_SESSION['user_level'])){
      $curr_user = ucwords($_SESSION['curr_user']);
      if($_SESSION['user_level'] != 1){
          header('Location: agent_panel.php');
      }
  } else {
    header('Location: index.php');
  }

  require_once 'connection.php';
  require_once 'organ.php';

?>

<?php

  $msg = '';
  $msgClass = '';
  
  if(filter_has_var(INPUT_POST, 'submit')){
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone_no = $_POST['phone_no'];
    $area = $_POST['area'];
    $address = $_POST['address'];

    if(!empty($area)){

    $query = "INSERT INTO `cbl_user`
              (`first_name`,`last_name`,`phone_no`,`area`,`address`)
              VALUES
              ('$first_name','$last_name','$phone_no','$area','$address')";

    $result = mysqli_query($conn,$query) or die(mysqli_error($conn));

    if($result == true){
      ?>
            <script type="text/javascript">
              alert('User Added!');
              window.open('map_device.php?user_id=<?php echo mysqli_insert_id($conn); ?>','_self');
            </script>
    <?php
    } else {
      $msg = 'Oops! Something\'s wrong with the database.';
      $msgClass = 'alert-danger';
    }

  } else {
    $msg = 'Please fill details!';
    $msgClass = 'alert-warning';
  }
}

?>

<div class="container p-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
    <i class="fas fa-folder-plus mr-1"></i>Entry Form</li>
  </ol>
  
  <hr size="3" noshade>

<!-- Warning LED -->
      <?php if($msg != ''): ?>
        <div class="alert <?php echo $msgClass ?>"><?php echo $msg; ?>
        </div>
      <?php endif; ?>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" class="bg-light">
  
    <div class="form-row mb-2">
        <div class="col-sm">
          <label>First Name: *</label>
            <input type="text" class="form-control" name="first_name" placeholder="First Name" value="<?php echo isset($_POST['first_name']) ? $first_name : ''; ?>">
        </div>
        <div class="col-sm">
          <label>Last Name:</label>
            <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="<?php echo isset($_POST['last_name']) ? $last_name : ''; ?>">
        </div>
    </div>

      <div class="form-row mb-2">
        <div class="col-sm">
          <label>Contact Number:</label>
            <input type="text" class="form-control" name="phone_no" placeholder="Contact Number" value="<?php echo isset($_POST['primary_cont']) ? $primary_cont : ''; ?>">
        </div>
        <div class="col-sm">
          <label>Area: *</label>
            <select name="area" class="form-control">
              <option value="">Select Area</option>
              <option value="Humayunpur">Humayunpur</option>
              <option value="Arjun Nagar">Arjun Nagar</option>
              <option value="Krishna Nagar">Krishna Nagar</option>
              <option value="B-4">B-4</option>
              <option value="Other">Other</option>
            </select>
        </div>
      </div>

      <div class="form-row mb-2">
        <div class="col-sm">
          <label>Address:</label>
          <textarea class="form-control" name="address" placeholder="Complete Address with House Number and Floor"><?php echo isset($_POST['address']) ? $address : ''; ?></textarea>
        </div>
      </div>
      <div class="form-group">
        <button type="submit" name="submit" class="btn btn-outline-primary">Add</button>
      </div>
      
    </form>
</div>

<?php require_once 'common/footer.php'; ?>