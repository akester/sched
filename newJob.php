<?php 
	require 'include/php-digest-mysql.class.php';
	require 'include/sched_main.class.php';
	$auth = new phpAuthMySQL();
	$auth->auth(true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Machine Scheduling | New Job</title>
		<link rel="stylesheet" type="text/css" href="css/main.css" />
		<script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
		<link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.10.2.custom.css" />
		<script src="js/jquery-ui-1.10.2.custom.min.js" type="text/javascript"></script>
		<script src="js/sched_jobFormSubmit.js" type="text/javascript"></script>
		<script src="js/sched_jobFormValidation.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(function(){
				$( "#date" ).datepicker({ dateFormat: "yy-mm-dd" });
			});
		</script>
	</head>
	<body>
	<p>
		<a href="index.php?s=1">Today</a> | <a href="index.php?s=7">This Week</a> | 
		<a href="index.php?s=30">This Month</a> | 
		<a href="newJob.php">Create a new job</a>
	</p>
	<form action="#" method="post" name="jobForm" id="jobForm"
				onsubmit="return sched_jobFormSubmit();">
		<table>
				<tr>
					<td>Job ID:</td>
					<td><input type="text" name="jobId" /></td>
				</tr>
				<tr>
					<td>Machine:</td>
					<td><select name="machine">
						<?php 
							$sched = new sched_main();
							foreach ($sched->getMachines() as $m) {
								echo '<option name='.$m.'>'.$m.'</option>';
							}
						?>
						</select></td>
				</tr>
				<tr>
					<td>Total Hours:</td>
					<td><input type="text" name="hours" /></td>
				</tr>
				<tr>
					<td>Hours Remain:</td>
					<td><input type="text" name="hoursToGo" /></td>
				</tr>
				<tr>
					<td>Part Number:</td>
					<td><input type="text" name="partNo"></td>
				</tr>
				<tr>
					<td>Material:</td>
					<td><input type="text" name="material" /></td>
				</tr>
				<tr>
					<td>Qty Remain:</td>
					<td><input type="text" name="qtyRemain" /></td>
				</tr>
				<tr>
					<td>Due Date:</td>
					<td><input id="date" type="text" name="due" /></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" value="Submit Job" /></td>
				</tr>
			</table>
		</form>
	</body>
</html>