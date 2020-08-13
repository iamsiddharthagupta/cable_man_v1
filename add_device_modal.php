<!-- Modal -->
<div class="modal fade" id="addDevice" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Add Device</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="container-fluid">

         <form method="POST" action="<?php echo htmlspecialchars('add_device_process.php'); ?>">
            <div class="form-group">
              <input type="text" name="device_no" class="form-control" placeholder="Enter STB, VC, NDS Number" required>
            </div>
            <div class="form-group">
              <select name="device_mso" class="form-control" required>
                <option value="">MSO</option>
                <option value="SK Vision">SK Vision</option>
                <option value="Sky HD">Sky HD</option>
                <option value="Hathway">Hathway</option>
                <option value="In-Digital">In-Digital</option>
              </select>
            </div>
            <div class="form-group">
              <select class="form-control" name="device_type" required>
                <option value="">Type</option>
                <option value="SD">SD</option>
                <option value="HD">HD</option>
              </select>
            </div>
            <div class="form-group">
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
            <div class="form-group">
              <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            </div>

       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-primary">Add</button>
      </div>
      </form>
    </div>
  </div>
</div>