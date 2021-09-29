<?php
require_once ("include/db.php");
require_once ("include/session.php");
require_once ("include/redirect.php");


	if(isset($_GET['id'])){
		$admin_id = $_GET['id'];
		$delete = "DELETE FROM subadmin WHERE id = '$admin_id'";
		$query = mysqli_query($connect, $delete);
			if($query){
				$_SESSION['SuccessMessage'] = 'Admin Deleted Successfully';
				redirect('admin.php');
				}else{
					$_SESSION['ErrorMessage'] = 'Error, Try again';
					redirect('admin.php');
					}
	}
?>