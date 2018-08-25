<?php require_once 'layouts/dashboard_header.php'; ?>
<?php
    require_once 'class/Functions.php';
    require_once 'class/Session.php';

    $session = new Session();
    $start_year = 2017;
    $cur_year = date('Y');

    if ($_SESSION["pos_user"] === null) {
        redirect_to("error.php");
    }    

    if ($_SESSION['pos_staff'] === true) {
        redirect_to("save_sales.php");
    }
?>
    <div id="wrapper">
        <?php require_once 'layouts/navigation.php'; ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <!-- <h1 class="page-header">Dashboard</h1> -->
                    <p class="page-header">Dashboard</p>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-male fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
                                        <?php
                                            require_once 'class/Supplier.php';
                                            $supplier_db = new Supplier();
                                            $supplier_count = $supplier_db->count_supplier();
                                            foreach ($supplier_count as $count) {
                                                $total = $count["Total"];                                            
                                            }

                                            echo $total;
                                        ?>
                                    </div>
                                    <div>Suppliers</div>
                                </div>
                            </div>
                        </div>
                        <a href="supplier.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
                                        <?php
                                            require_once 'class/Employee.php';
                                            $employee_db = new Employee();
                                            $employee_count = $employee_db->count_employee();

                                            foreach ($employee_count as $count) {
                                                $total = $count["Total"];
                                            }

                                            echo $total;
                                        ?>
                                    </div>
                                    <div>Employees</div>
                                </div>
                            </div>
                        </div>
                        <a href="manage_employee.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-hdd-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge" id="total_items">
                                        <?php
                                            require_once 'class/Stocks.php';
                                            $stocks_db = new Stocks();
                                            $stock_count = $stocks_db->count_all_items();
                                            foreach ($stock_count as $count) {
                                                $total = $count["Total"];                                            
                                            }

                                            echo $total;
                                        ?>
                                    </div>
                                    <div>Total Items</div>
                                </div>
                            </div>
                        </div>
                        <a href="stocks.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
                                        <?php
                                            require_once 'class/Sales.php';
                                            require_once 'class/Functions.php';
                                            $sales_db = new Sales();
                                            $sales_count = $sales_db->count_all_sales();
                                            foreach ($sales_count as $count) {
                                                $total = $count["Total"];                                            
                                            }

                                            echo $total;
                                        ?>
                                    </div>
                                    <div>Total Sales</div>
                                </div>
                            </div>
                        </div>
                        <a href="sales.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row quick-actions">
                <h5 class="text-center">Welcome to 24 Beinte Quatro Minimart Co., choose a common task below to start!</h5>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="list-group">
                            <?php
                                $start_date_formatted = date('Y-m-d');
                            ?>
                            <a class="list-group-item" href="detailed_sales.php?start_date_formatted=<?php echo $start_date_formatted;?>"> <i class="fa fa-calendar-o"></i> Today's detailed sales report</a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="list-group">
                            <a class="list-group-item" href="sales_report.php"> <i class="fa fa-bar-chart"></i> Search sales report</a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="list-group">
                            <a class="list-group-item" href="year_report.php"> <i class="fa fa-list-alt"></i> Sales summary</a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="list-group">
                            <a class="list-group-item" href="product_sales_report.php"> <i class="glyphicon glyphicon-list-alt"></i> Product analytics</a>
                        </div>
                    </div>

                </div>
                <!-- /.row -->

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

    <!-- Morris Charts JavaScript -->
    <script src="vendor/raphael/raphael.min.js"></script>
    <!-- <script src="vendor/morrisjs/morris.min.js"></script> -->
    <!-- <script src="data/morris-data.js"></script> -->

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>
    <script src="js/functions.js"></script>

</body>

</html>
