<?php
	require_once 'Database.php';

	class Sales extends Database
	{
		protected static $table = "sales";

		public function get_sales() {
			$query = "SELECT * FROM ".static::$table;
			return parent::select($query);
		}

		public function count_all_sales() {
			$query = "SELECT COUNT(sales_id) AS 'Total' FROM ".static::$table;
			return parent::select($query);
		}

		// Original sales query

		public function get_total_sales($year, $month){
			$query = "SELECT SUM(`total_sales`) as `total_sales` FROM ".static::$table." WHERE YEAR(`created_on`) = $year AND MONTH(`created_on`) = $month";
			return (double) $this->select_row($query)['total_sales'];
		}

		// public function get_total_sales($start_date, $end_date) {
		// 	$query = "SELECT SUM(`total_sales`) as `total_sales` FROM `sales` WHERE `created_on` BETWEEN '$start_date' AND '$end_date'";
		// 	return (double) parent::select($query);
		// }

		public function generate_report_by_date($from, $to, $staff_id) {
			$query = "
				SELECT
				    sales.sales_id AS sales_id,
				    sales.total_sales AS total_sales,
				    sales.created_date AS created_date
				FROM sales    
				WHERE
					sales.created_date
						BETWEEN '$from' 
							AND '$to'
							AND staff_id = '$staff_id'
			";
			// $query = "";
			return parent::select($query);
		}

		public function generate_summary_employees($from, $to) {
			$query = "
				SELECT
				  CONCAT(staff.fname, ' ', staff.lname) AS staff_name,
				  SUM(total_sales) AS total_sales,
				  sales.created_on AS created_on
				FROM sales
				INNER JOIN staff
				  ON staff.staff_id = sales.staff_id
				WHERE sales.created_date BETWEEN '$from' AND '$to'
				GROUP BY staff.staff_id
				ORDER BY sales.created_on DESC

			";
			return parent::select($query);
		}

		public function total_sales() {
			$query = "SELECT SUM(`total_sales`) as `total_sales` FROM ".static::$table;
			return parent::select($query);
		}

		public function get_daily_report($month_option, $year) {
			$query = "SELECT created_date, SUM(total_sales) AS total_sales FROM sales WHERE MONTH(created_on) = '$month_option' AND YEAR(created_date) = '$year' GROUP BY created_date";
			return parent::select($query);
		}

		public function get_weekly_report($start_day, $end_day) {
			$query = "SELECT created_date AS mydate, SUM(total_sales) AS total_sales, SUM(total_sales) AS profit FROM sales WHERE created_date BETWEEN '$start_day' AND '$end_day' GROUP BY created_date";
			return parent::select($query);
		}

		public function get_quarterly_report($curMonth ,$curQuarter) {
			$query = "SELECT created_date AS created_date, total_sales AS total_sales FROM sales WHERE created_date BETWEEN '$curMonth' AND '$curQuarter'";
			return parent::select($query);			
		}

		public function get_yearly_report($cur_year) {
			$query = "
				SELECT YEAR(created_date) AS created_date, SUM(total_sales) AS total_sales FROM `sales` WHERE YEAR(created_date) BETWEEN '$cur_year' AND NOW() GROUP BY YEAR(created_date)";
			return parent::select($query);			

		}

		public function filter_cashier_by_employee($staff_id) {
			$query = "
				SELECT 
				    product.product_name AS product_name,
				    sales.created_date AS created_date,
				    CONCAT(staff.fname, ' ',staff.lname) AS sold_by,
				    sales_details.quantity AS quantity,
				    sales_details.total AS total
				FROM sales_details
				    INNER JOIN product ON sales_details.product_id = product.product_id
				    INNER JOIN sales ON sales_details.sales_id = sales.sales_id
				    INNER JOIN staff ON sales.staff_id = staff.staff_id
				WHERE staff.staff_id = '$staff_id'
				ORDER BY sales.created_date DESC
			";
			return parent::select($query);			
		}		

		public function todays_detailed_sales_report($date) {
			$query = "
				SELECT product.product_name  			 AS product_name, 
				       sd.quantity      	 			 AS quantity, 
				       sd.total    	 		 			 AS total_sold, 
				       s.created_on 					 AS created_on,
				       CONCAT(emp.fname, ' ', emp.lname) AS staff_name,
				       product.selling_price 			 AS selling_price, 
				       st.cost_price         			 AS cost_price 
				FROM   `product` 
				       INNER JOIN sales_details sd 
				               ON sd.product_id = product.product_id 
				       INNER JOIN sales s 
				               ON sd.sales_id = s.sales_id 
				       INNER JOIN stocks st 
				               ON st.product_id = product.product_id 
				       INNER JOIN staff emp 
				               ON s.staff_id = emp.staff_id 				         
				WHERE  s.created_date = '$date' 
				GROUP  BY sd.product_id 
				ORDER BY s.created_on DESC";
			return parent::select($query);
		}
		public function cashier_sales($staff_id) {
			$query = "
				SELECT 
				    CONCAT(staff.fname, ' ',staff.lname) AS sold_by,
				    SUM(sales.total_sales) AS total_sales
				FROM sales_details
				    INNER JOIN sales ON sales_details.sales_id = sales.sales_id
				    INNER JOIN staff ON sales.staff_id = staff.staff_id
				WHERE staff.staff_id = '$staff_id'

			";
			return parent::select($query);			
		}		

		public function view_sales($sales_id) {
			$query="
				SELECT 
				    product.product_name AS product_name,
				    sales_details.quantity AS quantity,
				    sales_details.total AS total
				FROM sales_details
				    INNER JOIN product ON sales_details.product_id = product.product_id
				    INNER JOIN sales ON sales_details.sales_id = sales.sales_id
				WHERE sales_details.sales_id = '$sales_id'
			";
			return parent::select($query);
		}

		public function total_sales_rep($from, $to) {
			$query="
				SELECT 
					SUM(total_sales) AS total_sales
				FROM sales
				WHERE created_date
					BETWEEN '$from'
						AND '$to'
			";
			return parent::select($query);
		}

		public function total_after_sales($from, $to) {
			$query="
				SELECT 
					SUM(issue_amount) AS issues_amount
				FROM issues
				WHERE issues.date
					BETWEEN '$from'
						AND '$to'
			";
			return parent::select($query);
		}

		public function total_expenses($from, $to) {
			$query="
				SELECT 
					SUM(expensed_amount) AS total_expenses
				FROM expenses
				WHERE expenses.date
					BETWEEN '$from'
						AND '$to'

			";
			return parent::select($query);
		}

		public function total_return($from, $to) {
			$query="
				SELECT 
					SUM(price) AS total_return
				FROM returned_items
				WHERE created_date
					BETWEEN '$from'
						AND '$to'

			";
			return parent::select($query);
		}

	}
?>