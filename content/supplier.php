<?php require_once 'layouts/supplier_header.php'; ?>
<?php
    require_once 'class/Functions.php';
    require_once 'class/Session.php';
    require_once 'class/Supplier.php';
    require_once 'class/helper.php';
    require_once 'class/wp-db.php';

    $supplier_db = new Supplier();
    $session = new Session(); 

    if ($_SESSION["pos_user"] === null || $_SESSION["pos_staff"] === true) {
        redirect_to("error.php");
    }    

?>
<?php
    function create_supplier($supplier) {
        $supplier_id = $supplier["supplier_id"];
        $checkbox = '<input type="checkbox" name="supplier_id[]" value="'.$supplier_id.'" class="chk_supplier">';
        $edit = '<a id="edit" class="pointer pull-right" href="save_supplier.php?supplier_id='.$supplier_id.'"><span class="glyphicon glyphicon-pencil"></span> Edit</a>';
        $delete = '<a class="pointer pull-right link-red" style="margin-left: 15px;" onclick="show_delete_modal('.$supplier_id.')"><span class="glyphicon glyphicon-trash"></span> Delete</a>';
        $email = $supplier["email"];
        $mail = '<a href="mailto:' . $email . '"> ' . $email . ' </a>';
        $html = '
            <tr id="'.$supplier['supplier_id'].'" class="td-supplier">
                <td class="supplier_name"><a href="view_supplier.php?supplier_id='.$supplier_id.'">' . $supplier["supplier_name"] . '</a></td>
                <td class="email">' . $mail . '</td>
                <td class="contact">' . $supplier["phone_number"] . '</td>
                <td class="address">' . $supplier["address"] . '</td>

                <td>' . $delete . $edit . '</td>
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
                                List of Supplier
                                <div class="pull-right btn_options">
                                    <a href="save_supplier.php" class="btn btn-primary hidden-sm hidden-xs" id="btnAddItem">
                                        <span>New Supplier</span>
                                    </a>
                                    <!-- <a class="btn btn-more dropdown-toggle item_config" type="button" data-toggle="dropdown" aria-expanded=false>
                                        <i class="glyphicon glyphicon-list"></i>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>test</li>
                                    </ul> -->
                                    <ul class="nav navbar-right item_config">
                                        <li class="dropdown pull-right visible-sm visible-xs">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                                <i class="glyphicon glyphicon-option-horizontal"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="visible-sm visible-xs">
                                                    <a href="save_supplier.php"><i class="glyphicon glyphicon-plus"></i> Add New Supplier </a>
                                                </li>
                                            </ul>
                                            <!-- /.dropdown-menu -->
                                        </li>
                                        <!-- /.dropdown -->
                                    </ul>
                                </div>
                            </h3>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-hover" id="supplier_list">
                                <thead>
                                    <tr>
                                        <th>Supplier Name</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Address</th>
                                        <th id="action" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $query = $supplier_db->get_all_supplier();

                                        $tds = '';
                                        $td = '';
                                        foreach ($query as $supplier) {
                                            $tds .= create_supplier($supplier);
                                        }

                                        $td .= $tds;

                                        if (empty($query)) {
                                            $td = '
                                                <div class="text-center text-warning">
                                                    <h3>There are no items found.</h3>
                                                </div>';
                                        }

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
                    <p>Do you want to delete this supplier?</p>
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
    function show_delete_modal(id){
        supplier_id = id;
        $('#delete-modal').modal('show');
    }

    $('#btnYes').click(function(){
        document.location = 'remove_supplier.php?supplier_id=' + supplier_id;
    });

    $(document).ready(function() {
        $('#supplier_list').DataTable({
            responsive: true,
            "order": [[ 0, "desc" ]]            
        });

    });
    </script>
</body>

</html>
