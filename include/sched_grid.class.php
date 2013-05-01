<?php
class sched_grid extends sched_main {
	private $scaleSecs;
	
	function __construct(){
		
		parent::__construct();
	}
	
	function __autoload($class_name) {
		include $class_name . '.class.php';
	}
		
	function calculateGrid($scale = 0) {
		if ($scale == 0) {
			$scale = 1;
		}
		
		$this->scaleSecs = $scale * ( 3600 * 24 );
		
		$out = array();
		foreach ($this->getMachines() as $machine) {
			$out[$machine] = $this->calculateMachine($machine);
		}
		return $out;
	}
	
	function calculateMachine($machine = null) {
		if ($machine == null)
			throw new BadFunctionCallException('E: No Machine name passed');
		$m = new sched_machine($machine);
		
		$time = time();
		$totalTime = $this->scaleSecs;
		$previousCompletion = $time;
		$totalPct = 0;
		$out = array();
		foreach ($m->getJobs() as $job) {
			/* Calculate percent to draw box */
			$pct = round((($job['hoursToGo'] * 3600) / $totalTime) * 100);
			if ($pct > 100)
				$pct = 100;
			
			/* Calcuate the job status */
			$complete = $previousCompletion + ($job['hoursToGo'] * 3600);
			$previousCompletion = $complete;
			
			if ($complete > strtotime($job['due']))
				$status = 'warn';
			else
				$status = 'ok';
			
			if ($pct + $totalPct > 95)
				$pct = 90 - $totalPct;
			
			if ($totalPct < 95) {
				$out[$job['jobId']]['pct'] = $pct;
				$out[$job['jobId']]['status'] = $status;
			$totalPct += $pct;
			}
		}
		return $out;
	}
	
	function calculateJobPct($job) {
		$pct = round((($job['hoursToGo'] * 3600) / $this->scaleSecs) * 100);
		if ($pct > 100)
			$pct = 100;
		return $pct;
	}
}
?>