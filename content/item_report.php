<?php require_once 'layouts/report_header.php'; ?>
<?php
    require_once 'class/Functions.php';
    require_once 'class/Session.php';
    require_once 'class/Report.php';
    require_once 'class/helper.php';
    require_once 'class/Stocks.php';

    $session = new Session();
    $report_db = new Report();
    $stocks_db = new Stocks();

    if ($_SESSION["pos_user"] === null || $_SESSION["pos_staff"] === true) {
        redirect_to("error.php");
    }    

        $query = $stocks_db->order(5);

        $output = "";

        foreach ($query as $data) {
            $output.= "
                <tr>
                    <td class='col-sm-1 text-center'> {$data['stock_id']}</td>
                    <td class='col-sm-1 text-center'> {$data['product_name']}</td>
                    <td class='col-sm-1 text-center'> {$data['quantity']}</td>
                    <td class='col-sm-1 text-center'> {$data['description']}</td>
                    <td class='col-sm-1 text-center'> {$data['barcode']}</td>

                </tr>";
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
                        <div class="panel-heading">Reports - Items Report <small class="reports-range"><?php if(isset($from) && isset($to)){echo $from . " - ". $to; }?></small></div>
                        <div class="actions" style="margin: 10px;">
                            <button class="btn btn-primary hidden-print" onclick="javascript:print()"><i class="fa fa-print"></i> Print</button>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered table-striped" style="table-layout:fixed;">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID</th>          
                                        <th class="text-center">Product Name</th> 
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">Barcode</th>   
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
</body>

</html>
