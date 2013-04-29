<?php
	class sched_main {
		protected $db;
		
		function __construct(){
			$this->db = new sched_mysql();
			$this->db->connect();
		}
		
		function __autoload($class_name) {
			include $class_name . '.class.php';
		}
				
		protected function getMachines(){
			$result = $this->db->query('SELECT `name` FROM `sched_machines` WHERE 1
					ORDER BY `group` ASC, `name` ASC');
			$out = array();
			while($machine = $result->fetch_assoc()){
				$out[] = $machine['name'];
			}
			return $out;
		}
		
	}
?>