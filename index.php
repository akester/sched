<?php 
	require 'include/php-digest-mysql.class.php';
	$auth = new phpAuthMySQL();
	$auth->auth(true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Machine Scheduling</title>
		<link rel="stylesheet" type="text/css" href="css/main.css" />
		<script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
		<link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.10.2.custom.css" />
		<script src="js/jquery-ui-1.10.2.custom.min.js" type="text/javascript"></script>
		<script src="js/sched_grid.js" type="text/javascript"></script>
		<script src="js/sched_parseGetData.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				var get = sched_parseGetData();
				if (get['s'] == '' || get['s'] == null) {
					get['s'] = 1;
				}
				sched_grid(get['s']);
			});
		</script>
	</head>
	<body>
	<p>
		<a href="?s=1">Today</a> | <a href="?s=7">This Week</a> | 
		<a href="?s=30">This Month</a> | 
		<a href="newJob.php">Create a new job</a>
	</p>
	<h1>Wescon Plastics - Machine Schedule</h1>
	<table id="gridTable"><tr><td>Loading...</td></tr></table>
	</body>
</html>