<?php require_once 'layouts/report_header.php'; ?>
<?php
    require_once 'class/Functions.php';
    require_once 'class/Session.php';
    require_once 'class/Report.php';
    require_once 'class/helper.php';
    require_once 'class/Sales.php';
    require_once 'class/Staff.php';

    $session = new Session();
    $report_db = new Report();
    $sales_db = new Sales();
    $staff_db = new Staff();

    if ($_SESSION["pos_user"] === null || $_SESSION["pos_staff"] === true) {
        redirect_to("error.php");
    }    

    $start_date_formatted = isset($_GET['start_date_formatted']) ? escape($_GET['start_date_formatted']) : "";
    $end_date_formatted = isset($_GET['end_date_formatted']) ? escape($_GET['end_date_formatted']) : "";

    if (isset($_GET["submit"])) {
        $from = escape($_GET["start_date_formatted"]);
        $to = escape($_GET["end_date_formatted"]);
        $query = $sales_db->generate_summary_employees($from, $to);
        $output = "";
        $th = "";
        $final_total = null;
        foreach ($query as $data) {
            $employee = $data['staff_name'];
            $total_sales = number_format($data['total_sales'], 2, '.', ',');
            $date = $data['created_on'];
            $final_total += $data['total_sales'];

            $output.= "<tr>
                <td class='col-md-2'>{$employee}</td>
                <td class='col-md-2'>&#8369; {$total_sales}</td>

                </tr>";
        }
        $output.="
            <table class='table table-bordered'>
                <tbody>
                    <tr>
                        <td class='col-md-2'>Total:</td>
                        <td class='col-md-2' style='font-size:15px;'><strong>&#8369; ".number_format($final_total,2,'.',',')."</strong></td>
                    </tr>
                </tbody>
            </table>
        ";

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
                    <form class="form-horizontal hidden-print" method="get">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="range" class="col-sm-3 col-md-3 col-lg-2 control-label">Custom Date Range:</label>
                                    <div class="col-sm-9 col-md-9 col-lg-10">
                                        <div class="row">
                                            <div class="col-md-6" >
                                                <div class="input-group input-daterange">
                                                    <span class="input-group-addon-bg">From</span>
                                                    <input class="form-control" id="start_date_formatted" type="text" value="<?php echo $start_date_formatted;?>" name="start_date_formatted" readonly='true'>
                                                </div>
                                            </div>
                                            <div class="col-md-6" >
                                                <div class="input-group input-daterange">
                                                    <span class="input-group-addon-bg">To</span>
                                                    <input class="form-control" id="end_date_formatted" type="text" value="<?php echo $end_date_formatted;?>" name="end_date_formatted" readonly='true'>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions pull-right">
                                    <input name="submit" type="submit" id="generate_report" class="btn btn-primary submit_button btn-large" value="Submit"></input>
                                </div>

                            </div>
                            
                        </div>
                    </form>
                    <div class="panel panel-default">
                        <div class="panel-heading">Reports - Cashier Report <small class="reports-range"><?php if(isset($from) && isset($to)){echo $from . " - ". $to; }?></small></div>
                        <div class="actions" style="margin: 10px;">
                            <button class="btn btn-primary hidden-print" onclick="javascript:print()"><i class="fa fa-print"></i> Print</button>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered table-striped" style="table-layout:fixed;">
                                <thead>
                                    <tr>
                                        <th class="text-center">Employee</th>
                                        <th class="text-center">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if (isset($output)) {
                                            echo $output;
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->   
                            <div class="text-center">
                                <button class="btn btn-primary hidden-print" onclick="javascript:print()"><i class="fa fa-print"></i> Print</button>
                            </div>
                        </div>
                    </div>
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
    <script src="vendor/jquery-ui-1.12.1/jquery-ui.js"></script>
    <script src="js/functions.js"></script>
    <script>
    $(document).ready(function() {
        $('#employees_report').DataTable({
            responsive: true,
            "order": [[ 0, "desc" ]]
        });

        // datepicker method
        $('#start_date_formatted, #end_date_formatted').datepicker({
            dateFormat: 'yy-mm-dd'
        });

    });

    </script>
</body>

</html>
