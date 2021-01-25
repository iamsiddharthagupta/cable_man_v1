<?php

  ob_start();
  session_start();

    (!isset($_SESSION['logged_staff'])) ? header('Location: index.php') : $curr_user = ucwords($_SESSION['logged_staff']);
  
	$page = 'list_customer.php';
	
	require_once 'includes/top-nav.php';
	require_once 'includes/side-nav.php';

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
		        <th>Address</th>
		        <th>Phone</th>
		        <th>Box</th>
		        <th>Rate</th>
		        <th>Install Date</th>
		      </tr>
			</thead>

			<?php

				$result = $read->fetch_list_customer();

				if($result->num_rows < 1) {
					
					echo "<tr><td colspan='10'>No user yet! Start feeding them from <a href='user_profile_add.php'>here</a></td><tr>";
				
				} else {

					foreach ($result as $key => $row) :
			?>

			<tbody id="myTable">
				<tr>

					<td>
						<div class="btn-group" role="group">
	    					<button type="button" class="btn btn-dark btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	      						Action
	    					</button>
		    				<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
		    					<?php if(empty($row['dev_id'])){ ?>
		    						<a class="dropdown-item" href="profile_device_map.php?cust_id=<?php echo $row['cust_id']; ?>">Assign Device</a>
		    					<?php } elseif(!empty($row['dev_id'])){ ?>
		    						<a class="dropdown-item" href="user_profile_select_device.php?cust_id=<?php echo $row['cust_id']; ?>">Start</a>
		    					<?php } ?>
		    					<a class="dropdown-item" href="user_profile_ledger.php?cust_id=<?php echo $row['cust_id']; ?>">Ledger Book</a>
								<a class="dropdown-item" href="user_profile_update.php?cust_id=<?php echo $row['cust_id']; ?>">Update Profile</a>
								<a class="dropdown-item" href="user_profile_device_map.php?cust_id=<?php echo $row['cust_id']; ?>">Map/Edit Device</a>
						    </div>
				  		</div>
					</td>

					<td><a href="profile_ledger.php?cust_id=<?php echo htmlentities($row['cust_id']); ?>"><?php echo $row['first_name']." ".$row['last_name'];?></a></td>

					<td><?php echo $row['address'];?>, <strong><?php echo $row['area_name'] ?></strong></td>

					<td><?php echo $row['phone_no'];?></td>

					<td>2</td>
					
					<td>500</td>

					<td><?php echo date('jS M y',strtotime($row['install_date'])); ?></td>
				</tr>
			</tbody>
		<?php
				endforeach;
				$result->free_result();
			}
		?>
		</table>
	</div>
</div>

<?php require_once 'includes/footer.php'; ?>