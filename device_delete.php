<?php
	
	ob_start();

	require_once 'organ.php';

	$result = $user->device_delete($_GET['dev_id'],$_GET['user_id']);