<?php
	require_once ("include/db.php");
	require_once ("include/session.php");
	require_once ("include/redirect.php");
	
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$query = "UPDATE comments SET status = 'OFF' WHERE id = '$id'";
		$execute = mysqli_query($connect, $query);
		if($execute){
			$_SESSION['SuccessMessage'] = "Comment Disapproved successfully";
			redirect('comment.php');
		}else{
			$_SESSION['ErrorMessage'] = "Something went wrong, Try again";
			redirect('comment.php');
		}
	}
?>