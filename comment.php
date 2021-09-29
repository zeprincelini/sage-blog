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
					<h1>Approved comments</h1>
					<?php
						echo error();
						echo success();
					?>
						<div class="table-responsive">
							<table class="table table-striped table-hover text-center">
								<tr class="success">
									<th class="text-center">SN</th>
									<th class="text-center">Name</th>
									<th class="text-center">Date</th>
									<th class="text-center">Comment</th>
									<th class="text-center">Revert-Approve</th>
									<th class="text-center">Delete Comment</th>
									<th class="text-center">Details</th>
								</tr>
								
								<?php
								$sn = 0;
									$get = "SELECT * FROM comments WHERE status = 'ON' ORDER BY datetime desc";
									$execute = mysqli_query($connect, $get);
									while($data = mysqli_fetch_array($execute)){
										$comment_id = $data['id'];
										$name = $data['name'];
										$date = $data['datetime'];
										$comment = $data['comment'];
										$comment_post_id = $data['admin_panel_id'];
										$sn++;
									
								?>
								<tr>
									<td><?php echo htmlentities($sn); ?></td>
									<td style="color: #5e5eff;"><?php 
									if(strlen($name) > 15){
										$name = substr($name, 0, 15).'...';
									}
									echo htmlentities($name); ?></td>
									<td><?php 
									if(strlen($date)>16){
										$date= substr($date, 0, 16).'...';
									}
									echo htmlentities($date); ?></td>
									<td><?php 
									if(strlen($comment) > 20){
										$comment = substr($comment, 0, 20)."...";
									}
									echo htmlentities($comment); ?></td>
									<td><a href = "disapprove.php?id=<?php echo $comment_id;?>"><span class="btn btn-warning">Disapprove</span></a></td>
									<td><a href = "deletecomment.php?id=<?php echo $comment_id; ?>"><span class="btn btn-danger">Delete</span></a></td>
									<td><a href = "fullpost.php?id=<?php echo $comment_post_id; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a></td>
								</tr>
									<?php } ?>
							</table>
						</div>
						<br>
						<br>
						<h1>Disapproved comments</h1>
		
						<div class="table-responsive">
							<table class="table table-striped table-hover text-center">
								<tr class="danger">
									<th class="text-center">SN</th>
									<th class="text-center">Name</th>
									<th class="text-center">Date</th>
									<th class="text-center">Comment</th>
									<th class="text-center">Approve</th>
									<th class="text-center">Delete Comment</th>
									<th class="text-center">Details</th>
								</tr>
								
								<?php
								$sn = 0;
									$get = "SELECT * FROM comments WHERE status = 'OFF' ORDER BY datetime desc";
									$execute = mysqli_query($connect, $get);
									while($data = mysqli_fetch_array($execute)){
										$comment_id = $data['id'];
										$name = $data['name'];
										$date = $data['datetime'];
										$comment = $data['comment'];
										$comment_post_id = $data['admin_panel_id'];
										$sn++;
									
								?>
								<tr>
									<td><?php echo htmlentities($sn); ?></td>
									<td style="color: #5e5eff;"><?php 
									if(strlen($name) > 15){
										$name = substr($name, 0, 15).'...';
									}
									echo htmlentities($name); ?></td>
									<td><?php 
									if(strlen($date)>16){
										$date= substr($date, 0, 16).'...';
									}
									echo htmlentities($date); ?></td>
									<td><?php 
									if(strlen($comment) > 20){
										$comment = substr($comment, 0, 20)."...";
									}
									echo htmlentities($comment); ?></td>
									<td><a href = "approve.php?id=<?php echo $comment_id; ?>"><span class="btn btn-success">Approve</span></a></td>
									<td><a href = "deletecomment.php?id=<?php echo $comment_id;?>"><span class="btn btn-danger">Delete</span></a></td>
									<td><a href = "fullpost.php?id=<?php echo $comment_post_id; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a></td>
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