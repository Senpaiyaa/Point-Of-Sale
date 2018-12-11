<?php
	require_once 'Database.php';

	class Category extends Database {

		protected static $table = "category";

		public function get_all_category() {
			$query = "SELECT * FROM ".static::$table." WHERE is_deleted = FALSE";
			return parent::select($query);
		}

		public function add_category($category) {
			$query = "INSERT INTO ".static::$table. " (`category_name`) VALUES ('$category')";
			return parent::query($query);
		}

		public function update_category($category_id, $category_name) {
			$query = "UPDATE ".static::$table. " SET `category_name`='$category_name' WHERE category_id = '$category_id'";
			return parent::query($query);
		}

		public function remove_category($category_id) {
			$query = "UPDATE ".static::$table." SET `is_deleted` = TRUE WHERE category_id = '$category_id'";
			return parent::query($query);
		}

		public function get_category($category_id) {
			$query = "SELECT * FROM ".static::$table. " AS category WHERE category_id = '$category_id'";
			$result = parent::select($query);
			if(count($result)===0){
				return NULL;
			}
			return $result[0];
		}
	}
?>