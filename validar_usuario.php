<?php
session_start();
// Recibimos los datos del formulario desde el AJAX
$username = $_POST['username'];
$password = $_POST['password'];

// Verificar si los datos son correctos en la BBDD
$con = mysqli_connect("localhost", "root", "", "tienda");

//Comprobar si la conexión funciona
if (!$con->connect_error) {
    // Consulta preparada para evitar inyección SQL
    $consulta = 'SELECT * FROM usuarios WHERE nombre_usuario=? AND password=?';

    //Ejecutamos la consulta
    $stmt = mysqli_prepare($con, $consulta);
    mysqli_stmt_bind_param($stmt, 'ss', $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    //Si deveulve resultados y filas, es que existe un usuario con ese nombre y contraseña ya que nos devuelve la consulta una fila
    if ($result) {
        //Numeros de fila que deuelve
        $num_rows = mysqli_num_rows($result);

        //Si devuelve mas de una fila existe y los datos son validos
        if ($num_rows > 0) {
            echo 1; // Usuario y contraseña válidos
            setcookie("username", $username, time() + 3600, "/"); // Expires in 1 hour

        } else {
            echo 2; // Usuario o contraseña incorrectos
        }

        // Cerrar la conexión
        mysqli_close($con);
    } else {
        echo "Error en la consulta: " . mysqli_error($con);
    }
} else {
    die("Error de conexión: " . mysqli_connect_error());
}
?>