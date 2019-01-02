<?php require_once 'layouts/count_header.php'; ?>
<?php
    require_once 'class/Functions.php';
    require_once 'class/Session.php';
    require_once 'class/Stocks.php';
    require_once 'class/Product.php';

    $stocks_db = new Stocks();
    $product_db = new Product();
    $session = new Session();

    if ($_SESSION["pos_user"] === null || $_SESSION["pos_staff"] === true) {
        redirect_to("error.php");
    }    
?>
<?php
    function create_item($stock) {
        global $product_db, $stocks_db;
        $stock_id = $stock["stock_id"];
        $checkbox = '<input type="checkbox" name="stock_id[]" value="'.$stock_id.'" class="chk_stock">';
        $count = '<center><a id="count" class="pointer" href="save_count.php?stock_id='.$stock_id.'"><span class="glyphicon glyphicon-list-alt"></span> Count</a></center>';
        // $expiry = isset($stock["product_expiration"]) ? $stock["product_expiration"] : "Not set";
        $expiry = $stock["product_expiration"];
        $check_qty;
        $item;

        // debug($expiry);

        if ($expiry === '0000-00-00') {
            $expiry = "Not set";
        } else {
            $expiry = $stock["product_expiration"];
        }   

        $product = $product_db->get_product($stock['product_id']);
        // $quantity = $stocks_db->quantity_sum($stock['product_id']);
        $quantity = $stock['product_quantity'];
        if ($quantity == 0) {
            $item = '<td class="product_name text-center">'.$product["product_name"].'</td>
';
            $check_qty = '<td class="product_quantity text-center text-danger">' . $quantity . '</td>';
        } else {
            $item = '<td class="product_name text-center">'.$product["product_name"].'</td>
';
            $check_qty = '<td class="product_quantity text-center">' . $quantity . '</td>';
        }

        // debug($stock);

        $html = '
            <tr id="'.$stock['stock_id'].'" class="td-stock">
                ' . $item . '
                ' . $check_qty .'
                <td class="expire_days text-center">' . $expiry . '</td>
                <td>' . $count . '</td>
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
                                List of Stocks
                                <span class="badge bg-primary" style="background-color: #489EE7;" id="item_count">
                                    <?php
                                        // call item_count here
                                        // $item_count = $stocks_db->count_all_items();
                                        // echo $item_count;
                                        $stock_count = $stocks_db->inventory_count_display();
                                        $total = 0;
                                        foreach ($stock_count as $count) {
                                            $total += $count["total"];                                            
                                        }

                                        echo $total;
                                    ?>
                                </span>
                            </h3>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-bordered table-striped" id="item_list">
                                <thead>
                                    <tr>
                                        <th class="text-center">Name</th>                                        
                                        <th class="text-center">Quantity</th>           
                                        <th class="text-center">Expire date</th>                                   
                                        <th id="action" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $query = $stocks_db->inventory_count_query();

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

    <!-- modals -->

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

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#item_list').DataTable({
            responsive: true,
            "order": [[ 1, "asc" ]]            
        });
    });
    </script>
</body>

</html>
