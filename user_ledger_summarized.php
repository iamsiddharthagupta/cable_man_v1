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

	$user_id = $_GET['user_id'];

	$result = mysqli_query($conn,"SELECT * FROM cbl_user WHERE user_id = '$user_id'");
	$data = mysqli_fetch_assoc($result);
?>

<div class="container-fluid p-4">
	<h5><strong><?php echo $data['first_name']." ".$data['last_name']; ?></strong></h5>
		<h6>Phone No: <strong><?php echo $data['phone_no']; ?></strong></h6>
		<h6>Address: <strong><?php echo $data['address']; ?></strong></h6>
		<h6><strong><?php echo $data['area']; ?></strong></h6>
	<?php
		include 'user_ledger.php';
	?>

</div>


<?php
	include '../common/footer.php';
?>