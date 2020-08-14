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


<?php require_once 'common/footer.php'; ?>