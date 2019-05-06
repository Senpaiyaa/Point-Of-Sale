<?php require_once 'layouts/sale_header.php'; ?>
<?php
    require_once 'class/Functions.php';
    require_once 'class/Session.php';
    require_once 'class/Stocks.php';
    require_once 'class/Product.php';

    $stocks_db = new Stocks();
    $product_db = new Product();
    $session = new Session();

    if ($_SESSION["pos_user"] === null || $_SESSION["pos_admin"] === true) {
        redirect_to("error.php");
    }

?>
    <div id="wrapper">

        <!-- include nav  -->
        <?php //require_once 'layouts/pos_navigation.php'; ?>

        <!-- <div id="page-wrapper"> -->
            <!-- <p>&nbsp;</p> -->
            <!-- <br> -->
        <script src="js/time.js"></script>

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background:#489ee7;">
            <div class="navbar-header">
                <a class="navbar-brand" href="dashboard.php" style="color:#fff;">24 Beinte Quatro Minimart Co.</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown pull-right">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="color:#fff;" id="user-icon">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="logoff.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <li class="pull-right">
                    <p id="time">
                        <span id="date_time"></span>
                        <script type="text/javascript">window.onload = date_time('date_time');</script>
                    </p>
                </li>
                <!-- /.dropdown -->
            </ul>

        </nav>
            <span>&nbsp;</span>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <button class="btn btn-warning btn-block" onclick="window.location='pos_searchTransaction.php';" style="margin-top: 15px;">Search Transaction</button><br/>
                            <button class="btn btn-info btn-block" onclick="window.location='viewProducts.php';" style="margin-top: 15px;">View Products</button><br/>
                            <button class="btn btn-success btn-block" onclick="new_sales()" style="margin-top: 15px;">New Sales</button><br/>
                            <button class="btn btn-primary btn-block" onclick="show_payment_modal()" style="margin-top: 15px;">Complete Sales</button><br/>

                            <form id="product-form" method="get">
                                <div class="modal-body">
                                
                                    <div class="form-group">
                                        <label>Quantity</label>
                                        <input type="number" id="quantity" class="form-control text-right" min="0" />
                                    </div>
                                    <div class="form-group">
                                        <label>Barcode</label>
                                        <input type="text" id="barcode" class="form-control" placeholder="Enter or scan barcode here..." />
                                    </div>
                                    <div class="alert alert-danger text-center" id="product-not-found" style="display:none;">Unable to add item. Out of stock.</div>

                                </div>
                                <button type="submit" class="btn btn-md btn-primary" style="display:none;">Submit</button>
                            </form>
                            <h1 class="text-right">Total: <span id="total_sales">0.00</span></h1>
                            <table class="table table-bordered">
                                <thead>
                                    <th class="col-md-2">Product Name</th>
                                    <th class="col-md-2 text-right">Price</th>
                                    <th class="col-md-2 text-right">Quantity</th>
                                    <th class="col-md-2 text-right">Total</th>
                                    <th class="col-md-2 text-right">Action</th>
                                </thead>
                                <tbody id="tbody">
                                </tbody>
                            </table>    
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    <a href="#keyboardhelp" class="pull-right visible-lg" id="keyboard_toggle">Keyboard shortcuts help</a>
                    <div id="keyboardhelp" style="background-color: white; padding: 12px; display: none;" title="Keyboard shortcuts help">
                      
                      <div>
                        <span>[S]  =&gt; <strong>S</strong>tart a new sale</span><br>
                        <span>[B]  =&gt; Set focus on <strong>b</strong>arcode</span><br>
                        <span>[Q]  =&gt; Set focus on <strong>q</strong>uantity</span><br>
                        <span>[M]  =&gt; Co<strong>m</strong>pletes current sale</span><br>
                        <span>[N]  =&gt; Ca<strong>n</strong>cel current sale</span><br>
                        <span>[L]  =&gt; <strong>L</strong>ogout</span><br>
                      </div>
                      
                    </div>
                </div>
                <!-- /.col-lg-12 -->

            </div>
            <!-- /.row -->
        <!-- </div> -->
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- MODALS -->
    <div class="modal fade" id="product-quantity-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="add-product-form">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" id="product_name" class="form-control col-md-6" readonly/>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" id="price" class="form-control col-md-6 text-right" readonly/>
                        </div>
                        <!-- <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" id="quantity" class="form-control text-right"/>
                        </div> -->
                    </div>
                </form>
            </div>  
        </div>
    </div>
    <div class="modal fade" id="payment-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="payment-form">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Cash</label>
                            <input type="text" id="amount_paid" class="form-control col-md-6 text-right" min="0" step="0.01" />
                        </div>
                        <div class="form-group">
                            <label>Change</label>
                            <input type="number" id="amount_change" class="form-control col-md-6 text-right" readonly />
                        </div>
                        <span>&nbsp;</span>
                        <!-- <div class="checkbox text-right">
                            <label>
                                <input type="checkbox" id="discount">
                                Discounted
                            </label>

                        </div> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-md btn-primary">Submit</button>
                    </div>
                </form>
            </div>  
        </div>
    </div>
    <div class="modal fade" id="complete-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <p>Sales has been completed.</p>
                    <a href="" id="print" target="_new">Print</a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-primary" data-dismiss="modal" onclick="reset();" >Okay</button>
                </div>
            </div>  
        </div>
    </div>
    <div class="modal fade" id="cancel_sale" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <p>Are you sure you want to clear this sale? All items will cleared.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-md btn-primary" data-dismiss="modal" id="btnYes">Okay</button>
                </div>
            </div>  
        </div>
    </div>
    <div class="modal fade" id="logoff-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <p>Are you sure to logoff?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-default" data-dismiss="modal" id="logOffbtnNo">Cancel</button>
                    <button type="button" class="btn btn-md btn-primary" data-dismiss="modal" id="logOffbtnYes">Okay</button>
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
    <script src="js/save_sales.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#barcode').focus();
            $('#quantity').val(1);
            $('#keyboard_toggle').on('click', function() {
                $('#keyboardhelp').toggle();
            });
        });

        $(document).on("keydown",function(event){
            if(event.which===83) window.location.href='dashboard.php';
            if(event.which===76) {
                $('#logoff-modal').modal('show');
                $('#logOffbtnYes').click(function(){
                    window.location.href="logoff.php";
                });
            }
            if(event.which===78) {
                show_cancel_modal();
                $('#btnYes').click(function(){
                    reset();
                });
            }
            if(event.which===120) {
                if($('#total_sales').html()!=0) console.log("x");
            }
            if (event.which===66) $('#barcode').focus();
            if (event.which===81) $('#quantity').focus();
            if(event.which===77) show_payment_modal();
        });
    </script>
</body>

</html>
