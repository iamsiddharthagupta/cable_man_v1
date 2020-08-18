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
        <h1 class="m-0 text-dark">Add Device</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Add Device</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="container">
	<form method="POST" action="<?php echo htmlspecialchars('device_map_process.php'); ?>">
		<div class="form-row">
		<div class="form-group col-md">
          <input type="text" name="device_no" id="myInput" class="form-control" placeholder="Enter STB, VC, NDS Number" required>
        </div>
        <div class="form-group col-md">
          <select name="device_mso" class="form-control" required>
            <option value="" disabled>MSO</option>
            <option value="SK Vision">SK Vision</option>
            <option value="Sky HD">Sky HD</option>
            <option value="Hathway">Hathway</option>
            <option value="In-Digital">In-Digital</option>
          </select>
        </div>
        <div class="form-group col-md">
          <select class="form-control" name="device_type" required>
            <option value="" disabled>Type</option>
            <option value="SD">SD</option>
            <option value="HD">HD</option>
          </select>
        </div>
        <div class="form-group col-md">
            <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">&#8377</span>
            </div>
            <input type="number" class="form-control" name="package" aria-label="Amount (to the nearest rupee)" placeholder="Package">
            <div class="input-group-append">
              <span class="input-group-text">.00</span>
            </div>
            </div>
        </div>
        <div class="col-auto">
        	<button class="btn btn-primary" type="submit" name="submit">Add</button>
        </div>
		</div>
	</form>

	        <div class="card-body table-responsive p-0" style="height: 490px;">
          <table class="table table-hover text-center table-bordered table-sm table-head-fixed">
            <thead class="thead-light">
              <tr>
                <th>SN</th>
                <th>Device ID</th>
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
              
              <td><?php echo $data['first_name']." ".$data['last_name']; ?></td>
              
              <td>

                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                      <form method="POST" action="device_edit.php">
                        <input type="hidden" name="dev_id" value="<?php echo $data['dev_id']; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $data['user_id']; ?>">
                        <button type="submit" name="submit" class="dropdown-item">Edit</button>
                      </form>
                    <?php if(empty($data['user_id'])){ ?>
                    <?php } else { ?>
                        <form method="POST" action="device_release.php">
                          <input type="hidden" name="user_id" value="<?php echo $data['user_id']; ?>">
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

<?php require_once 'common/footer.php'; ?>