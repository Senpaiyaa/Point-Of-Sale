<?php require_once 'layouts/categories_header.php'; ?>
<?php
    require_once 'class/Functions.php';
    require_once 'class/Session.php';
    require_once 'class/Category.php';

    $session = new Session();
    $category_db = new Category();

    if ($_SESSION["pos_user"] === null || $_SESSION["pos_staff"] === true) {
        redirect_to("error.php");
    }

    $empty_name = false;

    $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $id = get_valueFromStringUrl($url , "category_id");

    $category = $category_db->get_category($id);

    if (isset($_POST["update"])) {
        $category_id = $_POST["category_id"];
        $category_name = escape($_POST["category_name"]);

        if (empty($category_name)) {
            $empty_name = true;
        } else {
            $category = $category_db->update_category($category_id, $category_name);
            redirect_to("manage_category.php");
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
                                <h3>Edit Category</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" class="form-control" name="category_id" id="category_id" value="<?php echo $category['category_id'];?>"> 
                                        <div class="form-group">
                                            <label for="cats" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Category Name:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="category_name" value="<?php echo $category['category_name'];?>" id="category_name" class="form-control form-inps" type="text">
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
    <script type="text/javascript">
        var qsParm = new Array();
        function qs() {
            var query = window.location.search.substring(1);
            var parms = query.split('&');
            for (var i=0; i < parms.length; i++) {
                var pos = parms[i].indexOf('=');
                if (pos > 0) {
                    var key = parms[i].substring(0, pos);
                    var val = parms[i].substring(pos + 1);
                    qsParm[key] = val;
                }
            }
        }

    </script>
</body>

</html>
