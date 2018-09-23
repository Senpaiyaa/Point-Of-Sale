<?php require_once 'layouts/employees_header.php'; ?>
<?php
    require_once 'class/Functions.php';
    require_once 'class/Session.php';
    require_once 'class/Employee.php';
    require_once 'class/Staff.php';

    $employee_db = new Employee();
    $session = new Session();
    $staff_db = new Staff();

    if ($_SESSION["pos_user"] === null || $_SESSION["pos_staff"] === true) {
        redirect_to("error.php");
    }    

?>
<?php
    function create_employee($employee) {
        $employee_id = $employee["staff_id"];
        $name = $employee["fname"].' '.$employee["lname"];
        $email = $employee["email"];
        $mail = '<a href="mailto:' . $email . '"> ' . $email . ' </a>';

        $edit = '<a id="edit" class="pointer pull-right" onclick="edit_employee('.$employee_id.')"><span class="glyphicon glyphicon-pencil"></span> Edit</a>';
        $delete = '<a class="pointer pull-right link-red" style="margin-left: 15px;" onclick="show_delete_modal('.$employee_id.')"><span class="glyphicon glyphicon-remove"></span> Deactivate</a>';
        $html = '
            <tr id="'.$employee['staff_id'].'" class="td-employee">
                <td class="username text-center"><a href="view_employee.php?staff_id='.$employee_id.'">' . $employee["username"] . '</a></td>
                <td class="password text-center">' . $employee["password"] . '</td>
                <td class="name text-center">' . $name . '</td>
                <td class="mail text-center">' . $mail . '</td>
                <td class="contact text-center">' . $employee["phone_number"] . '</td>
                <td class="city text-center">' . $employee["city"] . '</td>

                <td>' . $delete . $edit . '</td>
            </tr>';
        return $html;
    }
?>
    <div id="wrapper">

        <?php require_once 'layouts/navigation.php'; ?>

        <div id="page-wrapper">
            <span>&nbsp;</span>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>
                                List of Employees
                                <div class="pull-right btn_options">
                                    <a href="new_employee.php" class="btn btn-primary hidden-sm hidden-xs" id="btnAddItem">
                                        <span>New Employee</span>
                                    </a>
                                    <ul class="nav navbar-right item_config">
                                        <li class="dropdown pull-right">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="visible-sm visible-xs">
                                                    <a href="new_employee.php"><i class="glyphicon glyphicon-plus"></i> Add New Employee </a>
                                                </li>
                                                <li>
                                                    <a href="manage_accounts.php"><i class="glyphicon glyphicon-cog"></i> Manage Inactive Accounts</a>
                                                </li>
                                                <li>
                                                    <a href="manage_admin.php"><i class="fa fa-user-md"></i> Manage Administrator</a>
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
                            <table width="100%" class="table table-hover" id="employee_list" >
                                <thead>
                                    <tr>
                                        <th class="text-center">Username</th>
                                        <th class="text-center">Password</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Contact</th>
                                        <th class="text-center">City</th>
                                        <th id="action" class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $query = $employee_db->get_all_employee();
                                        $tds = '';
                                        $td = '';

                                        foreach ($query as $employee) {
                                            $tds .= create_employee($employee);
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
    <!-- /#wrapper -->
    <div class="modal fade" id="delete-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <p>Do you want to deactivate this account?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-default" data-dismiss="modal" id="btnNo">Cancel</button>
                    <button type="button" class="btn btn-md btn-danger" data-dismiss="modal" id="btnYes">Deactivate</button>
                </div>
            </div>  
        </div>
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

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    var staff_id = 0;

    function show_delete_modal(id){
        staff_id= id;
        $('#delete-modal').modal('show');
    }

    $('#btnYes').click(function(){
        document.location = 'remove_employee.php?staff_id=' + staff_id;
    });

    $('#btnNo').click(function(){
        $('#delete-modal').modal('hide');
    })


    $(document).ready(function() {
        $('#employee_list').dataTable({
            responsive: true,
        });

        $("#employee_count").append($("table > tbody > .td-employee").length);
    });
    </script>
</body>

</html>
