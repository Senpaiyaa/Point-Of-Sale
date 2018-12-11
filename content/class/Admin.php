<?php
	require_once 'Database.php';

	class Admin extends Database {

		protected static $table = "admin";
		
		public function find_admin($username, $password) {
			$query = "SELECT * FROM ".static::$table." WHERE username = '$username' AND password = '$password' LIMIT 1";
			return parent::select($query);
		}

		public function get_admin() {
			$query = "SELECT * FROM ".static::$table. " WHERE admin_id <> 1 ORDER BY admin_id ASC";
			return parent::select($query);			
		}

		public function count_admin() {
			$query = "SELECT COUNT(*) AS admin_count FROM `admin`";
			return parent::select($query);
		}

		public function create_activity($user_type, $activity) {
			date_default_timezone_set("Asia/Kuala_Lumpur");
			$date_logged = date('Y-m-d H:i:s');
			$query = "INSERT INTO `user_logs`(`user_type`, `user_activity`, `date_logged`) VALUES ('$user_type', '$activity', '$date_logged')";
			return parent::query($query);
		}

		public function get_logs() {
			$query = "SELECT * FROM `user_logs`";
			return parent::select($query);
		}
	}
?>