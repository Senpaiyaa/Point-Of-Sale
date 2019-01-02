<?php require_once 'layouts/report_header.php'; ?>
<?php
    require_once 'class/Functions.php';
    require_once 'class/Session.php';
    require_once 'class/Report.php';
    require_once 'class/helper.php';
    require_once 'class/Sales.php';

    $session = new Session();
    $report_db = new Report();
    $sales_db = new Sales();

    if ($_SESSION["pos_user"] === null || $_SESSION["pos_staff"] === true) {
        redirect_to("error.php");
    }    

    $start_date_formatted = isset($_GET['start_date_formatted']) ? escape($_GET['start_date_formatted']) : "";
    $end_date_formatted = isset($_GET['end_date_formatted']) ? escape($_GET['end_date_formatted']) : "";

    if (isset($start_date_formatted)) {
        $date = $start_date_formatted;
        $query = $sales_db->todays_detailed_sales_report($date);

        $output = "";
        $final_total = 0;
        $quantity_sold = 0;
        $selling_price = 0;
        $cost_price = 0;
        $total_profit = 0;

        foreach ($query as $data) {
            $total_sold = number_format($data['total_sold'], 2, '.', ',');
            $price = number_format($data['selling_price'], 2, '.', ',');
            $cost = number_format($data['cost_price'], 2, '.', ',');
            $selling = $data['selling_price'];
            $final_total += $data['total_sold'];
            $quantity_sold += $data['quantity'];
            $selling_price += $data['selling_price'];
            $cost_price += $data['cost_price'];
            $profit = ($selling_price - $cost_price);
            $total_profit += $profit;

            $output.= "
                <tr>
                    <td class='col-sm-1'>{$data['product_name']}</td>
                    <td class='col-sm-1 text-center'>{$data['quantity']}</td>
                    <td class='col-sm-1 text-center'>&#8369; {$total_sold}</td>
                    <td class='col-sm-1 text-center'>&#8369; {$price}</td>
                    <td class='col-sm-1 text-center'>&#8369; {$cost}</td>
                    <td class='col-sm-1 text-center'>&#8369; {$profit}</td>
                </tr>";
        }
        $format = array(
                    'final_total' => number_format($final_total,2,'.',','),
                    'selling_price' => number_format($selling_price,2,'.',','),
                    'cost_price' => number_format($cost_price,2,'.',','),
                    'total_profit' => number_format($total_profit,2,'.',',')
                );
        $output.="
            <table class='table table-bordered' style='table-layout:fixed;'>
                <tbody>
                    <tr>
                        <td class='col-sm-1'>Total:</td>
                        <td class='col-sm-1 text-center' style='font-size: 15px;'><strong>{$quantity_sold}</strong></td>
                        <td class='col-sm-1 text-center' style='font-size: 15px;'><strong>&#8369; {$format['final_total']}</strong></td>
                        <td class='col-sm-1 text-center' style='font-size: 15px;'><strong>&#8369; {$format['selling_price']}</strong></td>
                        <td class='col-sm-1 text-center' style='font-size: 15px;'><strong>&#8369; {$format['cost_price']}</strong></td>
                        <td class='col-sm-1 text-center' style='font-size: 15px;'><strong>&#8369; {$format['total_profit']}</strong></td>
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
                    <div class="panel panel-default">
                        <div class="panel-heading">Reports - Today's Sales Report <small class="reports-range"><?php if(isset($from) && isset($to)){echo $from . " - ". $to; }?></small></div>
                        <div class="actions" style="margin: 10px;">
                            <button class="btn btn-primary hidden-print" onclick="javascript:print()"><i class="fa fa-print"></i> Print</button>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered table-striped" style="table-layout:fixed;">
                                <thead>
                                    <tr>
                                        <th class="text-center">Item Name</th>          
                                        <th class="text-center">Quantity Sold</th> 
                                        <th class="text-center">Total Sold</th>
                                        <th class="text-center">Selling Price</th>
                                        <th class="text-center">Cost Price</th>   
                                        <th class="text-center">Profit</th>
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
        $('#sales_list').DataTable({
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
