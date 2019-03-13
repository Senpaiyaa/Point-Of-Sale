<?php
    require_once 'class/Functions.php';
    require_once 'class/Session.php';
    require_once 'class/Sales.php';
    require_once 'class/Product.php';
    require_once 'class/Staff.php';

    $session = new Session();
    $sales_db = new Sales();
    $product_db = new Product();
    $staff_db = new Staff();

    // this page is for staff only
    if ($_SESSION["pos_user"] === null || $_SESSION["pos_admin"] === true) {
        redirect_to("error.php");
    }
?>
<?php require_once 'layouts/sale_header.php'; ?>
<style type="text/css">
    @page{
        size:11in 5.5in;
        margin-top: 0;
        margin-right: 7.58in;
        margin-bottom: 2.19in;
        margin-left: 0.19in;
        size:landscape;
    }
</style>
<div id="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default"></div>
            <?php
                $sales_id = _request('sales_id');
                $query = "SELECT * FROM `sales` WHERE `sales_id` = $sales_id";
                $sales = $sales_db->select_row($query);
                $query = "SELECT * FROM `sales_details` WHERE `sales_id` = $sales_id";
                $sales_details = $sales_db->select($query);
                if (count($sales_details) === 0) {
                    return NULL;
                }
                $staff_id = $sales['staff_id'];
                $sales_employee = $staff_db->get_staff_full_name($staff_id);
                $total = number_format($sales['total_sales'], 2, '.', ',');
                $amount_paid = number_format($sales['amount_paid'], 2, '.', ',');
                // $amount_change = number_format($sales['amount_change'], 2, '.', ',');
                $cashier_id = isset($_SESSION["pos_user"]["staff_id"]) ? $_SESSION["pos_user"]["staff_id"] : null;
                $formatted_cashier_id = sprintf("%'.03d\n", $cashier_id);
                $formatted_si = sprintf("%'.05d\n", $sales['sales_id']);
                $tax = (double) $sales['total_sales'];
                $tax = $tax * 1.12;
                $tax = $tax / 12;
                $total = (double) $sales['total_sales']+$tax;
                $total = number_format($total, 2, '.', ',');
                $amount_change = $amount_paid - $total;
                $tax = number_format($tax, 2, '.', ',');
                $invoice_no = sprintf('%09d', $sales_id);
                $output = "
                    <ul class='list-unstyled' >
                        <li style='font-weight: 700;'>24 Beinte Quatro Minimart Co.</li>
                        <li ># 34, 35 Phase 1 Katapatan Subdivision</li>
                        <li >Cabuyao, Laguna</li>
                        <li >4025</li>

                    </ul>
                    <hr/>
                    <ul class='list-unstyled' >
                        <li class='text-center'>Sales receipt</li>
                        <li class='receipt_space'></li>
                        <li class='text-center'><strong>{$sales['created_on']}</strong></li>
                        <li class='receipt_space'></li>
                        <li class='text-center'>Sale ID: {$formatted_si}</li>
                        <li class='receipt_space'></li>
                        <li class='text-center'>Invoice: IN{$invoice_no}</li>
                        <li class='receipt_space'></li>
                        <li class='text-center'>Cashier: {$sales_employee['full_name']}</li>
                    </ul>
                    <hr/>";

                $sales_details_output = "";

                foreach($sales_details as $row){
                    $product = $product_db->get_product($row['product_id']);
                    $price = ((double)$row['total'])/((int)$row['quantity']);
                    $formatted_price = number_format($price+$tax, 2, '.', ',');
                    $formatted_total = number_format($row['total']+$tax, 2, '.', ',');
                    $sales_details_output.= "
                        <tr>
                            <td>{$product['product_name']}</td>
                            <td>{$row['quantity']}</td>
                            <td>&#8369; {$formatted_price}</td>
                            <td>&#8369; {$formatted_total}</td>
                        </tr>";
                }

                $output.= "
                    <table class='table'>
                        <thead >
                            <tr>
                                <th >Item Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody >{$sales_details_output}</tbody>
                    </table>
                    <div class='col-md-offset-4 col-sm-offset-4 col-md-6 col-sm-6 col-xs-8 text-right'>
                        Cash:
                    </div>
                    <div class='col-md-2 col-sm-2 col-xs-4 text-right'>
                        &#8369; {$amount_paid}
                    </div>
                    <div class='col-md-offset-4 col-sm-offset-4 col-md-6 col-sm-6 col-xs-8 text-right'>
                        Change:
                    </div>
                    <div class='col-md-2 col-sm-2 col-xs-4 text-right'>
                        &#8369; {$amount_change}
                    </div>
                    <div class='col-md-offset-4 col-sm-offset-4 col-md-6 col-sm-6 col-xs-8 text-right'>
                        Sales Tax:
                    </div>
                    <div class='col-md-2 col-sm-2 col-xs-4 text-right'>
                        &#8369; {$tax}
                    </div>

                    <div class='col-md-offset-4 col-sm-offset-4 col-md-6 col-sm-6 col-xs-8 text-right'>
                        Total:
                    </div>
                    <div class='col-md-2 col-sm-2 col-xs-4 text-right'>
                        &#8369; {$total}
                    </div>
                    <hr/>
                    <div class='col-md-12 col-sm-12 col-xs-12 text-center'>
                        Thank you. Come Again!
                    </div>
                    <div class='col-md-12 col-sm-12 col-xs-12 text-center'>
                        &lt;&lt;THIS SERVES AS YOUR SALES INVOICE&gt;&gt;
                    </div>";
            ?>

            <?php echo $output; ?>          
            <?php require_once 'layouts/footer.php'; ?>
            <div class="form-actions">
                <button class="submit_button floating_button btn btn-primary hidden-print" id="submit" onclick="javascript:print()">Print</button>

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
<script type="text/javascript">
    var mediaQueryList = window.matchMedia('print');
    $(document).ready(function(){
        window.print();
        var print = $(window.matchMedia('print'));
        print.click();
    });
    mediaQueryList.addListener(function(mql) {
        if (mql.matches) {
            console.log('before print dialog open');
        } else {
            console.log('after print dialog closed');
            window.close();
        }
    });
</script>
</body>
</html>