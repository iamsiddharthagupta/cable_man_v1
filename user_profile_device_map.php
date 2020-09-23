<?php

  require_once 'user_profile_base.php';
  $result = $user->user_device_map();

?>

	<div class="col-md-3">
    <div class="card card-primary">
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
                $result = $user->user_profile_device_fetch($_GET['user_id']);
                $row = mysqli_fetch_assoc($result);
                foreach ($result as $key => $row) :
              ?>
                <tbody>
                  <tr>
                    <td><?php echo $row['device_mso'].' - '.$row['device_no']; ?></td>
                    <td><a href="user_profile_device_release.php?assign_id=<?php echo $row['assign_id']; ?>&user_id=<?php echo $_GET['user_id']; ?>" onclick="return confirm('Do you want to release this device?');"><i class="fas fa-minus-circle"></i></a></td>
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
	<div class="col-md-6">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Device List</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
          </div>
        </div>
		    <div class="card-body table-responsive p-0" style="height: 490px;">
          <table class="table table-hover text-center table-bordered table-sm table-head-fixed text-nowrap">
            <thead class="thead-light">
              <tr>
                <th>Action</th>
                <th>Dev ID</th>
                <th>MSO</th>
                <th>Package</th>
                <th>Assignee</th>
              </tr>
          </thead>

          <?php

            $result = $user->user_profile_device_list_fetch();

            if (mysqli_num_rows($result) < 1){

              echo "<tr><td colspan='4'>Not Yet Active!</td><tr>";

            } else {

              foreach ($result as $key => $row) : ?>
                
          <tbody id="myTable">
            <tr>

              <td>

                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-dark btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        
                        <a href="device_edit.php?dev_id=<?php echo $row['dev_id']; ?>&user_id=<?php echo $_GET['user_id']; ?>" class="dropdown-item">
                          Edit
                        </a>

                        <?php if(empty($row['assign_id'])) { ?>
                        <a href="device_delete.php?dev_id=<?php echo $row['dev_id']; ?>&user_id=<?php echo $_GET['user_id']; ?>" class="dropdown-item" onclick="return confirm('Do you want to release this user?');">
                          Delete
                        </a>
                      <?php } ?>
                    </div>
                  </div>
              </td>

              <td><?php echo $row['device_no']; ?></td>
              
              <td><?php echo $row['device_mso'];?> [<?php echo $row['device_type']; ?>]</td>
              
              <td><?php echo $row['package']; ?></td>
              
              <td><?php echo $row['first_name']." ".$row['last_name']; ?></td>

            </tr>
          </tbody>

            <?php
              endforeach;
              }
            ?>
        </table>
      </div>
	   </div>

    </div>
  </div>
</div>

<?php require_once 'assets/footer.php'; ?>