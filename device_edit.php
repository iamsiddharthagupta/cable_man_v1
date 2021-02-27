<?php

    ob_start();
    session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

  	$page = 1.5;

    require_once 'config/init.php';
  	require_once 'includes/top-nav.php';
  	require_once 'includes/side-nav.php';

    $row = $organ->query("SELECT * FROM tbl_device WHERE device_id = '". $_GET['device_id'] ."'")->fetch_assoc();

    if(isset($_POST['submit'])) {

          $device_id = intval($_POST['device_id']);
          $device_no = $organ->escapeString($_POST['device_no']);
          $device_type = $organ->escapeString($_POST['device_type']);

          $array = array(
              "device_no" => $device_no,
              "device_type" => $device_type
            );

      $res = $organ->update('tbl_device', $array, "device_id = '$device_id'");

      if($res) {

            $msg = 'Device Updated Successfully.';
            $code = 'success';
            header('Location: device_list.php?&msg='.$msg.'&code='.$code);

      } else {

            $msg = 'Database Error.';
            $code = 'error';
            header('Location: device_edit.php?device_id='.$device_id.'&msg='.$msg.'&code='.$code);
        
      }
    }

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h4 class="text-dark">Edit Device</h4>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Add Management</li>
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
        <div class="col-md">
          <label>Device ID:</label>
          <input type="text" name="device_no" class="form-control" value="<?php echo $row['device_no']; ?>">
        </div>
        <div class="col-md">
          <label>Device Type:</label>
          <select class="custom-select" name="device_type">
            <option value="1" <?php if($row["device_type"] == 1){ echo "selected"; } ?>>Standard Definition [SD]</option>
            <option value="2" <?php if($row["device_type"] == 2){ echo "selected"; } ?>>High Definition [HD]</option>
          </select>
        </div>
      </div>
      <div class="card-footer">
        <input type="hidden" name="device_id" value="<?php echo $row['device_id']; ?>">
        <div class="btn-group float-right" role="group" aria-label="Basic example">
          <button name="submit" type="submit" class="btn btn-dark">Add</button>
          <button type="button" onclick="goBack()" class="btn btn-secondary">Go Back</button>
        </div>
      </div>
    </div>
  </form>
</div>

<?php require_once 'includes/footer.php'; ?>