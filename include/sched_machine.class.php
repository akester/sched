<?php
class sched_machine extends sched_main {
	private $machine;
	
	function __construct($machine) {
		$this->machine = $machine;
		parent::__construct();
	}
	
	function __autoload($class_name) {
		include $class_name . '.class.php';
	}
	
	function getJobs() {
		$result = $this->db->query('SELECT * FROM `sched_jobs` WHERE `machine` 
				= \''.$this->machine.'\' AND `hoursToGo` > 0 ORDER BY `pos` ASC');
		$out = array();
		$complete = time();
		while ($job = $result->fetch_assoc()){
			$complete += $job['hoursToGo'] * 3600;
			$out[$job['jobId']] = $job;
			
			if ($complete > strtotime($job['due']))
				$out[$job['jobId']]['status'] = 'warn';
			else
				$out[$job['jobId']]['status'] = 'ok';
			
			$out[$job['jobId']]['complete'] = date('Y-m-d', $complete);
		}
		return $out;
	}
	
	function getLastJobPos() {
		$result = $this->db->query('SELECT * FROM `sched_jobs` WHERE `machine`
				= \''.$this->machine.'\' AND `hoursToGo` > 0 ORDER BY `pos` DESC');
		$job = $result->fetch_assoc();
		return $job['pos'];
	}

	function getJobById($jobid){
		$result = $this->db->query('SELECT * FROM `sched_jobs` WHERE `jobId` =
			\''.$jobId.'\'');
		$job = $result->fetch_assoc();
		return $job;
	}
}
?>
