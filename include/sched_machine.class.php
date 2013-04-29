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
		while ($job = $result->fetch_assoc()){
			$out[] = $job;
		}
		return $out;
	}
}
?>