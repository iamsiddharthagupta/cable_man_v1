<?php

  session_start();

  if(isset($_SESSION['user_level'])){
      $curr_user = ucwords($_SESSION['curr_user']);
      if($_SESSION['user_level'] != 1){
          header('Location: agent_panel.php');
      }
  } else {
    header('Location: index.php');
  }

  require_once 'connection.php';
  require_once 'organ.php';

  $user_id = $_GET['user_id'];

  $query = "
            SELECT
            cbl_user.user_id AS user_id,
            cbl_user.first_name AS first_name,
            cbl_user.last_name AS last_name,
            cbl_user.phone_no AS phone_no,
            cbl_user.address AS address,
            cbl_user.area AS area,
            cbl_user.doi AS doi,
            cbl_dev_stock.device_no AS device_no,
            cbl_dev_stock.device_mso AS device_mso,
            cbl_dev_stock.device_type AS device_type,
            cbl_dev_stock.package AS package

            FROM cbl_user_dev

            RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
            LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id

            WHERE cbl_user.user_id = '$user_id'";

  
  $result = mysqli_query($conn,$query);
  $data = mysqli_fetch_assoc($result);
  $dev_count = mysqli_num_rows($result);

?>

<!-- Breadcrumbs Starts -->
  <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h4 class="text-dark">Profile</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
<!-- Breadcrumbs Ends -->

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          
          <div class="col-md-3">
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="common/avatar.png" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo $data['first_name']." ".$data['last_name']; ?></h3>

                <a href="#" class="btn btn-primary btn-block"><b>Install Receipt</b></a>
              </div>

            </div>


            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Basic Details</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>

              <div class="card-body">

                  <span><strong>Phone:</strong> <span class="text-muted"><?php if(empty($data['phone_no'])){echo 'Unavailable';} else { echo $data['phone_no']; } ?></span></span><br>
                  <span><strong>Address:</strong> <span class="text-muted"><?php echo $data['address'].", ".$data['area']; ?></span></span><br>
                  <span><strong>Customer Since:</strong> <span class="text-muted"><?php echo date('jS M y',strtotime($data['doi'])); ?></span></span>

                    <hr>

                  <strong>Device and Package:</strong><br>

                  <?php
                    foreach ($result as $key => $data) {
                        ?>
                            <span>(Rs.<?php echo $data['package']; ?>) <strong><?php echo $data['device_mso']; ?></strong> <?php echo $data['device_no']; ?></span><br>
                        <?php
                    }
                  ?>
              </div>
            </div>
          </div>

          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#renewal" data-toggle="tab">Renewal</a></li>
                  <li class="nav-item"><a class="nav-link" href="#ledger" data-toggle="tab">Ledger</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Update</a></li>
                  <li class="nav-item"><a class="nav-link" href="#device" data-toggle="tab">Device</a></li>
                </ul>
              </div>
              <div class="card-body">

                <div class="tab-content">
<!-- Renewal Panel -->
                  <div class="active tab-pane" id="renewal">
                      
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
                        <a href="#renew<?php echo $data['dev_id']; ?>" data-toggle="modal"><i class="fas fa-sync"></i></a>
                      </td>

                    </tr>
                    <?php require_once 'renewal_modal.php'; ?>
                  </tbody>
                  <?php
                    endforeach;
                  }
                ?>
              </table>
            </div>

                  </div>

<!-- Ledger Panel -->
          <div class="tab-pane" id="ledger">

            <div class="card-body table-responsive p-0" style="height: 490px;">
              <table class="table table-hover text-center table-bordered table-sm table-head-fixed">
                        <thead>
                          <tr>
                            <th>Device</th>
                            <th>Duration</th>
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
                  echo "<tr><td colspan='7'>Not Yet Active!</td><tr>";
                } else {
                  
                  foreach ($result as $key => $data) : ?>

                  <tbody>
                    <tr>
                      
                      <td><?php echo $data['device_no']; ?></td>

                      <td>
                        <strong><?php echo date('jS M',strtotime($data['renew_date'])); ?> - <?php echo date('jS M',strtotime($data['expiry_date'])); ?></strong>
                      </td>

                      <td><?php echo $data['pay_amount']; ?></td>

                      <td><?php if($data['pay_amount'] < $data['package']){ ?>
                          <div class="text-danger"><strong><?php echo $data['pay_amount'] - $data['package']; ?></strong></div>
                        <?php } elseif($data['pay_amount'] > $data['package']) { ?>
                          <div class="text-success"><strong><?php echo $data['pay_amount'] - $data['package']; ?></strong></div>
                        <?php } else { ?>
                          <div><?php echo 'Clear'; ?></div>
                        <?php } ?>
                      </td>
                      
                      <td><?php echo $data['status']; ?></td>
                      
                      <td>
                        <?php if($data['pay_date'] == NULL){ ?>
                          <div class="text-danger">Unpaid</div>
                        <?php } else { ?>
                          <div><?php echo date('j F y',strtotime($data['pay_date'])); ?></div>
                        <?php } ?>
                      </td>
                      
                      <td>
                        <?php if($data['status'] == 'Renewed'){ ?>
                          <button onclick="window.location.href='payment_form.php?ledger_id=<?php echo $data['ledger_id']; ?>'" class="btn btn-sm btn-danger">Pay <?php echo $data['package']; ?></button>
                        <?php } else { ?>
                          <form method="POST" action="receipt.php">
                            <input type="hidden" name="ledger_id" value="<?php echo $data['ledger_id']; ?>">
                            <input type="submit" name="generate_pdf" class="btn btn-success btn-sm" value="Reciept">
                          </form>
                        <?php } ?>
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
<!-- Update Panel -->
                    <div class="tab-pane" id="settings">
                      <form class="form-horizontal" method="POST" action="<?php echo htmlspecialchars('update_process.php'); ?>" autocomplete="off">
                      <div class="row">
                        <div class="col-sm">
                          <label>First Name: *</label>
                            <input type="text" class="form-control" name="first_name" value="<?php echo $data['first_name']; ?>" placeholder="First Name">
                        </div>
                        <div class="col-sm">
                          <label>Last Name:</label>
                            <input type="text" class="form-control" name="last_name" value="<?php echo $data['last_name'];?>" placeholder="Last Name">
                        </div>
                      </div>

                        <div class="row">
                            <div class="col-sm">
                              <label>Contact Number:</label>
                                <input type="text" id="contactInput" class="form-control" name="phone_no" value="<?php echo $data['phone_no'];?>" placeholder="Contact Number">
                            </div>

                            <div class="col-sm">
                              <label>Area: *</label>
                                <select name="area" class="form-control">
                                  <option value="" disabled>Select Area</option>
                                  
                                  <option value="Humayunpur" <?php if($data["area"]=='Humayunpur'){ echo "selected"; } ?>>Humayunpur</option>
                                  
                                  <option value="Arjun Nagar" <?php if($data["area"]=='Arjun Nagar'){ echo "selected"; } ?>>Arjun Nagar</option>
                                  
                                  <option value="Krishna Nagar" <?php if($data["area"]=='Krishna Nagar'){ echo "selected"; } ?>>Krishna Nagar</option>
                                  
                                  <option value="B-4" <?php if($data["area"]=='B-4'){ echo "selected"; } ?>>B-4</option>
                                  
                                  <option value="Other" <?php if($data["area"]=='Other'){ echo "selected"; }?>>Other</option>
                                </select>
                          </div>
                        </div>

                        <div class="row mb-2">
                          <div class="col-sm">
                              <label>Address</label>
                                <textarea class="form-control" name="address" placeholder="Complete Address with House Number and Floor"><?php echo $data['address'];?></textarea>
                            </div>
                          </div>

                      <input type="hidden" name="user_id" value="<?php echo $data['user_id']; ?>">
                      <button type="submit" name="submit" class="btn btn-outline-success">Update</button>
                    </form>
                  </div>


<!-- Device Panel -->
    <div class="tab-pane" id="device">

    <div class="row">
      <div class="col-md">
          <div class="card">
            <div class="card-header">Map/Edit Device:</div>
              <ul class="list-group list-group-flush">
                <?php

                  $query = "SELECT * FROM cbl_user_dev
                            RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
                            LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id
                            WHERE cbl_user_dev.user_id = '$user_id'";

                  $result = mysqli_query($conn,$query);
                  
                  $data = mysqli_fetch_assoc($result);

                  foreach ($result as $key => $data) :
                    ?>
                        <li class="list-group-item">
                          <span>
                            <form method="POST" action="release_device.php">
                              <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                              <input type="hidden" name="assign_id" value="<?php echo $data['assign_id']; ?>">
                              <button type="submit" name="submit" onclick="return confirm('Do you want to release this user?');" class="btn btn-danger btn-xs">x</button>
                            </form> <?php echo $data['device_mso']; ?> - <strong><?php echo $data['device_no']; ?></strong></span>
                        </li>
                    <?php
                  endforeach;
                ?>
                    <form method="POST" action="<?php echo htmlspecialchars('map_device_process.php') ?>">
                <li class="list-group-item">
                  <input type="text" name="device_no" id="myInput" placeholder="Enter Device ID" class="form-control" required>
                </li>
                <li class="list-group-item">
                  <textarea name="reason" class="form-control" placeholder="Reason"></textarea>
                </li>
                <li class="list-group-item">
                    <div class="col-sm-2">
                      <input type="hidden" name="prev_dev_no" value="<?php echo $data['device_no']; ?>">
                      <input type="hidden" name="prev_dev_mso" value="<?php echo $data['device_mso']; ?>">
                      <input type="hidden" name="prev_dev_type" value="<?php echo $data['device_type']; ?>">
                      <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                      <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </li>
                </ul>
              </div>
          </div>
          </form>

      <div class="col-md">
        <div class="card-body table-responsive p-0" style="height: 490px;">
          <table class="table table-hover text-center table-bordered table-sm table-head-fixed">
            <thead class="thead-light">
              <tr>
                <th>SN</th>
                <th>Dev #</th>
                <th>MSO</th>
                <th>Package</th>
                <th>Assignee</th>
                <th>Action</th>
              </tr>
          </thead>

          <?php

            $query = "
                      SELECT
                      cbl_dev_stock.dev_id AS dev_id,
                      cbl_dev_stock.device_no AS device_no,
                      cbl_dev_stock.device_mso AS device_mso,
                      cbl_dev_stock.device_type AS device_type,
                      cbl_dev_stock.package AS package,
                      cbl_user.user_id AS user_id,
                      cbl_user.first_name AS first_name,
                      cbl_user.last_name AS last_name,
                      cbl_user_dev.assign_id AS assign_id

                      FROM cbl_user_dev
                      LEFT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
                      RIGHT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id
                      ORDER BY cbl_user.user_id ASC";
            $result = mysqli_query($conn,$query);

            if (mysqli_num_rows($result) < 1){
              echo "<tr><td colspan='6'>Not Yet Active!</td><tr>";
            } else {
              $i = 0;
              foreach ($result as $key => $data) : $i++; ?>
                
          <tbody id="myTable">
            <tr>

              <td><?php echo $i; ?></td>

              <td><?php echo $data['device_no']; ?></td>
              
              <td><?php echo $data['device_mso'];?> [<?php echo $data['device_type']; ?>]</td>
              
              <td><?php echo $data['package']; ?></td>
              
              <td><a href="user_profile.php?user_id=<?php echo $data['user_id']; ?>"><?php echo $data['first_name']." ".$data['last_name']; ?></a></td>
              
              <td>

                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                      <form method="POST" action="edit_device.php">
                        <input type="hidden" name="dev_id" value="<?php echo $data['dev_id']; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <button type="submit" name="submit" class="dropdown-item">Edit</button>
                      </form>
                    <?php if(empty($data['user_id'])){ ?>
                    <?php } else { ?>
                        <form method="POST" action="release_device.php">
                          <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                          <input type="hidden" name="assign_id" value="<?php echo $data['assign_id']; ?>">
                          <button type="submit" name="submit" onclick="return confirm('Do you want to release this user?');" class="dropdown-item">Release</button>
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
      </div>
    </div>
  </div>
</div>
</div>
</section>

<?php require_once 'common/footer.php'; ?>