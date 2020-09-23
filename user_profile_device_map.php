<?php

  require_once 'user_profile_base.php';
  $result = $user->user_device_map();

?>

	<div class="col-md-3">
    <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Mapped Device:</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <form method="POST">
                  <table class="table table-sm text-nowrap">

                  <?php

                    $result = $user->user_profile_device_fetch($_GET['user_id']);
                    $row = mysqli_fetch_assoc($result);
                    foreach ($result as $key => $row) :
                  ?>
                    <tbody>
                      <tr>
                        <td><?php echo $row['device_mso'].' - '.$row['device_no']; ?></td>
                        <td><a href="#" class="btn btn-danger btn-xs"><i class="fas fa-minus-circle"></i></a></td>
                      </tr>
                    </tbody>
                  
                  <?php
                    endforeach;
                  ?>
                </table>
                  <div class="form-group col-md">
                      <input type="text" name="device_no" id="myInput" placeholder="Enter Device ID" class="form-control" required> 
                  </div>

                  <div class="form-group col-md">
                    <input type="hidden" name="user_id" value="<?php echo $_GET['user_id']; ?>">
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                  </div>
              </form>
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