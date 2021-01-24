<?php
	
  ob_start();
  session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);

    $page = 'manage_device.php';

	require_once 'includes/top-nav.php';
	require_once 'includes/side-nav.php';

	$row = $read->device_edit_fetch($_GET['dev_id'])->fetch_assoc();

	$update->update_device();

?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Device Editor</h1>
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
    	<div class="card card-outline card-info">
			<div class="card-header">
				<div class="card-tools">
				  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
				  </button>
				</div>
			</div>
			<div class="card-body">
				<div class="row mb-2">
					<div class="col-sm">
						<label>Device ID:</label>
						<input type="text" name="device_no" class="form-control" value="<?php echo $row['device_no']; ?>">
					</div>
				</div>
				<div class="row mb-2">
					<div class="col-sm">
						<label>Device Type:</label>
						<select class="form-control" name="device_type">
							<option value="SD" <?php if($row["device_type"] == 'SD'){ echo "selected"; } ?>>SD</option>
							<option value="HD" <?php if($row["device_type"] == 'HD'){ echo "selected"; } ?>>HD</option>
						</select>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<input type="hidden" name="dev_id" value="<?php echo $row['dev_id']; ?>">
				<div class="btn-group float-right" role="group" aria-label="Basic example">
					<button type="submit" name="submit" class="btn btn-dark">Update</button>
					<button type="button" onclick="goBack()" class="btn btn-secondary">Cancel</button>
				</div>
			</div>
		</div>
	</form>

</div>


<?php require_once 'includes/footer.php'; ?>