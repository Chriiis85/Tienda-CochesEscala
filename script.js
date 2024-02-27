/*----------------------------------------------------------FUNCIONALIDAD PAGINA PRINCIPAL-------------------------------------------------*/
/*VARIABLE GLOBAL DEL CARRITO*/
const carritoCompra = [];
/*VARIABLE GLOBAL AUXILIAR DEL CARRITO*/
let carritoCompraP = [];
/*FUNCION PARA PODER GUARDAR LA COOKIE*/
function guardarArrayEnCookie(nombreCookie, array, expiracion) {
  // Convertir el array en una cadena JSON
  var arrayString = JSON.stringify(array);
  // Crear la cookie con el nombre especificado y la cadena JSON como valor
  document.cookie =
    nombreCookie + "=" + arrayString + "; expires=" + expiracion + "; path=/";
}
/*Funcion que al cargar la aplicacion detecta cada input de las teclas, recoje la palabra y el valor escrito en el campo y lo manda
a la funcion buscar producto para mostrar los productos*/
window.onload = function () {
  //Cookie del carrito
  carritoCompraP = obtenerCookie("carritoCompraCookie");

  //Recogo el input para detectar lo que se va introduciendo para poder mostraro
  let buscarproducto = document.getElementById("buscarproducto");
  buscarproducto.addEventListener("click", function () {
    //Si no tiene sesion iniciada no deja navegar
    if (verificarCookie("username")) {
      alert("Debe Iniciar Sesión para navegar!!!");
      window.location.href = "InicioSesion.php";
    } else {
      //Muestra los productos
      buscarproducto.addEventListener("input", function (event) {
        buscarProducto(buscarproducto.value);
      });
    }
  });
};

/*Funcion que se le pasa una palabra por parametro y mediante ajax realiza una conexion a la BBDD y buscar la palabra(producto) a mostrar*/
function buscarProducto(letra) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      //let productos = this.response;
      let producto = "";
      producto = JSON.parse(this.response);
      mostrarProductos(producto);
    }
  };
  xhttp.open("POST", "buscar_producto.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("letra=" + letra);
}

/*Funcion encargada de pintar y mostrar en el DOM los productos que se devuelven*/
function mostrarProductos(productos) {
  let contenedormostrarProductos = document.getElementById(
    "contenedor-producto"
  );
  let contenedorProductos = document.createElement("article");
  contenedorProductos.classList.add("mostrarProd");
  contenedorProductos.setAttribute("id", "mostrarProd");

  // Limpiar el contenido del contenedor
  contenedormostrarProductos.innerHTML = "";

  if (productos.length < 1) {
    //inputbuscarProducto.value = ""; // Limpiar el campo de búsqueda si no hay productos
    let div = document.createElement("div");
    div.classList.add("producto2");
    let nombre = document.createElement("p");
    nombre.textContent = "No hay coincidencias";
    contenedorProductos.appendChild(div);
    div.appendChild(nombre);
    contenedormostrarProductos.appendChild(contenedorProductos);
  } else {
    for (let i = 0; i < productos.length; i++) {
      //Crea los elementos en el DOM
      console.log(productos[i][0]);
      let div = document.createElement("div");
      div.classList.add("producto");
      let nombre = document.createElement("p");
      let precio = document.createElement("p");
      let boton = document.createElement("button");
      nombre.textContent = productos[i][0];
      //precio.textContent = productos[i][1];
      div.appendChild(nombre);
      //div.appendChild(precio);
      contenedorProductos.appendChild(div);
    }
    contenedormostrarProductos.appendChild(contenedorProductos);

    //Cre las cajar donde se muestran los productos
    let cajasproductos = document.querySelectorAll(".producto");
    for (const producto of cajasproductos) {
      //Redirige el producto seleccionado
      producto.addEventListener("click", function () {
        document.cookie = "prodname=" + producto.textContent;
        window.location.href = "PaginaProducto.php";
      });
    }
  }
}

/*Detectan los clicks fuera del input para buscar y lo oculta*/
document.addEventListener("click", function (event) {
  const inputBuscarProducto = document.getElementById("buscarproducto");
  const divResultadoBusqueda = document.getElementById("mostrarProd");

  // Verificar si los elementos existen y el click ocurrre fuera del input de búsqueda y del div de resultados
  if (
    inputBuscarProducto &&
    divResultadoBusqueda &&
    !inputBuscarProducto.contains(event.target) &&
    !divResultadoBusqueda.contains(event.target)
  ) {
    // Ocultar el div de resultados
    divResultadoBusqueda.style.display = "none";
    inputBuscarProducto.value = "";
  }
});

/*---------------------------------------------------------------FUNCIONALIDAD DEL CARRITO-------------------------------------------------*/
//TotalProductosPagina y su contador
let TotalProductosPagina = document.getElementById("TotalProductosPagina");
let TotalProductosPaginacont = carritoCompra.length;

//TotalProductosCarrito
let TotalProductosCarrito = document.getElementById("TotalProductosCarrito");

//Article donde mostrar los productos
let mostrarProductosPedido = document.getElementById("mostrarProductosPedido");

//Article donde se muestra el resumen del Pedido
let resumenPedido = document.getElementById("resumenPedido");

document.getElementsByTagName("body")[0].style.overflowX = "hidden";

document.getElementsByTagName("body")[0].style.overflow = "auto";

var dialogo = document.getElementById("dialog");
var fondoOscuro = document.getElementById("fondoOscuro");

//Muestra el carrito de la compra
function mostrarDialogo() {
  dialogo.style.display = "block";
  document.getElementsByTagName("body")[0].style.overflow = "hidden";
  pintarProductosCarrito(carritoCompra);
}

//Cierra el carrito de la compra
function ocultarDialogo() {
  dialogo.style.display = "none";
  document.getElementsByTagName("body")[0].style.overflow = "auto";
}

//ID que identifica los articulos del carrito
let contIdProd = 0;
//Funcion que pinta los productos en el carro
function pintarProductosCarrito(productos) {
  mostrarProductosPedido.innerHTML = "";
  //Titulo del Carrito
  let divTitulo = document.createElement("div");
  let h2Titulo = document.createElement("h2");
  divTitulo.classList.add("productostitulo");
  h2Titulo.setAttribute("id", "TotalProductosCarrito");
  let h5Titulo = document.createElement("h5");
  h2Titulo.textContent = "Carrito de la Compra";

  //Contador del productos en el carro
  let contProductosEnCarro = 0;
  contProductosEnCarro = parseFloat(contProductosEnCarro);
  for (let i = 0; i < productos.length; i++) {
    let unidadProducto = 0;
    unidadProducto = parseFloat(productos[i][2]);
    contProductosEnCarro = contProductosEnCarro + unidadProducto;
  }
  h5Titulo.textContent = contProductosEnCarro + " Productos";
  divTitulo.appendChild(h2Titulo);
  divTitulo.appendChild(h5Titulo);
  mostrarProductosPedido.appendChild(divTitulo);

  //Mostrar dinamicamente los productos
  for (let i = 0; i < productos.length; i++) {
    contIdProd++;

    //Crear Elementos en el DOM
    let div = document.createElement("div");
    div.setAttribute("id", contIdProd + "div");
    let hr = document.createElement("hr");
    let img = document.createElement("img");
    img.setAttribute("id", contIdProd + "img");
    let h3Nombre = document.createElement("h3");
    h3Nombre.setAttribute("id", contIdProd + "nombre");
    h3Nombre.classList.add("nombreProdCarrito");
    let unidad = document.createElement("input");
    unidad.setAttribute("id", contIdProd + "unidad");
    unidad.setAttribute("type", "number");
    unidad.classList.add("unidadArticuloCarrito");
    unidad.setAttribute("value", productos[i][2]);
    unidad.setAttribute("min", 1);

    //Actualiza las unidades de los productos para verlos y pedirlos correctamente
    unidad.addEventListener("input", function (event) {
      //Recoger todas las unidades del carrito para ver si se han modificado y pedir bien el pedido con las unidades si se modifican en el carro
      let inputUnidad = document.querySelectorAll(".unidadArticuloCarrito");
      let i = 0;
      for (const input of inputUnidad) {
        let valor = input.value;
        carritoCompra[i][2] = valor;
        i++;
      }
      setTimeout(function () {
        pintarProductosCarrito(carritoCompra);
      }, 100);
    });

    //Pone el maximo de unidades a escoger de cada pedido
    returnUnidadProd(productos[i][1], function (unidades) {
      unidad.max = unidades;
      unidad.setAttribute("max", unidades);
    });

    let h3Precio = document.createElement("h3");
    let equis = document.createElement("button");
    equis.setAttribute("id", contIdProd);
    //Añadir Clases
    div.classList.add("productocarrito");
    hr.classList.add("pedidoBarra");

    img.src =
      "Imagenes/" + productos[i][0] + "/" + productos[i][0] + "-Imagen1.jpg";

    //Añadir informacion a los elementos
    h3Nombre.textContent = productos[i][1];

    let precio = productos[i][3];
    precio = precio.substring("€", precio.length);
    h3Precio.textContent = precio;
    equis.textContent = "X";

    //BOTON PARA ELIMINAR UN PRODUCto
    equis.addEventListener("click", function () {
      //Detectamos el id del producto clicado
      var idEquis = equis.id;
      //Recogemos el nombre del elemento a eliminar
      let nombreProdEliminar = document.getElementById(
        idEquis + "nombre"
      ).textContent;

      //Buscar el elemento que ha clicado el usuario para eliminar, mediante splice buscamos el elemento a eliminar y definimos la variable indice
      //con el indice(posicion) en la que se encuentra el producto.
      var indice = -1;
      for (var i = 0; i < carritoCompra.length; i++) {
        if (carritoCompra[i][1] === nombreProdEliminar) {
          // Comparar el nombre del producto
          indice = i;
          break;
        }
      }

      //Si se ha encontrado el producto se elimina
      if (indice !== -1) {
        carritoCompra.splice(indice, 1); // Eliminar 1 elemento en el índice obtenido
        alert("Producto: " + nombreProdEliminar + " eliminado.");
      } else {
        alert("El Producto " + nombreProdEliminar + " no se encuentra.");
      }
      actualizarNumeroCarrito();
      pintarProductosCarrito(carritoCompra);
    });

    //Añadir elementos al div
    div.appendChild(img);
    div.appendChild(h3Nombre);
    div.appendChild(unidad);
    div.appendChild(h3Precio);
    div.appendChild(equis);
    //Añadir elementos al DOM
    mostrarProductosPedido.appendChild(hr);
    mostrarProductosPedido.appendChild(div);
  }
  //Mostrar elementos extra en el DOM
  let hr = document.createElement("hr");
  hr.classList.add("pedidoBarra");
  mostrarProductosPedido.appendChild(hr);

  /*RESUMEN*/
  resumenPedido.innerHTML = "";
  //Mostrar elementos extra en el DOM
  let h1Resumen = document.createElement("h1");
  h1Resumen.textContent = "Resumen del Pedido";
  let divBarra = document.createElement("div");
  divBarra.classList.add("pedidoBarra");
  let h3Productos = document.createElement("h3");

  //Cuenta los productos en el carro y si ponen mas unidades
  contProductosEnCarro = parseFloat(contProductosEnCarro);
  for (let i = 0; i < productos.length; i++) {
    let unidadProducto = 0;
    unidadProducto = parseFloat(productos[i][2]);
    contProductosEnCarro = contProductosEnCarro + unidadProducto;
  }

  h3Productos.textContent = "Productos: " + contProductosEnCarro / 2;
  resumenPedido.appendChild(h1Resumen);
  resumenPedido.appendChild(divBarra);
  resumenPedido.appendChild(h3Productos);

  //Mostrar los productos dinamicamente
  let resumen = document.createElement("div");
  resumen.classList.add("resumenpedidoProductos");
  for (let i = 0; i < productos.length; i++) {
    let pResumen = document.createElement("p");
    pResumen.textContent = productos[i][1] + " " + productos[i][2] + "/U";
    resumen.appendChild(pResumen);
  }
  resumenPedido.appendChild(resumen);

  //Precio de los Productos para hacer el contador del precio final
  var contPrecio = 0;
  for (let i = 0; i < productos.length; i++) {
    let sumaPrecio = 0;
    sumaPrecio = sumaPrecio + productos[i][3];
    sumaPrecio = sumaPrecio.toString();
    let indiceCortarInicial = sumaPrecio.indexOf(" ");
    let indiceCortarFinal = sumaPrecio.lastIndexOf("€");
    let sumaPrecioCorregida = sumaPrecio.substring(
      indiceCortarInicial + 1,
      indiceCortarFinal
    );
    contPrecio = parseFloat(contPrecio);
    sumaPrecioCorregida = parseFloat(sumaPrecioCorregida);
    sumaPrecioCorregida = sumaPrecioCorregida * productos[i][2];
    contPrecio = contPrecio + sumaPrecioCorregida;
  }
  resumenPedido.appendChild(divBarra);
  let h3Precio = document.createElement("h3");
  contPrecio = Math.round(contPrecio * 100) / 100;
  h3Precio.textContent = "Precio Total: " + contPrecio + "€";
  resumenPedido.appendChild(h3Precio);
  //Mostrar elementos(Abajo) extra en el DOM
  let botonPedido = document.createElement("button");
  let botonCerrar = document.createElement("button");
  botonPedido.classList.add("botonFin");
  botonCerrar.classList.add("botonCerrar");
  botonPedido.textContent = "Finalizar Pedido";
  botonCerrar.textContent = "Cerrar Carrito";
  botonCerrar.onclick = ocultarDialogo;

  //Evenet Listener para registrar un Pedido
  botonPedido.addEventListener("click", function () {
    if (carritoCompra.length < 1) {
      alert("NO HAY PRODUCTOS EN EL CARRITO");
    } else {
      //Recoger todas las unidades del carrito para ver si se han modificado y pedir bien el pedido con las unidades si se modifican en el carro
      let inputUnidad = document.querySelectorAll(".unidadArticuloCarrito");
      let i = 0;
      for (const input of inputUnidad) {
        let valor = input.value;
        carritoCompra[i][2] = valor;
        i++;
      }

      //FUNCION QUE VERIFICA SI EL PEDIDO ESTA CORRECTO Y LO MANDA
      async function verificarPedido() {
        let contMal = 0;
        let nombresProducto = document.querySelectorAll(".nombreProdCarrito");

        for (let j = 0; j < nombresProducto.length; j++) {
          let unidades = await obtenerUnidades(nombresProducto[j].textContent);
          //alert("UNidad en carrito:" + carritoCompra[j][2]);
          //alert("UNidad disp:" + unidades);
          if (carritoCompra[j][2] > unidades) {
            contMal++;
          }
        }

        //Verifica que esten todos los pedidos bien para poder realizar el pedido
        if (contMal === 0) {
          registrarPedido(carritoCompra);
          alert("PEDIDO REALIZADO CORRECTAMENTE");
        } else {
          alert(
            "No se puede Realizar el Pedido. Seleccione las unidades correctas."
          );
        }
      }

      //Devuelve las unidades para el pedido
      async function obtenerUnidades(producto) {
        return new Promise((resolve, reject) => {
          returnUnidadProd(producto, function (unidades) {
            resolve(unidades);
          });
        });
      }

      verificarPedido();
    }
  });
  //Appendchild
  resumenPedido.appendChild(botonPedido);
  resumenPedido.appendChild(botonCerrar);
}

//Funcion que realiza el pedido y registra
function registrarPedido(carritoCompra) {
  console.log("Botón de pedido clicado");
  console.log("carritoCompra:", carritoCompra);
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "realizarPedido.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      alert(xhr.responseText);
      carritoCompra = [];
      location.reload();
    }
  };
  xhr.send(JSON.stringify({ carritoCompra: carritoCompra }));
}

/*PINTA LAS UNIDADES DISPONIBLES EN LOS INPUT NUMBER PARA CONTROLAR LOS VALORES*/
function returnUnidadProd(producto, callback) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let unidadDisponible = parseInt(this.responseText);
      callback(unidadDisponible);
    }
  };
  xhttp.open("POST", "consultarUnidades.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("nombreProd=" + producto);
}

//FUNCION QUE AL CARGAR LA PAGINA PONE EL MAXIMO DE UNIDADES A COMPRAR
let inputsUnidadesProducto = document.querySelectorAll(".unidadArticulo");
for (const input of inputsUnidadesProducto) {
  let idinputProd = input.id;
  let corteIni = idinputProd.lastIndexOf("o");
  let nombreProd = idinputProd.substring(corteIni + 1, idinputProd.length);
  let nombreProdLargo = document.getElementById(
    "tituloProd" + nombreProd
  ).textContent;
  //for (let i = 0; i < inputsUnidadesProducto.length; i++) {
  returnUnidadProd(nombreProdLargo, function (unidades) {
    let inputSetMax = document.getElementById("unidadesProducto" + nombreProd);
    inputSetMax.max = unidades;
  });

  //}
}

/*------------------------------------------------FUNCIONALIDAD PRODUCTOS PAGINA PRINCIPAL-------------------------------------------------------*/

//Detectar el boton de compra
let botonesCompra = document.querySelectorAll(".botonCompra");
for (const botonCompra of botonesCompra) {
  botonCompra.addEventListener("click", function () {
    //Si hay sesion iniciada te permite comprar
    if (!verificarCookie("username")) {
      let nombreRecoger = botonCompra.id.split("-");
      nombreRecoger = nombreRecoger[1];

      let stock = 0;
      //VERIFICAR SI LAS UNIDADES DEL PRODUCTO ESTAN DISPONIBLES
      returnUnidadProd(nombreRecoger, function (unidades2) {
        stock = unidades2;
        let idBoton = botonCompra.id;

        let nombreProdCorto = idBoton.split("-");
        nombreProdCorto = nombreProdCorto[1];

        let nombreProdLargo = document.getElementById(
          "tituloProd" + nombreProdCorto
        ).textContent;

        let precioProd = document.getElementById(
          "precio" + nombreProdCorto
        ).textContent;

        let indiceInicialPrecio = precioProd.indexOf(" ");
        let indiceFinalPrecio = precioProd.indexOf("P", indiceInicialPrecio);
        let precio = precioProd.substring(
          indiceInicialPrecio + 1,
          indiceFinalPrecio
        );

        let unidades = document.getElementById(
          "unidadesProducto" + nombreProdCorto
        ).value;
        if (unidades <= stock) {
          // Verificar si el producto ya está en el carrito
          for (let i = 0; i < carritoCompra.length; i++) {
            if (carritoCompra[i][1] == nombreProdLargo) {
              carritoCompra[i][2]++;
              mostrarDialogo();
              productoYaEnCarrito = true;
              break;
            }
          }
          let productoYaEnCarrito = false;

          // Si el producto no está en el carrito, añadirlo
          if (!productoYaEnCarrito) {
            carritoCompra.push([
              nombreProdCorto,
              nombreProdLargo,
              unidades,
              precioProd,
            ]);
          }

          //Actualiza y muestra el carrito con el contador de productos
          actualizarNumeroCarrito();
          mostrarDialogo();
        } else {
          alert("NO hay las unidades seleccionadas para este producto.");
        }
      });
    } else {
      alert("Debe Iniciar Sesión para poder comprar!!!");
      window.location.href = "InicioSesion.php";
    }
  });
}

//Detectar el boton de cesta
let botonesCesta = document.querySelectorAll(".botonCesta");
for (const botonCesta of botonesCesta) {
  botonCesta.addEventListener("click", function () {
    //Si no hay sesion iniciada no puede añadir a la cesta
    if (!verificarCookie("username")) {
      let nombreRecoger = botonCesta.id.split("-");
      nombreRecoger = nombreRecoger[1];

      let stock = 0;
      //VERIFICAR SI LAS UNIDADES DEL PRODUCTO ESTAN DISPONIBLES
      returnUnidadProd(nombreRecoger, function (unidades2) {
        stock = unidades2;

        let idBoton = botonCesta.id;

        let nombreProdCorto = idBoton.split("-");
        nombreProdCorto = nombreProdCorto[1];

        let nombreProdLargo = document.getElementById(
          "tituloProd" + nombreProdCorto
        ).textContent;

        let precioProd = document.getElementById(
          "precio" + nombreProdCorto
        ).textContent;

        let unidades = document.getElementById(
          "unidadesProducto" + nombreProdCorto
        ).value;
        //VERIFICA SI SE PUEDEN INTRODUCIR UNIDADES AL CARRITO SI HAY EN STOCK
        if (unidades <= stock) {
          alert(
            "Se añadio a la cesta: " +
              nombreProdLargo +
              " - " +
              unidades +
              " Unidades"
          );

          let productoYaEnCarrito = false;

          // Verificar si el producto ya está en el carrito
          for (let i = 0; i < carritoCompra.length; i++) {
            if (carritoCompra[i][1] == nombreProdLargo) {
              carritoCompra[i][2]++;
              productoYaEnCarrito = true;
              break;
            }
          }

          // Si el producto no está en el carrito, añadirlo
          if (!productoYaEnCarrito) {
            carritoCompra.push([
              nombreProdCorto,
              nombreProdLargo,
              unidades,
              precioProd,
            ]);

            //Guarda el nuevo productos añadido a la cookie
            guardarArrayEnCookie(
              "carritoCompraCookie",
              carritoCompra,
              "Thu, 01 Jan 2100 00:00:00 GMT"
            );
          }
          //Actualizar el numero del carrito
          actualizarNumeroCarrito();
        } else {
          alert(
            "NO hay las unidades seleccionadas para este producto. Utilize las flechas!"
          );
        }
      });
    } else {
      alert("Debe Iniciar Sesión para poder comprar!!!");
      window.location.href = "InicioSesion.php";
    }
  });
}

//Actualiza el numero de los articulos en todos los sitios
function actualizarNumeroCarrito() {
  TotalProductosPagina.textContent = carritoCompra.length;
}

//Elimina la cookie que se le pase por parametro
function delete_cookie(name) {
  document.cookie = name + "=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;";
}

/*BOTON CERRAR SESION PARA QUITAR LE CUENTA DEL USUARIO*/
setTimeout(function () {
  let cerrarSesion = document.getElementById("CerrarSesionBoton");
  cerrarSesion.addEventListener("click", function () {
    delete_cookie("username");
    window.location.href = "index.php";
  });
}, 1000);

/*NOMBRE PAGINA PARA VOLVER A LA PAGINA PRINCIPAL*/
setTimeout(function () {
  let TituloPagina = document.getElementById("TituloPagina");
  TituloPagina.addEventListener("click", function () {
    window.location.href = "index.php";
  });
}, 100);

/*FUNCION PARA VERIFICAR SI LAS COOKIES EXISTEN*/
function verificarCookie(nombreCookie) {
  // Obtener todas las cookies del documento
  var cookies = document.cookie.split(";");

  // Recorrer todas las cookies para buscar la que coincide con el nombre dado
  for (var i = 0; i < cookies.length; i++) {
    var cookie = cookies[i].trim();
    // Verificar si la cookie actual coincide con el nombre dado
    if (cookie.indexOf(nombreCookie + "=") === 0) {
      // La cookie está definida, ahora verificamos si tiene valor null
      var valorCookie = cookie.substring(nombreCookie.length + 1);
      if (valorCookie === "null") {
        // La cookie está definida como null
        return true;
      } else {
        // La cookie está definida con un valor diferente de null
        return false;
      }
    }
  }
  // La cookie no se encontró, por lo que no está definida
  return true;
}

/*FUNCION PARA PODER RECOGER LA COOKIE*/
function obtenerCookie(nombreCookie) {
  // Separar todas las cookies en una matriz
  var cookies = document.cookie.split(";");

  // Buscar la cookie específica por su nombre
  for (var i = 0; i < cookies.length; i++) {
    var cookie = cookies[i].trim();
    // Verificar si la cookie actual coincide con el nombre dado
    if (cookie.indexOf(nombreCookie + "=") === 0) {
      // Devolver el valor de la cookie
      return cookie.substring(nombreCookie.length + 1);
    }
  }
  // Si no se encuentra la cookie, devolver null
  return null;
}
