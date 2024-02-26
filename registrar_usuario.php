<?php
// Recibimos los datos del formulario desde el AJAX
$username = $_POST['username'];
$password = $_POST['password'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$mail = $_POST['mail'];

// Verificar si los datos son correctos en la BBDD
$con = mysqli_connect("localhost", "root", "", "tienda");

if (!empty($username) && !empty($password) && !empty($name) && !empty($surname) && !empty($mail)) {

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
            echo '<script language="javascript">';
            echo 'alert("Usuario insertado correctamente.");';
            echo 'window.location.href = "InicioSesion.php";';
            echo '</script>';
            exit();
        } else {
            echo '<script language="javascript">alert("Error al insertar el usuario.");</script>';
            header("Location: Registrar.php");
        }

        mysqli_stmt_close($stmt);
        mysqli_close($con);
    } else {
        die("Error de conexión: " . mysqli_connect_error());
    }
} else {
    echo '<script language="javascript">';
    echo 'alert("Debe Rellenar todos los campos.");';
    echo 'window.location.href = "Registrar.php";';
    echo '</script>';
}
?>