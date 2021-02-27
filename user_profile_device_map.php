<?php

    require_once 'user_profile_base.php';

    if(isset($_POST['submit'])) {

        $user_id = $_POST['user_id'];
        $device_no = $_POST['device_no'];

        $row = $organ->query("SELECT device_id FROM tbl_device WHERE device_no = '$device_no'")->fetch_assoc();

        $device_id = $row['device_id'];

        $array = array(
            "user_id" => $user_id,
            "device_id" => $device_id
          );

        $res = $organ->insert('tbl_mapping', $array);

        if($res) {

                  $msg = 'Device Mapped Successfully.';
                  $code = 'success';
                  header('Location: user_profile_ledger.php?user_id='.$user_id.'&msg='.$msg);

        } else {

            $msg = 'Database Error.';
            $code = 'error';
            header('Location: user_profile_device_map.php?msg='.$msg.'&code='.$code);

        }
    }

?>

  <div class="col-md-9">
    <form method="POST" class="needs-validation" novalidate>
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">Map Device</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="form-group col-md">
            <label>Device #</label>
              <input type="text" class="form-control" name="device_no" id="device_no" onBlur="checkAvailability()" required=""><span id="user-availability-status"></span>
              <div class="invalid-feedback">
                Please provide a valid device number.
              </div>
          </div>
          <p><img src="assets/images/LoaderIcon.gif" id="loaderIcon" style="display:none" /></p>
        </div>
        <div class="card-footer">
          <input type="hidden" name="user_id" value="<?php echo $_GET['user_id']; ?>">
          <button type="submit" name="submit" class="btn btn-primary float-right">Add</button>
        </div>
      </div>
    </form>
  </div>

  </div>
</div>

<?php require_once 'includes/footer.php'; ?>