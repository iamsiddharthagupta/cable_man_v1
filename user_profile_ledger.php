<?php require_once 'user_profile_base.php'; ?>

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

          $result = $user->user_profile_ledger_fetch($_GET['user_id']);

          if (mysqli_num_rows($result) < 1){
            echo "<tr><td colspan='8'>Not Yet Active.</td><tr>";
          } else {
            
            foreach ($result as $key => $row) : ?>

            <tbody>
              <tr>
                
                <td><?php echo $row['device_no']; ?></td>

                <td>
                  <strong><?php echo date('jS M',strtotime($row['renew_date'])); ?> - <?php echo date('jS M',strtotime($row['expiry_date'])); ?> (<?php echo $row['renew_term']; ?>)</strong>
                </td>

                <td><?php echo $row['due_amount']; ?></td>

                <td><?php echo $row['pay_amount']; ?></td>
                
                <td><?php echo $row['pay_balance']; ?></td>
                
                <td><?php echo $row['ledger_status']; ?></td>
                
                <td>
                  <?php if($row['pay_date'] == NULL){ ?>
                    <div class="text-danger">Unpaid</div>
                  <?php } else { ?>
                    <div><?php echo date('j F y',strtotime($row['pay_date'])); ?></div>
                  <?php } ?>
                </td>
                
                <td>
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-dark btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <?php if($row['ledger_status'] == 'Renewed'){ ?>
                          <a class="dropdown-item" href="user_profile_payment.php?user_id=<?php echo $row['user_id']; ?>&ledger_id=<?php echo $row['ledger_id']; ?>&dev_id=<?php echo $row['dev_id']; ?>">Add Payment</a>
                        <?php } else { ?>
                          <form method="POST" action="receipt.php">
                            <input type="hidden" name="ledger_id" value="<?php echo $row['ledger_id']; ?>">
                            <input type="submit" name="generate_pdf" class="dropdown-item" value="Reciept">
                          </form>
                        <?php } ?>
                        <a class="dropdown-item" href="profile_ledger_delete.php?user_id=<?php echo $row['user_id']; ?>&ledger_id=<?php echo $row['ledger_id']; ?>&dev_id=<?php echo $row['dev_id']; ?>" onclick="return confirm('Do you want to release this user?');">Delete Entry</a>
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
</div>

<?php require_once 'assets/footer.php'; ?>