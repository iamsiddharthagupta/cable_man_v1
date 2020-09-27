<?php require_once 'user_profile_base.php'; ?>

      <div class="col-md">
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">Select Device</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-hover text-center table-bordered table-sm table-head-fixed text-nowrap">
            <thead class="thead-light">
              <thead>
                <tr>
                  <th>Device</th>
                  <th>MSO</th>
                  <th>Duration</th>
                  <th>Renew</th>
                </tr>
            </thead>

        <?php
        
          $result = $user->user_profile_select_device_fetch($_GET['user_id']);

          if (mysqli_num_rows($result) < 1){
            echo "<tr><td colspan='4'>No Device Assigned!</td><tr>";
          } else {

          foreach ($result as $key => $row) : ?>

            <tbody>
              <tr>
                
                <td><?php echo $row['device_no']; ?></td>
                
                <td><?php echo $row['device_mso']; ?></td>

                <td>
                  <strong><?php if(empty($row['renew_date'])){ echo 'Activation Pending'; } else {echo date('jS M',strtotime($row['renew_date'])).' - '. date('jS M',strtotime($row['expiry_date']));} ?></strong>
                </td>

                <td>
                    <a href="user_profile_renewal.php?user_id=<?php echo $row['user_id']; ?>&dev_id=<?php echo $row['dev_id']; ?>"><i class="fas fa-sync"></i></a>
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
        </div>
    </div>

  </div>
</div>

<?php require_once 'assets/footer.php'; ?>