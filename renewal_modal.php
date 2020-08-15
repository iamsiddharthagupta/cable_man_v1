<!-- Modal -->
<div class="modal fade" id="renew<?php echo $data['dev_id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Renewal Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

    <?php

      $dev_id = $data['dev_id'];
      $query = "SELECT
                cbl_user.user_id AS user_id,
                cbl_user.first_name AS first_name,
                cbl_user.last_name AS last_name,
                cbl_user.phone_no AS phone_no,
                cbl_user.address AS address,
                cbl_user.area AS area,
                cbl_dev_stock.device_no AS device_no,
                cbl_dev_stock.device_mso AS device_mso,
                cbl_dev_stock.device_type AS device_type
                
                FROM cbl_user_dev

                RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
                LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id
                
                WHERE cbl_user_dev.dev_id = '$dev_id'";

      $result = mysqli_query($conn,$query);
      $data = mysqli_fetch_assoc($result);

    ?>

<div class="container-fluid">
<div class="row">
  <div class="col-sm mb-2">
    <form method="POST" action="<?php echo htmlspecialchars('renewal_process.php'); ?>">
      <div class="card">
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><span class="mr-2">Device No:</span>
              <strong><?php echo $data['device_no']; ?></strong>
            </li>
            <li class="list-group-item"><span class="mr-2">Device MSO:</span>
              <strong><?php echo $data['device_mso']; ?></strong>
            </li>
            <li class="list-group-item">
              <input type="date" name="renew_date" class="form-control" required>
            </li>
            <li class="list-group-item">
              <textarea name="note" placeholder="Notes" class="form-control"></textarea>
            </li>
            <li class="list-group-item">
              <input type="hidden" name="invoice_no" value="<?php echo 'ALC'.date('Ymd').$data['user_id']; ?>">
              <input type="hidden" name="user_id" value="<?php echo $data['user_id']; ?>">
              <input type="hidden" name="dev_id" value="<?php echo $dev_id; ?>">
            </li>
          </ul>
      </div>
  </div>
</div>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    </div>
  </div>
</div>