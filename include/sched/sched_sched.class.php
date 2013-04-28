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
						echo '<a href="?p=machine&m='.$m.'">'.$m.'</a>';
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
				case 'machine':
					$m = $get['m'];
					$mObj = new sched_machine($m);
					$jobs = $mObj->getJobs();
					echo '<h1>'.$m.'</h1>';
					echo <<<EOT
					<table>
						<tr><th>Pos</th><th>Job No</th><th>Part No.</th>
						<th>Hours Remain</th><th>Qty Remain</th>
						<th>Material</th><th>Due</th><th>Est. Complete</th>
						<th>Move</th><th>Edit</th></tr>
EOT;
					$realPos = 0;
					$lastFinish = time();
					foreach ($jobs as $j) {
						$realPos += 1;
						$finish = $lastFinish + ($j['hoursToGo'] * 3600);
						$lastFinish = $finish;
						
						if ($finish > strtotime($j['due']))
							$status = 'warn';
						else
							$status = 'ok';
						
						echo '<tr class="jobRow '.$status.'">';
						echo '<td>'.$realPos.'</td>';
						echo '<td>'.$j['jobId'].'</td>';
						echo '<td>'.$j['partNo'].'</td>';
						echo '<td>'.$j['hoursToGo'].'</td>';
						echo '<td>'.$j['qtyRemain'].'</td>';
						echo '<td>'.$j['material'].'</td>';
						echo '<td>'.$j['due'].'</td>';
						echo '<td>'.date('m/d/Y H:00', $finish).'</td>';
						echo '<td><a href="?p=move&m='.$m.'&j='.$j['jobId'].'">Move</a></td>';
						echo '<td><a href="?p=edit&m='.$m.'&j='.$j['jobId'].'">Edit</a></td>';
						echo '</tr>';
					}
					break;
					
				case 'move':
					$m = $get['m'];
					$mObj = new sched_machine($m);
					$jobs = $mObj->getJobs();
					echo '<h1>'.$m.'</h1>';
					echo <<<EOT
					<script src="js/sched/sched_moveJob.js" type="text/javascript"></script>
					<table>
						<tr><th>Pos</th><th>Job No</th><th>Part No.</th>
						<th>Hours Remain</th><th>Qty Remain</th>
						<th>Material</th><th>Due</th><th>Est. Complete</th>
						<th>Move</th></tr>
EOT;
					$realPos = 0;
					$lastFinish = time();
					foreach ($jobs as $j) {
						if ($j['jobId'] == $get['j'])
							echo '<tr style="background-color: #DDDDDD;">';
						else
							echo '<tr>';
						$realPos += 1;
						$finish = $lastFinish + ($j['hoursToGo'] * 3600);
						$lastFinish = $finish;
					
						echo '<td>'.$realPos.'</td>';
						echo '<td>'.$j['jobId'].'</td>';
						echo '<td>'.$j['partNo'].'</td>';
						echo '<td>'.$j['hoursToGo'].'</td>';
						echo '<td>'.$j['qtyRemain'].'</td>';
						echo '<td>'.$j['material'].'</td>';
						echo '<td>'.$j['due'].'</td>';
						echo '<td>'.date('m/d/Y H:00', $finish).'</td>';
						echo '<td><a onclick="return sched_moveJob(\''
								.$j['jobId'].'\', \''.$get['j'].'\', \''.$j['machine']
								.'\')" href="?p=move&j='.$j['jobId'].'">
								Move Ahead</a></td>';
						echo '</tr>';
					}
					echo '<tr><td></td><td></td><td></td><td></td><td></td><td></td>
							<td></td><td></td>';
					echo '<td><a onclick="return sched_moveJob(\''
							.'end\', \''.$get['j'].'\', \''.$m
							.'\')" href="?p=move&j='.$j['jobId'].'">
								Move to End</a></td>';
					break;
					
				case 'edit':
					$this->dbObj->connect();
					$result = $this->dbObj->query('SELECT * FROM `sched_jobs` WHERE `jobId`
							= \''.$get['j'].'\'');
					$job = $result->fetch_assoc();
					
					echo '
					<script src="js/sched/sched_jobEditSubmit.js" type="text/javascript"></script>
					<script src="js/sched/sched_jobFormValidation.js" type="text/javascript"></script>
					<form action="?p=newJobExec" method="post" name="jobForm" id="jobForm"
							onsubmit="return sched_jobEditSubmit();">
					<table>
						<tr><td>Job ID:</td><td>
							<input type="text" name="jobId" value="'.$job['jobId'].'" readonly="readonly"/></td></tr>
						<tr><td>Machine:</td><td><select name="machine">';
					foreach ($this->getMachines() as $m) {
						if ($m == $job['machine'])
							echo '<option name="'.$m.'" selected="selected">'.$m.'</option>';
						else
							echo '<option name="'.$m.'">'.$m.'</option>';
					}
					echo '
						</select></td></tr>
						<tr><td>Total Hours:</td>
						<td><input type="text" name="hours" value="'.$job['hours'].'"/></td></tr>
						<tr><td>Hours Remain:</td>
						<td><input type="text" name="hoursToGo" value="'.$job['hoursToGo'].'"/></td></tr>
						<tr><td>Part Number:</td>
						<td><input type="text" name="partNo" value="'.$job['partNo'].'"/></td></tr>
						<tr><td>Material:</td>
						<td><input type="text" name="material" value="'.$job['material'].'"/></td></tr>
						<tr><td>Qty Remain:</td>
						<td><input type="text" name="qtyRemain" value="'.$job['qtyRemain'].'"/></td></tr>
						<tr><td>Due Date:</td>
						<td><input id="date" type="text" name="due" value="'.$job['due'].'"/></td></tr>
						<tr><td></td><td><input type="submit" value="Submit Job" /></td></tr>';
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