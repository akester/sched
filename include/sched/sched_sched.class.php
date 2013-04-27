<?php
	require 'sched_machine.class.php';
	require 'sched_class.class.php';
	require 'sched_mysql.class.php';
	
	class sched_sched {
		function __construct(){
			$this->dbObj = new sched_mysql();
		}
		private function getMachines() {
			$this->dbObj->connect();
			$result = $this->dbObj->query('SELECT * FROM `sched_machines` WHERE 1 ORDER BY `class` ASC');
			if (!$result)
				throw new Exception('Could not load machines');
			$out = array();
			while ($row = $result->fetch_assoc()) {
				#if (!array_key_exists($row['class'], $out))
					#FIXME
					#$out[$row['class']] = array();
				$out[] = $row['name'];
			}
			return $out;
		}
		
		public function generateBody($get, $post) {
			if (!array_key_exists('p', $get))
				$page = 'index';
			else
				$page = $get['p'];
			
			/* Set the scale for everything */
			$time = time();
			if (!array_key_exists('s', $get) || $get['s'] < 1)
				$scale = $time + (60 * 60 * 24 * 7);
			else
				$scale = $time + ($get['s'] * 60 * 60 * 24);
			
			/* This switch handles all of the different pages */
			switch($page) {
				/* The home page */
				case 'index':
					echo <<<EOT
					<h1>Machine Schedule</h1>
					<table>
						<tr class="heading">
							<td class="machineColumn">Machines</td>
							<td class="timeColumn">Time</td>
						</tr>
EOT;
					foreach ($this->getMachines() as $k=>$m) {
						echo '<tr>';
						echo '<td>';
						echo $m;
						echo '</td><td>';
						$mObj = new sched_machine($m);
						$mObj->drawGrid($scale, $time);
						echo '</td>';
						echo '</tr>';
						
					}
					echo '</table>';
					break;
					
				case 'newJob':
					echo <<<EOT
					<script src="js/sched/sched_jobFormSubmit.js" type="text/javascript"></script>
					<script src="js/sched/sched_jobFormValidation.js" type="text/javascript"></script>
					<form action="?p=newJobExec" method="post" name="jobForm" id="jobForm"
							onsubmit="return sched_jobFormSubmit();">
					<table>
						<tr><td>Job ID:</td><td>
							<input type="text" name="jobId" /></td></tr>
						<tr><td>Machine:</td><td><select name="machine">
EOT;
					foreach ($this->getMachines() as $m) {
						echo '<option name='.$m.'>'.$m.'</option>';
					}
					echo <<<EOT
						</select></td></tr>
						<tr><td>Total Hours:</td>
						<td><input type="text" name="hours" /></td></tr>
						<tr><td>Hours Remain:</td>
						<td><input type="text" name="hoursToGo" /></td></tr>
						<tr><td>Part Number:</td>
						<td><input type="text" name="partNo"></td></tr>
						<tr><td>Material:</td>
						<td><input type="text" name="material" /></td></tr>
						<tr><td>Qty Remain:</td>
						<td><input type="text" name="qtyRemain" /></td></tr>
						<tr><td>Due Date:</td>
						<td><input id="date" type="text" name="due" /></td></tr>
						<tr><td></td><td><input type="submit" value="Submit Job" /></td></tr>
						
EOT;
					break;

					
				default:
					echo <<<EOT
					<h1>Not Found</h1>
					<p>The requested page was not found</p>
EOT;
					break;
			}
		}
	}
?>