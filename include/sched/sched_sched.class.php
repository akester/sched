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
		
		public function generateBody($get) {
			if (!array_key_exists('p', $get))
				$page = 'index';
			else
				$page = $get['p'];
			
			/* Set the scale for everything */
			$time = time();
			if (!array_key_exists('s', $get))
				$scale = $time + (60 * 60 * 24);
			else
				$scale = $get['s'];
			
			/* This switch handles all of the different pages */
			switch($page) {
				/* The home page */
				case 'index':
					echo <<<EOT
					<h1>Machine Schedule</h1>
					<table border=1>
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
			}
		}
	}
?>