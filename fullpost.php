<?php
	require_once ("include/db.php");
	require_once ("include/session.php");
	require_once ("include/redirect.php");
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
	</nav>
	<div class="container">
		<h1>Welcome to blank</h1>
		<div class="row">
			<div class="col-sm-8">
			<?php
						echo error();
						echo success();
					?>
				<?php
				if(isset($_GET['searchbtn'])){
					$search = $_GET['search'];
					$getter_query = "SELECT * FROM admin_panel WHERE datetime LIKE '%$search%' OR title LIKE '%$search%'
					OR category LIKE '%$search%'
					OR author LIKE '%$search%'
					OR post LIKE '%$search%'";	
				}else{
					$post_id_from_url = $_GET['id']; 
					$getter_query = "SELECT * FROM admin_panel WHERE id = '$post_id_from_url' ORDER BY datetime desc";}
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
								echo nl2br($post);
							?>
						</p>
					</div>
				</div>
					<?php } ?>
					<br>
					<br>
					<span>Love to hear your thoughts.</span>
					<br>
					<br>
				<div id="form">
				<?php
					if(isset($_POST['submit'])){
						$current_time = time();
						$post_id_from_url = $_GET['id']; 
						$date = strftime("%B-%d-%Y %H:%M:%S", $current_time);
						$name = mysqli_real_escape_string($connect, $_POST['Name']);
						$email = mysqli_real_escape_string($connect, $_POST['Email']);
						$comment = mysqli_real_escape_string($connect, $_POST['Comment']);
						
						if(empty($name) || empty($email) || empty($comment)){
							$_SESSION['ErrorMessage'] = "All Fields are required";
						}elseif(strlen($comment) > 2000){
							$_SESSION['ErrorMessage'] = "Only 2000 characters allowed";
						}else{
							$query = "INSERT INTO comments (datetime, name, email, comment, status, admin_panel_id) 
							VALUES ('$date', '$name', '$email', '$comment', 'ON', $post_id_from_url)";
							$execute = mysqli_query($connect, $query);
							if($execute){
								$_SESSION['SuccessMessage'] = 'Comment Added Successfully'; 
							redirect('fullpost.php?id='.$post_id_from_url);
							}else{
								$_SESSION['ErrorMessage'] = 'Comment Not Added, Try again'; 
								redirect('fullpost.php?id='.$post_id_from_url);
							}
						}
					}
				
				?>
						<form action = "fullpost.php?id=<?php echo $post_id_from_url; ?>" method = "post" enctype="multipart/form-data">
							<div class="form-group">
								<label for = "post_name">Name</label>
								<input class = "form-control" type= "text" placeholder= "name" name="Name" id="post_name" style="color:black;">
							</div>
							<div class="form-group">
								<label for = "post_email">Email</label>
								<input class = "form-control" type= "email" placeholder= "email" name="Email" id="post_email">
							</div>
							<div class="form-group">
								<label for = "post_comment">Comment</label>
								<textarea class = "form-control" name="Comment" id="post_comment"></textarea>
							</div>
							<br>
							<input class="btn btn-primary" type="submit" name ="submit" value="Add Comment">
							<br>
							<br>
						</form>
					</div>
					<br>
					<?php
							$comment_post_id = $_GET['id'];
							$comment_getter = "SELECT * FROM comments WHERE admin_panel_id = '$post_id_from_url' AND status = 'ON'";
							$execute = mysqli_query($connect, $comment_getter);
							while($data = mysqli_fetch_array($execute)){
								$commenter_name = $data['name'];
								$commenter_date = $data['datetime'];
								$commenter_post = $data['comment'];
							
						?>
						<style>
						#com{
							background: #f6f7f9;	
						}
						#com_name{
							color: blue;
							font-weight: bold;
						}
						</style>
						<div id="com">
							<img class = "pull-left" src="img/userpic.png" width="70px" height="70px" style="margin-left:10px; margin-top:10px;">
							<p id="com_name"><?php echo $commenter_name; ?></p>
							<p><?php echo $commenter_date; ?></p><br>
							<p><?php echo nl2br($commenter_post); ?></p>
						</div>
						<hr>
						<?php } ?>
			</div>
			<div class="col-sm-offset-1 col-sm-3">
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