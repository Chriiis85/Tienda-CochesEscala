<?php
// Recibimos los datos del formulario desde el AJAX
$username = $_POST['username'];
$password = $_POST['password'];

// Verificar si los datos son correctos en la BBDD
$con = mysqli_connect("localhost", "root", "", "tienda");

if (!$con->connect_error) {
    // Consulta preparada para evitar inyección SQL
    $consulta = 'SELECT * FROM usuarios WHERE nombre_usuario=? AND contraseña=?';
    $stmt = mysqli_prepare($con, $consulta);
    mysqli_stmt_bind_param($stmt, 'ss', $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $num_rows = mysqli_num_rows($result);

        if ($num_rows > 0) {
            echo 1; // Usuario y contraseña válidos
        } else {
            echo 2; // Usuario o contraseña incorrectos
        }
    } else {
        echo "Error en la consulta: " . mysqli_error($con);
    }
} else {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
