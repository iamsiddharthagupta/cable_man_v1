<?php

  ob_start();
  session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

	$page = 3.1;

  require_once 'config/init.php';
	require_once 'includes/top-nav.php';
	require_once 'includes/side-nav.php';

  if(isset($_POST['submit'])) {

        $first_name = $organ->escapeString($_POST['first_name']);
        $last_name = $organ->escapeString($_POST['last_name']);
        $mobile_no = $organ->escapeString($_POST['mobile_no']);
        $install_date = $organ->escapeString($_POST['install_date']);
        $address = $organ->escapeString($_POST['address']);
        $area_id = $organ->escapeString($_POST['area_id']);
        $user_status = $organ->escapeString($_POST['user_status']);

        $array = array(
            "first_name" => $first_name,
            "last_name" => $last_name,
            "mobile_no" => $mobile_no,
            "install_date" => $install_date,
            "address" => $address,
            "area_id" => $area_id,
            "user_status" => $user_status
          );

    $res = $organ->insert('tbl_user', $array);

    if($res) {

        header('Location: user_profile_device_map.php?user_id='.$organ->insert_id());

    } else {

        $msg = 'Database Error.';
        $code = 'error';
        header('Location: user_profile_add.php?msg='.$msg.'&code='.$code);

    }
  }

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h4 class="text-dark">Add User</h4>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">User Management</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <form method="POST" class="needs-validation" novalidate>
    <div class="card card-info">
      <div class="card-header">
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
          <div class="form-row">
              <div class="form-group col-md">
                <label>First Name</label>
                  <input type="text" class="form-control" name="first_name" required="">
              </div>
              <div class="form-group col-md">
                <label>Last Name</label>
                  <input type="text" class="form-control" name="last_name" required="">
              </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md">
              <label>Phone Number</label>
                <input type="text" class="form-control" name="mobile_no" id="phone" required="">
            </div>
            <div class="form-group col-md">
              <label>Installation Date</label>
                <input type="date" class="form-control" value="<?php echo date("Y-m-d") ?>" name="install_date">
            </div>
          </div>

          <div class="form-row">
            <div class=" form-group col-md">
              <label>Address</label>
              <input type="text" name="address" class="form-control" required="">
            </div>
            <div class="form-group col-md">
              <label>Area</label>
              <?php
                $areas = $read->fetch_area_list();
                  echo "<select name='area_id' class='custom-select' required>";
                  echo "<option value=''>Choose...</option>";
                    foreach ($areas as $key => $area) {
                      echo "<option value='$area[area_id]'>$area[a_name]</option>";
                    }
                  echo "</select>";
              ?>
            </div>
          </div>
      </div>
      <div class="card-footer">
        <input type="hidden" name="user_status" value="1">
        <div class="btn-group float-right" role="group" aria-label="Basic example">
          <button name="submit" type="submit" class="btn btn-dark">Add</button>
          <button type="button" onclick="goBack()" class="btn btn-secondary">Go Back</button>
        </div>
      </div>
    </div>
  </form>
</div>

<?php require_once 'includes/footer.php'; ?>