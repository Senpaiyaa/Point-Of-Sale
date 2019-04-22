<?php require_once 'layouts/report_header.php'; ?>
<?php
    require_once 'class/Functions.php';
    require_once 'class/Session.php';
    require_once 'class/Returns.php';

    $returns_db = new Returns();
    $session = new Session();

    if ($_SESSION["pos_user"] === null || $_SESSION["pos_staff"] === true) {
        redirect_to("error.php");
    }    

    $start_date_formatted = isset($_GET['start_date_formatted']) ? escape($_GET['start_date_formatted']) : "";
    $end_date_formatted = isset($_GET['end_date_formatted']) ? escape($_GET['end_date_formatted']) : "";

    if (isset($_GET["submit"])) {
        $from = escape($_GET["start_date_formatted"]);
        $to = escape($_GET["end_date_formatted"]);
        $query = $returns_db->generate_return_report($from, $to);

        // debug($query);
        $output = "";
        $final_total = null;
        $total_qty = null;
        foreach ($query as $data) {
            $item = $data['item_name'];
            $quantity = $data['quantity'];
            $price = number_format($data['price'], 2, '.', ','); 
            $status = $data['status'];
            $date = $data['created_date'];
            $total_qty += $quantity;
            $final_total += $price;
            $output.= "<tr>
                <td class='col-sm-1'>{$item}</td>
                <td class='col-sm-1'>{$quantity}</td>
                <td class='col-sm-1'>&#8369; {$price}</td>
                <td class='col-sm-1'>{$status}</td>
                <td class='col-sm-1'>{$date}</td>
                <td class='col-sm-1'>{$data['reason']}</td>
                </tr>";
        }
        $output.="
            <table class='table table-bordered' style='table-layout:fixed;'>
                <tbody>
                    <tr>
                        <td class='col-md-2'>Total:</td>
                        <td class='col-md-2' style='font-size:15px;'><strong>{$total_qty}</strong></td>
                        <td class='col-md-2' style='font-size:15px;'><strong>&#8369; ".number_format($final_total, 2, '.', ',')."</strong></td>
                        <td class='col-md-2'></td>
                        <td class='col-md-2'></td>
                        <td class='col-md-2'></td>

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
                        <div class="panel-heading">Report - Defectives <small class="reports-range"><?php if(isset($from) && isset($to)){echo $from . " - ". $to; }?></small></div>
                        <div class="actions" style="margin: 10px;">
                            <button class="btn btn-primary hidden-print" onclick="javascript:print()"><i class="fa fa-print"></i> Print</button>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered table-striped" style="table-layout:fixed;">
                                <thead>
                                    <tr>
                                        <th class="text-center">Product</th>          
                                        <th class="text-center">Quantity</th> 
                                        <th class="text-center">Amount</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Remarks</th>
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
        $('#expense_table').DataTable({
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
