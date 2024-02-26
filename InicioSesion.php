<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Sesión - CModels Scale</title>
    <link rel="stylesheet" href="CSS/login.css">
</head>

<body>
    <div class="box">
        <h1>INICIAR SESIÓN</h1>
        <form role="form" method="post" action="validar_usuario.php">

            <div class="inputBox">
                <input type="text" id="username" name="username" autocomplete="off" required>
                <label>Username</label>
            </div>
            <div class="inputBox">
                <input type="password" id="password" name="password" autocomplete="off" required>
                <label>Password</label>
            </div>
            <h3>No tienes cuenta?! <a href="Registrar.php">Registrate</a></h3>
            <div class="botones">
                <!-- Submit button -->
                <button class="botonRegistro" type="submit" id="iniciarSesion" class="btn btn-primary btn-block mb-4">
                    Iniciar Sesión
                </button>

            </div>
        </form>
        <!-- Submit button -->
        <button class="botonCentro" onclick="volver();" id="volver" class="btn btn-primary btn-block mb-4">
            Volver Atrás
        </button>
    </div>

</body>
<!--LA FUNCION DE REGISTRO ESTA HECHA CON AJAX PERO LOS ALERT DE JS CHOCAN CON EL PHP Y SE REALIZAN A LA SEGUNDA VEZ QUE SE INTRODUCEN
PARA EVITAR ESTO SE HA CAMBIADO LA FORMA DE HACERLO Y SE HACE MEDIANTE UN FORM NORMAL-->
<script>
    /*//Recoger los elementos el DOM
    let botonIniciarSesion = document.getElementById("iniciarSesion");
    let botonAtras = document.getElementById("volver");
    //Variables para guardar el contenido de los inpus
    let username;
    let password;

    //FUNCION AJAX QUR VALIDA LOS USUARIOS
    function validarUsuario() {
        //Recoge del DOM los inputs
        username = document.getElementById("username").value;
        password = document.getElementById("password").value;

        //Creamos el objeto para hacer la funcion AJAX
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                //Si la respuesta es de valor 1, es correcto y se inicia sesion
                if (this.responseText == 1) {
                    alert("¡Bienvenido, " + username + "!!");
                    location.href = "index.php";
                    //Si la respuesta es distinta de 1, es incorrecto y se indica al usuario un mensaje de error
                } else {
                    alert("Nombre de usuario o contraseña incorrectos");
                }
            }
        }
        //Mandamos el AJAX
        xhttp.open("POST", "validar_usuario.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("username=" + username + "&password=" + password);
    }

    //Eventos de escucha para los botones de la pagina
    botonIniciarSesion.addEventListener("click", function () {
        validarUsuario();
    });

    //Eventos de escucha para los botones de la pagina
    botonAtras.addEventListener("click", function () {
        location.href = "index.php";
    });*/

    function volver() {
        window.location.href = "index.php";
    }
</script>

</html>