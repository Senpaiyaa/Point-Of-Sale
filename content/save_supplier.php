<?php require_once 'layouts/supplier_header.php'; ?>
<?php
    require_once 'class/Functions.php';
    require_once 'class/Session.php';
    require_once 'class/Supplier.php';
    require_once 'class/helper.php';
    require_once 'class/wp-db.php';

    $supplier_db = new Supplier();
    $session = new Session();
    $header = "New";
    $supplier_id = NULL;    

    if ($_SESSION["pos_user"] === null || $_SESSION["pos_staff"] === true) {
        redirect_to("error.php");
    }

    $supplier = array(
        'supplier_id' => NULL, 
        'supplier_name' => NULL, 
        'first_name' => NULL, 
        'last_name' => NULL, 
        'email' => NULL, 
        'phone_number' => NULL, 
        'address' => NULL, 
        'city' => NULL, 
        'zip' => NULL, 
        'country' => NULL);

    if(isset($_GET['supplier_id'])){
        $supplier_id = (int) $_GET['supplier_id'];
        $supplier = $supplier_db->get_supplier($supplier_id);
        $header = "Update";
    }

    if (isset($_POST["submit"])) {
        // $stock['stock_id'] = $_POST['stock_id'];
        $supplier['supplier_name'] = escape($_POST['supplier_name']);
        $supplier['first_name' ] = escape($_POST['fname']);
        $supplier['last_name' ] = escape($_POST['lname']);
        $supplier['email' ] = escape($_POST['email']);
        $supplier['phone_number'] = escape($_POST['phone_number']);
        $supplier['address'] = escape($_POST['address']);
        $supplier['city'] = escape($_POST['city']);
        $supplier['zip'] = escape($_POST['zip']);
        $supplier['country'] = escape($_POST['country']);

        if($supplier_id===NULL){
            //insert
            $wpdb->insert('supplier',$supplier);
            $supplier_id = $wpdb->insert_id;
            $header = "Update";
            $message = '<div class="alert alert-success" id="message">Supplier has been added.</div>';
        }
        else{
            //update
            $wpdb->update('supplier',$supplier,array('supplier_id'=>$supplier_id));
            $message = '<div class="alert alert-success" id="message">Supplier has been updated.</div>';
            // redirect_to('stocks.php');
            //$wpdb->delete('product',array('product_id'=>$product_id));
        }

        $supplier = $supplier_db->get_supplier($supplier_id);    
    }

?>
<?php
    function create_supplier($supplier) {
        $supplier_id = $supplier["supplier_id"];
        $checkbox = '<input type="checkbox" name="supplier_id[]" value="'.$supplier_id.'" class="chk_supplier">';
        $edit = '<a id="edit" class="pointer pull-right" href="supplier.php?supplier_id='.$supplier_id.'"><span class="glyphicon glyphicon-pencil"></span> Edit</a>';
        $delete = '<a class="pointer pull-right link-red" style="margin-left: 15px;" onclick="item_delete('.$supplier_id.')"><span class="glyphicon glyphicon-trash"></span> Delete</a>';
        $html = '
            <tr id="'.$supplier['supplier_id'].'" class="td-supplier">
                <td class="supplier_id text-center">' . '<span class="spanSupplierID">' . $supplier["supplier_id"] . '</span>' .'</td>
                <td class="supplier_name">' . $supplier["supplier_name"] . '</td>
                <td class="fname">' . $supplier["first_name"] . '</td>
                <td class="lname">' . $supplier["last_name"] . '</td>
                <td class="email">' . $supplier["email"] . '</td>
                <td class="contact">' . $supplier["phone_number"] . '</td>
                <td>' . $delete . $edit . '</td>
            </tr>';
        return $html;
    }
?>
    <div id="wrapper">

        <!-- include nav  -->
        <?php require_once 'layouts/navigation.php'; ?>

        <div id="page-wrapper">
            <!-- <p>&nbsp;</p> -->
            <!-- <br> -->
            <span>&nbsp;</span>
            <div class="row">
                <div class="col-lg-12">
                    <form class="form-horizontal" role="form" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="supplier_form">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-pencil"></i> <?php echo $header; ?> Supplier Information <small>(Fields in red are required)</small>
                            </div>
                            <div class="panel-body">
                                <span id="message"><?php if(isset($message)) echo $message; ?></span>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="company_name" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Company Name:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="supplier_name" value="<?php echo $supplier['supplier_name']; ?>" id="supplier_name" class="form-control form-inps" type="text">
                                                <span class="text-danger" style="display:none;" id="empty_supplier_name">Company name is a required field.</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 col-md-3 col-lg-2 control-label wide">First Name:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="fname" value="<?php echo $supplier['first_name']; ?>" id="fname" class="form-control form-inps" type="text">
                                                <span class="text-danger" style="display:none;" id="empty_fname">First name is a required field.</span>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="lname" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Last Name:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="lname" value="<?php echo $supplier['last_name']; ?>" id="lname" class="form-control form-inps" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Email:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="email" value="<?php echo $supplier['email']; ?>" id="email" class="form-control form-inps" type="text">
                                                <span class="text-danger" style="display:none;" id="empty_email">Email is a required field.</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone_number" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Phone Number:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="phone_number" value="<?php echo $supplier['phone_number']; ?>" id="phone_number" class="form-control form-inps" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="address" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Address:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="address" value="<?php echo $supplier['address']; ?>" id="address" class="form-control form-inps" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="city" class="col-sm-3 col-md-3 col-lg-2 control-label wide">City:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="city" value="<?php echo $supplier['city']; ?>" id="city" class="form-control form-inps" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="zip" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Zip:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="zip" value="<?php echo $supplier['zip']; ?>" id="zip" class="form-control form-inps" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="country" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Country:</label>
                                            <div class="col-sm-9 col-md-9 col-lg-10">
                                                <input name="country" value="<?php echo $supplier['country']; ?>" id="country" class="form-control form-inps" type="text">
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <input type="submit" name="submit" class="submit_button floating_button btn btn-primary" value="Submit" id="submit">
                                        </div>
                                    </div>
                                    <!-- /.col-lg-6 (nested) -->
                                </div>
                                <!-- /.row (nested) -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </form>
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

    <!-- DataTables JavaScript -->
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

    <script src="js/functions.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>

    $('#supplier_form').submit(function(){
        var error = false;
        var supplier_name_length = $('#supplier_name').val().trim().length;
        var fname_length = $('#fname').val().trim().length;
        var email_length = $('#email').val().trim().length;

        if(supplier_name_length===0){
            error = true;
            $('#empty_supplier_name').show();
        }
        if(fname_length===0){
            error = true;
            $('#empty_fname').show();
        }
        if(email_length===0){
            error = true;
            $('#empty_email').show();
        }

        else{
            $('#empty_supplier_name').hide();
            $('#empty_fname').hide();
            $('#empty_email').hide();
        }

        return !error;
    });

    </script>
</body>

</html>
