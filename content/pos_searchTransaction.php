<?php require_once 'layouts/sale_header.php'; ?>
<?php
    require_once 'class/Functions.php';
    require_once 'class/Session.php';
    require_once 'class/Sales.php';

    $session = new Session();
    $sales_db = new Sales();

    if ($_SESSION["pos_user"] === null || $_SESSION["pos_admin"] === true) {
        redirect_to("error.php");
    }

?>
<?php
    function create_sales($sales) {
        global $sales_db;

        $sales_id = $sales["sales_id"];
        $action = '<a href= "pos_salesDetails.php?sales_id='.$sales_id.'">View Details</a>';
        $html = '
            <tr id="'.$sales['sales_id'].'" class="td-sales">
                <td class="sales_id text-center">'.$sales_id.'</td>
                <td class="created_on text-center">' . $sales["created_on"] . '</td>
                <td class="text-center">' .$action  . '</td>
            </tr>';
        return $html;
    }
?>


    <div id="wrapper">

        <!-- include nav  -->
        <?php require_once 'layouts/pos_navigation.php'; ?>

        <div id="page-wrapper">
            <!-- <p>&nbsp;</p> -->
            <!-- <br> -->
            <span>&nbsp;</span>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>
                                List of Sales
                            </h3>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-bordered table-striped" id="sales_list">
                                <thead>
                                    <tr>
                                        <th class="text-center">Sales ID</th>
                                        <th class="text-center">Created On</th>
                                        <th class="text-center" id="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $query = $sales_db->get_sales();

                                        $tds = '';
                                        $td = '';
                                        foreach ($query as $sales) {
                                            $tds .= create_sales($sales);
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
    <div class="modal fade" id="logoff-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <p>Are you sure to logoff?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-default" data-dismiss="modal" id="logOffbtnNo">Cancel</button>
                    <button type="button" class="btn btn-md btn-primary" data-dismiss="modal" id="logOffbtnYes">Okay</button>
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

        function show_delete_modal(id){
            product_id = id;
            $('#delete-modal').modal('show');
        }


        function show_logoff_modal(){
            $('#logoff-modal').modal('show');
            $('#logOffbtnYes').click(function(){
                window.location.href='logoff.php';
            });
        }

        $(document).ready(function() {
            $('#sales_list').DataTable({
                responsive: true,
                "order": [[ 0, "desc" ]]
            });

            $('#btnYes').click(function(){
                document.location = 'remove_product.php?product_id=' + product_id;
            });

            $('#btnNo').click(function(){
                $('#delete-modal').modal('hide');
            })

            $('#keyboard_toggle').on('click', function() {
                $('#keyboardhelp').toggle();
            });

        });


    </script>

</body>

</html>
