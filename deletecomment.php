<?php
	require_once ("include/db.php");
	require_once ("include/session.php");
	require_once ("include/redirect.php");
	if(!isset($_SESSION['name'])){
		$_SESSION['ErrorMessage'] = 'Login Required';
		redirect('login.php');
	}
?>
<!doctype html>
<html lang="en">
	<head>
		<title>no name yet</title>
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
	<!--nav class="navbar navbar-default" id="navbar-scroll">
		<div class="container">
			<div class="row">
			
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
						<span class="sr-only">Navigation Toggle</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="blog.php">Blank</a>
				</div>
				<div class="collapse navbar-collapse" id="navbar-collapse">
					<ul class="nav navbar-nav">
						<li class="aactive"><a href="#">Home</a></li>
						<li><a href="blog.php" target="_blank">Blog</a></li>
						<li><a href="#">About Us</a></li>
						<li><a href="#">Services</a></li>
						<li><a href="#">Contact Us</a></li>
						<li><a href="#">Features</a></li>
					</ul>
					<form action="blog.php" class="navbar-form navbar-right">
					<div class="form-group">
						<input type="text" placeholder="Search" name="search" class="form-control">
					</div>
					<button class="btn btn-default" name="searchbtn">GO</button>
				</form>
				</div>	
			</div>
		</div>
		<div id="ln"></div>
	</nav-->
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
							<li><a href="profile.php"><span class="fa fa-user"></span>&nbsp;Manage Profile</a></li>
							<?php
								}
							?>
							<li class="active"><a href="comment.php"><span class="fa fa-comment"></span>&nbsp;Comments</a></li>
							<li><a href="blog.php?Page=1"><span class="fa fa-play"></span>&nbsp;Live blog</a></li>
							<li><a href="logout.php"><span class="fa fa-sign-out-alt"></span>&nbsp;Logout</a></li>
						</ul>
					
				</div>
				<!-- side nav end-->
				
				
				<!-- main area begin -->
				<div class="col-sm-10">
					<h1>Delete comments</h1>
					<?php
						echo error();
						echo success();
					?>
					<?php
						$comment_id = $_GET['id'];
						$query = "SELECT * FROM comments WHERE id = '$comment_id' ";
						$execute = mysqli_query($connect, $query);
						while($data = mysqli_fetch_array($execute)){
							$id = $data['id'];
							$name = $data['name'];
							$email = $data['email'];
							$comment = $data['comment'];
						}
					?>
					<div class="delform">
						<form action = "deletecomment.php?id=<?php echo $comment_id;?>" method = "post" enctype="multipart/form-data">
							<div class="form-group">
								<label for = "post_name">Name</label>
								<input class = "form-control" type= "text" placeholder= "name" name="Name" id="post_name" style="color:black;" 
								value="<?php echo $name; ?>" disabled>
							</div>
							<div class="form-group">
								<label for = "post_email">Email</label>
								<input class = "form-control" type= "email" placeholder= "email" name="Email" id="post_email"
								value="<?php echo $email; ?>" disabled>
							</div>
							<div class="form-group">
								<label for = "post_comment">Comment</label>
								<textarea class = "form-control" name="Comment" id="post_comment" disabled><?php echo $comment; ?></textarea>
							</div>
							<br>
							<input class="btn btn-danger" type="submit" name ="submit" value="Delete Comment">
							<br>
							<br>
						</form>
					</div>
					<?php
						$comment_id = $_GET['id'];
						if(isset($_POST['submit'])){
							$delete = "DELETE FROM comments WHERE id = '$comment_id'";
							$query = mysqli_query($connect, $delete);
							if($query){
								$_SESSION['SuccessMessage'] = 'Comment Deleted Successfully';
								redirect('comment.php');
							}else{
								$_SESSION['ErrorMessage'] = 'Error, Try again';
								redirect('comment.php');
							}
						}
					?>
						
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