<?php
	require_once 'Database.php';

	class Employee extends Database
	{
		protected static $table = "staff";

		public function get_all_employee() {
			$query = "SELECT * FROM ".static::$table. " WHERE is_deleted = FALSE";
			return parent::select($query);
		}	

		public function add_staff($username, $password, $fname, $lname, $email, $phone_number, $address, $city, $province, $zip) {
			$query = "INSERT INTO ".static::$table. " (`username`, `password`, `fname`, `lname`, `email`, `phone_number`, `address`, `city`, `province`, `zip`) VALUES ('$username', '$password', '$fname', '$lname', '$email', '$phone_number', '$address', '$city', '$province', '$zip')";
			return parent::query($query);
		}

		public function update_staff($staff_id, $username, $password, $fname, $lname, $email, $phone_number, $address, $city, $province, $zip) {
			$query = "UPDATE ".static::$table. " SET `username`='$username',`password`='$password',`fname`='$fname',`lname`='$lname',`email`='$email',`phone_number`='$phone_number',`address`='$address',`city`='$city',`province`='$province',`zip`='$zip' WHERE staff_id = '$staff_id'";
			return parent::query($query);
		}

		public function get_employee($id) {
			$query = "SELECT * FROM ".static::$table. " WHERE staff_id = '$id'";
			// return parent::select($query);
			$result = parent::select($query);
			if(count($result)===0){
				return NULL;
			}
			return $result[0];

		}

		public function view_employee($staff_id) {
			$query = "SELECT * FROM ".static::$table. " WHERE staff_id = '$staff_id'";
			$result = parent::select($query);
			if(count($result)===0){
				return NULL;
			}
			return $result[0];
			// return parent::select($query)[0];

		}

		public function count_employee() {
			$query = "SELECT COUNT(*) AS Total FROM ".static::$table." WHERE is_deleted = FALSE";
			return parent::select($query);
		}

		public function remove_employee($id) {
			$query = "UPDATE ".static::$table." SET is_deleted = TRUE WHERE staff_id = '$id'";
			return parent::query($query);
		}

		public function get_deactivated_accounts() {
			$query = "SELECT * FROM ".static::$table. " WHERE is_deleted = TRUE";
			return parent::select($query);
		}

		public function reactivate_account($id) {
			$query = "UPDATE ".static::$table." SET is_deleted = FALSE WHERE staff_id = '$id'";
			return parent::query($query);
		}

	}
?>