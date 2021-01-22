<?php
  
    ob_start();
    session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

    $page = 'manage_device.php';

    require_once 'includes/top-nav.php';
    require_once 'includes/side-nav.php';

    $create->create_device();

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h4 class="m-0 text-dark">Device Registration</h4>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item"><a href="manage_device_list.php">Device List</a></li>
          <li class="breadcrumb-item active">Device Registration</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="container p-5">

  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off">
    <div class="card card-outline card-info">
      <div class="card-header">
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
        <div class="card-body">
          <div class="form-group">
            <label>Device No:</label>
            <input type="text" name="device_no" class="form-control" placeholder="STB, VC, NDS Number">
          </div>
          <div class="form-group">
                <div class="form-group">
                  <label>Device Type:</label>
                  <select name="device_type" class="form-control">
                    <option value="">Device type:</option>
                    <option value="SD">Standard Definition [SD]</option>
                    <option value="HD">High Definition [HD]</option>
                  </select>
                </div>
          </div>
        </div>
          <div class="card-footer">
            <div class="btn-group float-right" role="group" aria-label="Basic example">
              <button type="submit" name="submit" class="btn btn-dark">Add</button>
              <button type="button" onclick="goBack()" class="btn btn-secondary">Cancel</button>
            </div>
          </div>
        </div>
      </div>
  </form>

</div>

<?php require_once 'includes/footer.php'; ?>