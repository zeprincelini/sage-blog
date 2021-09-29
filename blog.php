<?php
	require_once ("include/db.php");
	//require_once(header("location:blog.php?Page=1"));
	/*session_start();
	$_SESSION['cr'] = "go";
	if(isset($_SESSION['cr'])){
		header("location:blog.php?Page=1");
	}*/
	//include($_SERVER['DOCUMENT_ROOT']. "/cms/css/admin.css")
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
		<link rel="stylesheet" href="css/blog.css">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<script>//window.location.href = "blog.php?Page=1";</script>

		<!--link rel="stylesheet" href="css/jquery-ui.min.css"-->
		
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
	</head>
	<body>
		<nav class="navbar navbar-default" id="navbar-scroll">
		
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
					<!--ul class="nav navbar-nav">
						<li class="active"><a href="#">Home</a></li>
						<li><a href="#">Blog</a></li>
						<li><a href="#">About Us</a></li>
						<li><a href="#">Services</a></li>
						<li><a href="#">Contact Us</a></li>
						<li><a href="#">Features</a></li>
					</ul-->
					
					<form action="blog.php" class="navbar-form">
					<div class="form-group" id="searchform">
						<input type="text" placeholder="Search" name="search" class="form-control">
							<button class="btn btn-default" type="submit" name="searchbtn">GO</button>
					</div>
					
				</form>
				</div>	
			</div>
		</div>
		<div id="ln"></div>
	</nav>
	
	<div class="container">
		<h1>Welcome to blank</h1>
		<div class="row">
			<div class="col-sm-8">
				<?php
				//query to display contents according to search
				if(isset($_GET['searchbtn'])){
					$search = $_GET['search'];
					$getter_query = "SELECT * FROM admin_panel WHERE datetime LIKE '%$search%' OR title LIKE '%$search%'
					OR category LIKE '%$search%'
					OR author LIKE '%$search%'
					OR post LIKE '%$search%'";	
				}
				elseif(isset($_GET['Page'])){
					//query when pagination is active i.e blog.php?Page=1
					$page = $_GET['Page'];
					if($page <= 0){
						$showpostfrom = 0;
					}else{
					$showpostfrom = ($page * 5) - 5;
					}
					$getter_query = "SELECT * FROM admin_panel ORDER BY datetime desc LIMIT $showpostfrom, 5";
				}else{//default query to display blog contents
					$getter_query = "SELECT * FROM admin_panel ORDER BY datetime desc LIMIT 0, 5";}
					$execute = mysqli_query($connect, $getter_query);
					while($datarow = mysqli_fetch_array($execute)){
						$id = $datarow['id'];
						$datetime= $datarow['datetime'];
						$title = $datarow['title'];
						$category = $datarow['category'];
						$author = $datarow['author'];
						$image = $datarow['image'];
						$post = $datarow['post'];
				?>
				<div class="blogpost thumbnail">
					<img class="img-responsive img-rounded" src="uploads/<?php echo $image; ?>">
					<div class="caption">
						<h1 id ="title"><?php echo htmlentities($title); ?></h1>
						<p class="description">Category: <?php echo htmlentities($category); ?> Published on <?php echo htmlentities($datetime); ?></p>
						<p class="post">
							<?php
								if(strlen($post) > 150){
									$post = substr($post, 0, 150).'...';
								}
								echo $post;
							?>
						</p>
						<a class="pull-right" href="fullpost.php?id=<?php echo $id; ?>"><span class="btn btn-info read">Read More &rsaquo;&rsaquo;</span></a>
					</div>
				</div>
					<?php } ?>
					<nav>
						<ul class="pagination pull-left">
						
					<?php
					if(isset($page)){
						//creating the backward button
						if($page>1){
				
					?>
							<li><a href="blog.php?Page=<?php echo $page - 1; ?>">&laquo;</a></li>
						
					<?php }
					} ?>
					<?php
					//getting the total no of posts and pages
						$query = "SELECT COUNT(*) FROM admin_panel";
						$executer = mysqli_query($connect, $query);
						$data= mysqli_fetch_array($executer);
						$totalpost = array_shift($data);
						//echo $totalpost;
						$pageamount = $totalpost / 5;
						$pageamount = ceil($pageamount);
						for($i = 1; $i <= $pageamount; $i++){
						if(isset($page)){
							if($i == $page){
					?>
						<li class="active"><a href="blog.php?Page=<?php echo $i; ?>"><?php echo $i;?></a></li>
						<?php 
							}else{
						?>
						<li><a href="blog.php?Page=<?php echo $i; ?>"><?php echo $i;?></a></li>
						<?php
							}
						 }
						} ?>
						<?php
						//creating the forward button
						if(isset($page)){
							if($page+1 <= $pageamount){
				
					?>
							<li><a href="blog.php?Page=<?php echo $page + 1; ?>">&raquo;</a></li>
						
					<?php }
					} ?>
						
						</ui>
					</nav>
			</div>
			<div class="col-sm-offset-1 col-sm-3">
			<?php
				$query = "SELECT * FROM profile";
				$exe = mysqli_query($connect, $query);
				$data = mysqli_fetch_assoc($exe);
				$userpic = $data['pic'];
				$username = $data['name'];
				$userinfo = $data['about'];
			?>
			<br>
			<br>
			<br>
			<br>
			<center><h2>About Me</hr><img src="profile_pic/<?php echo $userpic;?>" class="img-responsive img-circle" style="max-width:200px;display:block;"></center><br>
			<p style="color:black; font-weight: bold; font-size: 17px;text-align:center;text-transform: uppercase;"><?php echo $username;?></p><hr>
			<h5 style="text-align: center; font-size: 16px; color: black;"><?php echo $userinfo;?></h5>
			<hr>
			<!--div class="panel" style="background: brown;color: white;">
				<div class="panel-heading">
					<h2 class="panel-title">Category</h2>
				</div>
				<div class="panel-body" style="background: white; color:black;">
				dummycontent
				</div>
				<div class="panel-footer">
				</div>
			</div-->
			
			<div class="panel side">
				<div class="panel-heading">
					<h2 class="panel-title">Recent Posts</h2>
				</div>
				<?php
				$selector = "SELECT * FROM admin_panel ORDER BY datetime desc LIMIT 0, 4";
				$executor = mysqli_query($connect, $selector);
				while($rows = mysqli_fetch_assoc($executor)){
					$mini_id = $rows['id'];
					$mini_date = $rows['datetime'];
					$mini_image = $rows['image'];
					$mini_title = $rows['title'];
					$mini_category = $rows['category'];
			?>
				<div class="panel-body" style="background: white; color:black;">
				<img src="uploads/<?php echo $mini_image; ?>" width="100px" height="100px;" class="img-responsive pull-left">
				<a href="fullpost.php?id=<?php echo $mini_id;?>">
				<p style="font-weight: bold; margin-left: 20px;"><?php echo $mini_title; ?></p>
				<p style="margin-left: 20px;"><?php if(strlen($mini_date)>16){
					$mini_date= substr($mini_date, 0, 16).'...';
					echo $mini_date;
				} ?></p>
				</a>
				<hr>
				</div>
				
				<?php } ?>
				<div class="panel-footer">
				</div>
			</div>
			
			</div>
		</div>
	</div>
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