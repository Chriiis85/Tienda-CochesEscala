<?php
// Recibimos los datos del formulario desde el AJAX
$letra = $_POST['letra'];

// Verificar si los datos son correctos en la BBDD
$con = mysqli_connect("localhost", "root", "", "tienda");

//Probar la conexión
if (!$con->connect_error) {
    // Consulta: SELECT nombre_producto FROM productos WHERE nombre_producto LIKE '%A%';
    $consulta = "SELECT nombre_producto FROM productos WHERE nombre_producto LIKE '%" . $letra . "%'";
    $result = mysqli_query($con, $consulta);

    //Verificamos si se ejecuta bien la consulta.
    if ($result) {
        // Obtener todos los resultados
        $productos = mysqli_fetch_all($result);
        // Devolver los resultados en formato JSON
        echo json_encode($productos);
    } else {
        echo "Error en la consulta: " . mysqli_error($con);
    }

    // Cerrar la conexión
    mysqli_close($con);
} else {
    die("Error de conexión: " . mysqli_connect_error());
}
?>