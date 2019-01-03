<?php require_once 'layouts/categories_header.php'; ?>
<?php
    require_once 'class/Functions.php';
    require_once 'class/Category.php';
    require_once 'class/Session.php';

    $category_db = new Category();
    $session = new Session();

    if ($_SESSION["pos_user"] === null || $_SESSION["pos_staff"] === true) {
        redirect_to("error.php");
    }    

    $empty_category = false;

    if (isset($_POST["submit"])) {
        $category_name = escape($_POST["category_name"]);

        if (empty($category_name)) {
            $empty_category = true;
        } else {
            $category = $category_db->add_category($category_name);
        }
    }

?>
<?php
    function create_category($category) {
        $category_id = $category["category_id"];
        $add = '<a href="#" data-toggle="modal" data-target="#add_category"><span class="fa fa-plus"></span> Add category</a>';
        $edit = '<a id="edit" class="pointer" style="margin-left: 5px;" onclick="category_edit('.$category_id.')"><span class="glyphicon glyphicon-pencil"></span> Edit</a>';
        $delete = '<a class="pointer link-red" style="margin-left: 5px;" onclick="category_delete('.$category_id.')"><span class="glyphicon glyphicon-trash"></span> Delete</a>';
        $ul = '
            <ul id="'. $category["category_id"]  .'" class="li-category">
                <li class="category_name"><span class="spanCategoryName">' . $category["category_name"] . '</span>' . $edit . $delete .'</li>
            </ul>';
        $html = '
            <tr id="'.$category_id.'" class="td-category">
                <td class="category_name text-center">' . $category["category_name"] . '</td>
                <td class="text-center">'.$add.$edit.$delete.'</td>
            </tr>
        ';
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
                    <div class="panel panel-default" >
                        <div class="panel-heading">
                            <h3>
                                Manage categories
                            </h3>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" >
                            <table class="table table-bordered table-striped" id="category_list" style="width:50%; margin: 0 auto;">
                                <thead>
                                    <tr>
                                        <th class="text-center">Name</th>
                                        <th id="action" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $query = $category_db->get_all_category();
                                        $tds = '';
                                        $td = '';
                                        foreach ($query as $category) {
                                            $tds .= create_category($category);
                                        }
                                        $td .= $tds;
                                        echo $td;
                                    ?>
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->

                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <form method="post" autocomplete="off" role="form" id="category_form">
        <div class="modal fade" id="add_category" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title">Please enter Category Name</h4>
                    </div>
                    <div class="modal-body"> 
                            <div class="form-group">
                                <label for="cats" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Category Name:</label>
                                <div class="col-sm-9 col-md-9 col-lg-10">
                                    <input name="category_name" value="" id="category_name" class="form-control form-inps" type="text">
                                    <span class="text-danger" style="display:none;" id="empty_category">Category is empty.</span>

                                </div>
                            </div>
                    </div>

                    <div class="modal-footer" style="margin-top: 40px;">
                        <button type="submit" class="btn btn-primary pull-right" name="submit">Submit</button>
                    </div>
                </div>  
            </div>
        </div>
    </form>
    <!-- /#add_category -->
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
    <script src="js/category.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#category_list').DataTable({
                responsive: true,
                "order": [[ 0, "desc" ]],     
            });
        });
    </script>
</body>

</html>
