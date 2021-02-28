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
                  <th>Renew</th>
                </tr>
            </thead>

        <?php
              $result = $read->mapped_device($_GET['user_id']);

              if ($result->num_rows < 1) {
                
                echo "<tr><td colspan='5'>No Device Assigned!</td><tr>";
              
              } else {

              foreach ($result as $key => $row) :
        ?>

            <tbody>
              <tr>
                <td><?php echo $row['device_no']; ?></td>
                <td><?php echo $row['mso_name']; ?></td>
                <td>
                  <a href="user_profile_renewal.php?user_id=<?php echo $row['user_id']; ?>&device_id=<?php echo $row['device_id']; ?>"><i class="fas fa-sync"></i></a>
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

<?php require_once 'includes/footer.php'; ?>