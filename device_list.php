<?php

    ob_start();
    session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

    $page = 1.5;

    require_once 'config/init.php';
    require_once 'includes/top-nav.php';
    require_once 'includes/side-nav.php';

    $sql = "
            SELECT
            dv.device_id,
            dv.device_no,
            dv.device_type,
            pc.pack_code,
            pc.pack_rate,
            pc.mso_name

            FROM tbl_device dv
            LEFT JOIN tbl_package pc ON pc.package_id = dv.package_id
            ORDER BY dv.created_at
            ";

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h4 class="m-0 text-dark">Device List</h4>
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

<div class="container">
  <div class="card card-outline card-info">
    <div class="card-header">
      <a href="device_add.php" class="btn btn-sm btn-info">Add Device</a>
      <div class="card-tools">
        <div class="input-group input-group-sm">
          <input type="text" name="table_search" id="myInput" class="form-control float-right" placeholder="Search">
        </div>
      </div>
    </div>

    <div class="card-body table-responsive p-0">
    <table class="table table-hover text-center table-bordered table-sm table-head-fixed text-nowrap">
          <thead class="thead-light">
            <tr>
              <th>Device #</th>
              <th>Device type</th>
              <th>Package</th>
              <th>Rate</th>
              <th>MSO</th>
              <th>Action</th>
            </tr>
        </thead>

        <?php
          $result = $read->query($sql);
            if ($result->num_rows < 1) {
              echo "<tr><td colspan='6'>No device yet!</td><tr>";
            } else {
              foreach ($result as $key => $row) :
        ?>
        <tbody id="myTable">
          <tr>
            <td><?php echo $row['device_no']; ?></td>
            <td><?php echo $row['device_type']; ?></td>
            <td><?php echo $row['pack_name']; ?></td>
            <td><?php echo $row['pack_rate']; ?></td>
            <td><?php echo $row['mso_name']; ?></td>
            <td><a href="device_edit.php?device_id=<?php echo $row['device_id']; ?>"><i class="fas fa-pen-square"></i></a></td>
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