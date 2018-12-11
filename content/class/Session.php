<?php
	class Session {
		public function __construct() {
			session_start();
			$this->start_session();
		}

		public function __destruct(){}

		public function start_session(){							
			if(!isset($_SESSION["pos_login"])){
				$_SESSION["pos_login"] = false;
				$_SESSION["pos_user"] = null;
				$_SESSION["pos_admin"] = false;
				$_SESSION["pos_staff"] = false;
			}
			else {
				if(!$_SESSION["pos_login"]){	
					$_SESSION["pos_user"] = null;
					$_SESSION["pos_admin"] = false;
					$_SESSION["pos_staff"] = false;
				}
			}
		}

		public function remove_session(){
			$_SESSION["pos_login"] = false;
		    $_SESSION["pos_user"] = null;
			$_SESSION["pos_admin"] = false;
			$_SESSION["pos_staff"] = false;
		}
	}
?>