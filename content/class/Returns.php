<?php
	require_once 'Database.php';

	class Returns extends Database {
		protected static $table = "returned_items";

		public function get_returned_items() {
			$query = "SELECT * FROM ".static::$table;
			return parent::select($query);
		}

		public function generate_return_report($from, $to) {
			$query = "SELECT item_name AS item_name, quantity as quantity, price AS price, status AS status, created_date AS created_date, reason FROM returned_items WHERE created_date BETWEEN '$from' AND '$to'";
			return parent::select($query);
		}
	}
?>