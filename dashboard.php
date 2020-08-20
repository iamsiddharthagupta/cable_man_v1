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

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Dashboard</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row">

      <div class="col-md-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3><?php echo CountActiveDevice(date('Y-m-d')); ?></h3>
            <p>Active Devices</p>
          </div>
          <div class="icon">
            <i class="fas fa-hdd"></i>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3><?php echo CountActiveUser(date('Y-m-d')); ?></h3>
            <p>Active Users</p>
          </div>
          <div class="icon">
            <i class="fas fa-user-check"></i>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>44</h3>
            <p>User Registrations</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-6">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>65</h3>
            <p>Unique Visitors</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
          <div class="card-header border-0">
            <div class="d-flex justify-content-between">
              <h3 class="card-title">Expiring Today</h3>
            </div>
          </div>
          <div class="card-body">
          </div>
        </div>
      </div>

  </div>
</div>

<?php require_once 'common/footer.php'; ?>