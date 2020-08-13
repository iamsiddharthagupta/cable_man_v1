<?php
// Session starts here. It can be used in any page.
	session_start();
	if(isset($_SESSION['curr_user'])){
	$curr_user = ucwords($_SESSION['curr_user']);
	} else {
	header('location:index.php');
	}
	include '../common/cable_organ.php';
	include '../common/connection.php';

	$dev_id = $_POST['dev_id'];
	$user_id = $_POST['user_id'];

	$query = "SELECT * FROM cbl_dev_stock WHERE dev_id = '$dev_id'";
	$result = mysqli_query($conn,$query);
	$data = mysqli_fetch_assoc($result);
?>


<div class="container p-5">

	<ol class="breadcrumb">
	    <li class="breadcrumb-item">
	    <i class="fas fa-edit mr-1"></i>Edit Device</li>
	</ol>
  
  <hr size="3" noshade>

	<form method="post" action="<?php echo htmlspecialchars('edit_device_process.php'); ?>" autocomplete="off" class="bg-light">
		<div class="row mb-2">
			<div class="col-sm">
				<label>Device ID:</label>
				<input type="text" name="device_no" class="form-control" value="<?php echo $data['device_no']; ?>">
			</div>
			<div class="col-sm">
				<label>Device MSO:</label>
				<select class="form-control" name="device_mso">
					<option value="">Select MSO</option>
					<option value="SK Vision" <?php if($data["device_mso"]=='SK Vision'){ echo "selected"; } ?>>SK Vision</option>
					<option value="Sky HD" <?php if($data["device_mso"]=='Sky HD'){ echo "selected"; } ?>>Sky HD</option>
					<option value="Hathway" <?php if($data["device_mso"]=='Hathway'){ echo "selected"; } ?>>Hathway</option>
					<option value="In-Digital" <?php if($data["device_mso"]=='In-Digital'){ echo "selected"; } ?>>In-Digital</option>
				</select>
			</div>
		</div>
		<div class="row mb-2">
			<div class="col-sm">
				<label>Device Type:</label>
				<select class="form-control" name="device_type">
					<option value="">Select Type</option>
					<option value="SD" <?php if($data["device_type"]=='SD'){ echo "selected"; } ?>>SD</option>
					<option value="HD" <?php if($data["device_type"]=='HD'){ echo "selected"; } ?>>HD</option>
				</select>
			</div>
			<div class="col-sm">
				<label>Package:</label>
                <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">&#8377</span>
                </div>
                <input type="number" class="form-control" name="package" aria-label="Amount (to the nearest rupee)" value="<?php echo $data['package']; ?>">
                <div class="input-group-append">
                  <span class="input-group-text">.00</span>
                </div>
                </div>
			</div>
		</div>
		<div class="form-group">
			<input type="hidden" name="dev_id" value="<?php echo $dev_id; ?>">
			<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
			<button type="submit" name="submit" class="btn btn-outline-primary">Update</button>
		</div>
	</form>

</div>


<?php include '../common/footer.php'; ?>