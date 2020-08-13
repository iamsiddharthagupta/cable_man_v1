<?php
// Session starts here. It can be used in any page.
	session_start();
	if(isset($_SESSION['curr_user'])){
	$curr_user = ucwords($_SESSION['curr_user']);
	} else {
	header('location:index.php');
	}
	include '../common/cable_organ.php';
	include '../common/connection.php';

?>

<div class="container-fluid p-2">

	<div class="row justify-content-center">
		<div class="col-sm-6">
			<input id="myInput" class="form-control border-success text-center mb-2" placeholder="Unpaid List, Search...">
		</div>
	</div>

<div class="row">
	<div class="col-sm">
		<div class="table-responsive">
			<table class="table table-hover text-center table-bordered table-sm">
			    <thead class="thead-light">
			      <tr>
			      	<th>Pay</th>
			      	<th>Device</th>
			      	<th>Due Month</th>
			        <th>Name</th>
			        <th>Mobile No</th>
			        <th>Address</th>
			        <th>Area</th>
			        <th>Invoice #</th>
			        <th>Pay Date</th>
			      </tr>
				</thead>

		<?php
				
				$current_month = date('F');
				$query = "
							SELECT * FROM cbl_user_dev

			                RIGHT JOIN cbl_user ON cbl_user.user_id = cbl_user_dev.user_id
			                LEFT JOIN cbl_ledger ON cbl_ledger.dev_id = cbl_user_dev.dev_id
			                LEFT JOIN cbl_dev_stock ON cbl_dev_stock.dev_id = cbl_user_dev.dev_id

			                WHERE cbl_ledger.status = 'Paid'
			                GROUP BY cbl_ledger.dev_id
			                ORDER BY cbl_ledger.renew_month DESC
						";

	$result = mysqli_query($conn,$query);

	if (mysqli_num_rows($result) < 1){
		echo "<tr><td colspan='13'>No user yet.</td><tr>";
	} else {
		
		foreach ($result as $key => $data) : ?>

		<tbody id="myTable">
			<tr>

				<td>
					<form method="POST" action="test.php">
						<input type="hidden" name="ledger_id" value="<?php echo $data['ledger_id']; ?>">
						<input type="submit" class="btn btn-success btn-sm" value="Reciept">
					</form>
				</td>

				<td><?php echo $data['device_no']; ?></td>
				
				<td><strong><?php echo $data['renew_month'];?></strong></td>

				<td><strong><?php echo $data['first_name']." ".$data['last_name'];?></strong></td>

				<td><?php echo $data['phone_no'];?></td>

				<td><?php echo $data['address'];?></td>

				<td><?php echo $data['area'];?></td>

				<td><?php echo $data['invoice_no']; ?></td>
				
				<td><?php echo $data['pay_date']; ?></td>

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
<?php
	include '../common/footer.php';
?>