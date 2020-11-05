<?php

  session_start();

  $curr_user = $_SESSION['curr_user'];
  $user_level = $_SESSION['user_level'];

  $page = 'user_list_scheme.php';
  require_once 'includes/top-nav.php';
  require_once 'includes/side-nav.php';

  $result = $security->session($curr_user, $user_level);

?>

<div class="container-fluid p-2">

  <div class="form-row justify-content-center">
    <div class="form-group col-md-6">
      <input id="myInput" class="form-control text-center" placeholder="Quick Search">
    </div>
  </div>

  <div class="card-body table-responsive p-0" style="height: 600px;">
    <table class="table table-hover text-center table-bordered table-sm table-head-fixed text-nowrap">
          <thead class="thead-light">
            <tr>
              <th>Action</th>
              <th>Name</th>
              <th>Device</th>
              <th>Period</th>
              <th>Phone</th>
              <th>Address</th>
              <th>Rate</th>
              <th>Duration</th>
              <th>Payment</th>
            </tr>
        </thead>

<?php
  
  $result = $user->user_list_scheme();

  if (mysqli_num_rows($result) < 1) {
    
    echo "<tr><td colspan='8'>No user yet.</td><tr>";
  
  } else {

    foreach ($result as $key => $row) : ?>

    <tbody id="myTable">
      <tr>

        <td>
          <div class="btn-group" role="group">
              <button type="button" class="btn btn-dark btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
              </button>
              <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <a class="dropdown-item" href="user_profile_extend.php?user_id=<?php echo $row['user_id']; ?>&dev_id=<?php echo $row['dev_id']; ?>">Extend</a>
                <a class="dropdown-item" href="user_profile_ledger.php?user_id=<?php echo $row['user_id']; ?>">Ledger Book</a>
                <a class="dropdown-item" href="user_profile_update.php?user_id=<?php echo $row['user_id']; ?>">Update Profile</a>
              </div>
            </div>
        </td>

        <td>
          <strong>
              <?php echo $row['first_name']." ".$row['last_name'];?> <span class="text-warning"><?php echo $row['ledger_status']; ?></span>
          </strong>
        </td>

        <td><strong><?php echo $row['device_mso']; ?></strong> - <span><?php echo $row['device_no']; ?></span></td>

        <td>
          <strong><?php echo date('j M y',strtotime($row['renew_date'])); ?><span> - </span><?php echo date('j M y',strtotime($row['expiry_date'])); ?>
          </strong>
        </td>

        <td><?php echo $row['phone_no'];?></td>

        <td><?php echo $row['address'];?>, <strong><?php echo $row['area'];?></strong></td>

        <td><span>Rs.</span><?php echo $row['package'];?></td>

        <td><strong><?php echo $row['renew_term']; ?></strong></td>
        
        <td><span>Rs.</span><?php echo $row['pay_amount'];?></td>

      </tr>
    </tbody>
    <?php
      endforeach;
      mysqli_free_result($result);
    }
  ?>
    </table>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>