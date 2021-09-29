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
		$name = mysqli_real_escape_string($connect, $_POST['name']);
		$post = mysqli_real_escape_string($connect, $_POST['post']);
		$image = $_FILES['image']['name'];
		$target = "profile_pic/".basename($_FILES['image']['name']);
		$current_time = time();
		$date = strftime("%B-%d-%Y %H:%M:%S", $current_time);
		
		//$admin = "DonLini";
		
		if(empty($name)){
			$_SESSION['ErrorMessage'] = "Name cannot be empty";
			redirect("profile.php");	

		}/*else if(empty($post)){
			$_SESSION['ErrorMessage'] = "Post cannot be empty";
			redirect("profile.php");	
			
		}*/else{
			$insert = "UPDATE profile SET datetime = '$date', name = '$name', about = '$post', pic = '$image'";
			$query = mysqli_query($connect, $insert);
			move_uploaded_file($_FILES['image']['tmp_name'],$target);
			if($query){
				$_SESSION['SuccessMessage'] = 'Profile Updated successfully';
				redirect("profile.php");
			}else{
				$_SESSION['ErrorMessage'] = "Failed to Update..Try Again";
				redirect("profile.php");
			}
		}
	}
?>
<!doctype html>
<html lang="en">
	<head>
		<title>Profile</title>
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
							
							<?php 
							if($_SESSION['level'] == 'Head Admin'){
							
							?>
							<li id="access"><a href="admin.php"><span class="fa fa-user-plus"></span>&nbsp;Manage Admins</a></li>
							<li class="active"><a href="profile.php"><span class="fa fa-user"></span>&nbsp;Manage Profile</a></li>
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
					<h1>Manage Profile</h1>
					<?php
						echo error();
						echo success();
					?>
					<br>
					<div id="form">
					<?php
						$query = "SELECT * FROM profile";
						$execute = mysqli_query($connect, $query);
						$data = mysqli_fetch_assoc($execute);
							$username = $data['name']; 
							$userinfo = $data['about'];
							$userpic = $data['pic'];
						
					?>
						<form action = "profile.php" method = "post" enctype="multipart/form-data">
						<span><?php if($userpic == ""){
							echo '<img class="img-responsive" src="profile_pic/userpic.png" height="100px" width="100px">';
						}else{
							echo '<img class="img-responsive img-rounded" src="profile_pic/'.$userpic.'" height="100px" width="180px">';
						}
						?>
							<div class="form-group">
								<!--label for = "post_image">Image</label--><hr>
								<input class = "" type= "file" name="image" id="post_image">
							</div>
							<div class="form-group">
								<label for = "post_name">Name</label>
								<input class = "form-control" type= "text" placeholder= "Name" name="name" id="post_name" value="<?php echo $username;?>">
							</div>
							<div class="form-group">
								<label for = "post_text">About Me</label>
								<textarea class = "form-control" name="post" id="post_text"><?php echo $userinfo;?></textarea>
							</div>
							<br>
							<br>
							<input class="btn btn-success btn-block" type="submit" name ="submit" value="Post">
							<br>
							<br>
						
						</form>
					</div>
					<br>
						
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