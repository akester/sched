<?php
	require 'include/php-digest-mysql.class.php';
	$auth = new phpAuthMySQL();
	$auth->auth(true);

	require 'include/sched/sched_ajax.class.php';
	$ajax = new sched_ajax();
	
	$ajax->runAjax($_GET, $_POST);
?>