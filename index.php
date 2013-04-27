<?php 
	#require 'include/php-digest-mysql.class.php';
	#$auth = new phpAuthMySQL();
	#$auth->auth(true);
	
	require 'include/sched/sched_sched.class.php';
	$ms = new sched_sched();
?>
<html>
	<head>
		<title>Machine Scheduling</title>
		<link rel="stylesheet" type="text/css" href="css/main.css" />
	</head>
	<body>
		<?php $ms->generateBody($_GET);?>
	</body>
</html>