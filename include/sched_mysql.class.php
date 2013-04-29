<?php
	class sched_mysql {
		private $dbhost = '';
		private $dbname = '';
		private $dbuser = '';
		private $dbpass = '';
		
		function __construct() {
			#FIXME
			$cfg = parse_ini_file('/home/andrew/Projects/wescon-sched/cfg/sched_mysql.ini');
			$this->dbhost = $cfg['dbhost'];
			$this->dbname = $cfg['dbname'];
			$this->dbuser = $cfg['dbuser'];
			$this->dbpass = $cfg['dbpass'];
		}

		public function connect() {
			/* Create the connection to the database */
			$this->db = @new mysqli($this->dbhost, $this->dbuser, $this->dbpass,
					$this->dbname);
			if ($this->db->connect_errno)
				throw new Exception("Error: Could not connect to auth database!!
						MySQL returned: " . $this->authdb->connect_error);
		}
		
		public function query($query) {
			$result = $this->db->query($query);
			if ($this->db->errno) {
				header('HTTP/1.0 500 Internal Server Error');
				die($this->db->error);
			}
			return $result;
		}
		
		public function sanitize($val) {
			return $this->db->real_escape_string($val);
		}
	}
?>