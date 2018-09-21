<?php require_once 'layouts/supplier_header.php'; ?>
<?php
    require_once 'class/Functions.php';
    require_once 'class/Session.php';
    require_once 'class/Supplier.php';
    require_once 'class/helper.php';
    require_once 'class/wp-db.php';

    $supplier_db = new Supplier();
    $session = new Session(); 

    if ($_SESSION["pos_user"] === null) {
        redirect_to("error.php");
    }

    $supplier_id = (isset($_GET['supplier_id']) ? $_GET['supplier_id'] : NULL);
    $supplier = $supplier_db->remove_supplier($supplier_id);
?>

    <div id="wrapper">
        <?php require_once 'layouts/navigation.php'; ?>

        <div id="page-wrapper">
            <span>&nbsp;</span>
            <div class="row">
                <div class="alert alert-success"> Supplier has been deleted. <a href="supplier.php">Back</a></div>
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
