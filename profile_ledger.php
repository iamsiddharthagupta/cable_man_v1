<?php
  require_once 'profile_casing.php';
  $user_id = $_GET['user_id'];
?>

		<div class="col-md-9">
    	<div class="card-body table-responsive p-0" style="height: 490px;">
        <table class="table table-hover text-center table-bordered table-sm table-head-fixed">
                  <thead>
                    <tr>
                      <th>Device</th>
                      <th>Duration</th>
                      <th>Due Amount</th>
                      <th>Amount</th>
                      <th>Balance</th>
                      <th>Status</th>
                      <th>Payment</th>
                      <th>Action</th>
                    </tr>
                </thead>

        <?php
        
          $query = "
                SELECT * FROM cbl_user_dev

                RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
                LEFT JOIN cbl_ledger ON cbl_ledger.dev_id = cbl_user_dev.dev_id
                LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id

                WHERE cbl_ledger.user_id = '$user_id'
                ORDER BY renew_date DESC
                ";
          $result = mysqli_query($conn,$query);

          if (mysqli_num_rows($result) < 1){
            echo "<tr><td colspan='8'>Not Yet Active.</td><tr>";
          } else {
            
            foreach ($result as $key => $data) :

                $urlMulti = "user_id={$user_id}&ledger_id={$data['ledger_id']}";
            
            ?>

            <tbody>
              <tr>
                
                <td><?php echo $data['device_no']; ?></td>

                <td>
                  <strong><?php echo date('jS M',strtotime($data['renew_date'])); ?> - <?php echo date('jS M',strtotime($data['expiry_date'])); ?> (<?php echo $data['renew_term']; ?>)</strong>
                </td>

                <td><?php echo $data['due_amount']; ?></td>

                <td><?php echo $data['pay_amount']; ?></td>
                
                <td><?php echo $data['pay_balance']; ?></td>
                
                <td><?php echo $data['status']; ?></td>
                
                <td>
                  <?php if($data['pay_date'] == NULL){ ?>
                    <div class="text-danger">Unpaid</div>
                  <?php } else { ?>
                    <div><?php echo date('j F y',strtotime($data['pay_date'])); ?></div>
                  <?php } ?>
                </td>
                
                <td>
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <?php if($data['status'] == 'Renewed'){ ?>
                          <a class="dropdown-item" href="profile_payment.php?<?= $urlMulti; ?>">Add Payment</a>
                        <?php } else { ?>
                          <form method="POST" action="receipt.php">
                            <input type="hidden" name="ledger_id" value="<?php echo $data['ledger_id']; ?>">
                            <input type="submit" name="generate_pdf" class="dropdown-item" value="Reciept">
                          </form>
                        <?php } ?>
                    </div>
                  </div>
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

</section>

<?php require_once 'common/footer.php'; ?>