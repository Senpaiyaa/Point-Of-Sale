<?php
	require_once 'class/Functions.php';
	require_once 'class/Staff.php';
	require_once 'class/Admin.php';
	require_once 'class/Session.php';

	$error	  = false;
	$message  = "";
	$staff_db = new Staff();
	$admin_db = new Admin();
	$session  = new Session();

	if (isset($_SESSION["pos_admin"])) {
		if ($_SESSION["pos_admin"] == true) {
			redirect_to("dashboard.php");
		}
	}

	if (isset($_SESSION["pos_staff"])) {
		if ($_SESSION["pos_staff"] == true) {
			redirect_to("save_sales.php");
		}
	}

	if (isset($_POST["login"])) {

		$username  = escape($_POST["user"]);
		// use md5 hash to login
		$password  = md5($_POST["pwd"]);

		$staff = $staff_db->find_staff($username, $password); 

		if ($staff != false) {
	        foreach ($staff as $key) {

    			if ($key["password"] != $password) {
    				$message = "Wrong password, please check your password.";
    			} else {
	        		$pos_user = array("user_type" => "Staff", "staff_id" => $key["staff_id"], "user" => $key["username"],"name" => $key["name"]);
		            $_SESSION["pos_user"]  = $pos_user; 
		            $_SESSION["pos_login"] = true;
		            $_SESSION["pos_staff"] = true;
		            $activity = "username with ".$pos_user["user"] . ' ' . " has logged in";
		            $staff_db->create_activity($pos_user["user_type"], $activity);
		            redirect_to("save_sales.php");						
       			}
	        }
		} else {
			$error   = true;
			$message = "Incorrect username or password. Please try again.";
		}


		$admin = $admin_db->find_admin($username, $password);

		if ($admin != false) {
	        foreach ($admin as $key) {
	        	if ($key["password"] != $password) {
       				$message = "Wrong password, please check your password.";
	        	} else {
				    $pos_user = array("user_type" => "Administrator","admin_id" => $key["admin_id"], "user" => $key["username"]);
				    $_SESSION["pos_user"] = $pos_user;
		            $_SESSION["pos_login"] = true;
		            $_SESSION["pos_admin"] = true;
		            $activity = "username with ".$pos_user["user"] . ' ' . " has logged in";
		            $admin_db->create_activity($pos_user["user_type"], $activity);
		        	redirect_to("dashboard.php");	        		
		        }
			}
		} else {
			$error = true;
			$message = "Incorrect username or password. Please try again.";
		}
	}

?>
<?php require_once 'layouts/login_html.php' ?>
<div class="login">
	<div class="container-fluid">
	    <div class="row">
			<i class="fa fa-clock-o icon-clock fa-3x"></i>
			<div class="panel-heading">
				<h1 class="text-center">Sign in to 24 Beinte Quatro Minimart Point Of Sale System</h1>
			</div>
			<div class="col-md-4 col-md-offset-4">
				<div class="post_error">
		 			<?php
		 				if ($error == true) {
							$message = "<center><div class='alert alert-danger' role='alert' id='message'>{$message}</div></center>";
							echo $message;
		 				}
		 			?>
				</div>
	    		<div class="panel panel-default">
				  	<div class="panel-body">
				    	<form accept-charset="UTF-8" role="form" method="post" id="login_form">
					    	<div class="form-group">
				    			<input type="text" id="username" name="user" class="form-control" placeholder="Username" tabindex="1">
					    	</div>
					    	<div class="form-group">
					    		<input class="form-control" placeholder="Password" name="pwd" type="password" id="password" tabindex="2">
					    	</div>
				    		<button class="btn btn-primary btn-block" type="submit" name="login" tabindex="3">Login</button>
				      	</form>
				    </div>
				</div>
				<?php require_once 'layouts/footer.php'; ?>
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

<!-- Custom Theme JavaScript -->
<script src="dist/js/sb-admin-2.js"></script>

<script src="js/login.js"></script>
</body>
</html>

