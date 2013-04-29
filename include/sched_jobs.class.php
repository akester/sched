<?php
class sched_jobs extends sched_main {
	function __construct() {
		parent::__construct();
	}
	
	function __autoload($class_name) {
		include $class_name . '.class.php';
	}
}

?>