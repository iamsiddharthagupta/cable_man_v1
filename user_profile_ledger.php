<?php

  require_once'user_profile_base.php';

  $sql = "
        SELECT
        d.dev_id,
        d.device_no,
        d.device_mso,
        l.ledger_id,
        l.renew_date,
        l.expiry_date,
        l.renew_term,
        l.due_amount,
        l.pay_amount,
        l.pay_balance,
        CASE
          WHEN l.pay_status IS NULL THEN '-'
          ELSE l.pay_status
        END AS pay_status,
        CASE
          WHEN l.pay_date IS NULL THEN 'Unpaid'
          ELSE DATE_FORMAT(l.pay_date, '%e %b %Y')
        END AS pay_date,
        l.ledger_status,
        l.user_id

        FROM cbl_user_dev ud

        RIGHT JOIN cbl_user u ON u.user_id = ud.user_id
        LEFT JOIN cbl_ledger l ON l.dev_id = ud.dev_id
        LEFT JOIN cbl_dev_stock d ON d.dev_id = ud.dev_id

        WHERE l.user_id = '". $_GET['user_id'] ."'
        ORDER BY renew_date DESC
    ";

?>

		<div class="col-md-9">

      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">Ledger Book</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
          </div>
        </div>
        <div class="card-body table-responsive p-0" style="height: 490px;">
          <table class="table table-hover text-center table-bordered table-sm table-head-fixed text-nowrap">
            <thead class="thead-light">
                <thead>
                    <tr>
                      <th>Device</th>
                      <th>Duration</th>
                      <th>Due Amount</th>
                      <th>Amount</th>
                      <th>Arrears</th>
                      <th>Status</th>
                      <th>Payment</th>
                      <th>Action</th>
                    </tr>
                </thead>

        <?php

          $res = $organ->profile_ledger($_GET['user_id']);

          if (mysqli_num_rows($res) < 1) {

            echo "<tr><td colspan='8'>Not Entries Yet!</td><tr>";

          } else {

            foreach ($res as $key => $row) : ?>

            <tbody>
              <tr>
                
                <td><?php echo $row['device_no'].' - '.$row['device_mso']; ?></td>

                <td>
                  <strong><?php echo date('jS M',strtotime($row['renew_date'])); ?> - <?php echo date('jS M',strtotime($row['expiry_date'])); ?> (<?php echo $row['renew_term']; ?>)</strong>
                </td>

                <td><?php echo $row['due_amount']; ?></td>

                <td><?php echo $row['pay_amount']; ?></td>
                
                <td><?php echo $row['pay_balance']; ?></td>
                
                <td><?php echo $row['pay_status']; ?></td>
                
                <td><?php echo $row['pay_date']; ?></td>
                
                <td>
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-dark btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        
                        <?php if($row['ledger_status'] == 'Renewed'){ ?>
                          <a class="dropdown-item" href="user_profile_payment.php?user_id=<?php echo $row['user_id']; ?>&ledger_id=<?php echo $row['ledger_id']; ?>&dev_id=<?php echo $row['dev_id']; ?>">Add Payment</a>
                        
                        <?php } else { ?>
                          
                          <a href="user_profile_bill.php?ledger_id=<?php echo $row['ledger_id']; ?>" class="dropdown-item">Bill</a>

                        <?php } ?>
                        
                        <a class="dropdown-item" href="user_profile_ledger_delete.php?user_id=<?php echo $row['user_id']; ?>&ledger_id=<?php echo $row['ledger_id']; ?>" onclick="return confirm('Do you want to delete this entry?');">Delete Entry
                        </a>

                    </div>
                  </div>
                </td>

              </tr>
            </tbody>
            <?php
              endforeach;
              mysqli_free_result($res);
            }
          ?>
        </table>
      </div>
    </div>
  </div>

  </div>
</div>

<?php require_once 'includes/footer.php'; ?>