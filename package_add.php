<?php

  ob_start();
  session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

	$page = 1.4;

	require_once 'includes/top-nav.php';
	require_once 'includes/side-nav.php';

    $create->create_package();

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h4 class="text-dark">Add Package</h4>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Package Management</li>
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
          <input type="text" name="pack_name" class="form-control" required="">
        </div>
        <div class="form-row">
          <div class="form-group col-md">
            <label>Duration</label>
            <input type="number" name="pack_duration" class="form-control" required="">
          </div>
          <div class="form-group col-md">
            <label>Price</label>
            <input type="number" name="pack_price" class="form-control" required="">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md">
            <label>Type</label>
            <select name="pack_type" class="custom-select" required="">
              <option value="">Choose...</option>
              <option value="SD">Standard Definition [SD]</option>
              <option value="HD">High Definition [HD]</option>
            </select>
          </div>
          <div class="form-group col-md">
            <label>MSO</label>
              <input type="text" name="mso_name" class="form-control" required="">
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