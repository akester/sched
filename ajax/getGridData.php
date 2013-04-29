<?php
	require '../include/php-digest-mysql.class.php';
	$auth = new phpAuthMySQL();
	$auth->auth(true);
	
	function __autoload($class_name) {
		require '../include/'. $class_name . '.class.php';
	}
	$grid = new sched_grid($_GET['s']);
	echo json_encode($grid->calculateGrid($_GET['s']));
?>