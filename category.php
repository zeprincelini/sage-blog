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
		$category = mysqli_real_escape_string($connect,$_POST['category']);
		
		$current_time = time();
		$date = strftime("%B-%d-%Y %H:%M:%S", $current_time);
		
		$admin = "DonLini";
		
		if(empty($category)){
			$_SESSION['ErrorMessage'] = "Please fill out the field";
			redirect("category.php");	

		}elseif(strlen($category) > 99){
			$_SESSION['ErrorMessage'] = "Name too long";
			redirect("category.php");
		}else{
			$insert = "INSERT INTO category(datetime, name, creatorname)VALUES('$date', '$category', '$admin')";
			$query = mysqli_query($connect, $insert);
			if($query){
				$_SESSION['SuccessMessage'] = 'Category Added successfully';
				redirect("category.php");
			}else{
				$_SESSION['ErrorMessage'] = "Failed to Add category";
				redirect("category.php");
			}
		}
	}
?>
<!doctype html>
<html lang="en">
	<head>
		<title>Category</title>
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
							<li class="active"><a href="category.php"><span class="fa fa-tags"></span>&nbsp;Categories</a></li>
							<?php 
							if($_SESSION['level'] == 'Head Admin'){
							
							?>
							<li id="access"><a href="admin.php"><span class="fa fa-user-plus"></span>&nbsp;Manage Admins</a></li>
							<li><a href="profile.php"><span class="fa fa-user"></span>&nbsp;Manage Profile</a></li>
							<?php
								}
							?>
							<li><a href="comment.php"><span class="fa fa-comment"></span>&nbsp;Comments</a></li>
							<li><a href="blog.php?Page=1"><span class="fa fa-play"></span>&nbsp;Live blog</a></li>
							<li><a href="logout.php"><span class="fa fa-sign-out-alt"></span>&nbsp;Logout</a></li>
						</ul>
					
				</div>
				<!-- side nav end-->
				
				
				<!-- main area begin -->
				<div class="col-sm-10">
					<h1>Manage Category</h1>
					<?php
						echo error();
						echo success();
					?>
					<br>
					<div id="form">
						<form action = "category.php" method = "post">
							<div class="form-group">
								<label for = "myform">Name:</label>
								<input class = "form-control" type= "text" placeholder= "name" name="category" id="myform">
							</div>
							<br>
							<br>
							<input class="btn btn-success btn-block" type="submit" name ="submit" value="Add New Category">
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
								<th>Creator</th>
								<th>Action</th>
							</tr>
							
							<?php
							$sn = 0;
							$view = "SELECT * FROM category ORDER BY datetime desc";
							$query = mysqli_query($connect, $view);
							
							while($data = mysqli_fetch_array($query)){
								$id = $data['id'];
								$date = $data['datetime'];
								$name = $data['name'];
								$creator = $data['creatorname'];
								$sn++;
							
							?>
						
							<tr>
								<td><?php echo $sn ?></td>
								<td><?php echo $date ?></td>
								<td><?php echo $name ?></td>
								<td><?php echo $creator ?></td>
								<td><a href="deletecategory.php?id=<?php echo $id;?>"><span class="btn btn-danger">Delete</span></a></td>
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