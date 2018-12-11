<?php
	require_once 'Database.php';

	class Supplier extends Database
	{
		protected static $table = "supplier";

		public function get_all_supplier() {
			$query = "
				SELECT *
				FROM ".static::$table." 
				WHERE is_deleted = FALSE
				ORDER BY supplier_id DESC
			";
			return parent::select($query);
		}

		public function add_supplier($supplier, $fname, $lname, $email, $phone_number, $address, $city, $zip, $country) {
			$query = "
				INSERT INTO ".static::$table." (`supplier_name`, `first_name`, `last_name`, `email`, `phone_number`, `address`, `city`, `zip`, `country`) VALUES ('$supplier', '$fname', '$lname', '$email', '$phone_number', '$address', '$city', '$zip', '$country')
			";
			return parent::query($query);
		}

		public function option_supplier() {
			$query = "
				SELECT *
				FROM ".static::$table;
			return parent::select($query);
		}

		public function count_supplier() {
			$query = "SELECT COUNT(*) AS Total FROM ".static::$table;
			return parent::select($query);			
		}

		public function get_supplier($supplier_id) {
			$query = "
				SELECT *
				FROM ".static::$table." 
				WHERE supplier_id = '$supplier_id'
			";
			$result = parent::select($query);
			if (count($result)===0) {
				return null;
			}
			return $result[0];
			// return parent::select($query)[0];
		}

		public function remove_supplier($supplier_id) {
			$query = "UPDATE ".static::$table." SET `is_deleted` = TRUE WHERE supplier_id = '$supplier_id'";
			return parent::query($query);
		}
	}
?>