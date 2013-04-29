<?php
	require '../include/php-digest-mysql.class.php';
	$auth = new phpAuthMySQL();
	$auth->auth(true);
	
	function __autoload($class_name) {
		require '../include/'. $class_name . '.class.php';
	}
	
	$job = new sched_jobs();
	echo $job->createJob($_POST['jobId'], $_POST['machine'], '', 
			$_POST['hours'], $_POST['partNo'], $_POST['material'], 
			$_POST['qtyRemain'], $_POST['due'], $_POST['hoursToGo']);
?>