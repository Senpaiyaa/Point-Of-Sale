<?php require_once 'layouts/manage_item_header.php'; ?>
<?php
    require_once 'class/Functions.php';
    require_once 'class/Session.php';
    require_once 'class/Stocks.php';
    require_once 'class/Supplier.php';
    require_once 'class/Manufacturer.php';
    require_once 'class/Product.php';
    require_once 'class/helper.php';
    require_once 'class/wp-db.php';

    $stocks_db = new Stocks();
    $session = new Session();
    $supplier_db = new Supplier();
    $manufacturer_db = new Manufacturer();
    $product_db = new Product();
	$stock_id = NULL;    
    $header = "New";

    if ($_SESSION["pos_user"] === null || $_SESSION["pos_staff"] === true) {
        redirect_to("error.php");
    }    

    $stock = array(
    	'stock_id' => NULL, 
    	'product_id' => NULL, 
    	'product_quantity' => NULL, 
    	'location' => NULL, 
    	'cost_price' => NULL, 
    	'supplier_id' => NULL, 
    	'product_expiration' => NULL);

    if(isset($_GET['stock_id'])){
        $stock_id = (int) $_GET['stock_id'];
        $stock = $stocks_db->get_stock($stock_id);
        $header = "Update";
    }

    if (isset($_POST["submit"])) {
    	// $stock['stock_id'] = $_POST['stock_id'];

        if($stock_id===NULL){
            //insert
            $stock['product_id' ] = $_POST['product_id'];
            $stock['product_quantity'] = (int) escape($_POST['product_quantity']);
            $stock['location' ] = escape($_POST['location']);
            $stock['supplier_id'] = escape($_POST['supplier_id']);
            $stock['product_expiration'] = escape($_POST['product_expiration']);
            $wpdb->insert('stocks',$stock);
            $stock_id = $wpdb->insert_id;
            $message = '<div class="alert alert-success">Stock has been added.</div>';
        }
        else{
            $stock['cost_price' ] = (double) escape($_POST['cost_price']);
            $stock['location' ] = escape($_POST['location']);
            $stock['product_expiration'] = escape($_POST['product_expiration']);
            $wpdb->update('stocks',$stock,array('stock_id'=>$stock_id));
            $message = '<div class="alert alert-success">Stock has been updated.</div>';
            // redirect_to('stocks.php');
            //$wpdb->delete('product',array('product_id'=>$product_id));
        }

        $stock = $stocks_db->get_stock($stock_id);    
    }
?>
    <div id="wrapper">
        <?php require_once 'layouts/navigation.php'; ?>

        <div id="page-wrapper">
            <span>&nbsp;</span>
            <div class="row">
                <form class="form-horizontal" role="form" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="stock_form">
                    <div class="col-lg-12">
                        <!-- /.panel -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-pencil"></i> <?php echo $header; ?> Stock and Inventory <small>(Fields in red are required)</small>
                            </div>
                            <div class="panel-body">
                                <span id="message"><?php if(isset($message)) echo $message; ?></span>
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php
                                            $barcode_option = '';
                                            if (!isset($_GET['stock_id'])) {
                                                $barcode_option = '
                                                    <a data-toggle="collapse" href="#barcode_option" id="scan_barcode">Scan barcode</a>
                                                    <div id="barcode_option" class="collapse">
                                                        <div class="form-group">
                                                            <label for="barcode" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Barcode:</label>
                                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                                <input name="barcode" id="barcode" class="form-control" type="text" placeholder="Enter or scan barcode here...">
                                                            </div>

                                                        </div>                                            
                                                        <div class="alert alert-danger" id="stock-not-found" style="display:none;">Stock not found.</div>
                                                    </div>
                                                ';
                                            }
                                            echo $barcode_option;
                                        ?>
                                        <div class="form-group">
                                            <label for="product_id" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Product:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                            	<select class="form-control" name="product_id" id="product">
                                            		<?php
                                            			$products = $product_db->get_all_product();
                                            			$option = "";
                                            			foreach ($products as $product) {
                                            				$display = $product['product_barcode'] . ' - ' . $product['product_name'];
                                            				$option.= option($display, $product['product_id'], $stock['product_id']);
                                            			}
                                            			echo $option;
                                            		?>
                                            	</select>
                                            </div> 
                                        </div>
                                        <div class="form-group">
                                            <label for="product_quantity" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Quantity:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="product_quantity" value="<?php echo $stock['product_quantity'] ?>" id="product_quantity" class="form-control form-inps" type="number" min="0" oninput="validity.valid||(value='');">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="location" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Location at Store:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="location" value="<?php echo $stock['location']; ?>" id="location" class="form-control form-inps" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="cost_price" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Cost Price:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="cost_price" value="<?php echo $stock['cost_price']; ?>" id="cost_price" class="form-control form-inps" type="number" min="0" oninput="validity.valid||(value='');">
                                                <span class="text-danger" style="display:none;" id="empty_cost_price">Cost price is a required field.</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="supplier_id" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Supplier:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <select id="supplier_id" class="form-control" name="supplier_id">
                                                    <?php
	                                                        $suppliers = $supplier_db->get_all_supplier();
	                                                        $option = "";
	                                                        foreach ($suppliers as $supplier) {
	                                                            $option .= option($supplier['supplier_name'], $supplier['supplier_id'], $stock['supplier_id']);
	                                                        }
	                                                        echo $option;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="product_expiration" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Product Expiration:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="product_expiration" value="<?php echo $stock['product_expiration']; ?>" id="product_expiration" class="form-control form-inps" type="text" readonly>
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

    <script src="vendor/jquery-ui-1.12.1/jquery-ui.js"></script>
    <script src="js/functions.js"></script>
    <?php echo (!isset($_GET['stock_id'])) ? '<script src="js/save_stock.js"></script>' : ''; ?>
    <?php echo (isset($_GET['stock_id'])) ? '<script src="js/null_stock_id.js"></script>' : ''; ?>
    <script type="text/javascript">

        $(document).ready(function() {
            var barcode_value = null;
            var product_id = null;
            var json = null;
            $('#product_expiration').datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $('#barcode').keypress(function(e) {
                if(e.which === 13) {
                    barcode_value = $('#barcode').val();
                    console.log(barcode_value);
                    $.get("ajax/get_product.php?product_barcode="+barcode_value,function(response){
                        json = response;
                        console.log(json);
                        $("select[name='product_id']").val(json.product.product_id);
                        $("#product_quantity").val(json.product.product_quantity);
                        $("#location").val(json.product.location);
                        $("#cost_price").val(json.product.cost_price);
                        $("#product_expiration").val(json.product.product_expiration);
                    });
                    // log("stock form prevented submission.");
                    // return false;
                }
            });

        });

    </script>
</body>

</html>
