<?php
// Session starts here. It can be used in any page.
	session_start();
	if(isset($_SESSION['curr_user'])){
	$curr_user = ucwords($_SESSION['curr_user']);
	} else {
	header('location:index.php');
	}
	include '../common/cable_organ.php';
?>

<div class="container p-3">
  
  <ol class="breadcrumb">
  	<li class="breadcrumb-item"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</li>
  </ol>

  <div class="row justify-content-between p-3">
    
    <div class="col-sm">
      <div class="card border-dark mb-3 text-center">
          <div class="card-header">Active Users</div>
          <div class="card-body text-dark">
            <h2 class="card-title text-primary">[<?php echo countActiveUser(); ?>]</h2>
          </div>
      </div>
    </div>
    <div class="col-sm">
      <div class="card border-dark mb-3 text-center">
          <div class="card-header">Active Devices</div>
          <div class="card-body text-dark">
            <h2 class="card-title text-success">[<?php echo countActiveDevice(); ?>]</h2>
          </div>
      </div>
    </div>
    <div class="col-sm">
      <div class="card border-dark mb-3 text-center">
          <div class="card-header">Due Invoices</div>
          <div class="card-body text-dark">
            <h2 class="card-title text-danger">[<?php echo countUnpaid(); ?>]</h2>
          </div>
      </div>
    </div>
  </div>

  <div class="row justify-content-between p-3">
    <div class="col-sm">
      <div class="card border-primary mb-3 text-center">
        <div class="card-header">Total Collection</div>
        <div class="card-body">
          <h5 class="card-title">Coming Soon!</h5>
        </div>
      </div>
    </div>
  </div>

</div>

<?php
	include '../common/footer.php';
?>