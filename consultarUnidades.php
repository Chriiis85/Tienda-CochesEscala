<?php
$nombre_producto = $_POST["nombreProd"];
//CONEXION CON LA BD
$con = mysqli_connect("localhost", "root", "", "tienda");

//CONSULTA PREPARADA
$consulta = 'SELECT unidades FROM `productos` WHERE nombre_producto = ?';
$stmt = mysqli_prepare($con, $consulta);

// Enlazar parámetros y ejecutar la consulta
mysqli_stmt_bind_param($stmt, 's', $nombre_producto);
mysqli_stmt_execute($stmt);

// Obtener resultados
mysqli_stmt_bind_result($stmt, $unidades);
mysqli_stmt_fetch($stmt);

// Cerrar la consulta preparada
mysqli_stmt_close($stmt);

// Cerrar la conexión
mysqli_close($con);

echo $unidades;

?>