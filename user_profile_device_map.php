<?php

    require_once 'user_profile_base.php';
    $create->user_device_map();

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
              <input type="text" class="form-control" name="device_no" id="dev_no" onBlur="checkAvailability()" required=""><span id="user-availability-status"></span>
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