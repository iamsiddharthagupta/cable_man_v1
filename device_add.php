<?php

  ob_start();
  session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

	$page = 1.5;

	require_once 'includes/top-nav.php';
	require_once 'includes/side-nav.php';

    $create->create_device();

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h4 class="text-dark">Area Management</h4>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Area Management</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="needs-validation" novalidate>
    <div class="card card-info">
      <div class="card-header">
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label>Device No</label>
          <input type="text" name="device_no" class="form-control" required="">
        </div>
        <div class="form-group">
              <div class="form-group">
                <label>Device Type</label>
                <select name="device_type" class="custom-select" required="">
                  <option value="">Choose...</option>
                  <option value="1">Standard Definition [SD]</option>
                  <option value="2">High Definition [HD]</option>
                </select>
              </div>
        </div>
        <div class="form-group">
          <label>Package</label>
            <?php
                $packs = $read->fetch_package_list();
                  echo "<select name='pack_id' class='custom-select' required>";
                  echo "<option value=''>Choose...</option>";
                    foreach ($packs as $key => $pack) {
                      echo "<option value='$pack[pack_id]'>$pack[pack_name] - $pack[mso_name]</option>";
                    }
                  echo "</select>";
            ?>
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