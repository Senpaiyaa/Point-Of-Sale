<?php
	require_once '../class/wp-db.php';
    require_once '../class/Session.php';
    $session = new Session();
    date_default_timezone_set("Asia/Kuala_Lumpur");
    //var_dump($_POST);
    $created_date = date('Y-m-d');
	$sales = array(
		'sales_id' => NULL,
		'created_on' => NULL,
		'total_sales' => NULL,
		'amount_paid' => NULL,
		'amount_change' => NULL,
        'staff_id' => NULL,
        'created_date' => NULL);

    $sales['amount_paid' ] = $_POST['sales']['amount_paid'];
    $sales['total_sales'] = $_POST['sales']['total_sales'];
    $sales['created_on'] = date("Y-m-d H:i:s");
    $sales['amount_change'] = ((double) $sales["amount_paid"]) - ((double) $sales["total_sales"]);
    $sales['staff_id'] = $_SESSION['pos_user']['staff_id'];
    $sales['created_date'] = $created_date;
    
    $wpdb->insert('sales', $sales);
    $sales_id = $wpdb->insert_id;

    foreach ($_POST['sales_details'] as $temp) {
        $product_id = $temp['product']['product_id'];
        $quantity = (int)$temp['quantity'];
        $query = "SELECT * FROM `stocks` WHERE `product_id` = $product_id AND `product_quantity` >= $quantity";
        $stock = $wpdb->get_row($query, ARRAY_A);

        $remaining_qty = ((int)$stock['product_quantity']) - $quantity;

        $sales_details = array(
            'sales_details_id' => NULL, 
            'sales_id' => $sales_id,
            'product_id' => $product_id,
            'quantity' => $quantity,
            'stock_id' => $stock['stock_id'],
            'total' => (double)$temp['total']);


    	$wpdb->insert('sales_details', $sales_details);

    	$wpdb->update('stocks',array('product_quantity'=>$remaining_qty),array('stock_id'=>$stock['stock_id']));

    }

    echo $sales_id;
?>