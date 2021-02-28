<?php

	require_once 'config.php';
	require_once 'connection.php';
	require_once 'organ.php';
	require_once 'create.php';
	require_once 'delete.php';
	require_once 'security.php';

    $security = new Security();
    $organ = new Organ();
    $create = new Create();
    $delete = new Delete();

?>