<?php 
	require 'include/php-digest-mysql.class.php';
	require 'include/sched_main.class.php';
	require 'include/sched_machine.class.php';
	$auth = new phpAuthMySQL();
	$auth->auth(true);

	$m = new sched_machine();
	$job = $m->getJobById($_GET['j']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Machine Scheduling | Edit Job</title>
		<link rel="stylesheet" type="text/css" href="css/main.css" />
		<script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
		<link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.10.2.custom.css" />
		<script src="js/jquery-ui-1.10.2.custom.min.js" type="text/javascript"></script>
		<script src="js/sched_jobEditFormSubmit.js" type="text/javascript"></script>
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
	<h1>Edit Job</h1>
	<form action="#" method="post" id="jobForm"
				onsubmit="return sched_jobEditFormSubmit();">
		<table>
				<tr>
					<td>Job ID:</td>
					<td><input type="text" name="jobId" readonly="readonly"
							value="<?php echo $job['jobId'];?>"/></td>
				</tr>
				<tr>
					<td>Machine:</td>
					<td><select name="machine">
						<?php 
							$sched = new sched_main();
							foreach ($sched->getMachines() as $m) {
								if ($m == $job['machine'])
									echo '<option selected="selected">'.$m.'</option>';
								else
									echo '<option>'.$m.'</option>';
							}
						?>
						</select></td>
				</tr>
				<tr>
					<td>Total Hours:</td>
					<td><input type="text" name="hours" 
						value="<?php echo $job['hours'];?>"/></td>
				</tr>
				<tr>
					<td>Hours Remain:</td>
					<td><input type="text" name="hoursToGo" 
						value="<?php echo $job['hoursToGo'];?>"/></td>
				</tr>
				<tr>
					<td>Part Number:</td>
					<td><input type="text" name="partNo"
						value="<?php echo $job['partNo'];?>"/></td>
				</tr>
				<tr>
					<td>Material:</td>
					<td><input type="text" name="material" 
						value="<?php echo $job['material'];?>"/></td>
				</tr>
				<tr>
					<td>Qty Remain:</td>
					<td><input type="text" name="qtyRemain" 
						value="<?php echo $job['qtyRemain'];?>"/></td>
				</tr>
				<tr>
					<td>Due Date:</td>
					<td><input id="date" type="text" name="due" 
						value="<?php echo $job['due'];?>"/></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" value="Submit Job" /></td>
				</tr>
			</table>
		</form>
	</body>
</html>

