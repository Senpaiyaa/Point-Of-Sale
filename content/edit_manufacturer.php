<?php require_once 'layouts/manufacturer_header.php'; ?>
<?php
    require_once 'class/Functions.php';
    require_once 'class/Session.php';
    require_once 'class/Manufacturer.php';

    $session = new Session();
    $manufacturer_db = new Manufacturer();

    if ($_SESSION["pos_user"] === null || $_SESSION["pos_staff"] === true) {
        redirect_to("error.php");
    }

    $empty_name = false;

    $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $id = get_valueFromStringUrl($url , "manufacturer_id");

    $manufacturers = $manufacturer_db->get_manufacturer($id);

    if (isset($_POST["update"])) {
        $manufacturer_id = $_POST["manufacturer_id"];
        $manufacturer_name = escape($_POST["manufacturer_name"]);

        if (empty($manufacturer_name)) {
            $empty_name = true;
        } else {
            $manufacturer = $manufacturer_db->update_manufacturer($manufacturer_id, $manufacturer_name);
            redirect_to("manage_manufacturer.php");
        }
    }
?>

    <div id="wrapper">
        <?php require_once 'layouts/navigation.php'; ?>

        <div id="page-wrapper">
            <span>&nbsp;</span>
            <div class="row">
                <form class="form-horizontal" role="form" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Edit Manufacturer</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" class="form-control" name="manufacturer_id" id="manufacturer_id" value="<?php echo $manufacturers["manufacturer_id"];?>"> 
                                        <div class="form-group">
                                            <label for="manufacturer_name" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Manufacturer Name:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="manufacturer_name" value="<?php echo $manufacturers["manufacturer_name"];?>" id="manufactuer_name" class="form-control form-inps" type="text">
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <input type="submit" name="update" class="submit_button floating_button btn btn-primary" value="Update">
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

    <script src="js/functions.js"></script>
</body>

</html>
