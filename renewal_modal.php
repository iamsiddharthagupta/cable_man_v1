<!-- Modal -->
<div class="modal fade" id="renew<?php echo $user_id; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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

      $query = "
        
        SELECT

        cbl_user.first_name AS first_name,
        cbl_user.last_name AS last_name,
        cbl_user.phone_no AS phone_no,
        cbl_user.address AS address,
        cbl_user.area AS area,
        COUNT(cbl_dev_stock.dev_id) AS devices,
        SUM(cbl_dev_stock.package) AS package
        
        FROM cbl_user_dev

        RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
        LEFT JOIN cbl_ledger ON cbl_ledger.dev_id = cbl_user_dev.dev_id
        LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id
        
        WHERE cbl_user_dev.user_id = '$user_id'
        
        GROUP BY cbl_dev_stock.dev_id,cbl_dev_stock.package
        ";
      $result = mysqli_query($conn,$query);
      $data = mysqli_fetch_assoc($result);

    ?>

<div class="container-fluid">
<div class="row">
  <div class="col-sm mb-2">
    <form method="POST" action="<?php echo htmlspecialchars('renewal_process.php'); ?>">
      <div class="card">
        <div class="card-header">Renewal Panel:</div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><span class="mr-2">Name:</span>
              <strong><?php echo $data['first_name']." ".$data['last_name']; ?></strong>
            </li>
            <li class="list-group-item"><span class="mr-2">Phone Number:</span>
              <strong><?php echo $data['phone_no']; ?></strong>
            </li>
            <li class="list-group-item"><span class="mr-2">Address:</span>
              <strong><?php echo $data['address']; ?></strong>
            </li>
            <li class="list-group-item"><span class="mr-2">Device(s):</span>
              <strong><?php echo $data['devices']; ?></strong>
            </li>
            <li class="list-group-item"><span class="mr-2">Package Rate:</span>
              <strong><?php echo $data['package']; ?></strong>
            </li>

<?php
  
      $result = mysqli_query($conn,"
          SELECT
          cbl_user_dev.user_id AS user_id,
          cbl_dev_stock.dev_id AS dev_id,
          cbl_dev_stock.device_no AS device_no,
          cbl_dev_stock.device_mso AS device_mso,
          MAX(cbl_ledger.expiry_date) AS expiry_date

          FROM cbl_user_dev

          RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
          RIGHT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id
          LEFT JOIN cbl_ledger ON cbl_ledger.dev_id = cbl_user_dev.dev_id
          WHERE cbl_user_dev.user_id = '$user_id'
          GROUP BY cbl_user_dev.dev_id
        ");

      $data = mysqli_fetch_assoc($result);
      foreach ($result as $key => $data) {
        echo "  <li class='list-group-item'>
              <span class='mr-3'><input type='checkbox' name='dev_id[]' value='$data[dev_id]'></span><span>$data[device_mso]</span> - <strong><span>$data[device_no]</span></strong>
            </li>";
      }
?>

            </li>
            <li class="list-group-item">
              <input type="date" name="renew_date" class="form-control" required>
            </li>
            <li class="list-group-item">
              <textarea name="note" placeholder="Notes" class="form-control"></textarea>
            </li>
            <li class="list-group-item">
              <input type="hidden" name="invoice_no" value="<?php echo 'ALC'.date('Ymd').rand(100,999); ?>">
              <input type="hidden" name="user_id" value="<?php echo $data['user_id']; ?>">
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