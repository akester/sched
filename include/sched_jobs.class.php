<?php
class sched_jobs extends sched_main {
	function __construct() {
		parent::__construct();
	}
	
	function __autoload($class_name) {
		include $class_name . '.class.php';
	}
	
	function createJob($jobId, $machine, $class, $hours, $partNo, $material,
			$qtyRemain, $due, $hoursToGo){
		$this->validate($jobId, 'string');
		$this->validate($machine, 'string');
		$this->validate($class, 'string');
		$this->validate(intval($hours), 'integer');
		$this->validate($partNo, 'string');
		$this->validate($material, 'string');
		$this->validate(intval($qtyRemain), 'integer');
		$this->validate($due, 'string');
		$this->validate(intval($hoursToGo), 'integer');
		
		$mObj = new sched_machine($machine);
		$pos = $mObj->getLastJobPos() + 1;
		
		$this->db->query("INSERT INTO `sched_jobs` VALUES ('$jobId', '$machine',
				'$class', $hours, '$partNo', '$material', $qtyRemain, '$due',
				$pos, $hoursToGo)");
		
		return 'Job added sucessfully';
	}
	
	function editJob($jobId, $machine, $class, $hours, $partNo, $material,
			$qtyRemain, $due, $hoursToGo){
		$this->validate($jobId, 'string');
		$this->validate($machine, 'string');
		$this->validate($class, 'string');
		$this->validate(intval($hours), 'integer');
		$this->validate($partNo, 'string');
		$this->validate($material, 'string');
		$this->validate(intval($qtyRemain), 'integer');
		$this->validate($due, 'string');
		$this->validate(intval($hoursToGo), 'integer');
		
		$result = $this->db->query('SELECT `machine` FROM `sched_jobs`
				WHERE `jobId` = \''.$jobId.'\'');
		$row = $result->fetch_assoc();
		$oldMachine = $row['machine'];
		if ($machine != $oldMachine) {
			$mObj = new sched_machine($machine);
			$pos = $mObj->getLastJobPos() + 1;
			$this->db->query("UPDATE `sched_jobs` SET `machine` = '$machine', 
					`class` = '$class', `hours` = $hours, `partNo` = '$partNo',
					`material` = '$material', `qtyRemain` = $qtyRemain,
					`due` = '$due', `hoursToGo` = $hoursToGo, `pos` = $pos
					WHERE `jobId` = '$jobId'");
		} else {
			$this->db->query("UPDATE `sched_jobs` SET `machine` = '$machine',
					`class` = '$class', `hours` = $hours, `partNo` = '$partNo',
					`material` = '$material', `qtyRemain` = $qtyRemain,
					`due` = '$due', `hoursToGo` = $hoursToGo
					WHERE `jobId` = '$jobId'");
		}
		
		return $machine;
	}
}

?>