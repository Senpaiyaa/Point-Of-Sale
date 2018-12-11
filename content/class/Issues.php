<?php
	require_once 'Database.php';
	class Issues extends Database
	{
		protected static $table = "issues";

		public function generate_issue_report($from, $to) {
			$query = "
				SELECT product_name             AS product, 
				       issues.quantity          AS issue_quantity, 
				       issues.issue_amount      AS issue_amount, 
				       issues.type              AS issue_type, 
				       issues.date              AS issue_date, 
				       Sum(issues.issue_amount) AS final_total 
				FROM   product 
				       INNER JOIN stocks 
				               ON stocks.product_id = product.product_id 
				       INNER JOIN issues 
				               ON issues.product_id = stocks.stock_id 
				WHERE  issues.date BETWEEN '$from' AND '$to' 
				GROUP  BY stocks.product_id 
			";
			return parent::select($query);
		}
	}
?>