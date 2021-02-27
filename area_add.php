<?php

    ob_start();
    session_start();

      (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

    $page = 1.1;

    require_once 'config/init.php';
    require_once 'includes/top-nav.php';
    require_once 'includes/side-nav.php';

    if(isset($_POST['submit'])) {

          $area = $organ->escapeString($_POST['area']);
          $district = $organ->escapeString($_POST['district']);
          $city = $organ->escapeString($_POST['city']);
          $state = $organ->escapeString($_POST['state']);
          $pincode = $organ->escapeString($_POST['pincode']);
          $country = $organ->escapeString($_POST['country']);

          $array = array(
              "area" => $area,
              "district" => $district,
              "city" => $city,
              "state" => $state,
              "pincode" => $pincode,
              "country" => $country
            );

      $res = $organ->insert('tbl_area', $array);

      if($res) {

                $msg = 'Area added successfully.';
                $code = 'success';
                header('Location: area_list.php?msg='.$msg.'&code='.$code);

      } else {

          $msg = 'Database Error.';
          $code = 'error';
          header('Location: area_list.php?msg='.$msg.'&code='.$code);

      }
    }

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h4 class="text-dark">Add Area</h4>
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
            <label>Area</label>
            <input type="text" name="area" class="form-control" required="">
          </div>
          <div class="form-group col-md">
            <label>District</label>
            <input type="text" name="district" value="South-West Delhi" class="form-control" required="">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md">
            <label>City</label>
            <input type="text" name="city" value="New Delhi" class="form-control" required="">
          </div>
          <div class="form-group col-md">
            <label>State</label>
            <input type="text" name="state" value="Delhi" class="form-control" required="">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md">
            <label>Pincode</label>
            <input type="text" name="pincode" value="110029" class="form-control" required="">
          </div>
          <div class="form-group col-md">
            <label>Country</label>
            <input type="text" name="country" value="India" class="form-control" required="">
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