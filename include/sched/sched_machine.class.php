<?php
	class sched_machine {
		function __construct($name) {
			$this->name = $name;
			$this->db = new sched_mysql();
			$this->db->connect();
		}
		
		function getJobs() {
			$result = $this->db->query('SELECT * FROM `sched_jobs` WHERE 
					`machine` = \''.$this->name.'\' AND `hoursToGo` > 0 
					ORDER BY `pos` ASC');
			$out = array();
			while ($row = $result->fetch_assoc()) {
				$out[$row['jobId']] = $row;
			}
			return $out;
		}
		
		function drawGrid($scale, $time) {
			$jobs = $this->getJobs();
			$totalTime = $scale - $time;
			$previousCompletion = $time;
			$totalPct = 0;
			foreach ($jobs as &$j) {
				/* Calculate percent to draw box */
				$pct = round((($j['hoursToGo'] * 3600) / $totalTime) * 100);
				if ($pct > 100)
					$pct = 100;
				
				/* Calcuate the job status */
				$complete = $previousCompletion + $j['hoursToGo'] + 3600;
				$previousCompletion = $complete;
				
				if ($complete > strtotime($j['due']))
					$status = 'warn';
				else
					$status = 'ok';
				
				if ($pct + $totalPct > 100)
					$pct = 95 - $totalPct;
				
				if ($totalPct < 95) {
					if ($pct >= 10)	
						echo '<span style="width: '.$pct.'%;" class="jobBox '
								.$status.'">'.$j['jobId'].'</span>';
					else
						echo '<span style="width: '.$pct.'%;" class="jobBox '
								.$status.'"> </span>';
					$totalPct += $pct;
				}
			}
		}
	}
?>