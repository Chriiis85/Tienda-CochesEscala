<?php

$postData = file_get_contents('php://input');

// Decodificar los datos JSON recibidos
$jsonData = json_decode($postData, true);
if ($jsonData !== null && isset($jsonData['carritoCompra'])) {
    // Obtener el array 'carritoCompra'
    $carritoCompra = $jsonData['carritoCompra'];
    // Imprimir los datos recibidos para verificar si se recibieron correctamente
    //print_r($carritoCompra);

    $ultimoId = recogerUltimoID();
    //Bucle que recorrer el array y va insertando los productos
    for ($i = 0; $i < sizeof($carritoCompra); $i++) {
        //Recibe el nombre del Producto y guarda su ID para insertar el Pedido, tambien la cantidad y el id del usuario.
        $idProducto = devovlerNombreProducto($carritoCompra[$i][1]);
        $cantidad = $carritoCompra[$i][2];
        $idUsuario = 1;

        //Llama a la funcion de registrar Pedido con los datos proporcionados
        registrarPedido($ultimoId + 1, $idUsuario, $idProducto, $cantidad);
    }

} else {
    echo "Error: No se recibieron datos válidos en el cuerpo de la solicitud.";
}


//Funcion que devuelve el id del producto dado un nombre de producto
function devovlerNombreProducto($nombreProd)
{
    //CONEXION CON LA BD
    $con = mysqli_connect("localhost", "root", "", "tienda");
    //CONSULTA 'SELECT id_producto FROM `productos` WHERE nombre_producto="AMR23";
    $consulta = 'SELECT id_producto FROM `productos` WHERE nombre_producto="' . $nombreProd . '";';
    $result = $con->query($consulta);
    $row = $result->fetch_all();
    $idProducto = $row[0][0];
    // Cerrar la conexión
    mysqli_close($con);
    return $idProducto;
}

//Funcion que registra el pedido con los datos proporcionados por parametro
function registrarPedido($id, $idUsuario, $idProducto, $cantidad)
{
    //CONEXION CON LA BD
    $con = mysqli_connect("localhost", "root", "", "tienda");
    //CONSULTA INSERT INTO `pedidos`(`id_usuario`, `id_producto`, `cantidad`,) VALUES ()
    $consulta = 'INSERT INTO `pedidos`(`id_pedido`,`id_usuario`, `id_producto`, `cantidad`) VALUES (?, ?, ?, ?)';
    $stmt = mysqli_prepare($con, $consulta);

    // Verificar si la preparación de la consulta fue exitosa
    if ($stmt) {
        // Unir los parámetros con la declaración de la consulta
        mysqli_stmt_bind_param($stmt, 'iiii', $id, $idUsuario, $idProducto, $cantidad);

        // Ejecutar la consulta preparada
        mysqli_stmt_execute($stmt);

        // Verificar si se insertó correctamente
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo "Pedido registrado correctamente.";
        } else {
            echo "Error al registrar el pedido.";
        }

        // Cerrar la consulta preparada
        mysqli_stmt_close($stmt);
    } else {
        echo "Error al preparar la consulta.";
    }

    // Cerrar la conexión
    mysqli_close($con);
}

//FUNCION QUE RECOGE EL ULTIMO ID PARA PONER UN ID DE PEDIDO
function recogerUltimoID()
{
    //CONSULTA SELECT MAX(id) FROM pedidos;
    //CONEXION CON LA BD
    $con = mysqli_connect("localhost", "root", "", "tienda");

    //CONSULTA PREPARADA
    $consulta = 'SELECT MAX(id_pedido) FROM pedidos';
    $stmt = mysqli_prepare($con, $consulta);

    // Enlazar parámetros y ejecutar la consulta
    mysqli_stmt_execute($stmt);

    // Obtener resultados
    mysqli_stmt_bind_result($stmt, $id);
    mysqli_stmt_fetch($stmt);

    // Cerrar la consulta preparada
    mysqli_stmt_close($stmt);

    // Cerrar la conexión
    mysqli_close($con);

    return $id;
}

/*function consultarCantidadDisponible($nombre_producto)
{
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

    return $unidades;
}*/
?>