<?php
	$con = mysqli_connect("74.127.61.115","root","2wsxcde3","facturacion","10000");
    //$con = mysqli_connect("localhost", "root", "", "facturacion");

	// checamos la conexion
	if (mysqli_connect_errno())
	{
	echo "Error al conectarse con MYSQL: " . mysqli_connect_error();
	}
	?>