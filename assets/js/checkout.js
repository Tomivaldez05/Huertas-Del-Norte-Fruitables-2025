console.log("🧪 JS activo");

// Esperar a que el script de MercadoPago esté cargado
// y toda la lógica esté dentro del DOMContentLoaded

document.addEventListener('DOMContentLoaded', function() {
    // Verificar si MercadoPago está disponible
    if (typeof MercadoPago === 'undefined') {
        console.error('El SDK de MercadoPago no está cargado');
        return;
    }

    const mp = new MercadoPago("APP_USR-c7bc1d8d-239a-4ceb-bb8e-8da8d8ccb2c5", {
        locale: "es-AR"
    });

    let preciosMayoristas = {};

    async function obtenerPreciosMayoristas(productosIds) {
        try {
            const formData = new FormData();
            formData.append("productos", productosIds.join(","));

            const response = await fetch("acciones/controladorProducto.php?accion=precios-mayoristas", {
                method: "POST",
                body: formData
            });

            if (!response.ok) throw new Error("Error al obtener precios mayoristas");

            const data = await response.json();
            return data;
        } catch (error) {
            console.error("Error al obtener precios mayoristas:", error);
            return {};
        }
    }

    // Cargar el carrito y la tabla de resumen
    (async function cargarCarrito() {
        const carrito = JSON.parse(localStorage.getItem("carrito")) || {};
        const tbody = document.querySelector("#tabla-carrito-checkout");
        if (!tbody) return;

        tbody.innerHTML = "";

        const productosIds = Object.keys(carrito);
        preciosMayoristas = await obtenerPreciosMayoristas(productosIds);

        let subtotal = 0;

        for (const [id, item] of Object.entries(carrito)) {
            const datosMayorista = preciosMayoristas[id];
            const precioFinal = datosMayorista && item.cantidad >= datosMayorista.cantidad_minima_mayorista
                ? datosMayorista.precio_mayorista
                : item.precio;

            const totalItem = precioFinal * item.cantidad;
            subtotal += totalItem;

            item.precio_final = precioFinal;

            const fila = `
                <tr>
                    <td><img src="${item.imagen}" class="rounded-circle" style="width: 60px; height: 60px;"></td>
                    <td>${item.nombre}</td>
                    <td>$${precioFinal.toFixed(2)}</td>
                    <td>${item.cantidad}</td>
                    <td>$${totalItem.toFixed(2)}</td>
                </tr>
            `;
            tbody.innerHTML += fila;
        }

        if (tbody.innerHTML.trim() === "") {
            tbody.innerHTML = `<tr><td colspan="5" class="text-center text-danger">No se pudo cargar el carrito.</td></tr>`;
            return;
        }

        tbody.innerHTML += `
            <tr><td colspan="4" class="text-end fw-bold">Subtotal:</td><td>$${subtotal.toFixed(2)}</td></tr>
            <tr>
                <td colspan="4" class="text-end fw-bold">Envío:</td>
                <td>
                    <div class="form-check">
                        <input type="radio" name="shipping" class="form-check-input" value="0" checked> Gratis
                    </div>
                    <div class="form-check">
                        <input type="radio" name="shipping" class="form-check-input" value="15"> Tarifa $15
                    </div>
                </td>
            </tr>
            <tr><td colspan="4" class="text-end fw-bold">TOTAL:</td><td id="total-final">$${subtotal.toFixed(2)}</td></tr>
        `;

        document.querySelectorAll("input[name='shipping']").forEach(input => {
            input.addEventListener("change", () => {
                const envio = parseFloat(document.querySelector("input[name='shipping']:checked").value);
                document.getElementById("total-final").textContent = `$${(subtotal + envio).toFixed(2)}`;
            });
        });
    })();

    // Enviar formulario
    document.getElementById("form-checkout").addEventListener("submit", async function (e) {
        e.preventDefault();

        const form = new FormData(this);
        const datos = Object.fromEntries(form.entries());
        const carrito = JSON.parse(localStorage.getItem("carrito")) || {};

        for (const [id, item] of Object.entries(carrito)) {
            const datosMayorista = preciosMayoristas[id];
            item.precio_final = datosMayorista && item.cantidad >= datosMayorista.cantidad_minima_mayorista
                ? datosMayorista.precio_mayorista
                : item.precio;
        }

        // Verifica el método de pago seleccionado
        const metodoPago = datos.metodo_pago;

        if (metodoPago === "mercadopago") {
            // Lógica para Mercado Pago
            const res = await fetch("acciones/crear_preferencia.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ carrito })
            });

            const data = await res.json();

            if (data.id) {
                window.location.href = data.init_point;
            } else {
                alert("Error con Mercado Pago");
                console.error(data);
            }
            return; // No seguir con el flujo normal
        }

        // Si es contra reembolso, finalizar pedido normalmente
        const res = await fetch("acciones/finalizar_pedido.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ cliente: datos, carrito })
        });

        const data = await res.json();

        if (data.ok) {
            localStorage.removeItem("carrito");
            window.location.href = "gracias.php?pedido=" + data.numero_pedido;
        } else {
            alert("Error al finalizar pedido");
            console.error(data.error);
        }
    });

    // Elimina cualquier event listener sobre el radio de Mercado Pago
    // (No se necesita ningún código aquí)
});

function crearFilaProductoOCR(producto, index) {
    const fila = document.createElement('tr');
    fila.dataset.index = index;

    let claseFila = 'table-success';
    let mensaje = '';
    if (!producto.coincidencia && producto.estado === 'nuevo') {
        claseFila = 'table-warning';
        mensaje = '<br><small class="text-muted">Producto nuevo. <a href="#" class="editar-producto-nuevo" data-index="' + index + '">Configurar</a></small>';
    } else if (!producto.coincidencia && producto.estado === 'inactivo') {
        claseFila = 'table-danger';
        mensaje = '<br><small class="text-danger">Producto inactivo</small>';
    } else if (!producto.coincidencia) {
        claseFila = 'table-warning';
        mensaje = '<br><small class="text-muted">No se encontró coincidencia exacta</small>';
    }

    fila.className = claseFila;

    fila.innerHTML = `
        <td>
            <strong>${producto.nombre_detectado}</strong>
            ${mensaje}
        </td>
        <!-- ... resto igual ... -->
    `;

    // ... resto igual ...
    return fila;
}
