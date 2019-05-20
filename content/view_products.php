
<?php 
    require_once 'class/Functions.php';
    require_once 'class/Product.php';
    require_once 'class/Manufacturer.php';
    require_once 'class/Category.php';
    require_once 'class/Session.php';
    require_once 'layouts/product_header.php'; 
    $product_db = new Product();
    $manufacturer_db = new Manufacturer();
    $category_db = new Category();
    $session = new Session();
    if ($_SESSION["pos_user"] === null || $_SESSION["pos_admin"] === true) {
        redirect_to("error.php");
    }    
    $product_id = _request('product_id');
    $product = $product_db->get_product($product_id);
    $manufacturer = $manufacturer_db->get_manufacturer($product['manufacturer_id']);
    $category = $category_db->get_category($product['category_id']);
?>

    <div id="wrapper">
        <?php require_once 'layouts/pos_navigation.php'; ?>

        <div id="page-wrapper">
            <span>&nbsp;</span>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3>Product Information <span><i class="fa fa-pencil"></i></span></h3>
                        </div>
                        <div class="panel-body">

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Product ID</th>
                                            <th>Product Name</th>
                                            <th>Product Description</th>
                                            <th>Barcode</th>
                                            <th>Manufacturer</th>
                                            <th>Category</th>
                                            <th>Selling Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $product["product_id"]; ?></td>
                                            <td><?php echo $product["product_name"]; ?></td>
                                            <td><?php echo $product["product_description"]; ?></td>
                                            <td><?php echo $product["product_barcode"]; ?></td>
                                            <td><?php echo $manufacturer["manufacturer_name"]; ?></td>
                                            <td><?php echo $category["category_name"]; ?></td>
                                            <td>&#8369; <?php echo number_format($product["selling_price"],2,'.',',') ?></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer">
                            Product: <?php echo $product["product_name"]; ?>
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
