<?php
	
	ob_start();
	require_once 'includes/header.php';

	$result = $user->user_profile_ledger_delete($_GET['ledger_id'],$_GET['user_id']);