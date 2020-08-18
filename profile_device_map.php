<?php

	require_once 'profile_casing.php';

?>

		
	<div class="col-md-3">
	    <div class="container-fluid">
	      	<div class="card">
	      		<div class="card-header">Map/Edit Device:</div>
	              <ul class="list-group list-group-flush">
                <?php

                  $query = "SELECT * FROM cbl_user_dev
                            RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
                            LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id
                            WHERE cbl_user_dev.user_id = '$user_id'";

                  $result = mysqli_query($conn,$query);
                  
                  $data = mysqli_fetch_assoc($result);

                  foreach ($result as $key => $data) : ?>
                    <li class="list-group-item">
                      <span>
                        <form method="POST" action="release_device.php">
                          <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                          <input type="hidden" name="assign_id" value="<?php echo $data['assign_id']; ?>">
                          <button type="submit" name="submit" onclick="return confirm('Do you want to release this user?');" class="btn btn-danger btn-xs">x</button>
                        </form> <?php echo $data['device_mso']; ?> - <strong><?php echo $data['device_no']; ?></strong></span>
                    </li>
	                    <?php
	                  endforeach;
	                ?>
	                <form method="POST" action="<?php echo htmlspecialchars('map_device_process.php') ?>">
	                <li class="list-group-item">
	                  <input type="text" name="device_no" id="myInput" placeholder="Enter Device ID" class="form-control" required>
	                </li>
	                <li class="list-group-item">
	                  <textarea name="reason" class="form-control" placeholder="Reason"></textarea>
	                </li>
	                <li class="list-group-item">
	                    <div class="col-sm-2">
	                      <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
	                      <button type="submit" name="submit" class="btn btn-primary">Submit</button>
	                    </div>
	                  </li>
	                </ul>
	            </form>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		        <div class="card-body table-responsive p-0" style="height: 490px;">
          <table class="table table-hover text-center table-bordered table-sm table-head-fixed">
            <thead class="thead-light">
              <tr>
                <th>SN</th>
                <th>Dev #</th>
                <th>MSO</th>
                <th>Package</th>
                <th>Assignee</th>
                <th>Action</th>
              </tr>
          </thead>

          <?php

            $query = "
                      SELECT
                      cbl_dev_stock.dev_id AS dev_id,
                      cbl_dev_stock.device_no AS device_no,
                      cbl_dev_stock.device_mso AS device_mso,
                      cbl_dev_stock.device_type AS device_type,
                      cbl_dev_stock.package AS package,
                      cbl_user.user_id AS user_id,
                      cbl_user.first_name AS first_name,
                      cbl_user.last_name AS last_name,
                      cbl_user_dev.assign_id AS assign_id

                      FROM cbl_user_dev
                      LEFT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
                      RIGHT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id
                      ORDER BY cbl_user.user_id ASC";
            $result = mysqli_query($conn,$query);

            if (mysqli_num_rows($result) < 1){
              echo "<tr><td colspan='6'>Not Yet Active!</td><tr>";
            } else {
              $i = 0;
              foreach ($result as $key => $data) : $i++; ?>
                
          <tbody id="myTable">
            <tr>

              <td><?php echo $i; ?></td>

              <td><?php echo $data['device_no']; ?></td>
              
              <td><?php echo $data['device_mso'];?> [<?php echo $data['device_type']; ?>]</td>
              
              <td><?php echo $data['package']; ?></td>
              
              <td><a href="user_profile.php?user_id=<?php echo $data['user_id']; ?>"><?php echo $data['first_name']." ".$data['last_name']; ?></a></td>
              
              <td>

                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                      <form method="POST" action="edit_device.php">
                        <input type="hidden" name="dev_id" value="<?php echo $data['dev_id']; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <button type="submit" name="submit" class="dropdown-item">Edit</button>
                      </form>
                    <?php if(empty($data['user_id'])){ ?>
                    <?php } else { ?>
                        <form method="POST" action="release_device.php">
                          <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                          <input type="hidden" name="assign_id" value="<?php echo $data['assign_id']; ?>">
                          <button type="submit" name="submit" onclick="return confirm('Do you want to release this user?');" class="dropdown-item">Release</button>
                        </form>
                    <?php } ?>
                    </div>
                  </div>
              </td>
            </tr>
          </tbody>

            <?php
              endforeach;
              }
            ?>
        </table>
      </div>
	</div>
</section>

<?php require_once 'common/footer.php'; ?>