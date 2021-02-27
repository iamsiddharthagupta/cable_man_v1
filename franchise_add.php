<?php

  ob_start();
  session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

	$page = 1.2;

  require_once 'config/init.php';
	require_once 'includes/top-nav.php';
	require_once 'includes/side-nav.php';

  if(isset($_POST['submit'])) {

        $fr_name = $organ->escapeString($_POST['fr_name']);
        $landline_no = $organ->escapeString($_POST['landline_no']);
        $mobile_no = $organ->escapeString($_POST['mobile_no']);
        $gst_no = $organ->escapeString($_POST['gst_no']);
        $fr_address = $organ->escapeString($_POST['fr_address']);
        $area_id = $organ->escapeString($_POST['area_id']);

        $array = array(
            "fr_name" => $fr_name,
            "landline_no" => $landline_no,
            "mobile_no" => $mobile_no,
            "gst_no" => $gst_no,
            "fr_address" => $fr_address,
            "area_id" => $area_id
          );

    $res = $organ->insert('tbl_franchise', $array);

    if($res) {

              $msg = 'Franchise Added Successfully.';
              $code = 'success';
              header('Location: franchise_list.php?msg='.$msg.'&code='.$code);

    } else {

        $msg = 'Database Error.';
        $code = 'error';
        header('Location: franchise_list.php?msg='.$msg.'&code='.$code);

    }
  }

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
          <input type="text" name="fr_name" class="form-control" required="">
        </div>
        <div class="form-row">
          <div class="form-group col-md">
            <label>Landline No</label>
            <input type="text" name="landline_no" class="form-control" required="">
          </div>
          <div class="form-group col-md">
            <label>Mobile No</label>
            <input type="text" name="mobile_no" id="phone" class="form-control" required="">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md">
            <label>GST No</label>
            <input type="text" name="gst_no" class="form-control" required="">
          </div>
          <div class="form-group col-md">
            <label>Area</label>
              <?php
                $areas = $read->fetch_area_list();
                echo "<select name='area_id' class='custom-select' required>";
                echo "<option value=''>Select Area</option>";
                  foreach ($areas as $key => $area) {
                    echo "<option value='$area[area_id]'>$area[area]</option>";
                  }
                echo "</select>";
              ?>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md">
            <label>Address</label>
            <textarea class="form-control" name="fr_address" required=""></textarea>
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