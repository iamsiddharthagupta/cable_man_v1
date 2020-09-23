<?php
	
	ob_start();
	require_once 'organ.php';

	$result = $user->release_device($_GET['assign_id'],$_GET['user_id']);