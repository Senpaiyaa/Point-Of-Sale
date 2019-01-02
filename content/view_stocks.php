
<?php 
    require_once 'class/Functions.php';
    require_once 'class/Session.php';
    require_once 'class/Stocks.php';
    require_once 'class/Product.php';
    require_once 'class/Supplier.php';
    require_once 'layouts/item_header.php';
    $stocks_db = new Stocks();
    $product_db = new Product();
    $supplier_db = new Supplier();
    $session = new Session();
    if ($_SESSION["pos_user"] === null || $_SESSION["pos_staff"] === true) {
        redirect_to("error.php");
    }    
    $stock_id = $_GET["stock_id"];
    $stock = $stocks_db->get_stock($stock_id);
    $product = $product_db->get_product($stock['product_id']);
    $supplier = $supplier_db->get_supplier($stock['supplier_id']);
?>

    <div id="wrapper">
        <?php require_once 'layouts/navigation.php'; ?>

        <div id="page-wrapper">
            <span>&nbsp;</span>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3>Stock Information <span><i class="fa fa-pencil"></i></span></h3>
                        </div>
                        <div class="panel-body">

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Stock ID</th>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Location</th>
                                            <th>Cost Price</th>
                                            <th>Supplier</th>
                                            <th>Expiration</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $stock['stock_id']; ?></td>
                                            <td><?php echo $product['product_name']; ?></td>
                                            <td><?php echo $stock['product_quantity']; ?></td>
                                            <td><?php echo $stock['location']; ?></td>
                                            <td>&#8369; <?php echo number_format($stock['cost_price'],2,'.',',') ?></td>
                                            <td><?php echo $supplier['supplier_name']; ?></td>
                                            <td><?php echo $stock['product_expiration']; ?></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer">
                            Stock: <?php echo $product['product_name']; ?>
                        </div>
                    </div>
                    <?php require_once 'layouts/footer.php'; ?>
                </div>
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

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>
</body>

</html>
