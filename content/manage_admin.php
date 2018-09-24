<?php require_once 'layouts/employees_header.php'; ?>
<?php
    require_once 'class/Functions.php';
    require_once 'class/Session.php';
    require_once 'class/Admin.php';

    $admin_db = new Admin();
    $session = new Session();

    if ($_SESSION["pos_user"] === null || $_SESSION["pos_staff"] === true) {
        redirect_to("error.php");
    }    

?>
<?php
    function create_admin($admin) {
        $admin_id = $admin["admin_id"];
        $username = $admin["username"];
        $password = $admin["password"];
        $html = '
            <tr id="'.$admin['admin_id'].'" class="td-admin">
                <td class="username text-center">' . $admin["username"] . '</td>
                <td class="password text-center">' . $admin["password"] . '</td>
            </tr>';
        return $html;
    }
?>
    <div id="wrapper">

        <!-- include nav  -->
        <?php require_once 'layouts/navigation.php'; ?>

        <div id="page-wrapper">
            <span>&nbsp;</span>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>
                                List of Administrators
                                <div class="pull-right btn_options">
                                    <a href="new_admin.php" class="btn btn-primary hidden-sm hidden-xs" id="btnAddItem">
                                        <span>New Admin</span>
                                    </a>
                                    <ul class="nav navbar-right item_config visible-sm visible-xs">
                                        <li class="dropdown pull-right">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                                <i class="glyphicon glyphicon-option-horizontal"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="">
                                                    <a href="new_admin.php"><i class="glyphicon glyphicon-plus"></i> Add New Admin </a>
                                                </li>
                                            </ul>
                                            <!-- /.dropdown-menu -->
                                        </li>
                                        <!-- /.dropdown -->
                                    </ul>
                                </div>
                            </h3>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-hover" id="admin_list" width="350px;">
                                <thead>
                                    <tr>
                                        <th class="text-center">Username</th>
                                        <th class="text-center">Password</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $query = $admin_db->get_admin();
                                        $tds = '';
                                        $td = '';

                                        foreach ($query as $admins) {
                                            $tds .= create_admin($admins);
                                        }

                                        $td .= $tds;

                                        echo $td;
                                    ?>
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
                <?php require_once 'layouts/footer.php'; ?>
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>

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
</body>

</html>
