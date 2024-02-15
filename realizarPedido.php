<?php

// Obtener los datos del carrito del POST y decodificarlos desde JSON
$carrito = $_POST["carrito"];

// Imprimir los datos del carrito para verificar
echo $carrito[0];





//INSERT INTO `pedidos`( `id_usuario`, `id_producto`, `cantidad`) VALUES (1,1,1);

/*$con = mysqli_connect("localhost", "root", "", "tienda");

if (!$con->connect_error) {
    // Consulta: SELECT nombre_producto FROM `productos` WHERE id_producto = 1;

    $consulta = 'SELECT nombre_producto FROM `productos` WHERE id_producto = 1';
    $result = mysqli_query($con, $consulta);

    if ($result) {
        // Obtener todos los resultados
        $productos = mysqli_fetch_all($result);
        // Devolver los resultados en formato JSON
        echo $productos;
    } else {
        echo "Error en la consulta: " . mysqli_error($con);
    }
} else {
    die("Error de conexión: " . mysqli_connect_error());
}*/

/*$consulta =  'INSERT INTO `pedidos`( `id_usuario`, `id_producto`, `cantidad`) VALUES (?,?,?);';
$stmt = mysqli_stmt_init($con);

if (mysqli_stmt_prepare($stmt, $consulta)) {
    mysqli_stmt_bind_param($stmt, "sssssssss", $dni, $nombre, $apellido, $fechanac, $tipovia, $nombrevia, $numero, $localidad, $numerotelef);
    if (mysqli_stmt_execute($stmt)) {
        echo "Inserción exitosa.";
    } else {
        echo "Error en la inserción: " . mysqli_error($con);
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Error en la preparación de la consulta: " . mysqli_error($con);
}

mysqli_close($con);*/

?>