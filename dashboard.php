<?php

  session_start();

  if(isset($_SESSION['user_level'])){
      $curr_user = ucwords($_SESSION['curr_user']);
      if($_SESSION['user_level'] != 1){
          header('Location: agent_panel.php');
      }
  } else {
    header('Location: index.php');
  }

  require_once 'connection.php';
  require_once 'organ.php';

?>

  <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

<div class="container p-3">
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

<?php require_once 'common/footer.php'; ?>