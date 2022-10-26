<?php // CONEXION BD

$host='localhost';
$database='frijolitodelasuerte';
$user='root';
$password='';

$conexion=mysqli_connect($host, $user, $password, $database) or
	die("No se puede conectar al Servidor de Base de Datos");

// Check connection
if (!$conexion) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_query($conexion, "SET CHARACTER SET 'utf8'");?>