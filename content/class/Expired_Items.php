<?php
	require_once 'Database.php';

	class Expired_Items extends Database
	{
		protected static $table = "stocks";

		public function get_expired_items() {
			$query = "
				SELECT *
				FROM ".static::$table."
				WHERE product_expiration <= NOW() AND product_expiration != 0000-00-00 AND `is_deleted` = FALSE
				GROUP BY product_id
			";
			return parent::select($query);
		}

		public function count_all_expired() {
			$query = "
				SELECT COUNT(*) AS expired 
				FROM ".static::$table."
				WHERE product_expiration <= NOW() AND product_expiration != 0000-00-00 AND `is_deleted` = FALSE";
			return parent::select($query)[0];
		}

		public function get_expired_items_within_month($month = 1) {
			$query = "
				SELECT *
				FROM ".static::$table."
				WHERE (`product_expiration` BETWEEN NOW() AND NOW() + INTERVAL $month MONTH) AND product_expiration != 0000-00-00
				GROUP BY product_id
			";
			return parent::select($query);
		}

	}
?>