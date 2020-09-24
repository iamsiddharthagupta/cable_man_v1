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

  require_once 'organ.php';

  $result = $user->dashboard_expiring_list();

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
            <h3>Rs.<?php echo $user->CountDateColl(date('Y-m-d')); ?></h3>
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
            <h3 class="card-title">Overviews</h3>
          </div>
          <div class="card-body">

            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
              <p class="text-success text-xl">
                <i class="fas fa-user-plus"></i>
              </p>
              <p class="d-flex flex-column text-right">
                <span class="font-weight-bold"><?php echo $user->CountRecentUser(date('Y-m-d')); ?></span>
                <span class="text-muted">
                  <a href="user_list.php?query=<?php echo RecentUser(date('Y-m-d')); ?>">New Connection</a>
                </span>
              </p>
            </div>

            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
              <p class="text-warning text-xl">
                <i class="fas fa-sync-alt"></i>
              </p>
              <p class="d-flex flex-column text-right">
                <span class="font-weight-bold"><?php echo $user->CountRecentRenew(date('Y-m-d')); ?></span>
                <span class="text-muted">
                  <a href="active_list.php?query=<?php echo RecentRenew(date('Y-m-d')); ?>">Recent Renewal</a>
                </span>
              </p>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mb-0">
              <p class="text-danger text-xl">
                <i class="fas fa-user-times"></i>
              </p>
              <p class="d-flex flex-column text-right">
                <span class="font-weight-bold">1</span>
                <span class="text-muted">Today's Expiry</span>
              </p>
            </div>

          </div>
        </div>
      </div>

      <div class="col-md-6">
                  <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Expiring Today</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body p-0">
              <table class="table table-sm text-nowrap">
                <tbody>

                  <tr>
                    
                    <?php

                      foreach ($result as $key => $row) :
                        
                        ?>

                          <td class="text-danger"><?php echo $row['full_name']; ?></td>
                          <td class="text-danger"><?php echo $row['address']; ?></td>
                          <td class="text-danger"><?php echo date('j M',strtotime($row['expiry_date'])); ?></td>

                  </tr>
                    <?php
                      endforeach;
                    ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
      </div>


  </div>
</div>

<?php require_once 'assets/footer.php'; ?>