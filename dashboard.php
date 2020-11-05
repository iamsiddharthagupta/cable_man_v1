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

<!-- Red, Blue Boards -->
      <div class="col-md-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3><?php echo mysqli_num_rows($user->user_list_active()); ?></h3>
            <p>Active Users</p>
          </div>
          <div class="icon">
            <i class="fas fa-user-check"></i>
          </div>
          <a href="user_list_active.php" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-md-3 col-6">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3><?php echo mysqli_num_rows($user->user_list_expired()); ?></h3>
            <p>Expired Users</p>
          </div>
          <div class="icon">
            <i class="fas fa-user-slash"></i>
          </div>
          <a href="user_list_expired.php" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-md-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3><?php echo mysqli_num_rows($user->user_list_unpaid()); ?></h3>
            <p>Overdue Bills</p>
          </div>
          <div class="icon">
            <i class="fas fa-file-invoice"></i>
          </div>
          <a href="user_list_unpaid.php" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-md-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3>Rs.<?php echo $user->todays_collection(date('Y-m-d')); ?></h3>
            <p>Today's Collection</p>
          </div>
          <div class="icon">
            <i class="fas fa-rupee-sign"></i>
          </div>
          <a href="collection_book.php" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
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
            <div class="card-body table-responsive p-0" style="height: 320px;">
              <table class="table table-sm text-nowrap">
                <tbody>

                  <tr>
                    
                    <?php
                      $result = $user->dashboard_expiring_list();
                        
                        if(mysqli_num_rows($result) < 1) {

                          echo "<td colspan='4'>Hurray! No User Today.</td>";

                        } else {

                          foreach ($result as $key => $row) : ?>

                          <td class="text-danger"><?php echo $row['first_name'].' '.$row['last_name']; ?></td>
                          <td class="text-danger"><?php echo $row['address']; ?></td>
                          <td class="text-danger"><?php echo date('j M',strtotime($row['expiry_date'])); ?></td>
                          <td class="text-danger"><?php echo $row['status']; ?></td>

                  </tr>
                  <?php

                      endforeach;

                    }

                  ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
      </div>

  </div>
</div>

<?php

  require_once 'includes/footer.php';
  
  $devices = '';
  $device_mso = '';

  $result = $device->device_summary();

  while ($row = mysqli_fetch_array($result)) {

    $devices = $devices . '"'. $row['devices'].'",';
    $device_mso = $device_mso . '"'. $row['device_mso'] .'",';
  }

  $devices = trim($devices,",");
  $device_mso = trim($device_mso,",");


?>

<script type="text/javascript">

  var ctx = document.getElementById('myChart').getContext('2d');
  var chart = new Chart(ctx, {
      // The type of chart we want to create
      type: 'doughnut',

      // The data for our dataset
      data: {
          labels: [<?php echo $device_mso; ?>],
          datasets: [{
              label: 'Area-wise Active Connections',
              backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef'],
              borderColor: 'rgba(210, 214, 222, 1)',
              data: [<?php echo $devices; ?>]
          }]
      },

      // Configuration options go here
      options: {}
  });

</script>