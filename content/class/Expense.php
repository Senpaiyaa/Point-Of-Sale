<?php
	require_once 'Database.php';
	class Expense extends Database
	{
		public function generate_expense_report($from, $to) {
			$query="SELECT stocks.product_id AS product_id, quantity_expired AS qty_exp, expensed_amount AS exp_amt, comment AS exp_cmnt, date AS exp_date FROM expenses INNER JOIN stocks ON expenses.product_id = stocks.stock_id WHERE expenses.date BETWEEN '$from' AND '$to' ORDER BY expenses.date DESC";
			return parent::select($query);
		}
	}
?>