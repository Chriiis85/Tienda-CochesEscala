<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <input type="text" id="username" class="form-control" required />
    <input type="password" id="password" class="form-control" required />
    <!-- Submit button -->
    <button type="submit" id="iniciarSesion" class="btn btn-primary btn-block mb-4">
        Iniciar Sesión
    </button>
    <!-- Submit button -->
    <button id="volver" class="btn btn-primary btn-block mb-4">
        Volver Atrás
    </button>
</body>
<script>
    //Recoger los elementos el DOM
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
    });


</script>

</html>