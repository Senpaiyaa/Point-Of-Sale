<?php require_once 'layouts/employees_header.php'; ?>
<?php
    require_once 'class/Functions.php';
    require_once 'class/Employee.php';
    require_once 'class/Session.php';

    $session = new Session();
    $employee_db = new Employee();
    $staff_id = isset($_GET["staff_id"]) ? $_GET["staff_id"] : "";
    
    if ($_SESSION["pos_user"] === null || $_SESSION["pos_staff"] === true) {
        redirect_to("error.php");
    }    

    $id = (int) $_GET["staff_id"];
    $employees = $employee_db->get_employee($id);

    if (isset($_POST["update"])) {
        $username = escape($_POST["username"]);
        $password = md5($_POST["password"]);
        $fname = escape($_POST["fname"]);
        $lname = escape($_POST["lname"]);
        $email = escape($_POST["email"]);
        $phone_number = escape($_POST["phone_number"]);
        $address = escape($_POST["address"]);
        $city = escape($_POST["city"]);
        $province = escape($_POST["province"]);
        $zip = escape($_POST["zip"]);

        $employee = $employee_db->update_staff($staff_id, $username, $password, $fname, $lname, $email, $phone_number, $address, $city, $province, $zip);
        $message = '<div class="alert alert-success">Employee has been updated.</div>';
    }
?>

    <div id="wrapper">
        <?php require_once 'layouts/navigation.php'; ?>

        <div id="page-wrapper">
            <span>&nbsp;</span>
            <div class="row">
                <form class="form-horizontal" role="form" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="staff_information_form">
                    <div class="col-lg-12">
                    <span id="message"><?php if(isset($message)) echo $message; ?></span>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-user"></i> Employee Login Info <small>(Fields in red are required)</small>
                                </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="username" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Username:</label>
                                    <div class="col-sm-9 col-md-9 col-lg-10">
                                        <input name="username" id="username" value="<?php echo $employees['username'];?>" class="form-control" type="text">
                                        <span class="text-danger" style="display:none;" id="empty_username">Username is a required field.</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-md-3 col-lg-2 control-label wide">Password:</label>
                                    <div class="col-sm-9 col-md-9 col-lg-10">
                                        <input name="password" id="password" class="form-control" type="password">
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-pencil"></i> Employee Basic Information <small>(Fields in red are requried)</small>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 col-md-3 col-lg-2 control-label wide">First Name:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="fname" id="fname" value="<?php echo $employees['fname'];?>" class="form-control" type="text">
                                                <span class="text-danger" style="display:none;" id="empty_fname">First name is a required field.</span>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="lname" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Last Name:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="lname" id="lname" value="<?php echo $employees['lname'];?>" class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="col-sm-3 col-md-3 col-lg-2 control-label wide">E-mail:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="email" id="email" value="<?php echo $employees['email'];?>" class="form-control" type="text">
                                                <span class="text-danger" style="display:none;" id="empty_email">Email is a required field.</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone_number" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Phone Number:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="phone_number" id="phone_number" value="<?php echo $employees['phone_number'];?>" class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="address" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Address:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="address" id="address" value="<?php echo $employees['address'];?>" class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="city" class="col-sm-3 col-md-3 col-lg-2 control-label wide">City:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="city" id="city" value="<?php echo $employees['city'];?>" class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="province" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Province:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="province" id="province" value="<?php echo $employees['province'];?>" class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="zip" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Zip:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="zip" id="zip" value="<?php echo $employees['zip'];?>" class="form-control" type="text">
                                            </div>
                                        </div>

                                    </div>
                                    <!-- /.col-lg-6 (nested) -->
                                </div>
                                <!-- /.row (nested) -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->                 
                    <div class="form-actions">
                        <input type="submit" name="update" class="submit_button floating_button btn btn-primary" value="Update" id="update">
                    </div>   
                </form>
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
    <script src="js/modify_staff.js"></script>
</body>

</html>
