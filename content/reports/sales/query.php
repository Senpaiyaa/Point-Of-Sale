<?php
	$report = array();

	if($range_option == 'daily') {
		$report = $sales_db->get_daily_report($month_option, $year);
	}	
	if($range_option == 'this_week') {
		$report = $sales_db->get_weekly_report($start_day, $end_day);
	}
	if($range_option=='monthly'){
		for($x=1;$x<=12;$x++){
			$total_sales = $sales_db->get_total_sales($year, $x);
			$cur_month = addZero($x, 2);
			$data = array(
				'total_sales' => $total_sales,
				'date' => "$year-$cur_month-01",
				'month' => $x,
				'year' => $year
			);
			array_push($report, $data);
		}
	}
	// if($range_option == "quarterly") {
	// 	$report = $sales_db->get_quarterly_report($curMonth, $curQuarter);
	// }
	if($range_option == "yearly") {
		$report = $sales_db->get_yearly_report($year);
	}
?>