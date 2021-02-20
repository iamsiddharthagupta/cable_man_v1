<?php

  ob_start();
  session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

	$page = 1.2;

	require_once 'includes/top-nav.php';
	require_once 'includes/side-nav.php';

	$create->create_area();

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h4 class="text-dark">Add Franchise</h4>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Franchise Management</li>
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
          <label>Name</label>
          <input type="text" name="branch_name" class="form-control" required="">
        </div>
        <div class="form-row">
          <div class="form-group col-md">
            <label>Landline No</label>
            <input type="text" name="branch_landline" class="form-control" required="">
          </div>
          <div class="form-group col-md">
            <label>Mobile No</label>
            <input type="text" name="branch_mobile" id="phone" class="form-control" required="">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md">
            <label>GST No</label>
            <input type="text" name="branch_gst" class="form-control" required="">
          </div>
          <div class="form-group col-md">
            <label>Area</label>
              <?php
                $areas = $read->fetch_area_list();
                echo "<select name='area_id' class='custom-select' required>";
                echo "<option value=''>Select Area</option>";
                  foreach ($areas as $key => $area) {
                    echo "<option value='$area[area_id]'>$area[area_name]</option>";
                  }
                echo "</select>";
              ?>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md">
            <label>Address</label>
            <textarea class="form-control" name="branch_address" required=""></textarea>
          </div>
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