<?php

    ob_start();
    session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

    require_once 'includes/top-nav.php';
    require_once 'includes/side-nav.php';

    $create->user_profile_add();

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h4 class="m-0 text-dark">Customer Acquisition Form</h4>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item"><a href="user_list.php">User List</a></li>
          <li class="breadcrumb-item active">CAF Form</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="container pt-2">

  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off">
    <div class="card card-outline card-info">
      <div class="card-header">
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="form-row">
            <div class="form-group col-md">
              <label>First Name: <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="first_name" placeholder="First Name">
            </div>
            <div class="form-group col-md">
              <label>Last Name:</label>
                <input type="text" class="form-control" name="last_name" placeholder="Last Name">
            </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md">
            <label>Phone Number: <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="phone_no" id="phone" placeholder="Phone Number">
          </div>
          <div class="form-group col-md">
            <label>Installation Date:</label>
              <input type="text" class="form-control" id="today" name="install_date">
          </div>
        </div>

        <div class="form-row">
          <div class=" form-group col-md">
            <label>Address: <span class="text-danger">*</span></label>
            <input type="text" name="address" class="form-control" placeholder="Complete Address">
          </div>
          <div class="form-group col-md">
            <label>Area: <span class="text-danger">*</span></label>
            <?php

              $areas = $read->fetch_area_list();

              echo "<select name='area_id' class='form-control'>";
              echo "<option value=''>Select Area</option>";
                foreach ($areas as $key => $area) {
                  echo "<option value='$area[area_id]'>$area[area_name]</option>";
                }
              echo "</select>";

            ?>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <button type="submit" name="submit" class="btn btn-info float-right">Add</button>
      </div>
    </div>
  </form>
</div>

<?php require_once 'includes/footer.php'; ?>