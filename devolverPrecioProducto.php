<?php
$nombreProd = $_POST["nombre"];
$con = mysqli_connect("localhost", "root", "", "tienda");
//CONSULTA 'SELECT id_producto FROM `productos` WHERE nombre_producto="AMR23";
$consulta = 'SELECT precio FROM `productos` WHERE nombre_producto="' . $nombreProd . '";';
$result = $con->query($consulta);
$row = $result->fetch_all();
$idProducto = $row[0][0];
// Cerrar la conexión
mysqli_close($con);
echo $idProducto;
?>