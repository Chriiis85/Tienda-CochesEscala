<?php
// Nombre del producto a consultar pasado por POST
$nombre_producto = $_POST["nombreProd"];

// CONEXION CON LA BD
$con = mysqli_connect("localhost", "root", "", "tienda");

// CONSULTA PREPARADA
$consulta = 'SELECT unidades FROM productos WHERE nombre_producto LIKE ?';
$stmt = mysqli_prepare($con, $consulta);

// PREPARAR EL PATRON PARA LA BUSQUEDA
$nombre_producto = '%' . $nombre_producto . '%';

// EJECUTAR LA CONSULTA CON LOS PARAMETROS
mysqli_stmt_bind_param($stmt, 's', $nombre_producto);
mysqli_stmt_execute($stmt);

// RECOGER LOS RESULTADOS
mysqli_stmt_bind_result($stmt, $unidades);
mysqli_stmt_fetch($stmt);

// CERRAR LA CONEXION Y EL STATEMENT
mysqli_stmt_close($stmt);
mysqli_close($con);

// DEVOLVER LAS UNIDADES DEL PRODUCTO BUSCADO
echo $unidades;
?>