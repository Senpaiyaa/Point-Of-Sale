<?php require_once 'layouts/item_header.php'; ?>
<?php
    require_once 'class/Functions.php';
    require_once 'class/Session.php';
    require_once 'class/Stocks.php';
    require_once 'class/Product.php';

    $stocks_db = new Stocks();
    $product_db = new Product();
    $session = new Session();

    $default_query = ""; 
    $tds = '';
    $td = '';
    $span = '';

    if ($_SESSION["pos_user"] === null || $_SESSION["pos_staff"] === true) {
        redirect_to("error.php");
    }    
?>
<?php
    function create_stock($stock) {
        global $product_db, $stocks_db;
        $stock_id = $stock["stock_id"];
        $edit = '<center><a id="edit" class="pointer" href="save_stock.php?stock_id='.$stock_id.'"><span class="glyphicon glyphicon-pencil"></span> Edit</a></center>';
        $delete = '<a class="pointer pull-right link-red" style="margin-left: 15px;" onclick="show_delete_modal('.$stock_id.')"><span class="glyphicon glyphicon-trash"></span> Delete</a>';
        // $expiry = isset($stock["product_expiration"]) ? $stock["product_expiration"] : "Not set";
        $expiry = $stock["product_expiration"];
        $check_qty = null;
        $item = null;
        $html = '';

        // debug($expiry);

        if ($expiry === '0000-00-00') {
            $expiry = "Not set";
        } else {
            $expiry = $stock["product_expiration"];
        }   

        $product = $product_db->get_product($stock['product_id']);
        // $quantity = $stocks_db->quantity_sum($stock['product_id']);
        $quantity = $stock['product_quantity'];
//         if ($quantity <= 5) {
//             $item = '<td class="product_name text-center text-warning">'.$product["product_name"].'</td>
// ';
//             $check_qty = '<td class="product_quantity text-center text-warning">' . $quantity . '</td>';
//         } else {
//             $item = '<td class="product_name text-center">'.$product["product_name"].'</td>
// ';
//             $check_qty = '<td class="product_quantity text-center">' . $quantity . '</td>';
//         }

        if ($quantity < 6) {
            $item = '<td class="product_name text-center"><a href="view_stocks.php?stock_id='.$stock_id.'">'.$product["product_name"].'</a></td>
';
            $check_qty = '<td class="product_quantity text-center">' . $quantity . '</td>';
            $html = '
                <tr id="'.$stock['stock_id'].'" class="td-stock alert alert-warning">
                    ' . $item . '
                    <td class="product_description text-center">' . $product["product_description"] . '</td>
                    <td class="location text-center">' . $stock["location"] . '</td>
                    ' . $check_qty .'
                    <td class="expire_days text-center">' . $expiry . '</td>
                    <td>' . $edit . '</td>
                </tr>';
        }

        if ($quantity == 0) {
            $item = '<td class="product_name text-center"><a href="view_stocks.php?stock_id='.$stock_id.'">'.$product["product_name"].'</a></td>
';
            $check_qty = '<td class="product_quantity text-center">' . $quantity . '</td>';
            $html = '
                <tr id="'.$stock['stock_id'].'" class="td-stock alert alert-danger">
                    ' . $item . '
                    <td class="product_description text-center">' . $product["product_description"] . '</td>
                    <td class="location text-center">' . $stock["location"] . '</td>
                    ' . $check_qty .'
                    <td class="expire_days text-center">' . $expiry . '</td>
                    <td>' . $edit . '</td>
                </tr>';            
        } else if($quantity > 6) {
            $item = '<td class="product_name text-center"><a href="view_stocks.php?stock_id='.$stock_id.'">'.$product["product_name"].'</a></td>
';
            $check_qty = '<td class="product_quantity text-center">' . $quantity . '</td>';
            $html = '
                <tr id="'.$stock['stock_id'].'" class="td-stock">
                    ' . $item . '
                    <td class="product_description text-center">' . $product["product_description"] . '</td>
                    <td class="location text-center">' . $stock["location"] . '</td>
                    ' . $check_qty .'
                    <td class="expire_days text-center">' . $expiry . '</td>
                    <td>' . $edit . '</td>
                </tr>';
            
        }

        return $html;
    }

    function create_filtered_stocks($stock) {
        $stock_id = $stock['stock_id'];

        $edit = '<a id="edit" class="pointer pull-right" href="save_stock.php?stock_id='.$stock_id.'"><span class="glyphicon glyphicon-pencil"></span> Edit</a>';
        $delete = '<a class="pointer pull-right link-red" style="margin-left: 15px;" onclick="show_delete_modal('.$stock_id.')"><span class="glyphicon glyphicon-trash"></span> Delete</a>';

        $html = '
            <tr id="'.$stock['stock_id'].'" class="td-stock">
                <td class="stock_name text-center">' . $stock["stock_name"] . '</td>
                <td class="stock_description text-center">' . $stock["stock_description"] . '</td>
                <td class="stock_location text-center">' . $stock["stock_location"] . '</td>
                <td class="stock_quantity text-center">' . $stock['stock_quantity'] . '</td>
                <td class="stock_expire_date text-center">' . $stock['stock_expire_date'] . '</td>
                <td>' . $edit . '</td>
            </tr>';
        return $html;
    }
?>
<?php
    $search_this_item = isset($_GET['item_to_search']) ? escape($_GET['item_to_search']) : "";
    $selected_field = isset($_GET["field_to_find"]) ? escape($_GET["field_to_find"]) : "";
    if (isset($_GET["advance_search"])) {
        $search_this_item = escape($_GET["item_to_search"]);
        // $selected_field = escape($_GET["field_to_find"]);

        if (escape($_GET["field_to_find"]) == "Stock ID") {
            $search_this_item = (int) isset($_GET["item_to_search"]) ? escape($_GET["item_to_search"]) : null;
            $search_query = $stocks_db->stock_search_by_id($search_this_item);
        }
        if (escape($_GET["field_to_find"]) == "Name") {
            $search_this_item = isset($_GET["item_to_search"]) ? escape($_GET["item_to_search"]) : null;
            $search_query = $stocks_db->stock_search_by_name($search_this_item);
        }
        if (escape($_GET["field_to_find"]) == "Description") {
            $search_this_item = isset($_GET["item_to_search"]) ? escape($_GET["item_to_search"]) : null;
            $search_query = $stocks_db->stock_search_by_description($search_this_item);
        }
        if (escape($_GET["field_to_find"]) == "Location") {
            $search_this_item = isset($_GET["item_to_search"]) ? escape($_GET["item_to_search"]) : null;
            $search_query = $stocks_db->stock_search_by_location($search_this_item);
        }
        if (escape($_GET["field_to_find"]) == "Cost Price") {
            $search_this_item = (double) isset($_GET["item_to_search"]) ? escape($_GET["item_to_search"]) : null;
            $search_query = $stocks_db->stock_search_by_cost_price($search_this_item);
        }
        if (escape($_GET["field_to_find"]) == "Selling Price") {
            $search_this_item = (double) isset($_GET["item_to_search"]) ? escape($_GET["item_to_search"]) : null;
            $search_query = $stocks_db->stock_search_by_selling_price($search_this_item);
        }
        if (escape($_GET["field_to_find"]) == "Quantity") {
            $search_this_item = (int) isset($_GET["item_to_search"]) ? escape($_GET["item_to_search"]) : null;
            $search_query = $stocks_db->stock_search_by_quantity($search_this_item);
        }
        if (escape($_GET["field_to_find"]) == "Expire Date") {
            $search_this_item = isset($_GET["item_to_search"]) ? escape($_GET["item_to_search"]) : null;
            $search_query = $stocks_db->stock_search_by_expire_date($search_this_item);
        }

    }
?>
    <div id="wrapper">

        <!-- include nav  -->
        <?php require_once 'layouts/navigation.php'; ?>

        <div id="page-wrapper">
            <span>&nbsp;</span>
            <!-- divide -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <form id="search_form" autocomplete="off" method="get" accept-charset="utf-8">
                        <ul class="list-inline">
                            <li>&nbsp;<span role="status" aria-live="polite"></span><input type="text" class="form-control" name="item_to_search" id="search" value="<?php echo $search_this_item;?>" placeholder="Search Items" autocomplete="off"></li>
                            <li >Fields:
                                <select id="field_to_find" class="form-control" name="field_to_find">
                                    <option>Name</option>
                                    <option>Description</option>
                                    <option>Location</option>
                                    <option>Cost Price</option>
                                    <option>Selling Price</option>
                                    <option>Quantity</option>
                                    <option>Expire Date</option>                                    
                                </select>
                            </li>
                            <li>
                                <button type="submit" class="btn btn-primary" name="advance_search"><span class="fa fa-search"></span> Search</button>
                            </li>
                            <li class="li-right">
                                <a href="save_stock.php" class="btn btn-primary hidden-sm hidden-xs" id="btnAddItem">
                                    <span>New Stock</span>
                                </a>
                                <!-- <a class="btn btn-more dropdown-toggle item_config" type="button" data-toggle="dropdown" aria-expanded=false>
                                    <i class="glyphicon glyphicon-list"></i>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>test</li>
                                </ul> -->
                                <ul class="nav navbar-right item_config">
                                    <li class="dropdown pull-right">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class="visible-sm visible-xs">
                                                <a href="save_stock.php"><i class="glyphicon glyphicon-plus"></i> Add New Stock </a>
                                            </li>
                                            <li><a href="count.php"><i class="glyphicon glyphicon-list-alt"></i> Count inventory</a>
                                            </li>
                                            <li>
                                                <a href="view_item_issue.php"><i class="fa fa-shopping-cart"></i> Items with issues </a>
                                            </li>
                                        </ul>
                                        <!-- /.dropdown-user -->
                                    </li>
                                    <!-- /.dropdown -->
                                </ul>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>

            <!-- /.divide -->
            <span>&nbsp;</span>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>
                                List of Stocks
                                <?php
                                    if (!isset($search_query)) {
                                        $stock_count = $stocks_db->count_stocks();
                                        foreach ($stock_count as $count) {
                                            $total = $count["Total"];                                            
                                        }

                                        $span = '
                                            <span class="badge bg-primary" style="background-color: #489EE7;" id="item_count">'.$total.'</span>
                                        ';
                                    }
                                    echo $span;
                                ?>
                            </h3>

                        </div>
                        <!-- /.panel-heading -->
                        <div class="text-left" style="margin-left: 20px;" title="Indicators">
                            <i><h6>Legends</h6></i>
                            <div class="legends yellow"></div>=&gt;<small>(Stocks in <span class="text-warning">yellow</span> is exactly less than 5 in quantity)</small>
                            <br/>
                            <br/>
                            <div class="legends red"></div>=&gt;<small>(Stocks in <span class="text-red">red</span> indicates 0 in quantity)</small>
                        </div>
                        <div class="panel-body">
                            <table width="100%" class="table table-bordered" id="item_list">
                                <thead>
                                    <tr>
                                        <th class="text-center">Name</th>                                        
                                        <th class="text-center">Description</th> 
                                        <th class="text-center">Location</th>
                                        <th class="text-center">Quantity</th>           
                                        <th class="text-center">Expire date</th>                                   
                                        <th id="action" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if (!isset($_GET["field_to_find"])) {
                                            $default_query = $stocks_db->get_all_items();   
                                            if (is_array($default_query) || is_object($default_query)) {
                                                foreach ($default_query as $stock) {
                                                    $tds .= create_stock($stock);
                                                }
                                            }
                                        } else {
                                            $default_query = $search_query;
                                            if (is_array($default_query) || is_object($default_query)) {
                                                foreach ($default_query as $stock) {
                                                    $tds .= create_filtered_stocks($stock);
                                                }
                                            }
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
    <div class="modal fade" id="delete-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <p>Do you want to delete this product?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-default" data-dismiss="modal" id="btnNo">Cancel</button>
                    <button type="button" class="btn btn-md btn-primary" data-dismiss="modal" id="btnYes">Delete</button>
                </div>
            </div>  
        </div>
    </div>

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
    var stock_id = 0;

    $(document).ready(function() {
        $('#item_list').DataTable({
            responsive: true,
            "order": [[ 0, "desc" ]]            
        });
    });

    function show_delete_modal(id){
        stock_id = id;
        $('#delete-modal').modal('show');
    }

    $('#btnYes').click(function(){
        document.location = 'remove_item.php?stock_id=' + stock_id;
    });

    $('#btnNo').click(function(){
        $('#delete-modal').modal('hide');
    })
    </script>
</body>

</html>
