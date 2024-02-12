<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Index - CModel Cars</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
      crossorigin="anonymous"
    />

    <script
      src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
      integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
      integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
      integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
      crossorigin="anonymous"
    ></script>
  </head>
  <body>
    <!-- Section: Design Block -->
    <section class="text-center" style="background: #252525; height: 100vh;">
      <!-- Background image -->
      <div
        class="p-5 bg-image"
        style="
          background-image: url(Images/Banner.png);
          background-size: cover;
          background-repeat: no-repeat;
          height: 32vh;
        "
      ></div>

      <div
        class="card mx-4 mx-md-5 shadow-5-strong"
        style="
          margin-top: -50px;
          background: hsla(0, 0%, 100%, 0.8);
          backdrop-filter: blur(30px);
          height:50vh;
        "
      >
        <div class="card-body py-5 px-md-5">
          <div class="row d-flex justify-content-center">
            <div class="col-lg-8">
              <h2 class="fw-bold mb-5">Iniciar Sesión</h2>
              <form>

                <!-- Username input -->
                <div class="form-outline mb-4">
                  <label class="form-label" for="form3Example3"
                    >Nombre de Usuario</label
                  >
                  <input
                    type="text"
                    id="username"
                    class="form-control"
                    required
                  />
                </div>

                <!-- Password input -->
                <div class="form-outline mb-4">
                  <label class="form-label" for="form3Example4"
                    >Contraseña</label
                  >
                  <input
                    type="password"
                    id="password"
                    class="form-control"
                    required
                  />
                </div>

                <!-- Submit button -->
                <button type="submit" id="iniciarSesion" class="btn btn-primary btn-block mb-4">
                  Iniciar Sesión
                </button>
                <!-- Submit button -->
                <button id="volver" class="btn btn-primary btn-block mb-4">
                  Volver Atrás
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </body>
  <script>
  let botonIniciarSesion = document.getElementById("iniciarSesion");
  let botonAtras = document.getElementById("volver");
  let username;
  let password;

  function validarUsuario(){
    username = document.getElementById("username").value;
    password = document.getElementById("password").value;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        if(this.responseText==1){
          alert("¡Bienvenido, "+username+"!!");
          location.href ="index.php";
        }else{
          alert("Nombre de usuario o contraseña incorrectos");
          location.href ="login.php";
        }
      }
    }
    xhttp.open ("POST", "validar_usuario.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("username=" + username + "&password=" + password);
  }

  botonIniciarSesion.addEventListener("click", function(){
    validarUsuario();
  });

  botonAtras.addEventListener("click", function(){
    location.href ="index.php";
  });


</script>
</html>
