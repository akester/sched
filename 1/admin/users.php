<?php
	require '/home/andrew/Projects/wescon-sched/include/sched/sched_admin.class.php';
	$admin = new sched_admin();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Machine Scheduling - Users</title>
		<link rel="stylesheet" type="text/css" href="../css/main.css" />
		<script src="../js/jquery-1.9.1.min.js" type="text/javascript"></script>
		<link rel="stylesheet" href="../css/ui-lightness/jquery-ui-1.10.2.custom.css" />
		<script src="../js/jquery-ui-1.10.2.custom.min.js" type="text/javascript"></script>
		<script src="../js/sched/sched_editUser.js" type="text/javascript"></script>
	</head>
	<body>
	<h1>Edit Users</h1>
	<table>
	<?php 
		$users = $admin->getUsers();
		foreach ($users as $u){
			echo '<tr>'.PHP_EOL;
			echo '	<td>'.$u.'</td>'.PHP_EOL;
			echo '	<td><a href="#" onclick="return sched_editUser(\''.$u.'\')">Edit</a></td>'.PHP_EOL;
			echo '</tr>'.PHP_EOL;
			
		}
	?>
	</table>
	</body>
</html>
