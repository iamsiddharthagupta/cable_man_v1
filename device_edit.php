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
	$result = $user->device_edit_fetch($_GET['dev_id']);

	$row = mysqli_fetch_assoc($result);
	$result = $user->device_edit($_GET['user_id']);
?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Edit Device</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Edit Device</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="container p-5">

	<form method="POST" autocomplete="off">
		<div class="row mb-2">
			<div class="col-sm">
				<label>Device ID:</label>
				<input type="text" name="device_no" class="form-control" value="<?php echo $row['device_no']; ?>">
			</div>
			<div class="col-sm">
				<label>Device MSO:</label>
				<select class="form-control" name="device_mso">
					<option value="">Select MSO</option>
					<option value="SK Vision" <?php if($row["device_mso"]=='SK Vision'){ echo "selected"; } ?>>SK Vision</option>
					<option value="Sky HD" <?php if($row["device_mso"]=='Sky HD'){ echo "selected"; } ?>>Sky HD</option>
					<option value="Hathway" <?php if($row["device_mso"]=='Hathway'){ echo "selected"; } ?>>Hathway</option>
					<option value="In-Digital" <?php if($row["device_mso"]=='In-Digital'){ echo "selected"; } ?>>In-Digital</option>
				</select>
			</div>
		</div>
		<div class="row mb-2">
			<div class="col-sm">
				<label>Device Type:</label>
				<select class="form-control" name="device_type">
					<option value="">Select Type</option>
					<option value="SD" <?php if($row["device_type"]=='SD'){ echo "selected"; } ?>>SD</option>
					<option value="HD" <?php if($row["device_type"]=='HD'){ echo "selected"; } ?>>HD</option>
				</select>
			</div>
			<div class="col-sm">
				<label>Package:</label>
                <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">&#8377</span>
                </div>
                <input type="number" class="form-control" name="package" aria-label="Amount (to the nearest rupee)" value="<?php echo $row['package']; ?>">
                <div class="input-group-append">
                  <span class="input-group-text">.00</span>
                </div>
                </div>
			</div>
		</div>
		<div class="form-group">
			<input type="hidden" name="dev_id" value="<?php echo $row['dev_id']; ?>">
			<input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
			<button type="submit" name="submit" class="btn btn-outline-primary">Update</button>
		</div>
	</form>

</div>


<?php require_once 'assets/footer.php'; ?>