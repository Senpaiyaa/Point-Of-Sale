<?php
	require_once 'Database.php';

	class Manufacturer extends Database {

		protected static $table = "manufacturer";

		public function get_all_manufacturer() {
			$query = "
				SELECT *
				FROM ".static::$table."
				WHERE is_deleted = FALSE
			";
			return parent::select($query);
		}

		public function add_manufacturer($manufacturer) {
			$query = "INSERT INTO ".static::$table." (`manufacturer_name`) VALUES ('$manufacturer')";
			return parent::query($query);
		}

		public function update_manufacturer($manufacturer_id, $manufacturer_name) {
			$query = "UPDATE ".static::$table." SET `manufacturer_name`='$manufacturer_name' WHERE manufacturer_id = '$manufacturer_id'";
			return parent::query($query);
		}

		public function get_manufacturer($manufacturer_id) {
			$query = "SELECT * FROM ".static::$table." WHERE manufacturer_id = '$manufacturer_id'";
			$result = parent::select($query);
			if (count($result)===0) {
				return NULL;
			}
			return $result[0]; 
			// return parent::select($query);
		}

		public function remove_manufacturer($manufacturer_id) {
			$query = "UPDATE ".static::$table." SET `is_deleted` = TRUE WHERE manufacturer_id = '$manufacturer_id'";
			return parent::query($query);
		}
	}
?>