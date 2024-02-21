<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="CSS/index.css">
    <link rel="stylesheet" href="CSS/carrito.css">
    <script defer src="script.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <header>
        <section class="title">
            <h1>CMODEL SCALE CARS</h1>
        </section>
        <div class="group">
            <svg viewBox="0 0 24 24" aria-hidden="true" class="icon">
                <g>
                    <path
                        d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z">
                    </path>
                </g>
            </svg>
            <input class="input" type="search" id="buscarproducto" placeholder="Buscar Producto" />
        </div>
        <section class="botones">
            <button class="buttonlogin" role="button"><a href="login.php">Iniciar Sesión</a></button>
            <button class="buttonlogin" role="button">Crear Cuenta</button>
            <button onclick="mostrarDialogo()" class="cart">
                <img src="Imagenes/carrito.png" alt="">
                <span class="count" id="TotalProductosPagina">0</span>
            </button>
            </div>

        </section>
    </header>


    <footer>
        <div class="informacion">
            <div>
                <h1>¿Necesitas ayuda?</h1>
                <p>Estado del pedido.</p>
                <p>Reclamar pedido.</p>
            </div>
            <div class="vertical-bar"></div>
            <div>
                <h1>Suscribete a nuestra Newsletter</h1>
                <div id="newsletter-social">
                    <div id="newsletter">
                        <form>
                            <input type="text" placeholder="Introduce tu Mail">
                            <input type="submit" value="Enviar">
                        </form>
                    </div>
                </div>
            </div>
            <div class="vertical-bar"></div>
            <div>
                <h1>Sobre Nosotros</h1>
                <p>Politicas de Privacidad.</p>
                <p>Contacta con Nosotros.</p>
            </div>

        </div>
        <div class="derechos">
            <p>CMODEL SCALE CARS - ALL RIGHTS RESERVED - MADE BY CHRISTIAN MORENO DIAZ</p>
        </div>
    </footer>
</body>

</html>