<?php
	
	ob_start();
	require_once 'includes/header.php';

	$result = $device->release_device($_GET['assign_id'],$_GET['user_id']);