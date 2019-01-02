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

    $start_date = date("Y-m-d");
    $end_date = date("Y-m-d");
    $start_day = date("Y-m-d", strtotime('monday this week'));   
    $end_day = date("Y-m-d", strtotime('sunday this week'));
    $start_year = 2017;
    $cur_year = date('Y');
    $day = _request('day');
    $month_option = _request('month_option');
    $range_option = _request('range_option');
    $option_to_months = null;
    $option_years = '';
    $curMonth = date("m", time());
    $curQuarter = ceil($curMonth/3);

    $year = (int)(_request('year',$cur_year));

    for($x=$start_year; $x<=$cur_year; $x++){
        $option_years.= option($x, $x, $year);
    }

    for($x=1; $x<=12; $x++){
        $option_to_months.= option(date('F', mktime(0, 0, 0, $x, 10)), $x, $month_option);
    }

    require_once('reports/sales/query.php');
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
                <form method="post" id="form" class="hidden-print">
                <div class="col-md-12">
                <!--<div class="date-entry" style="display:none;">
                    <a data-toggle="collapse" href="#date"><i class="fa fa-plus"></i> Date entry</a>
                    <div id="date" class="collapse">
                        <div class="form-group">
                            <label for="day" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Day:</label>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <input name="day" id="day" class="form-control" type="text">
                            </div>
                        </div>                                            
                    </div>
                    
                </div>-->
                    
                </div>
                    <label>OPTION</label>
                    <select name="range_option" id="range_option">
                        <option value="daily">Daily</option>
                        <option value="this_week">This Week</option>
                        <option value="monthly">Monthly</option>
                        <!-- <option value="quarterly">Quarterly</option> -->
                        <option value="yearly">Yearly</option>
                    </select>
                    <span id="month_option" style="display:none;">
                        <label>MONTH</label>
                        <select name="month_option">
                            <?php echo $option_to_months; ?>
                        </select>                        
                    </span>
                    <span id="year_option" style="display:none;">
                        <label>YEAR</label>
                        <select name="year"><?php echo $option_years; ?></select>                        
                    </span>
                    <button>Submit</button>
                </form>
                <!-- <form method="post" id="form">
                    <div class="form-group">
                        <div class="col-sm-9 col-md-9 col-lg-10">
                            <div class="row">
                                <div class="col-md-6" style="padding-bottom: 20px;">
                                    <span class="input-group">
                                        From
                                    </span>
                                    <input name="start_date_formatted" value="<?php echo $start_date.' 00:00'; ?>" id="start_date" class="form-control" type="text">
                                    <input type="hidden" name="start_date" value="<?php echo $start_date.' 00:00'; ?>">
                                </div>
                                <div class="col-md-6" style="padding-bottom: 20px;">
                                    <span class="input-group">
                                        To
                                    </span>
                                    <input name="end_date_formatted" value="<?php echo $start_date.' 23:59'; ?>" id="end_date" class="form-control" type="text">
                                    <input type="hidden" name="end_date" value="<?php echo $end_date.' 23:59'; ?>">
                                </div>
                                <div class="form-actions">
                                    <input type="submit" name="submit" class="submit_button floating_button btn btn-primary" value="Submit" id="submit">
                                </div>
                            </div>
                        </div>
                    </div>
                </form> -->
                <div class="actions">
                    <button class="btn btn-primary hidden-print" onclick="javascript:print()"><i class="fa fa-print"></i> Print</button>
                </div>
                <?php require_once('reports/sales/output.php'); ?>

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

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
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
        $('#sales_list').DataTable({
            responsive: true,
            "order": [[ 0, "desc" ]]
        });

        $('#start_date, #end_date, #day').datepicker({
            dateFormat: 'yy-mm-dd'
        });

        if ($('#range_option').val() == "daily") {
                $('#month_option').show();   
                $('#year_option').show(); 
        }

        $('#range_option').on('change', function(){
            if ($('#range_option').val() == "daily") {
                $('#month_option').show();
            }
            if($('#range_option').val() == "this_week") {
                $('#month_option').hide();
                $('#year_option').hide();                
            }
            if ($('#range_option').val() == "monthly") {
                $('#month_option').hide();
            }
            if ($('#range_option').val() == "quarterly") {
                $('#month_option').hide();

            }

            if ($('#range_option').val() == "yearly") {
                $('#month_option').hide();
                $('#year_option').hide();
            }
        });
    });

    // $('#form').submit(function() {
    //     log($('#start_date').val());
    //     log($('#end_date').val());
    //     return false;
    // });
    </script>
</body>

</html>
