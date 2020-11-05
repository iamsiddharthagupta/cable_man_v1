<?php
	
	ob_start();

	require_once 'includes/header.php';

	$result = $device->device_delete($_GET['dev_id'],$_GET['user_id']);