<?php

    require_once 'user_profile_base.php';

    $sql = "
            SELECT
            m.mapped_id,
            dv.device_id,
            u.user_id,
            dv.device_no,
            CASE
            WHEN dv.device_type = 1 THEN '[SD]'
            WHEN dv.device_type = 2 THEN '[HD]'
            END AS device_type,
            pc.mso_name
            FROM
            tbl_mapping m
            LEFT JOIN tbl_user u ON u.user_id = m.user_id
            RIGHT JOIN tbl_device dv ON dv.device_id = m.device_id
            RIGHT JOIN tbl_package pc ON pc.package_id = dv.package_id
            WHERE m.user_id = '" .$_GET['user_id']. "'";

?>

      <div class="col-md-9">

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
                $res = $organ->query($mapped_devs);
                if ($res->num_rows < 1) {
                  echo "<tr><td colspan='5'>No Device Assigned!</td><tr>";
                } else {
                foreach ($res as $key => $row) :
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

<?php require_once 'includes/footer.php'; ?>