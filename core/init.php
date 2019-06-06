<?php  
	session_start();
	ob_start();
	if(!file_exists('config/config.php')) {
		$error = '';
		if(isset($_POST['submit'])) {
			function clean($string) {
				return htmlentities($string, ENT_QUOTES, 'UTF-8');
			}

			$host = clean($_POST["host"]);
			$user = clean($_POST["user"]);
			$pass = clean($_POST["pass"]);
			$name = clean($_POST["name"]);

			if($pass == "no password") {
				$pass = "";
			}

			$con = mysqli_connect($host, $user, $pass, $name);

			if($con) {
				$my_file = 'config/config.php';
				$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
				$file_contents = "<?php 
	//Set up database
	define('HOST','{$host}');	
	define('USER','{$user}');	
	define('PASS','{$pass}');	
	define('NAME','{$name}');	
?>";
			fwrite($handle, $file_contents);
			header("Refresh: 0");	
			} else {
				$error = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
							  <strong>OOPS!</strong> You should check you connection info.
							  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
							    <span aria-hidden="true">&times;</span>
							  </button>
							</div>';
			}

			
		}
		echo '<div class="row" style="margin-top: 50px;">
			<div class="col-md-4">
				
			</div>
			<div class="col-md-4" style="padding: 10px; background: #222; color: #fff; border-radius: 10px; box-shadow: 7px 7px 7px black;">
				<h1 class="text-center">Database Details</h1>
				' . $error . '
				<form action="" method="post">
					<div class="form-group">
						<input type="text" class="form-control" name="host" placeholder="Database Host" required>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" name="user" placeholder="Database Username" required>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" name="pass" placeholder="Database Password" required>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" name="name" placeholder="Database Name" required>
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-primary btn-block" value="Set Connection Info" name="submit">
					</div>
				</form>
			</div>
			<div class="col-md-4">
				
			</div>
		</div>';
	} else {
		require_once "config/config.php";
		spl_autoload_register(function($class) {
			require_once "classes/{$class}.php";
			$class = new $class();
		});
	}
?>