<?php

  ob_start();
  session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

	$page = 'manage_area.php';

	require_once 'includes/top-nav.php';
	require_once 'includes/side-nav.php';

	$create->create_area();

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
  <form method="POST" class="needs-validation" novalidate>
    <div class="form-group">
      <input type="text" name="area_name" placeholder="Area" class="form-control" required="">
    </div>
    <div class="form-group">
      <input type="text" name="area_district" placeholder="District" value="South-West Delhi" class="form-control" required="">
    </div>
    <div class="form-group">
      <input type="text" name="area_city" placeholder="City" value="New Delhi" class="form-control" required="">
    </div>
    <div class="form-group">
      <input type="text" name="area_state" placeholder="State" value="Delhi" class="form-control" required="">
    </div>
    <div class="form-group">
      <input type="text" name="area_pin" placeholder="Pin" value="110029" class="form-control" required="">
    </div>
    <div class="form-group">
      <input type="text" name="area_country" placeholder="Country" value="India" class="form-control" required="">
    </div>
    <div class="form-group">
      <button name="submit" type="submit" class="btn btn-info">Submit</button>
    </div>
  </form>
</div>

<?php require_once 'includes/footer.php'; ?>