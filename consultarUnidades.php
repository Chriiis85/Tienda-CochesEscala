<?php
// Nombre del producto a consultar pasado por POST
$nombre_producto = $_POST["nombreProd"];

// CONEXION CON LA BD
$con = mysqli_connect("localhost", "root", "", "tienda");

// CONSULTA PREPARADA
$consulta = 'SELECT unidades FROM productos WHERE nombre_producto LIKE ?';
$stmt = mysqli_prepare($con, $consulta);

// Preparar el patrón de búsqueda
$nombre_producto = '%' . $nombre_producto . '%';

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

// Devolver las unidades del producto
echo $unidades;
?>