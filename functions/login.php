<?php
session_start();
include('../includes/conexion.php');
 if (isset($_POST['login']))
	{
	$user_name = mysqli_real_escape_string($con, $_POST['user_name']);
	$user_password = mysqli_real_escape_string($con, md5($_POST['user_password']));
	
	$query = mysqli_query($con, "SELECT * FROM fact_users WHERE user_password='$user_password' and user_name='$user_name'");
	$row = mysqli_fetch_array($query);
	$num_row = mysqli_num_rows($query);
	
	if ($num_row > 0)
	{
	$_SESSION['user_name']=$row['user_name'];
	header('location:../menu_p.php');
	
	}
	else
	{
	echo '<div class="alert alert-warning" role="alert">Datos incorrectos!</div>';
	}
   }
   ?>