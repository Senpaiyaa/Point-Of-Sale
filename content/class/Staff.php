<?php
	require_once 'Database.php';

	class Staff extends Database {

		protected static $table = "staff";

		public function find_staff($username, $password) {
			$query = "
				SELECT * 
				FROM  ".static::$table." 
				WHERE username = '$username'
				AND password = '$password'
				AND is_deleted = FALSE
				LIMIT 1
			";
			return parent::select($query);
		}

		public function get_staff($staff_id) {
			$query = "SELECT * FROM ".static::$table." WHERE staff_id = {$staff_id}";
			return parent::select($query)[0];
		}

		public function count_deactivated_accounts() {
			$query = "SELECT COUNT(*) AS Deactivated_Accounts FROM `staff` WHERE is_deleted = TRUE";
			return parent::select($query);
		}

		public function count_staff() {
			$query = "SELECT COUNT(*) AS staff_count FROM `staff` WHERE staff_id <> 1 AND is_deleted = FALSE";
		return parent::select($query);
		}

		public function get_staff_full_name($staff_id) {
			$query = "SELECT CONCAT(fname, ' ', lname) AS full_name FROM ".static::$table." WHERE staff_id = {$staff_id}";
			return parent::select($query)[0];
		}

		public function create_activity($user_type, $activity) {
			date_default_timezone_set("Asia/Kuala_Lumpur");
			$date_logged = date('Y-m-d H:i:s');
			$query = "INSERT INTO `user_logs`(`user_type`, `user_activity`, `date_logged`) VALUES ('$user_type', '$activity', '$date_logged')";
			return parent::query($query);
		}
	}
?>