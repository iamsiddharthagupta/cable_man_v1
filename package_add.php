<?php

  ob_start();
  session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

	$page = 1.4;

  require_once 'config/init.php';
	require_once 'includes/top-nav.php';
	require_once 'includes/side-nav.php';

  if(isset($_POST['submit'])) {

        $pc_name = $_POST['pc_name'];
        $pc_rate = $_POST['pc_rate'];
        $pc_type = $_POST['pc_type'];
        $pc_duration = $_POST['pc_duration'];
        $mso_name = $_POST['mso_name'];
        $mso_rate = $_POST['mso_rate'];

        $array = array(
            "pc_name" => $pc_name,
            "pc_rate" => $pc_rate,
            "pc_type" => $pc_type,
            "pc_duration" => $pc_duration,
            "mso_name" => $mso_name,
            "mso_rate" => $mso_rate
          );

    $res = $organ->insert('tbl_package', $array);

    if($res) {

              $msg = 'Package added successfully.';
              $code = 'success';
              header('Location: package_list.php?msg='.$msg.'&code='.$code);

    } else {

        $msg = 'Database Error.';
        $code = 'error';
        header('Location: package_list.php?msg='.$msg.'&code='.$code);

    }
  }

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
        <div class="form-row">
          <div class="form-group col-md">
            <label>Pack name</label>
            <input type="text" name="pc_name" class="form-control" required="">
          </div>
          <div class="form-group col-md">
            <label>Pack rate</label>
            <input type="number" name="pc_rate" class="form-control" required="">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md">
            <label>Pack type</label>
            <select name="pc_type" class="custom-select" required="">
              <option value="">Choose...</option>
              <option value="1">Standard Definition [SD]</option>
              <option value="2">High Definition [HD]</option>
            </select>
          </div>
          <div class="form-group col-md">
            <label>Pack duration (Months)</label>
            <input type="number" name="pc_duration" class="form-control" required="">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md">
            <label>MSO name</label>
              <input type="text" name="mso_name" class="form-control" required="">
          </div>
          <div class="form-group col-md">
            <label>MSO rate</label>
              <input type="number" name="mso_rate" class="form-control" required="">
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