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

	require_once 'organ.php';

  $user = new User();
  $result = $user->device_entry();

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Device Management</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Device Management</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="container">

    <?php if(isset($_GET['msg'])){ ?>
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <?php echo $_GET['msg']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php } ?>

	<form method="POST">
		<div class="form-row">
		<div class="form-group col-md">
          <input type="text" name="device_no" id="myInput" class="form-control" placeholder="Enter STB, VC, NDS Number" required>
        </div>
        <div class="form-group col-md">
          <select name="device_mso" class="form-control" required>
            <option value="">Choose MSO</option>
            <option value="SK Vision">SK Vision</option>
            <option value="Sky HD">Sky HD</option>
            <option value="Hathway">Hathway</option>
            <option value="In-Digital">In-Digital</option>
          </select>
        </div>
        <div class="form-group col-md">
          <select class="form-control" name="device_type" required>
            <option value="">Choose Type</option>
            <option value="SD">SD</option>
            <option value="HD">HD</option>
          </select>
        </div>
        <div class="form-group col-md">
            <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">&#8377</span>
            </div>
            <input type="number" class="form-control" name="package" aria-label="Amount (to the nearest rupee)" placeholder="Package" required="">
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

            $user = new User();

            $result = $user->user_profile_device_list_fetch();

            if (mysqli_num_rows($result) < 1){
              
              echo "<tr><td colspan='6'>Not Yet Active!</td><tr>";
            
            } else {
              
                $i = 0;
              
              foreach ($result as $key => $row) : $i++; ?>
                
          <tbody id="myTable">
            <tr>

              <td><?php echo $i; ?></td>

              <td><?php echo $row['device_no']; ?></td>
              
              <td><?php echo $row['device_mso'];?> [<?php echo $row['device_type']; ?>]</td>
              
              <td><?php echo $row['package']; ?></td>
              
              <td><?php echo $row['first_name']." ".$row['last_name']; ?></td>
              
              <td>

                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-dark btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        
                        <a href="device_edit.php?dev_id=<?php echo $row['dev_id']; ?>" class="dropdown-item">
                          Edit
                        </a>

                        <a href="device_release.php?user_id<?php echo $row['user_id']; ?>&assign_id=<?php echo $row['assign_id']; ?>" class="dropdown-item" onclick="return confirm('Do you want to release this user?');">
                          Delete
                        </a>

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

<?php require_once 'assets/footer.php'; ?>