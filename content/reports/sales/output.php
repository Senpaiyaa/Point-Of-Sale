<?php
	$output = "<table class='table'>";
	$total = 0;
	if($range_option=='monthly'){
		$output.="
			<tr>
				<th>Month</th>
				<th class='text-right'>Total</th>
			</tr>";
		foreach ($report as $data) {
			$date = date("F", strtotime($data['date']));
			$total_sales = number_format($data['total_sales'],2,'.',',');
			$total+= (double)$data['total_sales'];
			$formatted_monthly_sales = $total_sales;
			// $link = "<a href='product_sales_report.php?month={$data['month']}&year={$data['year']}'>$date</a>";
			$output.= "<tr>
				<td>{$date}</td>
				<td class='text-right'>&#8369; {$formatted_monthly_sales}</td>
				</tr>";
		}
		$total_sales_for_year = number_format($total,2,'.',',');
		$output.="<tr><td>Total</td><td class='text-right'>&#8369; $total_sales_for_year</td></tr>";
	}
	else if($range_option == 'daily') {
		$output .= "
			<h5>Reports - Sales Summary Report</h5>
			<tr>
				<th>Date</th>
				<th>Total Sales</th>
			</tr>
		";
		$no_of_days = cal_days_in_month(CAL_GREGORIAN, (int)$month_option, $year);
		for($x=1; $x<=$no_of_days; $x++){
			$found = false;
			foreach ($report as $daily_report) {
				$thisDay = (int)date('d', strtotime($daily_report['created_date']));
				if($thisDay==$x){
					$total += (double)$daily_report['total_sales'];
					$formatted_daily_total_sales = number_format($daily_report['total_sales'],2,'.',',');
					$date = date('M d', strtotime($daily_report['created_date']));
					$output .= "
						<tr>
							<td>{$date}</td>
							<td>{$formatted_daily_total_sales}</td>
						</tr>";
					$found = true;
					break;
				}
			}
			if(!$found){
				$thisDay = addZero($x, 2);
				$thisMonth = addZero((int)$month_option, 2);
				$thisDate = "{$year}-$thisMonth-$thisDay";
				$date = date('M d', strtotime($thisDate));
				$formatted_daily_total_sales = number_format(0,2,'.',',');
				$output .= "
					<tr>
						<td>{$date}</td>
						<td>{$formatted_daily_total_sales}</td>
					</tr>";
			}
		}
		$total_daily_sales = number_format($total,2,'.',',');
		$output.="<tr><td>Total</td><td>&#8369; $total_daily_sales</td></tr>";
	}
	else if($range_option == 'this_week') {
		/* CHECK VALUE OF $i */

		$profit = 0;
		$output .= "
			<h5>Reports - Sales Summary Report <small class='reports-range'>" . $start_day . " - " . $end_day . "</small></h5>
			<tr>
				<th>Date</th>
				<th>Total</th>
			</tr>
		";
		for ($i=$start_day; $i <= $end_day; $i++) { 
			$date = date('d', strtotime($i));
			$found = false;
			foreach ($report as $weekly_report) {
				$week = (int)date('d',strtotime($weekly_report['mydate']));
				if ($week==$date) {
					$total_sales = $weekly_report['total_sales'];
					$total+=$total_sales;
					$date_display = date('M d', strtotime($weekly_report['mydate']));
					$output.="
						<tr>
							<td>{$date_display}</td>
							<td>{$total_sales}</td>
						</tr>
					";
					$found = true;
					break;
				}
			}
			if(!$found) {
				$thisDay = addZero($x, 2);
				$thisMonth = addZero((int)$month_option, 2);
				$thisDate = "{$year}-$thisMonth-$thisDay";
				$formatted_weekly_total_sales = number_format(0,2,'.',',');
				$date_display = date('M d', strtotime($i));
				$output .= "
					<tr>
						<td>{$date_display}</td>
						<td>{$formatted_weekly_total_sales}</td>
					</tr>";
			}
		}
		$profit_formatted = number_format($profit, 2, '.', ',');
		$total_weekly_sales = number_format($total,2,'.',',');
		$output.="
				<tr>
					<td>Total</td>
					<td>&#8369; $total_weekly_sales</td>
				</tr>";
		// foreach ($report as $weekly_report) {
		// 	$total_sales = number_format($weekly_report['total_sales'],2,'.',',');
		// 	$total += (double)$weekly_report['total_sales'];
		// 	$profit += ($total / $weekly_report['total_sales']) * 100;
		// 	$formatted_weekly_sales = $total_sales;
		// 	$output .= "
		// 		<tr>
		// 			<td>{$start_day} to {$end_day}</td>
		// 			<td>{$formatted_weekly_sales}</td>
		// 		</tr>";
		// }

	}
	// else if($range_option == 'quarterly') {
	// 	$output .= "
	// 		<h5>Reports - Sales Summary Report <small class='reports-range'>" . $curMonth . " - " . $curQuarter . "</small></h5>
	// 		<tr>
	// 			<th>Year</th>
	// 			<th>Quarter</th>
	// 			<th>Total</th>
	// 		</tr>
	// 	";
	// 	foreach ($report as $quarterly_report) {
	// 		$date = $quarterly_report['created_date'];
	// 		$total_sales = number_format($quarterly_report['total_sales'], 2, '.', ',');
	// 		$output .= "
	// 			<tr>
	// 				<td>$date</td>
	// 				<td>&#8369; $total_sales</td>
	// 			</tr>";
	// 	}
	// }
	else if($range_option == 'yearly') {
		$output .= "
			<h5>Reports - Sales Summary Report</h5>
			<tr>
				<th>Year</th>
				<th>Total</th>
			</tr>
		";
		foreach ($report as $yearly_report) {
			$date = $yearly_report['created_date'];
			$total = $yearly_report['total_sales'];
			$formatted_yearly_report = number_format($total,2,'.',',');
			$output .= "
				<tr>
					<td>$date</td>
					<td>&#8369; $formatted_yearly_report</td>
				</tr>";
		}

	}


	$output.= "</table>";

	echo $output;
?>
 