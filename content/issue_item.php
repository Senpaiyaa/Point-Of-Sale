<?php require_once 'layouts/item_header.php'; ?>
<?php
    require_once 'class/Functions.php';
    require_once 'class/Session.php';
    require_once 'class/Stocks.php';
    require_once 'class/Product.php';
    require_once 'class/Expired_Items.php';
    require_once 'class/wp-db.php';

    $stocks_db = new Stocks();
    $product_db = new Product();
    $session = new Session();

    if ($_SESSION["pos_user"] === null || $_SESSION["pos_staff"] === true) {
        redirect_to("error.php");
    }  

    $product_id = _request('product_id');
    $stock = $stocks_db->get_stock($product_id);
    $product = $product_db->get_product($stock['product_id']);
    // debug($_POST);
    $expensed_amount = (double) ($stock['product_quantity'] * $stock['cost_price']);

    $issues = array(
        'issues_id' => NULL,
        'product_id' => NULL,
        'quantity' => NULL,
        'issue_amount' => NULL,
        'type' => NULL,
        'date' => NULL);

    // Error
    // null $product_id

    if (isset($_POST["submit"])) {
        // debug($issues);
        $issues['product_id'] = escape($product_id);
        $issues['quantity'] = $stock['product_quantity'];
        $issues['issue_amount'] = escape($expensed_amount);
        $issues['type'] = escape($_POST['type']);
        $issues['date'] = escape(date("Y-m-d"));

        $wpdb->insert('issues', $issues);
        $message = '<div class="alert alert-success">You have added an after sale status for ' . $product['product_name'] . '.</div>';
        $wpdb->update('stocks',array('is_deleted'=>true),array('stock_id'=>$product_id));
    }
?>

    <div id="wrapper">

        <!-- include nav  -->
        <?php require_once 'layouts/navigation.php'; ?>

        <div id="page-wrapper">
            <!-- <p>&nbsp;</p> -->
            <!-- <br> -->
            <span>&nbsp;</span>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>Set item with an issue</h3>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <span id="message"><?php if(isset($message)) echo $message; ?></span>
                            <form class="form-horizontal" role="form" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="issue_form">
                                <div class="col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <i class="fa fa-pencil"></i> Item Information 
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="issued_product_name" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Product Name:</label>
                                                        <div class="col-sm-9 col-md-9 col-lg-10">
                                                            <input name="product_name" value="<?php echo $product['product_name']; ?>" id="product_name" class="form-control form-inps" type="text" disabled="disabled">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="quantity_expired" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Quantity Expired:</label>
                                                        <div class="col-sm-9 col-md-9 col-lg-10">
                                                            <input name="quantity_expired" value="<?php echo $stock['product_quantity']; ?>" id="quantity_expired" class="form-control form-inps" type="text" disabled="disabled">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="expensed_amount" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Expensed Amount:</label>
                                                        <div class="col-sm-9 col-md-9 col-lg-10">
                                                            <input name="expensed_amount" value="<?php echo number_format($expensed_amount, 2, ".", ",");  ?>" id="expensed_amount" class="form-control form-inps" type="text" readonly="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="type" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Type:</label>
                                                        <div class="col-sm-9 col-md-9 col-lg-10">
                                                            <select class="form-control" name="type" id="type">
                                                                <option selected>Broken</option>
                                                                <option>Lost</option>
                                                                <option>Rotted</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="date" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Date:</label>
                                                        <div class="col-sm-9 col-md-9 col-lg-10">
                                                            <input name="date" value="<?php echo date("Y-m-d");?>" id="date" class="form-control form-inps" type="text" readonly="">
                                                        </div>
                                                    </div>

                                                    <div class="form-actions">
                                                        <input type="submit" name="submit" class="submit_button floating_button btn btn-primary" value="Submit" id="submit">
                                                    </div>
                                                </div>
                                                <!-- /.col-lg-6 (nested) -->
                                            </div>
                                            <!-- /.row (nested) -->
                                        </div>
                                        <!-- /.panel-body -->
                                    </div>
                                    <!-- /.panel -->
                                </div>
                                <!-- /.col-lg-12 -->                    
                            </form>

                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
                <?php require_once 'layouts/footer.php'; ?>
            </div>
            <!-- /.row -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

    <script src="js/functions.js"></script>

</body>

</html>
