<?php
	
	ob_start();
	
	require_once 'organ.php';

	$user = new User();
	$result = $user->device_delete($_GET['dev_id']);