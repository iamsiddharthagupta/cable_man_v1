<?php

    ob_start();
    session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

    $page = 'manage_device.php';

    require_once 'includes/top-nav.php';
    require_once 'includes/side-nav.php';

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h4 class="m-0 text-dark">Device Management</h4>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Device Management</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="card">
    <div class="card-header">
      <a href="manage_device_add.php" class="btn btn-sm btn-info">Add Device</a>

      <div class="card-tools">
        <div class="input-group input-group-sm">
          <input type="text" name="table_search" id="myInput" class="form-control float-right" placeholder="Search">
        </div>
      </div>
    </div>

    <div class="card-body table-responsive p-0" style="height: 550px;">
    <table class="table table-hover text-center table-bordered table-sm table-head-fixed text-nowrap">
          <thead class="thead-light">
            <tr>
              <th>Device ID</th>
              <th>Device Type</th>
              <th>Device Status</th>
              <th>Action</th>
            </tr>
        </thead>

        <?php

          $result = $read->fetch_device_list();

          if ($result->num_rows < 1){

            echo "<tr><td colspan='3'>No Device Available!</td><tr>";

          } else {

            foreach ($result as $key => $row) : ?>
              
        <tbody id="myTable">
          <tr>

            <td><?php echo $row['device_no']; ?></td>
            
            <td><?php echo $row['device_type']; ?></td>
            
            <td><?php echo $row['device_type']; ?></td>
            
            <td><a href="manage_device_edit.php?dev_id=<?php echo htmlentities($row['dev_id']); ?>"><i class="fas fa-pen-square"></i></a></td>

          </tr>
        </tbody>

          <?php
              endforeach;
              $result->free_result();
            }
          ?>
      </table>
    </div>
   </div>
</div>

<?php require_once 'includes/footer.php'; ?>