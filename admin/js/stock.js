export function inicializarStock() {
  const esperarBtn = () => {
    const btn = document.getElementById("btnProductos");
    if (btn) {
      if (!btn.dataset.listenerAttached) {
        btn.addEventListener("click", () => {
          fetch("modulos/stock.php") // ← Este botón abre productos, no stock
            .then(res => res.text())
            .then(html => {
              const contenedor = document.getElementById("contenedor-modulo");
              contenedor.innerHTML = html;

              import("./js/productos.js").then(modulo => {
                if (typeof modulo.inicializarProductos === "function") {
                  modulo.inicializarProductos();
                }
              });
            });
        });
        // Marcar como "listener ya agregado"
        btn.dataset.listenerAttached = "true";
      }
    } else {
      setTimeout(esperarBtn, 100);
    }
  };

  esperarBtn();
}
