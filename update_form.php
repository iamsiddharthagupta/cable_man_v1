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

// Getting user data from User list by GET method.
  $user_id = $_GET['user_id'];

  $query = "
            SELECT * FROM cbl_user_dev
            
            RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
            LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id
            
            WHERE cbl_user.user_id = '$user_id'
            ";
  $result = mysqli_query($conn,$query);
  $data = mysqli_fetch_assoc($result);
?>

<div class="container p-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
    <i class="fas fa-edit mr-1"></i></i>Update Form</li>
  </ol>

  <hr size="3" noshade>

<form method="POST" action="<?php echo htmlspecialchars('update_process.php'); ?>" autocomplete="off" class="bg-light">
    
    <div class="row">
        <div class="col-sm">
          <label>First Name: *</label>
            <input type="text" class="form-control" name="first_name" value="<?php echo $data['first_name']; ?>" placeholder="First Name">
        </div>
        <div class="col-sm">
          <label>Last Name:</label>
            <input type="text" class="form-control" name="last_name" value="<?php echo $data['last_name'];?>" placeholder="Last Name">
        </div>
    </div>

    <div class="row">
        <div class="col-sm">
          <label>Contact Number:</label>
            <input type="text" id="contactInput" class="form-control" name="phone_no" value="<?php echo $data['phone_no'];?>" placeholder="Contact Number">
        </div>

        <div class="col-sm">
          <label>Area: *</label>
            <select name="area" class="form-control">
              <option value="">Select Area</option>
              
              <option value="Humayunpur" <?php if($data["area"]=='Humayunpur'){ echo "selected"; } ?>>Humayunpur</option>
              
              <option value="Arjun Nagar" <?php if($data["area"]=='Arjun Nagar'){ echo "selected"; } ?>>Arjun Nagar</option>
              
              <option value="Krishna Nagar" <?php if($data["area"]=='Krishna Nagar'){ echo "selected"; } ?>>Krishna Nagar</option>
              
              <option value="B-4" <?php if($data["area"]=='B-4'){ echo "selected"; } ?>>B-4</option>
              
              <option value="Other" <?php if($data["area"]=='Other'){ echo "selected"; }?>>Other</option>
            </select>
      </div>
    </div>

    <div class="row mb-2">
      <div class="col-sm">
          <label>Address</label>
            <textarea class="form-control" name="address" placeholder="Complete Address with House Number and Floor"><?php echo $data['address'];?></textarea>
        </div>
      </div>

        <input type="hidden" name="user_id" value="<?php echo $data['user_id']; ?>">
        <button type="submit" name="submit" class="btn btn-outline-primary">Update</button>
    </form>
</div>


<?php require_once 'common/footer.php'; ?>