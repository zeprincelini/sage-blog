<?php
	require_once ("include/db.php");
	require_once ("include/session.php");
	require_once ("include/redirect.php");
	if(!isset($_SESSION['name'])){
		$_SESSION['ErrorMessage'] = 'Login Required';
		redirect('login.php');
	}
?>
<?php
	if(isset($_POST['submit'])){
		$admin_name = mysqli_real_escape_string($connect,$_POST['name']);
		$admin_pass = mysqli_real_escape_string($connect,$_POST['password']);
		$admin_pass_hash = password_hash($admin_pass, PASSWORD_DEFAULT);
		$admin_repass = mysqli_real_escape_string($connect,$_POST['repassword']);
		$admin_repass_hash = password_hash($admin_repass, PASSWORD_DEFAULT);
		$admin_level = mysqli_real_escape_string($connect,$_POST['level']);
		$current_time = time();
		$date = strftime("%B-%d-%Y %H:%M:%S", $current_time);
		
		//$admin = "DonLini";
		
		if(empty($admin_name) || empty($admin_pass) || empty($admin_repass)){
			$_SESSION['ErrorMessage'] = "Please fill out the fields";
			redirect("admin.php");	

		}elseif(strlen($admin_pass) < 6){
			$_SESSION['ErrorMessage'] = "6 characters or more required";
			redirect("admin.php");
		}elseif($admin_repass != $admin_pass){
			$_SESSION['ErrorMessage'] = "Passwords do not match";
			redirect("admin.php");
		}else{
			$insert = "INSERT INTO subadmin(datetime, name, password, repassword, level)VALUES('$date', '$admin_name', '$admin_pass_hash', '$admin_repass_hash', '$admin_level')";
			$query = mysqli_query($connect, $insert);
			if($query){
				$_SESSION['SuccessMessage'] = 'Admin Added successfully';
				redirect("admin.php");
			}else{
				$_SESSION['ErrorMessage'] = "Failed to Add Admin";
				redirect("admin.php");
			}
		}
	}
?>
<!doctype html>
<html lang="en">
	<head>
		<title>Manage Admins</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- Google Fonts -->
		<!--link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet"-->
		
		<!--stylesheets-->
		<link rel="stylesheet" href="css/admin.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
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
			<div class="rows">
				<!-- side nav begin-->
				<div class="col-sm-2">
					<h3>NO NAME</h3>
						<ul class="nav nav-pills nav-stacked" id="side">
							<li><a href="dashboard.php"><span class="fa fa-home"></span>&nbsp;Dashboard</a></li>
							<li><a href="addnewpost.php"><span class="fa fa-plus"></span>&nbsp;Add New Post</a></li>
							<li><a href="category.php"><span class="fa fa-tags"></span>&nbsp;Categories</a></li>
							<li class="active"><a href="admin.php"><span class="fa fa-user-plus"></span>&nbsp;Manage Admins</a></li>
							<li><a href="profile.php"><span class="fa fa-user"></span>&nbsp;Manage Profile</a></li>
							<li><a href="comment.php"><span class="fa fa-comment"></span>&nbsp;Comments</a></li>
							<li><a href="blog.php?Page=1"><span class="fa fa-play"></span>&nbsp;Live blog</a></li>
							<li><a href="logout.php"><span class="fa fa-sign-out-alt"></span>&nbsp;Logout</a></li>
						</ul>
					
				</div>
				<!-- side nav end-->
				
				
				<!-- main area begin -->
				<div class="col-sm-10">
					<h1>Manage Admins</h1>
					<?php
						echo error();
						echo success();
					?>
					<br>
					<div id="form">
						<form action = "admin.php" method = "post">
							<div class="form-group">
								<label for = "myform1">Username:</label>
								<input class = "form-control" type= "text" placeholder= "" name="name" id="myform1">
							</div>
							<div class="form-group">
								<label for = "myform2">Password:</label>
								<input class = "form-control" type= "password" placeholder= "" name="password" id="myform2">
							</div>
							<div class="form-group">
								<label for = "myform3">Confirm Password:</label>
								<input class = "form-control" type= "password" placeholder= "" name="repassword" id="myform3">
							</div>
							<div class="form-group">
								<label for = "myform4">Level:</label>
								<select id="myform4" class="form-control" name="level">
								<option>Admin</option>
								<option>Head Admin</option>
								</select>
							</div>
							<br>
							<br>
							<input class="btn btn-success btn-block" type="submit" name ="submit" value="Add New Admin">
							<br>
							<br>
						</form>
					</div>
					<br>
					<div class="table-responsive">
						<table class="table table-hover table-striped">
							<tr class="success">
								<th>Serial No</th>
								<th>Date <?php echo "&";?> time</th>
								<th>Name</th>
								<th>Added By</th>
								<th>Action</th>
							</tr>
							
							<?php
							$sn = 0;
							$view = "SELECT * FROM admin , subadmin ORDER BY datetime desc";
							$query = mysqli_query($connect, $view);	
							while($data = mysqli_fetch_array($query)){
								$id = $data['id'];
								$date = $data['datetime'];
								$name = $data['name'];
								$creator = $data['adminname'];
								$sn++;
							
							?>
						
							<tr>
								<td><?php echo $sn ?></td>
								<td><?php echo $date ?></td>
								<td><?php echo $name ?></td>
								<td><?php echo $creator ?></td>
								<td><a href="deleteadmin.php?id=<?php echo $id;?>"><span class="btn btn-danger">Delete</span></a></td>
							</tr>
							<?php } ?>
						</table>
					</div>
				</div>
				<!-- main area begin -->
			</div>

		</div>
		<!-- container ends-->
		
		<!--footer begins -->
		<div id="footer">
			<footer class="text-center">
					Powered by | DonLini.io | 2019 © All Rights Reserved.
			</footer>
		</div>
		<!-- footer ends -->
	<!-- scripts -->
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	</body>
</html>