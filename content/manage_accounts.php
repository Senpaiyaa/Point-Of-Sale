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
        $reactivate = '<a class="pointer pull-right btn btn-success" onclick="show_reactivate_modal('.$employee_id.')">Reactivate</a>';
        $remove = '';
        $html = '
            <tr id="'.$employee['staff_id'].'" class="td-employee">
                <td class="username text-center">' . $employee["username"] . '</td>
                <td class="password text-center">' . $employee["password"] . '</td>
                <td class="name text-center">' . $name . '</td>
                <td class="mail text-center">' . $email . '</td>
                <td class="contact text-center">' . $employee["phone_number"] . '</td>
                <td class="address text-center">' . $employee["address"] . '</td>
                <td class="city text-center">' . $employee["city"] . '</td>
                <td class="province text-center">' . $employee["province"] . '</td>
                <td class="zip text-center">' . $employee["zip"] . '</td>
                <td>' . $reactivate . '</td>
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
                                List of Deactivated Employee Accounts
                            </h3>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-hover" id="deactivated_list" width="350px;">
                                <thead>
                                    <tr>
                                        <th class="text-center">Username</th>
                                        <th class="text-center">Password</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Contact</th>
                                        <th class="text-center">Address</th>
                                        <th class="text-center">City</th>
                                        <th class="text-center">Province</th>
                                        <th class="text-center">Zip</th>
                                        <th id="action" class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $query = $employee_db->get_deactivated_accounts();
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
            </div>
            <!-- /.row -->
            <?php require_once 'layouts/footer.php'; ?>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <div class="modal fade" id="reactivate-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <p>Do you want to reactivate this account?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-danger" data-dismiss="modal" id="btnNo">Cancel</button>
                    <button type="button" class="btn btn-md btn-success" data-dismiss="modal" id="btnYes">Reactivate</button>
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
    <script type="text/javascript">
        var staff_id = null;

		$(document).ready(function() {
		    $('#deactivated_list').DataTable({
		        responsive: true,
		        "order": [[ 0, "desc" ]]            
		    });
		});

        $('#btnYes').click(function(){
            document.location = 'reactivate.php?staff_id=' + staff_id;
        });

        $('#btnNo').click(function(){
            $('#reactivate-modal').modal('hide');
        })

        function show_reactivate_modal(id){
            staff_id = id;
            $('#reactivate-modal').modal('show');
        }

    </script>
</body>

</html>
