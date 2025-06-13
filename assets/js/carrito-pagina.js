// Variables globales para manejar precios mayoristas
let preciosMayoristas = {};

// Función para obtener precios mayoristas desde la base de datos
async function obtenerPreciosMayoristas(productosIds) {
    try {
        const formData = new FormData();
        formData.append('productos', productosIds.join(','));
        
        const response = await fetch('acciones/controladorProducto.php?accion=precios-mayoristas', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        if (data.error) {
            console.error('Error al obtener precios mayoristas:', data.error);
            return {};
        }
        
        return data;
    } catch (error) {
        console.error('Error en la petición de precios mayoristas:', error);
        return {};
    }
}

// Función para calcular precio final (minorista o mayorista)
function calcularPrecioFinal(idProducto, cantidad, precioMinorista) {
    const datosProducto = preciosMayoristas[idProducto];
    
    if (!datosProducto) {
        return precioMinorista; // Si no hay datos, usar precio minorista
    }
    
    // Si la cantidad es mayor o igual a la cantidad mínima mayorista, usar precio mayorista
    if (cantidad >= datosProducto.cantidad_minima_mayorista) {
        return datosProducto.precio_mayorista;
    }
    
    return precioMinorista;
}

// Función para actualizar una fila específica del carrito
async function actualizarFilaCarrito(id, nuevaCantidad) {
    const carrito = JSON.parse(localStorage.getItem("carrito")) || {};
    
    if (nuevaCantidad <= 0) {
        delete carrito[id];
    } else {
        carrito[id].cantidad = nuevaCantidad;
    }
    
    localStorage.setItem("carrito", JSON.stringify(carrito));
    
    // Actualizar la fila específica
    const fila = document.querySelector(`tr[data-producto-id="${id}"]`);
    if (fila && carrito[id]) {
        const item = carrito[id];
        const precioFinal = calcularPrecioFinal(id, item.cantidad, item.precio);
        const subtotal = precioFinal * item.cantidad;
        const aplicaDescuento = precioFinal < item.precio;
        
        // Actualizar cantidad
        fila.querySelector('.cantidad-display').textContent = item.cantidad;
        
        // Actualizar precio
        const celdaPrecio = fila.querySelector('.celda-precio');
        celdaPrecio.innerHTML = aplicaDescuento 
            ? `<s>$${item.precio.toFixed(2)}</s><br><strong>$${precioFinal.toFixed(2)}</strong> <span class="badge bg-success">Mayorista</span>`
            : `$${item.precio.toFixed(2)}`;
        
        // Actualizar subtotal
        fila.querySelector('.celda-subtotal').textContent = `$${subtotal.toFixed(2)}`;
    } else if (fila) {
        // Si el producto fue eliminado, remover la fila
        fila.remove();
    }
    
    // Actualizar total general
    actualizarTotalGeneral();
    actualizarContador();
}

// Función para actualizar el total general
function actualizarTotalGeneral() {
    const carrito = JSON.parse(localStorage.getItem("carrito")) || {};
    let total = 0;
    
    for (const [id, item] of Object.entries(carrito)) {
        const precioFinal = calcularPrecioFinal(id, item.cantidad, item.precio);
        total += precioFinal * item.cantidad;
    }
    
    const totalEl = document.getElementById("total-carrito");
    if (totalEl) {
        totalEl.textContent = `Total: $${total.toFixed(2)}`;
    }
}

// Función principal para cargar el carrito
document.addEventListener("DOMContentLoaded", async () => {
    const tabla = document.getElementById("tabla-carrito");
    const totalEl = document.getElementById("total-carrito");
    const carrito = JSON.parse(localStorage.getItem("carrito")) || {};

    if (Object.keys(carrito).length === 0) {
        tabla.innerHTML = "<p>Tu carrito está vacío.</p>";
        totalEl.textContent = "Total: $0.00";
        return;
    }

    // Obtener precios mayoristas para todos los productos del carrito
    const productosIds = Object.keys(carrito).map(id => parseInt(id));
    preciosMayoristas = await obtenerPreciosMayoristas(productosIds);

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
        const precioFinal = calcularPrecioFinal(id, item.cantidad, item.precio);
        const subtotal = precioFinal * item.cantidad;
        const aplicaDescuento = precioFinal < item.precio;
        total += subtotal;

        // CORRECCIÓN: Asegurar que la ruta de imagen incluya productos/
        let rutaImagen = item.imagen;
        if (!rutaImagen.includes('productos/')) {
            rutaImagen = rutaImagen.replace('assets/img/', 'assets/img/productos/');
        }

        html += `
            <tr data-producto-id="${id}">
                <td><img src="${rutaImagen}" alt="${item.nombre}" style="width: 60px; height: 60px; object-fit: cover;"></td>
                <td>${item.nombre}</td>
                <td class="celda-precio">
                    ${aplicaDescuento 
                        ? `<s>$${item.precio.toFixed(2)}</s><br><strong>$${precioFinal.toFixed(2)}</strong> <span class="badge bg-success">Mayorista</span>` 
                        : `$${item.precio.toFixed(2)}`
                    }
                </td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <span class="cantidad-display">${item.cantidad}</span>
                        <button class="btn btn-sm btn-outline-secondary btn-restar" data-id="${id}">−</button>
                        <button class="btn btn-sm btn-outline-secondary btn-sumar" data-id="${id}">+</button>
                    </div>
                </td>                
                <td class="celda-subtotal">$${subtotal.toFixed(2)}</td>
                <td><button class="btn btn-sm btn-danger btn-eliminar" data-id="${id}">Eliminar</button></td>
            </tr>`;
    }

    html += `</tbody></table>`;
    tabla.innerHTML = html;
    totalEl.textContent = `Total: $${total.toFixed(2)}`;

    // Event listeners para botones
    document.querySelectorAll(".btn-eliminar").forEach(btn => {
        btn.addEventListener("click", async () => {
            const id = btn.dataset.id;
            await actualizarFilaCarrito(id, 0);
        });
    });

    // Sumar cantidad
    document.querySelectorAll(".btn-sumar").forEach(btn => {
        btn.addEventListener("click", async () => {
            const id = btn.dataset.id;
            const carrito = JSON.parse(localStorage.getItem("carrito")) || {};
            const nuevaCantidad = carrito[id].cantidad + 1;
            await actualizarFilaCarrito(id, nuevaCantidad);
        });
    });

    // Restar cantidad
    document.querySelectorAll(".btn-restar").forEach(btn => {
        btn.addEventListener("click", async () => {
            const id = btn.dataset.id;
            const carrito = JSON.parse(localStorage.getItem("carrito")) || {};
            const nuevaCantidad = carrito[id].cantidad - 1;
            await actualizarFilaCarrito(id, nuevaCantidad);
        });
    });
});