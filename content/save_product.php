<?php require_once 'layouts/product_header.php'; ?>
<?php
    require_once 'class/Functions.php';
    require_once 'class/Session.php';
    require_once 'class/Stocks.php';
    require_once 'class/Supplier.php';
    require_once 'class/Manufacturer.php';
    require_once 'class/Product.php';
    require_once 'class/wp-db.php';
    require_once 'class/helper.php';

    $stocks_db = new Stocks();
    $session = new Session();
    $supplier_db = new Supplier();
    $manufacturer_db = new Manufacturer();
    $product_db = new Product();
    $message = NULL;
    $header = "New";
    // $time = 2;

    if ($_SESSION["pos_user"] === null || $_SESSION["pos_staff"] === true) {
        redirect_to("error.php");
    }    

    $product_id = NULL;
    $product = array(
        'product_id' => NULL,
        'product_name' => NULL,
        'product_description' => NULL,
        'product_barcode' => NULL,
        'manufacturer_id' => NULL,
        'category_id' => NULL,
        'selling_price' => NULL
    );

    if(isset($_GET['product_id'])){
        $product_id = (int) $_GET['product_id'];
        $product = $product_db->get_product($product_id);
        $header = "Update";
    }

    if (isset($_POST["submit"])) {
        $product['product_name' ] = escape($_POST['product_name']);
        $product['product_description'] = escape($_POST['product_description']);
        $product['product_barcode' ] = escape($_POST['product_barcode']);
        $product['manufacturer_id' ] = escape($_POST['manufacturer_id']);
        $product['category_id' ] = escape($_POST['category_id']);
        $product['selling_price' ] = (double) escape($_POST['selling_price']);
        if($product_id===NULL){
            //insert
            $wpdb->insert('product',$product);
            $product_id = $wpdb->insert_id;
            $header = "Update";
            $message = '<div class="alert alert-success">Product has been added.</div>';
            // timeout($time, "save_product.php");
        }
        else{
            //update
            $wpdb->update('product',$product,array('product_id'=>$product_id));
            $message = '<div class="alert alert-success">Product has been updated.</div>';
            // redirect_to('product.php');
            //$wpdb->delete('product',array('product_id'=>$product_id));
        }

        $product = $product_db->get_product($product_id);
    }
?>

    <div id="wrapper">
        <?php require_once 'layouts/navigation.php'; ?>

        <div id="page-wrapper">
            <span>&nbsp;</span>
            <div class="row">
                <form class="form-horizontal" role="form" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="product_form">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-pencil"></i> <?php echo $header; ?> Product Information <small>(Fields in red are required)</small>
                            </div>
                            <div class="panel-body">
                                <span id="message"><?php if(isset($message)) echo $message; ?></span>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product_barcode" class="col-sm-3 col-md-3 col-lg-2 control-label wide">UPC/EAN/ISBN:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="product_barcode" value="<?php echo $product['product_barcode']; ?>" id="product_barcode" class="form-control form-inps" type="text" autocomplete="off">
                                                <span class="text-danger" style="display:none;" id="barcode_exists">UPC/EAN/ISBN already exists</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="product_name" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Name:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="product_name" value="<?php echo $product['product_name']; ?>" id="product_name" class="form-control" type="text">
                                                <span class="text-danger" style="display:none;" id="empty_name">Product name is a required field.</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="product_description" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Description:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="product_description" value="<?php echo $product['product_description']; ?>" id="product_description" class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="manufacturer_id" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Manufacturer:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <select id="manufacturer_id" class="form-control" name="manufacturer_id">
                                                    <?php
                                                        $manufacturers = $manufacturer_db->get_all_manufacturer();
                                                        $option = "";
                                                        foreach ($manufacturers as $manufacturer) {
                                                            $option .= option($manufacturer['manufacturer_name'], $manufacturer['manufacturer_id'], $product['manufacturer_id']);
                                                        }
                                                        echo $option;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="category_id" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Category:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <select id="category_id" class="form-control" name="category_id">
                                                    <?php
                                                        $stocks = $stocks_db->option_category();
                                                        $option = "";
                                                        foreach ($stocks as $category) {
                                                            $option .= option($category['category_name'], $category['category_id'], $product['category_id']);
                                                        }
                                                        echo $option;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="selling_price" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Selling Price:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="selling_price" value="<?php echo $product['selling_price']; ?>" id="selling_price" class="form-control form-inps" type="number" min="0">
                                                <span class="text-danger" style="display:none;" id="empty_selling_price">Selling price is a required field.</span>
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

    <script src="js/functions.js"></script>
    <?php echo (!isset($_GET['product_id'])) ? '<script src="js/save_product.js"></script>' : ''; ?>
    <?php echo (!isset($_GET['product_id'])) ? '<script src="js/product.js"></script>' : ''; ?>
    <?php echo (isset($_GET['product_id'])) ? '<script src="js/null_product_id.js"></script>' : ''; ?>
</body>

</html>
