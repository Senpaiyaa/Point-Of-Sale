<?php require_once 'layouts/return_header.php'; ?>
<?php
    require_once 'class/Functions.php';
    require_once 'class/Session.php';
    require_once 'class/Returns.php';

    $returns_db = new Returns();
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
    function create_return($return) {
        $return_id = $return["return_id"];
        $delete = '<a class="pointer link-red " style="margin-left: 15px;" onclick="show_delete_modal('.$return_id.')"><span class="glyphicon glyphicon-trash"></span> Delete</a>';

        $delete = '<a class="pointer pull-right link-red" style="margin-left: 15px;" onclick="show_delete_modal('.$return_id.')"><span class="glyphicon glyphicon-trash"></span> Delete</a>';

        $html = '
            <tr id="'.$return_id.'" class="td-return">
                <td class="item_name text-center">' . $return["item_name"] . '</td>
                <td class="quantity text-center">' . $return["quantity"] . '</td>
            </tr>';            
        return $html;
    }

?>
    <div id="wrapper">

        <!-- include nav  -->
        <?php require_once 'layouts/navigation.php'; ?>

        <div id="page-wrapper">
            <span>&nbsp;</span>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>List of Defective Items</h3>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-hover" id="return_list">
                                <thead>
                                    <tr>
                                        <th class="text-center">Item Name</th> 
                                        <th class="text-center">Quantity</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $default_query = $returns_db->get_returned_items();   
                                        if (is_array($default_query) || is_object($default_query)) {
                                            foreach ($default_query as $items) {
                                                $tds .= create_return($items);
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
                    <p>Do you want to delete this item?</p>
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
        $('#return_list').DataTable({
            responsive: true,
            "order": [[ 0, "desc" ]]            
        });
    });

    function show_delete_modal(id){
        stock_id = id;
        $('#delete-modal').modal('show');
    }

    $('#btnYes').click(function(){
        document.location = 'remove_returns.php?return_id=' + stock_id;
    });

    $('#btnNo').click(function(){
        $('#delete-modal').modal('hide');
    });
    </script>
</body>

</html>
