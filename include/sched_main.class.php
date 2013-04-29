<?php
	require 'sched_mysql.class.php';
	class sched_main {
		protected $db;
		
		function __construct(){
			$this->db = new sched_mysql();
			$this->db->connect();
		}
		
		function __autoload($class_name) {
			include $class_name . '.class.php';
		}
				
		public function getMachines(){
			$result = $this->db->query('SELECT `name` FROM `sched_machines` WHERE 1
					ORDER BY `group` ASC, `name` ASC');
			$out = array();
			while($machine = $result->fetch_assoc()){
				$out[] = $machine['name'];
			}
			return $out;
		}
		
		protected function validate($val, $type) {
			switch ($type) {
				case 'integer':
					if (!is_int($val)) {
						header('HTTP/1.0 400 Bad Request');
						die($val . 'is not a valid integer');
					}
					break;
					
				case 'string':
					if (!is_string($val)) {
						header('HTTP/1.0 400 Bad Request');
						die($val . ' is not a valid string');
					}
					break;
				
				default:
					header('HTTP/1.0 400 Bad Request');
					die('Not a valid type.');
			}
			return $this->db->sanitize($val);
		}
		
	}
?>