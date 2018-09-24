<?php require_once 'layouts/employees_header.php'; ?>
<?php
    require_once 'class/Employee.php';
    require_once 'class/Session.php';
    require_once 'class/Functions.php';
    require_once 'class/wp-db.php';

    $session = new Session();
    $employee_db = new Employee();

    if ($_SESSION["pos_user"] === null || $_SESSION["pos_staff"] === true) {
        redirect_to("error.php");
    }    
    
    $admin = array('admin_id' => NULL, 
                   'username' => NULL,
                   'password' => NULL);

    if (isset($_POST["submit"])) {
        $admin['username'] = escape($_POST["username"]);
        $admin['password'] = md5($_POST["password"]);
        $wpdb->insert('admin', $admin);
        $message = '<div class="alert alert-success">Administrator has been added.</div>';
    }
?>
    <div id="wrapper">
        <?php require_once 'layouts/navigation.php'; ?>

        <div id="page-wrapper">
            <span>&nbsp;</span>
            <div class="row">
                <form class="form-horizontal" role="form" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="admin_information_form">
                    <div class="col-lg-12">
                    <span id="message"><?php if(isset($message)) echo $message; ?></span>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-user"></i> Admin Login Info <small>(Fields in red are required)</small>
                                </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="username" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Username:</label>
                                    <div class="col-sm-9 col-md-9 col-lg-10">
                                        <input name="username" id="username" class="form-control" type="text">
                                        <span class="text-danger" style="display:none;" id="empty_username">Username is a required field.</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Password:</label>
                                    <div class="col-sm-9 col-md-9 col-lg-10">
                                        <input name="password" id="password" class="form-control" type="password">
                                        <span class="text-danger" style="display:none;" id="empty_password"></span>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="pwd_again" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Password Again:</label>
                                    <div class="col-sm-9 col-md-9 col-lg-10">
                                        <input id="pwd_again" class="form-control" type="password">
                                        <span class="text-danger" style="display:none;" id="password_again_message"></span>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.col-lg-12 -->                 
                    <div class="form-actions">
                        <input type="submit" name="submit" class="submit_button floating_button btn btn-primary" value="Submit" id="submit">
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

    <script src="js/admin.js"></script>
</body>

</html>
