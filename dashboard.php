<?php

    ob_start();
    session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

    require_once 'config/init.php';
    require_once 'includes/top-nav.php';
    require_once 'includes/side-nav.php';

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h4 class="m-0 text-dark">Dashboard</h4>
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

<!-- Red, Blue Boards -->
      <div class="col-md-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>12</h3>
            <p>Active Users</p>
          </div>
          <div class="icon">
            <i class="fas fa-user-check"></i>
          </div>
          <a href="list_active_customer.php" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-md-3 col-6">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>12</h3>
            <p>Expired Users</p>
          </div>
          <div class="icon">
            <i class="fas fa-user-slash"></i>
          </div>
          <a href="list_expired_customer.php" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-md-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>12</h3>
            <p>Unpaid Bills</p>
          </div>
          <div class="icon">
            <i class="fas fa-file-invoice"></i>
          </div>
          <a href="list_unpaid_customer.php" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-md-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3>Rs.5000</h3>
            <p>Today's Collection</p>
          </div>
          <div class="icon">
            <i class="fas fa-rupee-sign"></i>
          </div>
          <a href="report_collection.php" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>


      <div class="col-md-6">
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Active Device Summary</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body p-0">
              <canvas id="myChart"></canvas>
            </div>
          </div>
      </div>

      <div class="col-md-6">
          <div class="card card-warning">
            <div class="card-header">
              <h3 class="card-title">Expiring Today</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
          </div>
      </div>

  </div>
</div>

<?php require_once 'includes/footer.php'; ?>