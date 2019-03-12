    <?php require_once 'layouts/report_header.php'; ?>
<?php
    require_once 'class/Functions.php';
    require_once 'class/Session.php';
    require_once 'class/Report.php';
    require_once 'class/helper.php';
    require_once 'class/Sales.php';
    require_once 'class/Staff.php';
    require_once 'class/Employee.php';

    $session = new Session();
    $report_db = new Report();
    $sales_db = new Sales();
    $staff_db = new Staff();
    $employee_db = new Employee();

    if ($_SESSION["pos_user"] === null || $_SESSION["pos_staff"] === true) {
        redirect_to("error.php");
    }    

    $start_date_formatted = isset($_GET['start_date_formatted']) ? escape($_GET['start_date_formatted']) : "";
    $end_date_formatted = isset($_GET['end_date_formatted']) ? escape($_GET['end_date_formatted']) : "";

    if (isset($_GET["submit"])) {
        $employee = escape($_GET["employee"]);
        $query = $sales_db->filter_cashier_by_employee($employee);
        $output = "";
        $total_qty=null;
        $final_total = null;
        foreach ($query as $data) {
            $total_qty+=$data['quantity'];
            $final_total+=$data['total'];
            $format_total = number_format($data['total'],2,'.',',');
            $output.= "<tr>
                <td class='col-sm-1'>{$data['product_name']}</td>
                <td class='col-sm-1'>{$data['created_date']}</td>
                <td class='col-sm-1'>{$data['quantity']}</td>
                <td class='col-sm-1'>&#8369; {$format_total}</td>
                </tr>";
        }
        $format = array(
            'total_qty' => number_format($total_qty,2,'.',','),
            'final_total' => number_format($final_total,2,'.',',') 
            );
        $output.="
            <table class='table table-bordered' style='table-layout:fixed;'>
                <tbody>
                    <tr>
                        <td class='col-sm-1'>Total:</td>
                        <td class='col-sm-1'></td>
                        <td class='col-sm-1' style='font-size:15px;'><strong>{$format['total_qty']}</strong></td>
                        <td class='col-sm-1' style='font-size:15px;'><strong>&#8369; {$format['final_total']}</strong></td>

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
                    <form class="form-horizontal hidden-print" method="get" style="margin-bottom: 10px;">

                        <div class="form-group">
                            <label for="employee" class="col-sm-3 col-md-3 col-lg-2 control-label">Employee:</label>
                            <div class="col-sm-9 col-md-2 col-lg-2">
                                <select class="form-control" name="employee">
                                    <?php
                                        $employees = $employee_db->get_all_employee();
                                        $option = "";
                                        foreach ($employees as $employee) {
                                            $display = strtoupper($employee['username']);
                                            $option.= option($display, $employee['staff_id']);
                                        }
                                        echo $option;
                                    ?>                                            
                                </select>
                            </div>
                            <span>
                                <div class="form-actions" style="">
                                    <input name="submit" type="submit" id="generate_report" class="btn btn-primary submit_button btn-large" value="Submit"></input>
                                </div>
                                
                            </span>

                        </div>


                    </form>
                    <div class="panel panel-default">
                        <div class="panel-heading">Reports - Detailed Employees Report <small class="reports-range"><?php if(isset($from) && isset($to)){echo $from . " - ". $to; }?></small></div>
                        <div class="actions" style="margin: 10px;">
                            <button class="btn btn-primary hidden-print" onclick="javascript:print()"><i class="fa fa-print"></i> Print</button>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered table-striped" style="table-layout:fixed;">
                                <thead>
                                    <tr>
                                        <th class="text-center">Product Name</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Quantity</th> 
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
