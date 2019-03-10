<?php require_once 'layouts/item_header.php'; ?>
<?php
    require_once 'class/Functions.php';
    require_once 'class/Session.php';
    require_once 'class/Stocks.php';
    require_once 'class/Product.php';
    require_once 'class/Expired_Items.php';

    $stocks_db = new Stocks();
    $product_db = new Product();
    $session = new Session();
    $expired_items_db = new Expired_Items();

    $invalid_date = '0000-00-00'

    if ($_SESSION["pos_user"] === null || $_SESSION["pos_staff"] === true) {
        redirect_to("error.php");
    }    

?>
<?php
    function create_item($stock) {
        global $product_db, $stocks_db;
        $stock_id = $stock["stock_id"];

        $product = $product_db->get_product($stock['product_id']);
        $expired_items = $stock["product_expiration"];

        if ($expired_items === $invalid_date) {
            $expired_items = "Not set";
        } else {
            $expired_items = $stock["product_expiration"];
        }

        // debug($expired_items);
        $html = '
            <tr id="'.$stock['stock_id'].'" class="td-expired-stock">
                <td class="product_id text-center">' . $stock["stock_id"] . '</td>
                <td class="product_name text-center">' . $product["product_name"] . '</td>
                <td class="product_description text-center">' . $product["product_description"] . '</td>
                <td class="expire_days text-center">' . $expired_items . '</td>
            </tr>';
        return $html;

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
                            <h3>
                                List of Items Expiring Before 1 Month
                            </h3>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table class="table table-bordered table-hover" id="forecast_item_list">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">Expire date</th>                                   
                                    </tr>
                                </thead>
                                <tbody id="expiring_items_count">
                                    <?php
                                        $query = $expired_items_db->get_expired_items_within_month(2);

                                        $tds = '';
                                        $td = '';
                                        foreach ($query as $stock) {
                                            $tds .= create_item($stock);
                                        }

                                        $td .= $tds;

                                        echo $td;
                                    ?>
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
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

    <script>    
        $(document).ready(function() {
            var count = jQuery('#expiring_items_count tr').length;
            var table = jQuery('#expired_count');
            $('#item_list').DataTable({
                responsive: true
            });
            log(count);
            jQuery(table).append(count);
        });

        $(document).on('click','.navbar-collapse',function(e) {
            if( $(e.target).is('a') ) {
                $(this).collapse('hide');
            }
        });
    </script>
</body>

</html>
