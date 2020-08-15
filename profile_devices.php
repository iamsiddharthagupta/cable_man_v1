<?php
	
	require_once 'profile_casing.php';
	$user_id = $_GET['user_id'];
?>

		<div class="col-md-9">
          	<div class="container-fluid">

          		<div class="card-body table-responsive p-0" style="height: 490px;">
                    <table class="table table-hover text-center table-bordered table-sm table-head-fixed">
                        <thead>
                          <tr>
                            <th>Device</th>
                            <th>MSO</th>
                            <th>Duration</th>
                            <th>Renew</th>
                          </tr>
                      </thead>

              <?php
              
                $query = "SELECT

                          cbl_dev_stock.dev_id AS dev_id,
                          cbl_dev_stock.device_no AS device_no,
                          cbl_dev_stock.device_mso AS device_mso,
                          cbl_dev_stock.device_type AS device_type,
                          MAX(cbl_ledger.renew_date) AS renew_date,
                          MAX(cbl_ledger.expiry_date) AS expiry_date

                          FROM cbl_user_dev

                          RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
                          LEFT JOIN cbl_ledger ON cbl_ledger.dev_id = cbl_user_dev.dev_id
                          LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id

                          WHERE cbl_user_dev.user_id = '$user_id'
                          GROUP BY cbl_dev_stock.dev_id";
                $result = mysqli_query($conn,$query);

                if (mysqli_num_rows($result) < 1){
                  echo "<tr><td colspan='4'>No Device Assigned!</td><tr>";
                } else {

                  foreach ($result as $key => $data) : ?>

                  <tbody>
                    <tr>
                      
                      <td><?php echo $data['device_no']; ?></td>
                      
                      <td><?php echo $data['device_mso']; ?></td>

                      <td>
                        <strong><?php if(empty($data['renew_date'])){ echo 'Activation Pending'; } else {echo date('jS M',strtotime($data['renew_date'])).' - '. date('jS M',strtotime($data['expiry_date']));} ?></strong>
                      </td>

                      <td>
	                        <form method="POST" action="profile_renewal.php">
								<input type="hidden" name="dev_id" value="<?php echo $data['dev_id']; ?>">
								<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
								<input type="submit" class="btn btn-outline-success btn-xs" value="Renew">
							</form>
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

</section>

<?php require_once 'common/footer.php'; ?>