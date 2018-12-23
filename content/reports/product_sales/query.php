<?php
	$report = array();
	$query = "SELECT * FROM `product` WHERE is_deleted = FALSE";

	$products = $wpdb->get_results($query, ARRAY_A);

	foreach ($products as $product) {
		$data = array(
			'product_name' => $product['product_name']
		);
		$total_quantity = 0;
		for($x=1;$x<=12;$x++){
			$sub_query = "SELECT `sales_id` FROM `sales` WHERE YEAR(`created_on`) = $year AND MONTH(`created_on`) = $x";
			$query = "SELECT SUM(`quantity`) AS `quantity`, SUM(`total`) AS `total` FROM `sales_details` WHERE `sales_id` IN ($sub_query) AND `product_id` = {$product['product_id']}";
			$sales_details = $wpdb->get_row($query, ARRAY_A);
			$cur_month = addZero($x, 2);
			$date = "$year-$cur_month-01";
			$quantity = (int)$sales_details['quantity'];
			$data[$date] = $quantity;
			$total_quantity+= $quantity;
		}
		$data['total_quantity'] = $total_quantity;
		array_push($report, $data);
	}

?>