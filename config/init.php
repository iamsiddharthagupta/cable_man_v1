<?php

	require_once 'config.php';
	require_once 'connection.php';
	require_once 'organ.php';
	require_once 'create.php';
	require_once 'read.php';
	require_once 'update.php';
	require_once 'delete.php';
	require_once 'security.php';

    require_once 'init.php';
    $security = new Security();
    $organ = new Organ();
    $create = new Create();
    $read = new Read();
    $update = new Update();
    $delete = new Delete();

?>