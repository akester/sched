<?php 
	require '../include/php-digest-mysql.class.php';
	$auth = new phpAuthMySQL();
	$auth->auth(true);

	function __autoload($class_name) {
		require '../include/'. $class_name . '.class.php';
	}

	$job = new sched_jobs();
	echo $job->moveJob($_POST['j'], $_POST['t'], $_POST['m']);
?>