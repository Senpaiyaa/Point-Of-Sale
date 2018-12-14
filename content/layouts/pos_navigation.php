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
        <a class="navbar-brand" href="dashboard.php" style="color:#fff;">24 Beinte Quatro Minimart Co.</a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown pull-right">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="color:#fff;" id="user-icon">
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
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

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="dashboard.php" data-toggle="collapse" data-target=".navbar-collapse"><i class="fa fa-dollar fa-fw"></i> Start Sale</a>
                </li>
                <li>
                    <a href="pos_searchTransaction.php"><i class="fa fa-search fa-fw"></i> Search Transaction</a>
                </li>
                <li>
                    <a href="viewProducts.php"><i class="fa fa-shopping-cart fa-fw"></i> View Products</a>
                </li>
                <li>
                    <a href="logoff.php"><i class="fa fa-power-off fa-fw" id="logoff"></i> Logout</a>
                </li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>