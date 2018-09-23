
<?php 
    require_once 'class/Functions.php';
    require_once 'class/Session.php';
    require_once 'class/Employee.php';
    require_once 'class/Staff.php';
    require_once 'class/Session.php';
    require_once 'layouts/employees_header.php';
    $employee_db = new Employee();
    $session = new Session();
    if ($_SESSION["pos_user"] === null || $_SESSION["pos_staff"] === true) {
        redirect_to("error.php");
    }    
    $staff_id = (int) $_GET["staff_id"];
    $employee = $employee_db->view_employee($staff_id);

?>

    <div id="wrapper">
        <?php require_once 'layouts/navigation.php'; ?>

        <div id="page-wrapper">
            <span>&nbsp;</span>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3>Employee Information <span><i class="fa fa-user"></i></span></h3>
                        </div>
                        <div class="panel-body">

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Employee ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Address</th>
                                            <th>City</th>
                                            <th>Province</th>
                                            <th>Zip</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $employee['staff_id']; ?></td>
                                            <td><?php echo $employee['fname']; ?></td>
                                            <td><?php echo $employee['lname']; ?></td>
                                            <td><?php echo $employee['email']; ?></td>
                                            <td><?php echo $employee['phone_number']; ?></td>
                                            <td><?php echo $employee['address']; ?></td>
                                            <td><?php echo $employee['city']; ?></td>
                                            <td><?php echo $employee['province']; ?></td>
                                            <td><?php echo $employee['zip']; ?></td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer">
                            Employee: <?php echo $employee['fname']. ' '. $employee['lname']; ?>
                        </div>
                    </div>
                    <?php require_once 'layouts/footer.php'; ?>
                </div>
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

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>
</body>

</html>
