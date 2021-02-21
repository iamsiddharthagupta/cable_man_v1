<?php

    require_once 'user_profile_base.php';
    $create->user_device_map();

?>

  <div class="col-md-5">
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title">Devices</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body p-0">
        <table class="table">
          <thead>
            <tr>
              <th>Device #</th>
              <th>MSO Name</th>
              <th>Action</th>
            </tr>
          </thead>
      <?php
        $result = $read->user_profile_device_fetch($_GET['user_id']);
        $row = mysqli_fetch_assoc($result);
          foreach ($result as $key => $row) :
      ?>
          <tbody>
            <tr>
              <td><?php echo $row['dev_no']; ?></td>
              <td><?php echo $row['mso_name']; ?></td>
              <td class="text-right py-0 align-middle">
                <div class="btn-group btn-group-sm">
                  <a href="device_edit.php?dev_id=<?php echo $row['dev_id']; ?>&user_id=<?php echo $_GET['user_id']; ?>" class="btn btn-info"><i class="fas fa-eye"></i></a>
                  <a href="user_profile_device_release.php?map_id=<?php echo $row['map_id']; ?>&user_id=<?php echo $_GET['user_id']; ?>" onclick="return confirm('Do you want to release this device?');" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                </div>
              </td>
            </tr>
          </tbody>
      <?php endforeach; ?>
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-4">
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
            <input type="text" class="form-control" name="device_no" id="dev_no" onBlur="checkAvailability()"><span id="user-availability-status"></span>
        </div>
        <p><img src="assets/images/LoaderIcon.gif" id="loaderIcon" style="display:none" /></p>
      </div>
      <div class="card-footer">
        <input type="hidden" name="user_id" value="<?php echo $_GET['user_id']; ?>">
        <button type="submit" name="submit" class="btn btn-primary float-right">Add</button>
      </div>
    </div>
  </div>

  </div>
</div>

<?php require_once 'includes/footer.php'; ?>

<script>
function checkAvailability() {
  $("#loaderIcon").show();
  jQuery.ajax({
  url: "device_checker.php",
  data:'dev_no='+$("#dev_no").val(),
  type: "POST",
  success:function(data){
    $("#user-availability-status").html(data);
    $("#loaderIcon").hide();
  },
  error:function (){}
  });
}
</script>