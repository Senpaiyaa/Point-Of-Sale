<?php
    require_once '../class/Functions.php';
    require_once '../class/Session.php';
    require_once '../class/Product.php';
    require_once '../class/helper.php';
    require_once '../class/wp-db.php';

    $product_db = new Product();
    $product_barcode = _request('product_barcode');
    $product = $product_db->get_barcode($product_barcode);
    header('content-type:application/json');
    $json = array('product'=>$product);
    echo json_encode($json);
?>