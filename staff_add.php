<?php

    ob_start();
    session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

    $page = 1.3;

    require_once 'includes/top-nav.php';
    require_once 'includes/side-nav.php';

    $create->create_staff();

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h4 class="text-dark">Add Staff</h4>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Staff Management</li>
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
            <label>Username</label>
            <input type="text" name="username" class="form-control" required="">
          </div>
          <div class="form-group col-md">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required="">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" required="">
          </div>
          <div class="form-group col-md">
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control" required="">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md">
            <label>Phone No</label>
            <input type="text" name="phone_no" id="phone" class="form-control" required="">
          </div>
          <div class="form-group col-md">
            <label>Staff Position</label>
            <select class="custom-select" name="staff_position" required="">
              <option value="">Select Position</option>
              <option value="1">Admin</option>
              <option value="2">Agent</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label>Branch</label>
            <?php
              $branches = $read->fetch_branch_list_all();
                echo "<select name='branch_id' class='custom-select' required>";
                echo "<option value=''>Select Branch</option>";
                  foreach ($branches as $key => $branch) {
                    echo "<option value='$branch[branch_id]'>$branch[branch_name]</option>";
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