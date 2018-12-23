<?php
	$output = "<table class='table' id='product_sales_report'>";
	$output.= "<thead><tr><th class='text-center'>Product</th>";
	for($x=1; $x<=12; $x++){
		$cur_month = addZero($x, 2);
		$date = "$year-$cur_month-01";
		$date = date("M", strtotime($date));
		$output.= "<th>$date</th>";
	}
	$output.= "<th>Total</th>";
	$output.= "</tr></thead><tbody>";
	for($x=0; $x<count($report); $x++){
		$output.= "<tr>";
		$data = $report[$x];
		foreach ($data as $key => $value) {
			$td_class = 'text-right';
			if($key==='product_name'){
				$td_class='text-center';
			}
			$output.= "<td class='{$td_class}'>{$value}</td>";
		}
		$output.= "</tr>";
	}
	$output.= "</tbody></table>";

	echo $output;
?>