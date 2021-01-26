<?php

    ob_start();
    session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

    $page = 'manage_device.php';

    require_once 'includes/top-nav.php';
    require_once 'includes/side-nav.php';
    $create->create_device();
    $update->update_device();

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
  <div class="card card-outline card-info">
    <div class="card-header">
      <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#add_device">
        Add Device
      </button>

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
              <th>Package</th>
              <th>MSO</th>
              <th>Action</th>
            </tr>
        </thead>

        <?php
          $result = $read->fetch_device_list();
            if ($result->num_rows < 1) {
              echo "<tr><td colspan='4'>No Device Available!</td><tr>";
            } else {
              foreach ($result as $key => $row) :
        ?>

          <!-- Edit -->
          <div class="modal fade" id="edit_data<?php echo $row['dev_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Edit Package</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off">
                    <div class="col-sm">
                      <label>Device ID:</label>
                      <input type="text" name="device_no" class="form-control" value="<?php echo $row['device_no']; ?>">
                    </div>
                    <div class="col-sm">
                      <label>Device Type:</label>
                      <select class="form-control" name="device_type">
                        <option value="SD" <?php if($row["device_type"] == 'SD'){ echo "selected"; } ?>>Standard Definition [SD]</option>
                        <option value="HD" <?php if($row["device_type"] == 'HD'){ echo "selected"; } ?>>High Definition [HD]</option>
                      </select>
                    </div>
                </div>
                <div class="modal-footer">
                  <input type="hidden" name="dev_id" value="<?php echo $row['dev_id']; ?>">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="update" name="update" class="btn btn-primary">Save changes</button>
                </form>
                </div>
              </div>
            </div>
          </div>

        <tbody id="myTable">
          <tr>
            <td><?php echo $row['device_no']; ?></td>
            <td><?php echo $row['device_type']; ?></td>
            <td><?php echo $row['pack_name']; ?></td>
            <td><?php echo $row['mso_name']; ?></td>
            <td><a href="#" data-toggle="modal" data-target="#edit_data<?php echo $row['dev_id']; ?>"><i class="fas fa-pen-square"></i></a></td>
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

<!-- Add -->
<div class="modal fade" id="add_device" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Device</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off">
          <div class="form-group">
            <label>Device No:</label>
            <input type="text" name="device_no" class="form-control" placeholder="STB, VC, NDS Number">
          </div>
          <div class="form-group">
                <div class="form-group">
                  <label>Device Type:</label>
                  <select name="device_type" class="form-control">
                    <option value="">Device type:</option>
                    <option value="SD">Standard Definition [SD]</option>
                    <option value="HD">High Definition [HD]</option>
                  </select>
                </div>
          </div>
          <div class="form-group">
            <label>Package:</label>
              <?php

                $packs = $read->fetch_package_list();

                echo "<select name='pack_id' class='form-control'>";
                echo "<option value=''>Select Package</option>";
                  foreach ($packs as $key => $pack) {
                    echo "<option value='$pack[pack_id]'>$pack[pack_name] - $pack[mso_name]</option>";
                  }
                echo "</select>";

              ?>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="add" name="add" class="btn btn-primary">Save changes</button>
      </form>
      </div>
    </div>
  </div>
</div>