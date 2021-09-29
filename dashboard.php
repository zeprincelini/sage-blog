<?php
	require_once ("include/db.php");
	require_once ("include/session.php");
	require_once ("include/redirect.php");
	//session_start();
	if(!isset($_SESSION['name'])){
		$_SESSION['ErrorMessage'] = 'Login Required';
		redirect('login.php');
	}else{
		$_SESSION['SucessMessage'] = 'welcome '. $_SESSION['name'];
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
							<li class="active"><a href="dashboard.php"><span class="fa fa-home"></span>&nbsp;Dashboard</a></li>
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
							<li><a href="comment.php"><span class="fa fa-comment"></span>&nbsp;Comments</a></li>
							<li><a href="blog.php?Page=1"><span class="fa fa-play"></span>&nbsp;Live blog</a></li>
							<li><a href="logout.php"><span class="fa fa-sign-out-alt"></span>&nbsp;Logout</a></li>
						</ul>
					
				</div>
				<!-- side nav end-->
				
				
				<!-- main area begin -->
				<div class="col-sm-10">
					<h1>Admin Dashboard</h1>
					<?php
						echo error();
						echo success();
					?>
						<div class="table-responsive">
							<table class="table table-striped table-hover text-center">
								<tr class="success">
									<th class="text-center">SN</th>
									<th class="text-center">Published</th>
									<th class="text-center">Title</th>
									<th class="text-center">Author</th>
									<th class="text-center">Category</th>
									<th class="text-center">Banner</th>
									<th class="text-center">Comments</th>
									<th class="text-center">Actions</th>
									<th class="text-center">Details</th>
								</tr>
								
								<?php
								$sn = 0;
									$get = "SELECT * FROM admin_panel ORDER BY datetime desc";
									$execute = mysqli_query($connect, $get);
									while($data = mysqli_fetch_array($execute)){
										$id = $data['id'];
										$date = $data['datetime'];
										$title = $data['title'];
										$author = $data['author'];
										$category = $data['category'];
										$image = $data['image'];
										$post = $data['post'];
										$sn++;
								?>
								<tr>
									<td><?php echo $sn; ?></td>
									<td><?php 
									if(strlen($date)>16){
										$date= substr($date, 0, 16).'...';
									}
									echo $date; ?></td>
									<td id="ti" style="color:brown; font-weight: bold;"><?php 
										if(strlen($title)>30){
											$title = substr($title, 0 , 30).'...';
										}
										echo $title; ?></td>
									<td><?php echo $author; ?></td>
									<td><?php
											if(strlen($category)>12){
												$category = substr($category, 0 , 12).'...';
											}
											echo $category; ?></td>
									<td><img src="uploads/<?php echo $image; ?>" width="180px" height="100px" class="image-responsive"></td>
									<td>
										<?php
											$comment_count = "SELECT COUNT(*) FROM comments WHERE admin_panel_id = '$id' AND status = 'ON'";
											$query = mysqli_query($connect, $comment_count);
											$get_approved = mysqli_fetch_array($query);
											$total_approved = array_shift($get_approved);
											if($total_approved > 0){
										?>
											<span class="label pull-right label-success">
												<?php echo $total_approved; ?>
											</span>
											<?php } ?>
											
										<?php
											$comment_count = "SELECT COUNT(*) FROM comments WHERE admin_panel_id = '$id' AND status = 'OFF'";
											$query = mysqli_query($connect, $comment_count);
											$get_disapproved = mysqli_fetch_array($query);
											$total_disapproved = array_shift($get_disapproved);
											if($total_disapproved > 0){
										?>
											<span class="label pull-left label-warning">
												<?php echo $total_disapproved; ?>
											</span>
											<?php } ?>
										
										
									
									</td>
									<td class="atags">
										<span class="btn btn-warning"><a href="editpost.php?edit=<?php echo $id; ?>">Edit</a></span>
										 
										<span class="btn btn-danger"><a href="deletepost.php?delete=<?php echo $id; ?>">Delete</a></span>
									</td>
									<td class="atags">
										<span class="btn btn-primary"><a href="fullpost.php?id=<?php echo $id; ?>" target="_blank">Live Preview</a></span>
									</td>
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