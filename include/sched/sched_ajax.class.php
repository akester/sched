<?php
	require 'sched_machine.class.php';
	require 'sched_class.class.php';
	require 'sched_mysql.class.php';
	
	class sched_ajax {
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
		
		public function runAjax($get, $post) {
			if (!array_key_exists('p', $get))
				$page = '';
			else
				$page = $get['p'];
			
			switch($page) {

				case 'newJobExec':
					$this->dbObj->connect();
					$jobId = $post['jobId'];
					$machine = $post['machine'];
					$totalHours = $post['hours'];
					$hoursToGo = $post['hoursToGo'];
					$partNo = $post['partNo'];
					$material = $post['material'];
					$qtyRemain = $post['qtyRemain'];
					$due = $post['due'];
						
					$result = $this->dbObj->query("SELECT pos FROM sched_jobs
							WHERE `machine`	= '$machine' ORDER BY `pos` DESC");
					$row = $result->fetch_assoc();
					$pos = $row['pos'] + 1;
										
					$query = "INSERT INTO `sched_jobs` VALUES('$jobId', '$machine',
					'0', $totalHours, '$partNo', '$material', $qtyRemain, '$due',
					$pos, $hoursToGo)";
					$this->dbObj->query($query);
					echo 'Job added sucsessfully';
					break;
					
				case 'moveJobExec':
					$this->dbObj->connect();
					$jobId = $post['jobId'];
					$target = $post['target'];
					$machine = $post['machine'];
					
					$jobs = $this->dbObj->query('SELECT * FROM `sched_jobs`
							 WHERE `machine` = \''.$machine.'\' ORDER BY `pos` ASC');
					$reached = false;
					$targetPos = -1;
					while ($j = $jobs->fetch_assoc()) {
						if ($j['jobId'] == $target) {
							/* We've reached the job we want to move ahead of */
							$targetPos = $j['pos'];
							$reached = true;
						}
						if ($target == 'end') {
							$targetPos = $j['pos'] + 1;
						}
						if ($reached == true) {
							$this->dbObj->query('UPDATE`sched_jobs` SET `pos` =
									'.($j['pos'] + 1).' WHERE `jobId` = \''.$j['jobId'].'\'');
						}
					}
					if ($targetPos >= 0)
						$this->dbObj->query('UPDATE`sched_jobs` SET `pos` =
										'.$targetPos.' WHERE `jobId` = \''.$jobId.'\'');
					
					echo 'Job move OK.';
					break;
					
					case 'editJobExec':
						$this->dbObj->connect();
						$jobId = $post['jobId'];
						$machine = $post['machine'];
						$totalHours = $post['hours'];
						$hoursToGo = $post['hoursToGo'];
						$partNo = $post['partNo'];
						$material = $post['material'];
						$qtyRemain = $post['qtyRemain'];
						$due = $post['due'];
					
						$query = "UPDATE `sched_jobs` SET machine = '$machine',
						hours = $totalHours, partNo = '$partNo', material = '$material'
						, qtyRemain = $qtyRemain, due = '$due', hoursToGo = $hoursToGo WHERE `jobId` = '$jobId'";
						$this->dbObj->query($query);
						echo 'Job eidted sucsessfully';
						break;
					
				default:
					http_response_code(400);
					die('Invalid.');
			}
		}
	}
?>