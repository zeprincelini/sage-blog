<?php
	require_once ("include/db.php");
	require_once ("include/session.php");
	require_once ("include/redirect.php");
?>
<?php
	if(isset($_POST['submit'])){
		$user = mysqli_real_escape_string($connect, $_POST['username']);
		$pass = mysqli_real_escape_string($connect, $_POST['password']);
		$current_time = time();
		$date = strftime("%B-%d-%Y %H:%M:%S", $current_time);
		
		if(empty($user)){
			$_SESSION['ErrorMessage'] = "username cannot be empty";
			redirect("login.php");	

		}elseif(empty($pass)){
			$_SESSION['ErrorMessage'] = "Password cannot be empty";
			redirect("login.php");	
			
		}else{/*
				$insert = "SELECT * FROM subadmin WHERE name = '$user'";
				$query = mysqli_query($connect, $insert);
				if($query == FALSE) { 
				die(mysqli_error($connect)); // error handling
				}
				$result = mysqli_num_rows($query);
				if($result < 1){
					$_SESSION['ErrorMessage'] = 'Account not found';
					redirect("login.php");
				}elseif($row = mysqli_fetch_assoc($query)){
					$_SESSION['level']= $row['level'];
					$password_dehash = password_verify($pass, $row['password']);
					if($password_dehash){
						if($row['level'] == 'Head Admin'){
							$_SESSION['name']= $row['name'];
							$_SESSION['SuccessMessage'] = 'Welcome '.$_SESSION['name'];
							redirect("dashboard.php");
						}elseif($row['level']== 'Admin'){
							$_SESSION['name']= $row['name'];
							$_SESSION['SuccessMessage'] = 'Welcome '.$_SESSION['name'];
							redirect("dashboard.php");
						}else{
							$_SESSION['ErrorMessage'] = 'Account not found';
							redirect("login.php");
						}
					}
		
		}*/
		$check = "SELECT * FROM subadmin WHERE name = '$user'";
		$query = mysqli_query($connect, $check);
		if(mysqli_num_rows($query) < 1){
			$_SESSION['ErrorMessage'] = 'wrong username';
					redirect("login.php");
		}elseif($data = mysqli_fetch_assoc($query)){
			$pass_check = $data['password'];
			$dehash_pass = PASSWORD_VERIFY($pass, $pass_check);
			if($dehash_pass){
				$lev = $data['level'];
				if($lev == 'Head Admin'){
					$_SESSION['name'] = $data['name'];
					$_SESSION['level'] = $data['level'];
					$_SESSION['SuccessMessage'] = 'Welcome '.$_SESSION['name'];
					redirect('dashboard.php');
				}elseif($lev == 'Admin'){
					$_SESSION['name'] = $data['name'];
					$_SESSION['level'] = $data['level'];
					$_SESSION['SuccessMessage'] = 'Welcome '.$_SESSION['name'];
					redirect('dashboard.php');
				}
			}else{
				$_SESSION['ErrorMessage'] = 'wrong username or password';
					redirect("login.php");
			}
		}
		}
	}
?>
<!doctype html>
<html lang="en">
	<head>
		<title>Sign In</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- Google Fonts -->
		<!--link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet"-->
		
		<!--stylesheets-->
		<!--link rel="stylesheet" href="css/admin.css"-->
		<link rel="stylesheet" href="login.css">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		
		<!--link rel="stylesheet" href="css/jquery-ui.min.css"-->
		
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
	</head>
	<body>
		<!-- container begins -->
		<div class="container-fluid">
		<br>
		<div class="nav" style="min-height: 50px; background:white;"><span class="pull-left" style="color: brown; font-weight:bold; font-style:italic;">BLANK</span></div>
			<?php
				echo error();
				echo success();
	       ?>
			<div class="rows">
				<div class="col-sm-4 col-sm-offset-4 col-xm-4 col-xm-offset-4">
					<div class="panel panel-default">
					<div class="panel-heading text-center" style="color:brown;font-weight:bold;">SIGN IN</div>
						<div class="panel-body">
							<form action="login.php" method="post">
								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon"><span class="glyphicon"></span></span>
											<input type="text" placeholder="username" name="username" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon"><span class="glyphicon"></span></span>
											<input type="password" placeholder="password" name="password" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<input type="submit" name="submit" class="btn btn-block btn-lg" value="Login" style="background: brown; color:white;">
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- container ends-->
		
		<!--footer begins -->
		<div id="footer" style="margin-top: 100px;color:brown; font-weight: bold; padding-bottom:12px;">
			<footer class="text-center">
					Powered by | DonLini.io | 2019 © All Rights Reserved.
			</footer>
		</div-->
		<!-- footer ends -->
	<!-- scripts -->
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	</body>
</html>