<?php
	require_once 'Database.php';

	class Report extends Database
	{		
		protected static $table = "sales";
		
		public function sales_report() {
			$query = "
				SELECT created_on, SUM(total_sales) AS amount_total, SUM(amount_paid) AS amount_paid, SUM(amount_change) AS amount_change, SUM(amount_discount) AS amount_discount 
				FROM ".static::$table." 
				GROUP BY CAST(created_on AS DATE)
			";
			return parent::select($query);
		}
	}
?>