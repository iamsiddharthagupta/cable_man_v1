<?php
	
	ob_start();
	require_once 'organ.php';

	$result = $user->user_profile_ledger_delete($_GET['ledger_id'],$_GET['user_id']);