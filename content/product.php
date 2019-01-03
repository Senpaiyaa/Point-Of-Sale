<?php require_once 'layouts/product_header.php'; ?>
<?php
    require_once 'class/Functions.php';
    require_once 'class/Stocks.php';
    require_once 'class/Manufacturer.php';
    require_once 'class/Category.php';
    require_once 'class/Product.php';
    require_once 'class/Session.php';

    $session = new Session();
    $manufacturer_db = new Manufacturer();
    $category_db = new Category();
    $product_db = new Product();

    $default_query = ""; 
    $tds = '';
    $td = '';
    $span = '';

    if ($_SESSION["pos_user"] === null || $_SESSION["pos_staff"] === true) {
        redirect_to("error.php");
    }    

?>
<?php
    function create_product($product) {
        global $manufacturer_db, $category_db;

        $product_id = $product["product_id"];
        $checkbox = '<input type="checkbox" name="product_id[]" value="'.$product_id.'" class="chk_product">';
        $edit = '<a id="edit" class="pointer pull-right" href="save_product.php?product_id='.$product_id.'"><span class="glyphicon glyphicon-pencil"></span> Edit</a>';
        $delete = '<a class="pointer pull-right link-red" style="margin-left: 15px;" onclick="show_delete_modal('.$product_id.')"><span class="glyphicon glyphicon-trash"></span> Delete</a>';

        $manufacturer = $manufacturer_db->get_manufacturer($product['manufacturer_id']);
        $category = $category_db->get_category($product['category_id']);

        $html = '
            <tr id="'.$product['product_id'].'" class="td-product">
                <td class="product_barcode text-center">' . $product["product_barcode"] . '</td>
                <td class="product_name text-center"><a href="view_item.php?product_id='.$product_id.'">' . $product["product_name"] . '</a></td>
                <td class="product_description text-center">' . $product["product_description"] . '</td>
                <td class="manufacturer_id text-center">' . $manufacturer["manufacturer_name"] . '</td>
                <td>' . $delete . $edit . '</td>
            </tr>';
        return $html;
    }

    function create_filtered_products($product) {
        $product_id = $product["id"];
        $edit = '<a id="edit" class="pointer pull-right" href="save_product.php?product_id='.$product_id.'"><span class="glyphicon glyphicon-pencil"></span> Edit</a>';
        $delete = '<a class="pointer pull-right link-red" style="margin-left: 15px;" onclick="show_delete_modal('.$product_id.')"><span class="glyphicon glyphicon-trash"></span> Delete</a>';

        $html = '
            <tr id="'.$product['id'].'" class="td-product">
                <td class="product_barcode text-center">' . $product["barcode"] . '</td>
                <td class="product_name text-center">' . $product["name"] . '</td>
                <td class="product_description text-center">' . $product["description"] . '</td>
                <td class="manufacturer_id text-center">' . $product["manufacturer_full_name"] . '</td>
                <td>' . $delete . $edit . '</td>
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

        if (escape($_GET["field_to_find"]) == "Product ID") {
            $search_this_item = (int) isset($_GET["item_to_search"]) ? escape($_GET["item_to_search"]) : null;
            $search_query = $product_db->product_search_by_product_id($search_this_item);
        }
        if (escape($_GET["field_to_find"]) == "Barcode") {
            $search_this_item = escape($_GET["item_to_search"]);
            $search_query = $product_db->product_search_by_barcode($search_this_item);
        }
        if (escape($_GET["field_to_find"]) == "Name") {
            $search_this_item = isset($_GET["item_to_search"]) ? escape($_GET["item_to_search"]) : null;
            $search_query = $product_db->product_search_by_name($search_this_item);
        }
        if (escape($_GET["field_to_find"]) == "Description") {
            $search_this_item = isset($_GET["item_to_search"]) ? escape($_GET["item_to_search"]) : null;
            $search_query = $product_db->product_search_by_description($search_this_item);
        }
        if (escape($_GET["field_to_find"]) == "Manufacturer") {
            $search_this_item = isset($_GET["item_to_search"]) ? escape($_GET["item_to_search"]) : null;
            $search_query = $product_db->product_search_by_manufacturer($search_this_item);
        }
        if (escape($_GET["field_to_find"]) == "Category") {
            $search_this_item = isset($_GET["item_to_search"]) ? escape($_GET["item_to_search"]) : null;
            $search_query = $product_db->product_search_by_category($search_this_item);
        }
        if (escape($_GET["field_to_find"]) == "Selling Price") {
            $search_this_item = (double) isset($_GET["item_to_search"]) ? escape($_GET["item_to_search"]) : null;
            $search_query = $product_db->product_search_by_selling_price($search_this_item);
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
                                    <option>Barcode</option>
                                    <option>Name</option>
                                    <option>Description</option>
                                    <option>Manufacturer</option>
                                    <option>Category</option>
                                    <option>Selling Price</option>
                                </select>
                            </li>
                            <li>
                                <button type="submit" class="btn btn-primary" name="advance_search"><span class="fa fa-search"></span> Search</button>
                            </li>
                            <li class="li-right">
                                <a href="save_product.php" class="btn btn-primary btn-sm hidden-sm hidden-xs" id="btnAddProduct">
                                    <span>New Product</span>
                                </a>
                                <!-- <a class="btn btn-more dropdown-toggle item_config" type="button" data-toggle="dropdown" aria-expanded=false>
                                    <i class="glyphicon glyphicon-list"></i>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>test</li>
                                </ul> -->
                                <ul class="nav navbar-right item_config">
                                    <li class="dropdown pull-right ">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class="visible-sm visible-xs">
                                                <a href="save_product.php"><i class="glyphicon glyphicon-plus"></i> Add New Product </a>
                                            </li>
                                            <li class="divider hidden-md hidden-lg"></li>
                                            <li><a href="manage_category.php"><i class="fa fa-folder-open"></i> Manage categories</a>
                                            </li>
                                            <li class="divider"></li>
                                            <li><a href="manage_manufacturer.php"><i class="fa fa-gears"></i> Manage manufacturers</a>
                                            </li>
                                            <!--<li><a href="#"><i class="glyphicon glyphicon-list-alt"></i> Count inventory</a>
                                            </li>-->
                                        </ul>
                                        <!-- /.dropdown-menu -->
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
                                List of Product
                                <?php
                                    if (!isset($search_query)) {
                                        $product_count = $product_db->count_all_product();
                                        foreach ($product_count as $count) {
                                            $total = $count["Total"];                                            
                                        }

                                        $span = '
                                            <span class="badge bg-primary" style="background-color: #489EE7;" id="product_count">'.$total.'</span>
                                        ';
                                    }
                                    echo $span;
                                ?>  
                            </h3>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-bordered table-striped" id="product_list">
                                <thead>
                                    <tr>
                                        <th class="text-center">Barcode</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">Manufacturer</th>
                                        <th id="action" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if (!isset($_GET["field_to_find"])) {
                                            $default_query = $product_db->get_all_product();   
                                            if (is_array($default_query) || is_object($default_query)) {
                                                foreach ($default_query as $product) {
                                                    $tds .= create_product($product);
                                                }
                                            }
                                        } else {
                                            $default_query = $search_query;
                                            if (is_array($default_query) || is_object($default_query)) {
                                                foreach ($default_query as $product) {
                                                    $tds .= create_filtered_products($product);
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
    <script>
    var product_id = 0;

    $(document).ready(function() {
        $('#product_list').DataTable({
            responsive: true,
            "order": [[ 0, "desc" ]]
        });
    });
    
    $('#btnYes').click(function(){
        document.location = 'remove_product.php?product_id=' + product_id;
    });

    $('#btnNo').click(function(){
        $('#delete-modal').modal('hide');
    })

    function show_delete_modal(id){
        product_id = id;
        $('#delete-modal').modal('show');
    }

    function show_item_modal(id) {
        product_id = id;
        $('#view_item').modal('show');
    }
    </script>
</body>

</html>
