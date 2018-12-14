<div class="panel-header-blue">
    <div class="col-lg-12">
        <div class="panel-heading clearfix">
            <button href="#menu-toggle" class="btn btn-primary-outline glyphicon glyphicon-th-list pull-left" id="menu-toggle"></button>
            <h4 class="panel-title pull-left" style="padding-top: 7.5px; padding-left: 5px;">24 Beinte Quatro Minimart Co.</h4>
            <div class="pull-right" style="margin: 6px; padding: 5px">
                <span style="">
                    <?php
                        date_default_timezone_set('Asia/Kuala_Lumpur');
                        $time = date("jS F l h:i A");
                        echo $time;
                    ?>
                </span>                
                <span href="#" style="margin-left: 15px;">
                    <span class="glyphicon glyphicon-user">
                        <?php
                            $current_logged = $_SESSION["pos_user"]["user"];
                            $logged = "{$current_logged}";
                            echo $logged . "<br>";                
                        ?>                                        
                    </span>
                    <!-- <span class="glyphicon glyphicon-triangle-bottom"></span> -->
                </span>
            </div>
        </div>
        
    </div>
</div>
