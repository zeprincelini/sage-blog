<?php
require_once ("include/session.php");

	session_start();
	session_unset();
	session_destroy();
	//$_SESSION['SuccessMessage']= 'Logout Successful';
	header("location: login.php");
	exit();

?>