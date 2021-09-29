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
		$title = mysqli_real_escape_string($connect, $_POST['Title']);
		$category = mysqli_real_escape_string($connect, $_POST['Category']);
		$post = mysqli_real_escape_string($connect, $_POST['Post']);
		$image = $_FILES['Image']['name'];
		$target = "uploads/".basename($_FILES['Image']['name']);
		$current_time = time();
		$date = strftime("%B-%d-%Y %H:%M:%S", $current_time);
		
		$admin = "DonLini";
		
		if(empty($title)){
			$_SESSION['ErrorMessage'] = "Title cannot be empty";
			redirect("addnewpost.php");	

		}else if(empty($post)){
			$_SESSION['ErrorMessage'] = "Post cannot be empty";
			redirect("addnewpost.php");	
			
		}else{
			$insert = "INSERT INTO admin_panel(datetime, title, category, author, image, post)
			VALUES('$date','$title', '$category', '$admin', '$image', '$post')";
			$query = mysqli_query($connect, $insert);
			move_uploaded_file($_FILES['Image']['tmp_name'],$target);
			if($query){
				$_SESSION['SuccessMessage'] = 'Post Added successfully';
				redirect("addnewpost.php");
			}else{
				$_SESSION['ErrorMessage'] = "Failed to Add Post..Try Again";
				redirect("addnewpost.php");
			}
		}
	}
?>
<!doctype html>
<html lang="en">
	<head>
		<title>Add New Post</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- Google Fonts -->
		<!--link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet"-->
		
		<!--stylesheets-->
		<link rel="stylesheet" href="css/admin.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
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
							<li class="active"><a href="addnewpost.php"><span class="fa fa-plus"></span>&nbsp;Add New Post</a></li>
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
					<h1>Add New Post</h1>
					<?php
						echo error();
						echo success();
					?>
					<br>
					<div id="form">
						<form action = "addnewpost.php" method = "post" enctype="multipart/form-data">
							<div class="form-group">
								<label for = "post_title">Title</label>
								<input class = "form-control" type= "text" placeholder= "title" name="Title" id="post_title">
							</div>
							<div class="form-group">
								<label for = "post_category">Category</label>
								<select class = "form-control" name="Category" id="post_category">
								<?php
									$get = "SELECT name FROM category";
									$query = mysqli_query($connect, $get);
									while($data = mysqli_fetch_array($query)){
										$cat_name = $data['name'];
								?>
									<option><?php echo $cat_name; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label for = "post_image">Image</label>
								<input class = "form-control" type= "file" name="Image" id="post_image">
							</div>
							<div class="form-group">
								<label for = "post_text">Post</label>
								<textarea class = "form-control" name="Post" id="post_text"></textarea>
							</div>
							<div>
							</div>
							<br>
							<br>
							<input class="btn btn-success btn-block" type="submit" name ="submit" value="Add New Post">
							<br>
							<br>
						</form>
					</div>
					<script>
						// Replace the <textarea id="editor1"> with a CKEditor
						// instance, using default configuration.
						CKEDITOR.replace( 'post_title' );
						CKEDITOR.replace( 'post_text' );
					</script>
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
	<script src="js/dashboard.js"></script>
	
	</body>
</html>