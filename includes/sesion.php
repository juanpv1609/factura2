<?php
	// Iniciamos la sesion
	session_start();
	if (!isset($_SESSION['user_name']) || (trim($_SESSION['user_name']) == '')) {
	header("location: index.php");
	exit();
	}
	$user_name=$_SESSION['user_name'];
	?>