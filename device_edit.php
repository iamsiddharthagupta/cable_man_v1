<?php

  ob_start();
  session_start();

  (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

	$page = 1.1;

  require_once 'config/init.php';
	require_once 'includes/top-nav.php';
	require_once 'includes/side-nav.php';

  $update->update_device();

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
          <select class="form-control" name="device_type">
            <option value="SD" <?php if($row["device_type"] == 'SD'){ echo "selected"; } ?>>Standard Definition [SD]</option>
            <option value="HD" <?php if($row["device_type"] == 'HD'){ echo "selected"; } ?>>High Definition [HD]</option>
          </select>
        </div>
      </div>
      <div class="card-footer">
        <div class="btn-group float-right" role="group" aria-label="Basic example">
          <button name="submit" type="submit" class="btn btn-dark">Add</button>
          <button type="button" onclick="goBack()" class="btn btn-secondary">Go Back</button>
        </div>
      </div>
    </div>
  </form>
</div>

<?php require_once 'includes/footer.php'; ?>