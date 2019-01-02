<?php require_once 'layouts/sale_header.php'; ?>
<?php
    require_once 'class/Functions.php';
    require_once 'class/Session.php';
    require_once 'class/Sales.php';
    require_once 'class/Staff.php';

    $session = new Session();
    $sales_db = new Sales();
    $staff_db = new Staff();

    if ($_SESSION["pos_user"] === null || $_SESSION["pos_staff"] === true) {
        redirect_to("error.php");
    }    

?>
<?php
    function create_sales($sales) {
        global $sales_db, $staff_db;

        $sales_id = $sales["sales_id"];
        $action = '<a href= "sales_details.php?sales_id='.$sales_id.'">View Details</a>';

        $staff = $staff_db->get_staff($sales["staff_id"]);
        $name = $staff_db->get_staff_full_name($sales["staff_id"]);
        $html = '
            <tr id="'.$sales['sales_id'].'" class="td-sales">
                <td class="created_on text-center">' . $sales["created_on"] . '</td>
                <td class="total_sales text-center">&#8369; ' . number_format($sales["total_sales"], 2, ".", ",")  . '</td>
                <td class="amount_paid text-center">&#8369; ' . number_format($sales["amount_paid"], 2, ".", ",") . '</td>
                <td class="amount_change text-center">&#8369; ' . number_format($sales["amount_change"], 2, ".", ",") . '</td>
                <td class="employee text-center">'.$name["full_name"].'</td>
                <td class="text-center">' .$action  . '</td>
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
                            <h3>List of Receipts</h3>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-bordered table-striped" id="sales_list">
                                <thead>
                                    <tr>
                                        <th class="text-center">Created On</th>
                                        <th class="text-center">Total Sales</th>
                                        <th class="text-center">Amount Paid</th>
                                        <th class="text-center">Amount Change</th>
                                        <th class="text-center">Employee</th>
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
        $('#sales_list').DataTable({
            responsive: true,
            "order": [[ 0, "desc" ]]
        });
    });
    </script>
</body>

</html>
