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
		
			
			$id_url = $_GET['delete']; 
			$delete = "DELETE FROM admin_panel WHERE id = '$id_url'";
			$query = mysqli_query($connect, $delete);
			move_uploaded_file($_FILES['Image']['tmp_name'],$target);
			if($query){
				$_SESSION['SuccessMessage'] = 'Post Deleted successfully';
				redirect("dashboard.php");
			}else{
				$_SESSION['ErrorMessage'] = "Failed to Delete Post..Try Again";
				redirect("dashboard.php");
			}
	}
?>
<!doctype html>
<html lang="en">
	<head>
		<title>Delete Post</title>
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
				<div class="col-sm-10" style="color:brown;">
					<h1>Delete Post</h1>
					
					<br>
					
					<?php
						$ID = $_GET['delete'];
						$getter = "SELECT * FROM admin_panel WHERE id = '$ID'";
						$execute = mysqli_query($connect, $getter);
						while($data = mysqli_fetch_array($execute)){
							$title_to_be_deleted = $data['title'];
							$category_to_be_deleted = $data['category'];
							$image_to_be_deleted = $data['image'];
							$post_to_be_deleted = $data['post'];
						}
						
					?>

					<div id="form">
					
						<form action = "deletepost.php?delete=<?php echo $ID; ?>" method = "post" enctype="multipart/form-data">
							<div class="form-group">
								<label for = "post_title">Title</label>
								<input disabled class = "form-control" value="<?php echo $title_to_be_deleted; ?>" type= "text" placeholder= "title" name="Title" id="post_title">
							</div><br>
							<div class="form-group">
								<!--span>Existing Category:</span><span style="font-weight: bold;"><?php echo $category_to_be_deleted; ?></span><br><br-->
								<label for = "post_category">Category</label>
								<select disabled class = "form-control" name="Category" id="post_category">
								<?php
									$get = "SELECT name FROM category";
									$query = mysqli_query($connect, $get);
									while($data = mysqli_fetch_array($query)){
										$cat_name = $data['name'];
								?>  
									<option selected = "selected"><?php echo $category_to_be_deleted;?></option>
									<option><?php echo $cat_name; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<span class="FieldInfo"><img src="uploads/<?php echo $image_to_be_deleted;?>" height="100px" width="180px"></span><br><br>
								<!--label for = "post_image">Image</label-->
								<!--sinput disabled class = "form-control" type= "file" name="Image" id="post_image"-->
							</div>
							<div class="form-group">
								<label for = "post_text">Post</label>
								<textarea disabled class = "form-control" name="Post" id="post_text"><?php echo $post_to_be_deleted; ?></textarea>
							</div>
							<br>
							<br>
							<input class="btn btn-danger btn-block" type="submit" name ="submit" value="Delete Post">
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