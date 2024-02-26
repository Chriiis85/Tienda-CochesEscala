<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario - CModels Scale</title>
    <link rel="stylesheet" href="CSS/login.css">
</head>

<body>
    <div class="box">
        <h1>REGISTRAR USUARIO</h1>
        <form role="form" method="post">

            <div class="inputBox">
                <input type="text" id="username" name="username" autocomplete="off" required>
                <label>Username</label>
            </div>
            <div class="inputBox">
                <input type="text" id="name" name="name" autocomplete="off" required>
                <label>Nombre</label>
            </div>
            <div class="inputBox">
                <input type="text" id="surname" name="surname" autocomplete="off" required>
                <label>Apellidos</label>
            </div>
            <div class="inputBox">
                <input type="mail" id="mail" name="mail" autocomplete="off" required>
                <label>E-Mail</label>
            </div>
            <div class="inputBox">
                <input type="password" id="password" name="password" autocomplete="off" required>
                <label>Password</label>
            </div>
            <h3>Ya tienes una cuenta?! <a href="InicioSesion.php">Inicia Sesión aquí</a></h3>
            <div class="botones">
                <!-- Submit button -->
                <button type="submit" id="registrar" class="btn btn-primary btn-block mb-4">
                    Confirmar Registro
                </button>
                <!-- Submit button -->
                <button id="volver" class="btn btn-primary btn-block mb-4">
                    Volver Atrás
                </button>
            </div>
        </form>
    </div>

</body>
<script>
    //Recoger los elementos el DOM
    let botonRegistrar = document.getElementById("registrar");
    let botonAtras = document.getElementById("volver");
    //Variables para guardar el contenido de los inpus
    let username;
    let password;
    let name;
    let surname;
    let mail;

    //FUNCION AJAX QUR VALIDA LOS USUARIOS
    botonRegistrar.addEventListener("click", function () {
        //Recoge del DOM los inputs
        username = document.getElementById("username").value;
        password = document.getElementById("password").value;
        name = document.getElementById("name").value;
        surname = document.getElementById("surname").value;
        mail = document.getElementById("mail").value;

        //Creamos el objeto para hacer la funcion AJAX
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                //Si la respuesta es de valor 1, es correcto y se inicia sesion
                alert(this.responseText);
                location.href = "InicioSesion.php";
            }
        }
        //Mandamos el AJAX
        xhttp.open("POST", "registrar_usuario.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("username=" + username + "&password=" + password + "&name=" + name + "&surname=" + surname + "&mail=" + mail);
    });



    //Eventos de escucha para los botones de la pagina
    botonAtras.addEventListener("click", function () {
        location.href = "index.php";
    });


</script>

</html>