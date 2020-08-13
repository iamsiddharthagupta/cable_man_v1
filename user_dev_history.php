<div class="table-responsive">
	<table class="table table-hover text-center table-bordered table-sm">
				    <thead class="thead-dark">
				      <tr>
				      	<th>Previous Device</th>
				      	<th>Changed Device</th>
				      	<th>Date of Changing</th>
				      </tr>
					</thead>

	<?php
		$query = "	SELECT * FROM cbl_user

					RIGHT JOIN cbl_dev_history ON cbl_dev_history.user_id = cbl_user.user_id
					WHERE cbl_dev_history.user_id = '$user_id'
					LIMIT 10
					";
		$result = mysqli_query($conn,$query);

		if (mysqli_num_rows($result) < 1){
			echo "<tr><td colspan='8'>No Device History Yet!</td><tr>";
		} else {
			while ($data = mysqli_fetch_assoc($result)) {
	?>
			<tbody>
				<tr>
					<td><strong><span><?php echo $data['prev_dev_no']; ?></span></strong> <span><?php echo $data['prev_dev_mso']; ?></span></td>
					<td><strong><span><?php echo $data['new_dev_no']; ?></span></strong> <span><?php echo $data['new_dev_mso']; ?></span></td>
					<td><span><?php echo date('jS M y',strtotime($data['timestamp'])); ?></span></td>
				</tr>
			</tbody>
			<?php
				}
			}
		?>
	</table>
</div>