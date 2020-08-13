<div class="table-resonsive">
    <table class="table table-hover text-center table-bordered table-sm">
        <thead class="thead-dark">
            <tr>
                <th>Device ID</th>
                <th>Device MSO</th>
                <th>Device Type</th>
                <th>Device Package</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <?php
            $result = mysqli_query($conn,"
                SELECT
                cbl_dev_stock.device_no AS device_no,
                cbl_dev_stock.device_mso AS device_mso,
                cbl_dev_stock.device_type AS device_type,
                cbl_dev_stock.package AS package,
                MAX(cbl_ledger.renew_date) AS renew_date,
                MAX(cbl_ledger.expiry_date) AS expiry_date

                FROM cbl_user_dev

                RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
                LEFT JOIN cbl_ledger ON cbl_ledger.dev_id = cbl_user_dev.dev_id
                LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id
                WHERE cbl_user_dev.user_id = '$user_id'

                GROUP BY cbl_user_dev.dev_id
                ");
            $data = mysqli_fetch_assoc($result);

            if(mysqli_num_rows($result) < 1){
                echo "<tr><td colspan='5'>No Device Assigned Yet!</td><tr>";
            } else {
                
                foreach ($result as $key => $data) :

            $current_date = date_create(date('Y-m-d'));
            $end_date = date_create($data['expiry_date']);
        ?>
                <tbody>
                    <tr>
                        <td><?php echo $data['device_no']; ?></td>
                        <td><?php echo $data['device_mso']; ?></td>
                        <td><?php echo $data['device_type']; ?></td>
                        <td><?php echo $data['package']; ?></td>
                        <td>
                            <?php if($current_date > $end_date){ ?>
                                <strong><div class="text-danger">Expired</div></strong>
                            <?php } else if(empty($data['renew_date'])) { ?>
                                <strong><div class="text-warning">Inactive</div></strong>
                            <?php } else { ?>
                                <strong><div class="text-success">Active</div></strong>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="#renew<?php echo $user_id; ?>" data-toggle="modal"><i class="fas fa-sync"></i></a>
                            <?php include 'renewal_modal.php'; ?>
                        </td>
                    </tr>
                </tbody>
            <?php
            endforeach;
        }
        ?>
    </table>
</div>