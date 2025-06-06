// Actualiza el contador del carrito
function actualizarContador() {
    const carrito = JSON.parse(localStorage.getItem("carrito")) || {};
    const totalItems = Object.values(carrito).reduce((acc, item) => acc + item.cantidad, 0);
    const contador = document.getElementById("contador-carrito");
    if (contador) {
        contador.textContent = totalItems;
    }
}

// Genera el resumen del carrito
function mostrarResumenCarrito() {
    const resumen = document.getElementById("resumen-carrito");
    const carrito = JSON.parse(localStorage.getItem("carrito")) || {};

    if (!resumen) return;

    if (Object.keys(carrito).length === 0) {
        resumen.innerHTML = "<p>El carrito está vacío.</p>";
        return;
    }

    let total = 0;
    let html = '<div class="list-group">';

    for (const [id, item] of Object.entries(carrito)) {
        const subtotal = item.precio * item.cantidad;
        total += subtotal;
        html += `
            <div class="list-group-item d-flex justify-content-between align-items-start">
                <img src="${item.imagen}" alt="${item.nombre}" style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;">
                <div class="flex-grow-1 ms-2">
                    <strong>${item.nombre}</strong><br>
                    <small>${item.cantidad} x $${item.precio.toFixed(2)}</small>
                </div>
                <button class="btn btn-sm btn-outline-danger btn-eliminar" data-id="${id}">&times;</button>
            </div>`;
    }

    html += `</div><hr class="my-2"><strong>Total: $${total.toFixed(2)}</strong>`;
    resumen.innerHTML = html;

    // Asignar eventos a botones de eliminar
    document.querySelectorAll(".btn-eliminar").forEach(btn => {
        btn.addEventListener("click", e => {
            e.stopPropagation();
            const id = btn.dataset.id;
            eliminarDelCarrito(id);
            mostrarResumenCarrito();
            actualizarContador();
        });
    });
}

function eliminarDelCarrito(id) {
    const carrito = JSON.parse(localStorage.getItem("carrito")) || {};
    delete carrito[id];
    localStorage.setItem("carrito", JSON.stringify(carrito));
}

document.addEventListener("DOMContentLoaded", () => {
    actualizarContador();

    const contenedor = document.getElementById("carritoContainer");
    const resumen = document.getElementById("resumen-carrito");

    if (contenedor && resumen) {
        contenedor.addEventListener("mouseenter", () => {
            mostrarResumenCarrito();
            resumen.style.display = "block";
        });

        contenedor.addEventListener("mouseleave", () => {
            resumen.style.display = "none";
        });
    }
});
