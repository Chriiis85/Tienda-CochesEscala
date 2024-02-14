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
        alert(producto.textContent);
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
