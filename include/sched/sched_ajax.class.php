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
					
				default:
					http_response_code(400);
					die('Invalid.');
			}
		}
	}
?>