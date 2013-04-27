<?php
	class sched_mysql {
		private $dbhost = 'localhost';
		private $dbname = 'sched';
		private $dbuser = 'sched';
		private $dbpass = 'password';
		
		public function connect() {
			/* Create the connection to the database */
			$this->db = @new mysqli($this->dbhost, $this->dbuser, $this->dbpass,
					$this->dbname);
			if ($this->db->connect_errno)
				throw new Exception("Error: Could not connect to auth database!!
						MySQL returned: " . $this->authdb->connect_error);
		}
		
		public function query($query) {
			return $this->db->query($query);
		}
	}
?>