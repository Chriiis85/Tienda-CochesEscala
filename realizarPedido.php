<?php
session_start();
//Recibimos por POST el array que nos pasa con el pedido.
$postData = file_get_contents('php://input');

// Decodificar los datos JSON recibidos.
$jsonData = json_decode($postData, true);
if ($jsonData !== null && isset($jsonData['carritoCompra'])) {
    // Obtener el array 'carritoCompra'.
    $carritoCompra = $jsonData['carritoCompra'];
    // Imprimir los datos recibidos para verificar si se recibieron correctamente.
    //Recoger el ultimo ID de pedido que hay en la base de datos.
    $ultimoId = recogerUltimoID();
    //Bucle que recorrer el array y va insertando los productos.
    for ($i = 0; $i < sizeof($carritoCompra); $i++) {
        //Recibe el nombre del Producto y guarda su ID para insertar el Pedido, tambien la cantidad y el id del usuario.
        $idProducto = devovlerNombreProducto($carritoCompra[$i][1]);
        $cantidad = $carritoCompra[$i][2];
        $idUsuario = devolverIDUsu($_COOKIE["username"]);
        if (consultarCantidadDisponible($idProducto) >= $cantidad && $cantidad > 0) {
            //Llama a la funcion de registrar Pedido con los datos proporcionados.
            registrarPedido($ultimoId + 1, $idUsuario, $idProducto, $cantidad);
            //Actualizar la tabla para quitar las unidades
            $cantidadDisp = consultarCantidadDisponible($idProducto) - $cantidad;
            actualizarTabla($cantidadDisp, $idProducto);
        } else {
            echo "No Se puede comprar, Se han seleccionado unidades erroneas del producto: " . $carritoCompra[$i][1];
        }
    }

} else {
    echo "Error: No se recibieron datos válidos en el cuerpo de la solicitud.";
}

//Funcion que devuelve el id del usuario para poder realizar el registro
function devolverIDUsu($nombreUsu)
{
    //CONEXION CON LA BD
    $con = mysqli_connect("localhost", "root", "", "tienda");
    //CONSULTA 'SELECT id_usuario  FROM `usuarios` WHERE nombre_usuario="CHRISTIAN";
    $consulta = 'SELECT id_usuario FROM `usuarios` WHERE nombre_usuario="' . $nombreUsu . '";';

    //EJECUTAR LA CONSULTA
    $result = $con->query($consulta);
    $row = $result->fetch_all();
    $idUsu = $row[0][0];

    // CERRAR LA CONEXION
    mysqli_close($con);
    return $idUsu;
}

//Funcion que devuelve el id del producto dado un nombre de producto.
function devovlerNombreProducto($nombreProd)
{
    //CONEXION CON LA BD
    $con = mysqli_connect("localhost", "root", "", "tienda");
    //CONSULTA 'SELECT id_producto FROM `productos` WHERE nombre_producto="AMR23";
    $consulta = 'SELECT id_producto FROM `productos` WHERE nombre_producto="' . $nombreProd . '";';

    //EJECUTAR LA CONSULTA
    $result = $con->query($consulta);
    $row = $result->fetch_all();
    $idProducto = $row[0][0];

    // CERRAR LA CONEXION
    mysqli_close($con);
    return $idProducto;
}

//Funcion que registra el pedido con los datos proporcionados por parametro.
function registrarPedido($id, $idUsuario, $idProducto, $cantidad)
{
    //CONEXION CON LA BD
    $con = mysqli_connect("localhost", "root", "", "tienda");
    //CONSULTA INSERT INTO `pedidos`(`id_usuario`, `id_producto`, `cantidad`,) VALUES ()
    $consulta = 'INSERT INTO `pedidos`(`id_pedido`,`id_usuario`, `id_producto`, `cantidad`) VALUES (?, ?, ?, ?)';
    $stmt = mysqli_prepare($con, $consulta);

    // VERIFICAR LA CONSULTA
    if ($stmt) {
        //DEFINIR LOS PARAMETROS
        mysqli_stmt_bind_param($stmt, 'iiii', $id, $idUsuario, $idProducto, $cantidad);

        // EJECUTAR LA CONSULTA
        mysqli_stmt_execute($stmt);

        // VERIFICAR SI SE INSERTA CORRECTAMENTE
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo "Pedido registrado correctamente.";
        } else {
            echo "Error al registrar el pedido.";
        }

        // CERRAR EL STATEMENT
        mysqli_stmt_close($stmt);
    } else {
        echo "Error al preparar la consulta.";
    }

    // CERRAR LA CONEXION
    mysqli_close($con);
}

//FUNCION QUE RECOGE EL ULTIMO ID PARA PONER UN ID DE PEDIDO.
function recogerUltimoID()
{
    //CONSULTA SELECT MAX(id) FROM pedidos;
    //CONEXION CON LA BD
    $con = mysqli_connect("localhost", "root", "", "tienda");

    //CONSULTA PREPARADA
    $consulta = 'SELECT MAX(id_pedido) FROM pedidos';
    $stmt = mysqli_prepare($con, $consulta);

    //DEFINIR LOS PARAMETROS
    mysqli_stmt_execute($stmt);

    // RECOGER LOS RESULTADOS
    mysqli_stmt_bind_result($stmt, $id);
    mysqli_stmt_fetch($stmt);

    // CERRAR LA CONEXION Y EL STATEMENT
    mysqli_stmt_close($stmt);
    mysqli_close($con);

    //DEVOLER EL ID QUE ESTAMOS BUSCANDO
    return $id;
}

//Funcion que consulta la cantidad de un producto para verificar la disponibilidad de unidades de un producto.
function consultarCantidadDisponible($nombre_producto)
{
    // CONEXION CON LA BD
    $con = mysqli_connect("localhost", "root", "", "tienda");

    // CONSULTA PREPARADA
    $consulta = 'SELECT unidades FROM `productos` WHERE id_producto = ?';
    $stmt = mysqli_prepare($con, $consulta);

    // DEFINIR LOS PARAMETROS
    mysqli_stmt_bind_param($stmt, 's', $nombre_producto);
    mysqli_stmt_execute($stmt);

    // RECOGER LOS RESULTADOS
    mysqli_stmt_bind_result($stmt, $unidades);
    mysqli_stmt_fetch($stmt);

    // CERRAR LA CONEXION Y EL STATEMENT
    mysqli_stmt_close($stmt);
    mysqli_close($con);

    return $unidades;
}

//Funcion que actualiza la cantidad del producto que se ha comprado.
function actualizarTabla($unidad, $idProducto)
{
    // CREAR Y VERIFICA LA CONEXION
    $con = mysqli_connect("localhost", "root", "", "tienda");
    if ($con->connect_error) {
        die("Conexión fallida: " . $con->connect_error);
    }

    //CONSULTA: UPDATE productos SET unidades=10 WHERE id_producto=1;
    // Consulta SQL para actualizar el nombre del usuario con el id proporcionado
    $consulta = 'UPDATE productos SET unidades=' . $unidad . ' WHERE id_producto=' . $idProducto . ';';

    // EJECUTAR LA CONSULTA
    if ($con->query($consulta) === TRUE) {
        echo "Producto actualizado correctamente";
    } else {
        echo "Error al actualizar el producto: " . $con->error;
    }

    // CERRAR LA CONEXION
    $con->close();
}
?>