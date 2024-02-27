<?php
session_start();
// RECIBIMOS LOS DATOS DEL FORMULARIO DESDE EL AJAX
$username = $_POST['username'];
$password = $_POST['password'];

// VERIFICAR SI LOS DATOS SON CORRECTOS EN LA BBDD
$con = mysqli_connect("localhost", "root", "", "tienda");

//COMPROBAR SI LA CONEXIÓN FUNCIONA
if (!$con->connect_error) {
    // CONSULTA PREPARADA PARA EVITAR INYECCIÓN SQL
    $consulta = 'SELECT * FROM usuarios WHERE nombre_usuario=? AND password=?';

    //EJECUTAMOS LA CONSULTA
    $stmt = mysqli_prepare($con, $consulta);
    mysqli_stmt_bind_param($stmt, 'ss', $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    //SI DEVEULVE RESULTADOS Y FILAS, ES QUE EXISTE UN USUARIO CON ESE NOMBRE Y CONTRASEÑA YA QUE NOS DEVUELVE LA CONSULTA UNA FILA
    if ($result) {
        //NUMEROS DE FILA QUE DEUELVE
        $num_rows = mysqli_num_rows($result);

        //SI DEVUELVE MAS DE UNA FILA EXISTE Y LOS DATOS SON VALIDOS
        if ($num_rows > 0) {
            //CREAMOS LA COOKIE PARA RECOGER EL NOMBRE DEL USUARIO
            setcookie("username", $username, time() + 3600, "/");
            //REDIRIGIMOS AL USUARIO
            echo '<script language="javascript">';
            echo 'alert("Bienvenido de nuevo: ' . $username . '");';
            echo 'window.location.href = "index.php";';
            echo '</script>';
        } else {
            //REDIRIGIMOS AL USUARIO
            echo '<script language="javascript">';
            echo 'alert("No se ha podido Iniciar Sesión");';
            echo 'window.location.href = "InicioSesion.php";';
            echo '</script>';
        }

        // CERRAR LA CONEXIÓN
        mysqli_close($con);
    } else {
        echo "Error en la consulta: " . mysqli_error($con);
    }
} else {
    die("Error de conexión: " . mysqli_connect_error());
}
?>