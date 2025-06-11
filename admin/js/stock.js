document.getElementById("btnProductos").addEventListener("click", () => {
  fetch("modulos/productos.php")
    .then(res => res.text())
    .then(html => {
      const contenedor = document.getElementById("contenedor-modulo");
      contenedor.innerHTML = html;

      // Cargar el script solo después de cargar el módulo
      const script = document.createElement("script");
      script.src = "js/productos.js";
      script.type = "module"; // opcional si usás funciones modernas
      document.body.appendChild(script);
    });
});
