<?php require_once 'layouts/count_header.php'; ?>
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
    $count_date = date('Y-m-d');

    if ($_SESSION["pos_user"] === null || $_SESSION["pos_staff"] === true) {
        redirect_to("error.php");
    }    

    $stock = array(
    	'stock_id' => NULL, 
    	'product_id' => NULL, 
    	'product_quantity' => NULL, 
    	'size' => NULL, 
    	'location' => NULL, 
    	'taxed' => NULL, 
    	'discount_id' => NULL, 
    	'cost_price' => NULL, 
    	'supplier_id' => NULL, 
    	'product_expiration' => NULL);

    $count = array('count_id' => NULL,
                   'count_date' => NULL,
                   'item_counted' =>NULL,
                   'comments' => NULL,
                   'product_id' => NULL );

    if(isset($_GET['stock_id'])){
        $stock_id = (int) $_GET['stock_id'];
        $stock = $stocks_db->get_stock($stock_id);
        $header = "Count";
    }

    if (isset($_POST["submit"])) {
    	// $stock['stock_id'] = $_POST['stock_id'];
        $stock['product_quantity'] = escape($_POST['count']);
        $count['comments'] = escape($_POST['comments']);
        $count['item_counted'] = escape($_POST['count']);
        $count['count_date'] = escape($count_date);
        $count['product_id'] = escape($stock_id);

        if($stock_id===NULL){
            //insert
            $wpdb->insert('stocks',$stock);
            $stock_id = $wpdb->insert_id;
            $message = '<div class="alert alert-success">Inventory count added.</div>';
        }
        else{
            //update
            $wpdb->update('stocks',$stock,array('stock_id'=>$stock_id));
            $wpdb->insert('count',$count);
            $message = '<div class="alert alert-success">Inventory has been updated.</div>';
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
                <form class="form-horizontal" role="form" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                    <div class="col-lg-12">
                        <!-- /.panel -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="glyphicon glyphicon-list-alt"></i> <?php echo $header; ?> Inventory
                            </div>
                            <div class="panel-body">
                                <span id="message"><?php if(isset($message)) echo $message; ?></span>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product_id" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Product:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                            	<select class="form-control" name="product_id" disabled>
                                            		<?php
                                            			$products = $product_db->get_all_product();
                                            			$option = "";
                                            			foreach ($products as $product) {
                                            				$display = $product['product_name'];
                                            				$option.= option($display, $product['product_id'], $stock["product_id"]);
                                            			}
                                            			echo $option;
                                            		?>
                                            	</select>
                                            </div> 
                                        </div>
                                        <div class="form-group">
                                            <label for="count" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Count:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="count" id="count" class="form-control" type="number" min="0" oninput="validity.valid || (value='')">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="product_quantity" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Actual on Hand:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="product_quantity" value="<?php echo $stock['product_quantity'] ?>" id="product_quantity" class="form-control form-inps" type="text" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="comments" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Comment:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="comments" id="comments" class="form-control" type="text">
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
    <script type="text/javascript">
        $(document).ready(function() {
            // var message = false;
            // var element = $("#message").html();

            // if (element.length) {
            //     log($(element).html());
            //     setTimeout(function() {
            //         redirect_to("save_stock.php");                
            //     }, 300);
            // }

            $('#product_expiration').datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>
</body>

</html>
