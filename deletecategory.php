<?php
require_once ("include/db.php");
require_once ("include/session.php");
require_once ("include/redirect.php");


	if(isset($_GET['id'])){
		$category_id = $_GET['id'];
		$delete = "DELETE FROM category WHERE id = '$category_id'";
		$query = mysqli_query($connect, $delete);
			if($query){
				$_SESSION['SuccessMessage'] = 'Category Deleted Successfully';
				redirect('category.php');
				}else{
					$_SESSION['ErrorMessage'] = 'Error, Try again';
					redirect('category.php');
					}
	}
?>