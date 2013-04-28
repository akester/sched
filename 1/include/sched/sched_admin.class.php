<?php
	require 'sched_sched.class.php';
	class sched_admin extends sched_sched {
		function __construct(){
			parent::__construct();
		}
		
		public function validateAdmin() {
			
		}
		
		public function getUsers() {
			$this->dbObj->connect();
			$result = $this->dbObj->query('SELECT `username` FROM `auth_users` WHERE 1');
			$out = array();
			while ($user = $result->fetch_assoc()) {
				$out[] = $user['username'];
			}
			return $out;
			
		}
	}
?>