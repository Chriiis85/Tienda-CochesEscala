<?php
// RECIBIR LOS DATOS DESDE EL FORMULARIO
$username = $_POST['username'];
$password = $_POST['password'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$mail = $_POST['mail'];

// CREAR CONEXION CON LA BBDD
$con = mysqli_connect("localhost", "root", "", "tienda");

//VERIFICAMOS QUE TODOS LOS CAMPOS SE HAYAN INSERTADO SI NO SE LO INDICAMOS
if (!empty($username) && !empty($password) && !empty($name) && !empty($surname) && !empty($mail)) {

    // VERIFICAR EL ESTADO DE LA CONEXION
    if (!$con->connect_error) {
        //INSERT INTO `usuarios`(`nombre_usuario`, `nombre`, `apellidos`, `correo`, `password`) VALUES ()
        // Consulta preparada para evitar inyección SQL
        $consulta = 'INSERT INTO `usuarios`(`nombre_usuario`, `nombre`, `apellidos`, `correo`, `password`) VALUES (?,?,?,?,?)';

        //EJECTUAR LA CONSULTA Y DEFINIR LOS PARAMETROS
        $stmt = mysqli_prepare($con, $consulta);
        mysqli_stmt_bind_param($stmt, 'sssss', $username, $name, $surname, $mail, $password);
        mysqli_stmt_execute($stmt);

        //SI NOS DEVUELVE FILAS ES QUE EL USUARIO SE HA CREADO CORRECTAMENTE Y REDIRIGIMOS AL INICIO DE SESION DE LO CONTRARIO VACIAMOS Y LE INDICAMOS
        //QUE HAY UN ERROR Y RECARGAMOS PAGINA
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

        //CERRAMOS CONSULTA Y CONEXION
        mysqli_stmt_close($stmt);
        mysqli_close($con);
    } else {
        die("Error de conexión: " . mysqli_connect_error());
    }
} else {
    //VERIFICAMOS QUE TODOS LOS CAMPOS SE HAYAN INSERTADO SI NO SE LO INDICAMOS
    echo '<script language="javascript">';
    echo 'alert("Debe Rellenar todos los campos.");';
    echo 'window.location.href = "Registrar.php";';
    echo '</script>';
}
?>