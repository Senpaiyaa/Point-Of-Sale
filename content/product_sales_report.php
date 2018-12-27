<?php require_once 'layouts/report_header.php'; ?>
<?php
    require_once 'class/Functions.php';
    require_once 'class/Session.php';
    require_once 'class/Report.php';
    require_once 'class/helper.php';
    require_once 'class/Sales.php';
    require_once 'class/Product.php';
    require_once 'class/wp-db.php';

    $session = new Session();
    $report_db = new Report();
    $sales_db = new Sales();
    $product_db = new Product();

    if ($_SESSION["pos_user"] === null || $_SESSION["pos_staff"] === true) {
        redirect_to("error.php");
    }    

    $option_years = '';
    $start_year = 2017;
    $cur_year = date('Y');

    $year = (int)(_request('year',$cur_year));

    for($x=$start_year; $x<=$cur_year; $x++){
        $option_years.= option($x, $x, $year);
    }

    require_once('reports/product_sales/query.php');
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
                <form method="post" id="form">
                    <label>YEAR</label>
                    <select name="year"><?php echo $option_years; ?></select>
                    <button>Submit</button>
                </form>
                <h3 class="hidden-print">Reports - Product Analytics</h3>
                <div class="actions hidden-print">
                    <button class="btn btn-primary" onclick="javascript:print()"><i class="fa fa-print"></i> Print</button>
                </div>
                <div class="table-responsive">
                    <?php require_once('reports/product_sales/output.php'); ?>
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

    <script src="js/functions.js"></script>
    <script>
        var product_id = 0;

        function show_delete_modal(id){
            product_id = id;
            $('#delete-modal').modal('show');
        }

        $('#btnYes').click(function(){
            document.location = 'remove_product.php?product_id=' + product_id;
        });

        $('#btnNo').click(function(){
            $('#delete-modal').modal('hide');
        })

        $(document).ready(function() {
            $('#product_sales_report').DataTable({
                "order": [[ 13, "desc" ]],
                "pageLength": 50
            });
        });
    </script>
</body>

</html>
