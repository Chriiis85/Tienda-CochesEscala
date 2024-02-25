<?php
session_start();
// Recibimos los datos del formulario desde el AJAX
$username = $_POST['username'];
$password = $_POST['password'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$mail = $_POST['mail'];

// Verificar si los datos son correctos en la BBDD
$con = mysqli_connect("localhost", "root", "", "tienda");

//Comprobar si la conexión funciona
if (!$con->connect_error) {
    //INSERT INTO `usuarios`(`nombre_usuario`, `nombre`, `apellidos`, `correo`, `password`) VALUES ()
    // Consulta preparada para evitar inyección SQL
    $consulta = 'INSERT INTO `usuarios`(`nombre_usuario`, `nombre`, `apellidos`, `correo`, `password`) VALUES (?,?,?,?,?)';

    //Ejecutamos la consulta
    $stmt = mysqli_prepare($con, $consulta);
    mysqli_stmt_bind_param($stmt, 'sssss', $username, $name, $surname, $mail, $password);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "Usuario insertado correctamente.";
    } else {
        echo "Error al insertar el usuario.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
} else {
    die("Error de conexión: " . mysqli_connect_error());
}
?>