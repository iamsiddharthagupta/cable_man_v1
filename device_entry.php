<?php
  
  ob_start();
  session_start();

  if(isset($_SESSION['user_level'])){
      $curr_user = ucwords($_SESSION['curr_user']);
      if($_SESSION['user_level'] != 1){
          header('Location: agent_panel.php');
      }
  } else {
    header('Location: index.php');
  }

  require_once 'includes/top-nav.php';
  require_once 'includes/side-nav.php';

  $result = $device->device_entry($_GET['user_id']);

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Add New Device</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Device Registration</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="container p-5">

  <form method="POST">
    <div class="form-group col-md">
      <input type="text" name="device_no" class="form-control" placeholder="Enter STB, VC, NDS Number" required>
    </div>
    <div class="form-group col-md">
      <select name="device_mso" class="form-control" required>
        <option value="">Select MSO</option>
        <option value="SK Vision">SK Vision</option>
        <option value="Sky HD">Sky HD</option>
        <option value="Hathway">Hathway</option>
        <option value="In-Digital">In-Digital</option>
        <option value="Den Jio">Den Jio</option>
      </select>
    </div>
    <div class="form-group col-md">
      <select class="form-control" name="device_type" required>
        <option value="">Select STB Type</option>
        <option value="SD">SD</option>
        <option value="HD">HD</option>
      </select>
    </div>
    <div class="form-group col-md">
        <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text">&#8377</span>
        </div>
        <input type="number" class="form-control" name="package" aria-label="Amount (to the nearest rupee)" placeholder="Package" required="">
        <div class="input-group-append">
          <span class="input-group-text">.00</span>
        </div>
        </div>
    </div>
    <div class="form-group col-md">
    	<button class="btn btn-primary" type="submit" name="submit">Add</button>
    </div>
  </form>

</div>

<?php require_once 'includes/footer.php'; ?>