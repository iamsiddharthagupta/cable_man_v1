<?php

    require_once 'profile_base.php';
    $create->user_device_map();

?>

	<div class="col-md-3">
    <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">Mapped Device</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
          </div>
        </div>
        <div class="card-body">
          <form method="POST">
              <table class="table table-sm text-nowrap">

              <?php
                $result = $device->user_profile_device_fetch($_GET['user_id']);
                $row = mysqli_fetch_assoc($result);
                foreach ($result as $key => $row) :
              ?>
                <tbody>
                  <tr>
                    <td><?php echo $row['device_mso'].' - '.$row['device_no']; ?></td>
                    <td>
                      <a href="user_profile_device_release.php?assign_id=<?php echo $row['assign_id']; ?>&user_id=<?php echo $_GET['user_id']; ?>" onclick="return confirm('Do you want to release this device?');"><i class="fas fa-minus-circle"></i>
                      </a>
                    </td>
                    <td>
                      <a href="device_edit.php?dev_id=<?php echo $row['dev_id']; ?>&user_id=<?php echo $_GET['user_id']; ?>">
                        <i class="fas fa-pen-square"></i>
                      </a>
                    </td>
                  </tr>
                </tbody>
              
              <?php
                endforeach;
              ?>
            </table>
              <div class="form-group col-md">
                  <input type="text" name="device_no" id="myInput" placeholder="Enter Device ID" class="form-control" required> 
              </div>

              <div class="form-group col-md">
                <input type="hidden" name="user_id" value="<?php echo $_GET['user_id']; ?>">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                <a href="device_entry.php?user_id=<?php echo $_GET['user_id']; ?>" class="btn btn-success">Add Device</a>
              </div>
          </form>
        </div>
    </div>
	</div>

  </div>
</div>

<?php require_once 'includes/footer.php'; ?>