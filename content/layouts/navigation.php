<script src="js/time.js"></script>
<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background:#489ee7;">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="dashboard.php" style="color:#fff;" title="Home">24 Beinte Quatro Minimart Co.</a>
    </div>
    <!-- /.navbar-header -->
    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown pull-right">                    
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="color:#fff;" id="user-icon">
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="dashboard.php"><i class="fa fa-home fa-fw"></i> Home</a>
                </li>
                <li class="divider"></li>
                <li><a href="logoff.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <li class="pull-right">
            <p id="time">
                <span id="date_time"></span>
                <script type="text/javascript">window.onload = date_time('date_time');</script>
            </p>
        </li>
        <!-- /.dropdown -->
    </ul>

    <div class="navbar-default sidebar" role="navigation" id="side-menu">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav">
                <li>
                    <a href="dashboard.php" data-toggle="collapse" data-target=".navbar-collapse"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                </li>
                <li>
                    <a href="manage_employee.php"><i class="fa fa-users"></i> Employees</a>
                </li>
                <li>
                    <a href="product.php"><i class="fa fa-shopping-cart"></i> Product</a>
                </li>
                <li>
                    <a href="stocks.php" data-toggle="collapse" data-target=".navbar-collapse"><i class="fa fa-hdd-o"></i> Stocks</a>
                </li>
                <?php
                    require_once 'class/Expired_Items.php';
                    require_once 'class/Functions.php';

                    $expired_items_db = new Expired_Items();

                    $count_expired_query = $expired_items_db->count_all_expired();
                    $li_element = '';
                    if ($count_expired_query['expired'] == 0) {
                        $li_element = '
                            <li>
                                <a href="#"><i class="glyphicon glyphicon-time"></i> Expiration <span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="expired_items.php"><span class="fa fa-hdd-o"></span> Expired Items</a>
                                    </li>
                                    <li>
                                        <a href="forcast_item_expired.php"><i class="fa fa-calendar"></i> Forcast Item Expiration</a>
                                    </li>                                
                                </ul>
                            </li>
                        ';
                    } else {
                        $li_element = '
                            <li>
                                <a href="#"><i class="glyphicon glyphicon-time"></i> Expiration <span class="label label-danger">!</span><span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="expired_items.php"><span class="fa fa-hdd-o"></span> Expired Items</a>
                                    </li>
                                    <li>
                                        <a href="forcast_item_expired.php"><i class="fa fa-calendar"></i> Forcast Item Expiration</a>
                                    </li>                                
                                </ul>
                            </li>

                        ';
                    }
                    echo $li_element;
                ?>
                <li>
                    <a href="supplier.php"><i class="fa fa-male"></i> Supplier</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-bar-chart fa-fw"></i> Reports<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="sales_report.php"><i class="fa fa-ruble"></i> Detailed Sales Report</a>
                        </li>
                        <li>
                            <a href="year_report.php"><i class="fa fa-list-alt"></i> Summary Report</a>
                        </li>

                        <li>
                            <a href="product_sales_report.php"><i class="fa fa-inbox"></i> Product Analytics Report</a>
                        </li>
                        <li>
                            <a href="summary_employees.php"><i class="fa fa-user"></i> Cashier Report</a>
                        </li>
                        <li>
                            <a href="detailed_summary_employees.php"><i class="fa fa-table"></i> Detailed Cashier Report</a>
                        </li>
                        <li>
                            <a href="item_issue_report.php"><i class="fa fa-shopping-cart"></i> Item Status Report</a>
                        </li>
                        <li>
                            <a href="expense.php"><i class="fa fa-save"></i> Expenses Report</a>
                        </li>
                        <li>
                            <a href="returns_report.php"><i class="fa fa-undo"></i> Defectives Report</a>
                        </li>
                        <li>
                            <a href="item_report.php"><i class="fa fa-reorder"></i> Item Report</a>
                        </li>

                        <li>
                            <a href="cashier_summaries.php"><i class="fa fa-rub"></i> Cashier Sales Summary</a>
                        </li>
                        <li>
                            <a href="summarized_report.php"><i class="fa fa-list-alt"></i> Summarize Report</a>
                        </li>

                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="sales.php"><i class="fa fa-file-text"></i> Sales Receipts</a>
                </li>
                <li>
                    <a href="return.php"><i class="fa fa-undo"></i> Defectives</a>
                </li>
                <li>
                    <a href="logoff.php"><i class="fa fa-power-off"></i> Logout</a>
                </li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>