/*----------------------------------------------------------FUNCIONALIDAD PAGINA PRINCIPAL-------------------------------------------------*/
/*Funcion que al cargar la aplicacion detecta cada input de las teclas, recoje la palabra y el valor escrito en el campo y lo manda
a la funcion buscar producto para mostrar los productos*/
window.onload = function () {
  let buscarproducto = document.getElementById("buscarproducto");
  buscarproducto.addEventListener("keypress", function (event) {
    buscarProducto(buscarproducto.value);
    let mostrarProductos = document.getElementById("mostrarProd");
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

  let inputbuscarProducto = document.getElementById("buscarproducto");

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

    let cajasproductos = document.querySelectorAll(".producto");
    for (const producto of cajasproductos) {
      producto.addEventListener("click", function () {
        alert("Aqui:" + producto.textContent);
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
const carritoCompra = [];
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

function mostrarDialogo() {
  dialogo.style.display = "block";
  document.getElementsByTagName("body")[0].style.overflow = "hidden";
  pintarProductosCarrito(carritoCompra);
  pintarProductosCarritoResumen(carritoCompra);
}

function ocultarDialogo() {
  dialogo.style.display = "none";
  document.getElementsByTagName("body")[0].style.overflow = "auto";
}

//TotalProductosCarrito.textContent = carritoCompra.length + " Productos";
TotalProductosPagina.textContent = TotalProductosPaginacont;

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
    //Crear Elementos
    let div = document.createElement("div");
    let hr = document.createElement("hr");
    let img = document.createElement("img");
    let h3Nombre = document.createElement("h3");
    let unidad = document.createElement("input");
    unidad.setAttribute("type", "number");
    unidad.classList.add("unidadArticuloCarrito");
    unidad.setAttribute("value", 1);
    unidad.setAttribute("min", 1);

    returnUnidadProd(productos[i][1], function (unidades) {
      unidad.max = unidades;
    });

    /*returnUnidadProd(nombreProdLargo, function (unidades) {
      let inputSetMax = document.getElementById(
        "unidadesProducto" + nombreProd
      );
      inputSetMax.max = unidades;
    });*/

    let h3Precio = document.createElement("h3");
    let equis = document.createElement("button");
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
    //'<input class="unidadArticulo" type="number" name="" id="unidadesProducto' . $nombreProdCorto . '" min="1" value="1">';
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
}

function pintarProductosCarritoResumen(productos) {
  resumenPedido.innerHTML = "";
  //Mostrar elementos extra en el DOM
  let h1Resumen = document.createElement("h1");
  h1Resumen.textContent = "Resumen del Pedido";
  let divBarra = document.createElement("div");
  divBarra.classList.add("pedidoBarra");
  let h3Productos = document.createElement("h3");

  let contProductosEnCarro = 0;
  contProductosEnCarro = parseFloat(contProductosEnCarro);
  for (let i = 0; i < productos.length; i++) {
    let unidadProducto = 0;
    unidadProducto = parseFloat(productos[i][2]);
    contProductosEnCarro = contProductosEnCarro + unidadProducto;
  }

  h3Productos.textContent = "Productos: " + contProductosEnCarro;
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

  //Precio de los Productos
  var contPrecio = 0;
  for (let i = 0; i < productos.length; i++) {
    let sumaPrecio = 0;
    sumaPrecio = sumaPrecio + productos[i][3];
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
    alert("HOLA");
    registrarPedido(carritoCompra);
    alert(carritoCompra);
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

let botonesCompra = document.querySelectorAll(".botonCompra");
for (const botonCompra of botonesCompra) {
  botonCompra.addEventListener("click", function () {
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

    carritoCompra.push([nombreProdCorto, nombreProdLargo, unidades, precio]);

    actualizarNumeroCarrito();
    mostrarDialogo();
  });
}

let botonesCesta = document.querySelectorAll(".botonCesta");
for (const botonCesta of botonesCesta) {
  botonCesta.addEventListener("click", function () {
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

    alert(
      "Se añadio a la cesta: " +
        nombreProdLargo +
        " - " +
        unidades +
        " Unidades"
    );

    carritoCompra.push([
      nombreProdCorto,
      nombreProdLargo,
      unidades,
      precioProd,
    ]);

    actualizarNumeroCarrito();
  });
}

//Actualiza el numero de los articulos en todos los sitios
function actualizarNumeroCarrito() {
  TotalProductosPaginacont++;
  TotalProductosPagina.textContent = TotalProductosPaginacont;
}
