<?php

  require_once 'user_profile_base.php';
  $result = $user->user_device_map();

?>

	<div class="col-md-3">
	    <div class="container-fluid">
	      	<div class="card">
	      		<div class="card-header">Mapped Device:</div>
	              <ul class="list-group list-group-flush">
                  <form method="POST">
                    <?php
                      
                      $result = $user->user_profile_device_fetch($_GET['user_id']);

                      $row = mysqli_fetch_assoc($result);

                      foreach ($result as $key => $row) : ?>
                        
                        <li class="list-group-item">
                          <span><?php echo $row['device_mso']; ?> - <strong><?php echo $row['device_no']; ?></strong></span>
                        </li>
                    <?php
                      endforeach;
                    ?>
	                <li class="list-group-item">
	                  <input type="text" name="device_no" id="myInput" placeholder="Enter Device ID" class="form-control" required>
	                </li>
	                <li class="list-group-item">
	                  <textarea name="reason" class="form-control" placeholder="Reason"></textarea>
	                </li>
	                <li class="list-group-item">
	                    <div class="col-sm-2">
	                      <input type="hidden" name="user_id" value="<?php echo $_GET['user_id']; ?>">
	                      <button type="submit" name="submit" class="btn btn-primary">Submit</button>
	                    </div>
	                  </li>
                    </form>
	                </ul>
            </div>
		    </div>
	</div>
	<div class="col-md-6">
		        <div class="card-body table-responsive p-0" style="height: 490px;">
          <table class="table table-hover text-center table-bordered table-sm table-head-fixed">
            <thead class="thead-light">
              <tr>
                <th>Dev ID</th>
                <th>MSO</th>
                <th>Package</th>
                <th>Assignee</th>
              </tr>
          </thead>

          <?php

            $result = $user->user_profile_device_list_fetch();

            if (mysqli_num_rows($result) < 1){

              echo "<tr><td colspan='4'>Not Yet Active!</td><tr>";

            } else {

              foreach ($result as $key => $row) : ?>
                
          <tbody id="myTable">
            <tr>
              <td><?php echo $row['device_no']; ?></td>
              
              <td><?php echo $row['device_mso'];?> [<?php echo $row['device_type']; ?>]</td>
              
              <td><?php echo $row['package']; ?></td>
              
              <td><?php echo $row['first_name']." ".$row['last_name']; ?></td>

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