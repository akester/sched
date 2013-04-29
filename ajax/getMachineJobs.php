<?php
	require '../include/php-digest-mysql.class.php';
	$auth = new phpAuthMySQL();
	$auth->auth(true);
	
	function __autoload($class_name) {
		require '../include/'. $class_name . '.class.php';
	}
	$m = new sched_machine($_GET['m']);
	echo json_encode($m->getJobs());
?>