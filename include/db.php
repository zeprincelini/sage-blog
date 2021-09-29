<?php
	$host = "localhost";
	$password ="";
	$root = "root";
	$db_name = "cms";
	
	if(!$connect = mysqli_connect($host, $root, $password, $db_name)){
		$message = mysqli_error($connect);
		echo $message;
		die();
	}

?>