document.addEventListener("DOMContentLoaded", () => {
    const tabla = document.getElementById("tabla-carrito");
    const totalEl = document.getElementById("total-carrito");
    const carrito = JSON.parse(localStorage.getItem("carrito")) || {};

    if (Object.keys(carrito).length === 0) {
        tabla.innerHTML = "<p>Tu carrito está vacío.</p>";
        totalEl.textContent = "Total: $0.00";
        return;
    }

    let total = 0;
    let html = `
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>`;

    for (const [id, item] of Object.entries(carrito)) {
        const subtotal = item.precio * item.cantidad;
        total += subtotal;
        html += `
            <tr>
                <td><img src="${item.imagen}" alt="${item.nombre}" style="width: 60px; height: 60px; object-fit: cover;"></td>
                <td>${item.nombre}</td>
                <td>$${item.precio.toFixed(2)}</td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <span>${item.cantidad}</span>
                        <button class="btn btn-sm btn-outline-secondary btn-restar" data-id="${id}">−</button>
                        <button class="btn btn-sm btn-outline-secondary btn-sumar" data-id="${id}">+</button>
                    </div>
                </td>                <td>$${subtotal.toFixed(2)}</td>
                <td><button class="btn btn-sm btn-danger btn-eliminar" data-id="${id}">Eliminar</button></td>
            </tr>`;
    }

    html += `</tbody></table>`;
    tabla.innerHTML = html;
    totalEl.textContent = `Total: $${total.toFixed(2)}`;

    document.querySelectorAll(".btn-eliminar").forEach(btn => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;
            delete carrito[id];
            localStorage.setItem("carrito", JSON.stringify(carrito));
            location.reload(); // recargar para ver el cambio
        });
    });

    // Sumar cantidad
document.querySelectorAll(".btn-sumar").forEach(btn => {
    btn.addEventListener("click", () => {
        const id = btn.dataset.id;
        const carrito = JSON.parse(localStorage.getItem("carrito")) || {};
        carrito[id].cantidad += 1;
        localStorage.setItem("carrito", JSON.stringify(carrito));
        location.reload();
    });
});

// Restar cantidad
document.querySelectorAll(".btn-restar").forEach(btn => {
    btn.addEventListener("click", () => {
        const id = btn.dataset.id;
        const carrito = JSON.parse(localStorage.getItem("carrito")) || {};
        if (carrito[id].cantidad > 1) {
            carrito[id].cantidad -= 1;
        } else {
            delete carrito[id]; // eliminar si llega a 0
        }
        localStorage.setItem("carrito", JSON.stringify(carrito));
        location.reload();
    });
});

});
