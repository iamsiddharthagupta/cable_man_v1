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
			SELECT * FROM cbl_user_dev

  			RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
  			LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id
  			WHERE cbl_user.user_id = '$user_id'
  			";
  	$result = mysqli_query($conn,$query);
  	$data = mysqli_fetch_assoc($result);
?>

<div class="container-fluid p-3">
	<div class="row">
			<div class="col-sm-4 mb-2">
				<form method="POST" action="<?php echo htmlspecialchars('map_device_process.php') ?>">
					<div class="card">
						<div class="card-header">Map/Edit Device:</div>
						  <ul class="list-group list-group-flush">
						    <li class="list-group-item"><span class="mr-2">Name:</span>
						    	<strong><a href="user_profile.php?user_id=<?php echo $data['user_id']; ?>"><?php echo $data['first_name']." ".$data['last_name']; ?></a></strong>
						    </li>
						    <li class="list-group-item"><span class="mr-2">Area:</span>
						    	<strong><?php echo $data['area']; ?></strong>
						    </li>

						    <?php
						    	$result = mysqli_query($conn,"
						    			
										    			SELECT * FROM cbl_user_dev
											    		RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
											    		LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id
											    		WHERE cbl_user_dev.user_id = '$user_id'

						    							");
						    	
						    	$data = mysqli_fetch_assoc($result);

						    	foreach ($result as $key => $data) {
						    		echo "	<li class='list-group-item'>
						    					<span>$data[device_mso]</span> - <strong><span>$data[device_no]</span></strong>
						    				</li>";

						    	}
						    ?>

						    <li class="list-group-item">
						    	<input type="text" name="device_no" id="myInput" placeholder="Enter Device ID" class="form-control" required>
						    </li>
						    <li class="list-group-item">
						    	<textarea name="reason" class="form-control" placeholder="Reason"></textarea>
						    </li>
						    <li class="list-group-item">
						    	<div class="row">
						    		<div class="col-sm-2 mr-1 mb-1">
						    			<input type="hidden" name="prev_dev_no" value="<?php echo $data['device_no']; ?>">
								    	<input type="hidden" name="prev_dev_mso" value="<?php echo $data['device_mso']; ?>">
								    	<input type="hidden" name="prev_dev_type" value="<?php echo $data['device_type']; ?>">
								    	<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
								    	<button type="submit" name="submit" class="btn btn-primary">Submit</button>
								    	</form>
						    		</div>
						    		<div class="col-sm-2">
						    			<a href="#addDevice" data-toggle="modal" class="btn btn-primary">Add</a>
						    			<?php include 'add_device_modal.php'; ?>
						    		</div>
						    	</div>
						    </li>
						  </ul>
					</div>
			</div>

			<div class="col-sm-8 mb-2">

				<div class="table-responsive">
				<table class="table table-hover text-center table-bordered table-sm">
				    <thead class="thead-light">
				      <tr>
				      	<th>Device ID</th>
				      	<th>Device MSO</th>
				      	<th>Device Type</th>
				      	<th>Package</th>
				      	<th>Assignee</th>
				      	<th>Action</th>
				      </tr>
					</thead>

					<?php

						$query = "	SELECT

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
									ORDER BY cbl_user.user_id ASC
									";
						$result = mysqli_query($conn,$query);

						if (mysqli_num_rows($result) < 1){
							echo "<tr><td colspan='6'>Not Yet Active!</td><tr>";
						} else {
							
							foreach ($result as $key => $data) : ?>
								
					<tbody id="myTable">
						<tr>
							<td><?php echo $data['device_no']; ?></td>
							
							<td><?php echo $data['device_mso'] ?></td>
							
							<td><?php echo $data['device_type'] ?></td>
							
							<td><?php echo $data['package'] ?></td>
							
							<td><a href="map_device.php?user_id=<?php echo $data['user_id']; ?>"><?php echo $data['first_name']." ".$data['last_name']; ?></a></td>
							
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

<?php require_once 'common/footer.php'; ?>