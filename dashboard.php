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
          <a href="active_list.php?query=<?php echo ActiveList('ac'); ?>" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
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
          <a href="user_list.php?query=<?php echo UserActiveList('ac'); ?>" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-md-3 col-6">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3><?php echo CountUnpaid(); ?></h3>
            <p>Overdues</p>
          </div>
          <div class="icon">
            <i class="fas fa-file-invoice"></i>
          </div>
          <a href="payment_list.php?query=<?php echo OverdueList('Renewed'); ?>" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-md-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>Rs.<?php echo CountDateColl(date('Y-m-d')); ?></h3>
            <p>Today's Collection</p>
          </div>
          <div class="icon">
            <i class="fas fa-rupee-sign"></i>
          </div>
          <a href="collection_book.php" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
          <div class="card-header border-0">
            <h3 class="card-title">Miscellaneous Overviews</h3>
          </div>
          <div class="card-body">

            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
              <p class="text-success text-xl">
                <i class="fas fa-user-plus"></i>
              </p>
              <p class="d-flex flex-column text-right">
                <span class="font-weight-bold">12</span>
                <span class="text-muted">New Connection</span>
              </p>
            </div>

            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
              <p class="text-warning text-xl">
                <i class="fas fa-sync-alt"></i>
              </p>
              <p class="d-flex flex-column text-right">
                <span class="font-weight-bold">12</span>
                <span class="text-muted">Recent Renewal</span>
              </p>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mb-0">
              <p class="text-danger text-xl">
                <i class="fas fa-user-times"></i>
              </p>
              <p class="d-flex flex-column text-right">
                <span class="font-weight-bold">1</span>
                <span class="text-muted">Recent Deactivations</span>
              </p>
            </div>

          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
          <div class="card-header border-0">
            <h3 class="card-title">Device Overviews</h3>
          </div>
          <div class="card-body">

          </div>
        </div>
      </div>

  </div>
</div>

<?php require_once 'common/footer.php'; ?>