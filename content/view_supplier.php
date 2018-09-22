
<?php 
    require_once 'class/Functions.php';
    require_once 'class/Session.php';
    require_once 'class/Supplier.php';
    require_once 'layouts/supplier_header.php';
    $supplier_db = new Supplier();
    $session = new Session();
    if ($_SESSION["pos_user"] === null || $_SESSION["pos_staff"] === true) {
        redirect_to("error.php");
    }    
    $supplier_id = (int) $_GET["supplier_id"];
    $supplier = $supplier_db->get_supplier($supplier_id);
?>

    <div id="wrapper">
        <?php require_once 'layouts/navigation.php'; ?>

        <div id="page-wrapper">
            <span>&nbsp;</span>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3>Supplier Information <span><i class="fa fa-male"></i></span></h3>
                        </div>
                        <div class="panel-body">

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Supplier ID</th>
                                            <th>Supplier Name</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Address</th>
                                            <th>City</th>
                                            <th>Zip</th>
                                            <th>Country</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $supplier['supplier_id']; ?></td>
                                            <td><?php echo $supplier['supplier_name']; ?></td>
                                            <td><?php echo $supplier['first_name']; ?></td>
                                            <td><?php echo $supplier['last_name']; ?></td>
                                            <td><?php echo $supplier['email']; ?></td>
                                            <td><?php echo $supplier['phone_number']; ?></td>
                                            <td><?php echo $supplier['address']; ?></td>
                                            <td><?php echo $supplier['city']; ?></td>
                                            <td><?php echo $supplier['zip']; ?></td>
                                            <td><?php echo $supplier['country']; ?></td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer">
                            Supplier: <?php echo $supplier['supplier_name']; ?>
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
