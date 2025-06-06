"use strict";

console.log("✅ shop.js cargado correctamente");

// Referencias globales de elementos HTML
const contenedor = document.getElementById("contenedor-productos");
const btnCargarMas = document.getElementById("btn-cargar-mas");
const inputBusqueda = document.getElementById("input-busqueda");
const sliderPrecio = document.getElementById("sliderPrecio");
const valorPrecio = document.getElementById("valorPrecio");
const listaCategorias = document.getElementById("lista-categorias");

let offset = 0;
const limite = 6;

// 🧱 Función reutilizable para mostrar productos
function renderizarProductos(productos) {
    const contenedor = document.getElementById("contenedor-productos");

    if (!Array.isArray(productos)) {
        console.error("❌ La respuesta no es un array:", productos);
        return;
    }

    if (!contenedor) {
        console.warn("⚠️ contenedor-productos no encontrado en el DOM.");
        return;
    }

    if (productos.length === 0) {
        contenedor.innerHTML = "<p class='text-center'>No se encontraron productos.</p>";
        return;
    }

    contenedor.innerHTML = "";

    productos.forEach(p => {
        const card = `
            <div class="col-md-4 mb-4">
                <div class="product-item border border-secondary rounded position-relative overflow-hidden bg-light">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="assets/img/${p.imagen}" alt="${p.nombre_producto}">
                    </div>
                    <div class="text-center p-4">
                        <h6 class="fw-bold">${p.nombre_producto}</h6>
                        <div class="d-flex justify-content-center mb-2">
                            <h5 class="text-primary">$${p.precio_minorista}</h5>
                        </div>
                        <p class="small ${p.stock <= 3 ? 'text-danger fw-bold' : 'text-muted'} mb-1">
                            Stock: ${p.stock}
                        </p>
                        ${p.stock > 0
                            ? `<a href="#" class="btn border border-secondary rounded-pill px-3 text-primary btn-agregar-carrito"
                                   data-id="${p.id_producto}" 
                                   data-nombre="${p.nombre_producto}" 
                                   data-precio="${p.precio_minorista}" 
                                   data-imagen="assets/img/${p.imagen}" 
                                   data-stock="${p.stock}">
                                   <i class="fa fa-shopping-cart me-2 text-primary"></i> Añadir al carrito
                               </a>`
                            : `<span class="badge bg-danger rounded-pill px-3 py-2">Sin stock</span>`}
                    </div>
                </div>
            </div>
        `;

        contenedor.innerHTML += card;
    });
}


// 🔁 Obtener precio máximo para el slider
function obtenerPrecioMaximo() {
    if (sliderPrecio && valorPrecio) {
        fetch("acciones/controladorProducto.php?accion=precioMax")
            .then(res => res.json())
            .then(data => {
                const max = Math.ceil(data.maximo);
                sliderPrecio.max = max;
                sliderPrecio.value = 0;
                valorPrecio.textContent = 0;
            })
            .catch(err => console.error("❌ Error al obtener el precio máximo:", err));
    }
}

// 🧪 Aplicar filtros combinados
function aplicarFiltros() {
    const texto = inputBusqueda?.value.trim() || "";
    const categoria = document.querySelector(".categoria-activa")?.dataset.id || "";
    const precioMax = sliderPrecio?.value || "";

    const params = new URLSearchParams();
    if (texto) params.append("q", texto);
    if (categoria) params.append("categoria", categoria);
    if (precioMax) params.append("precioMax", precioMax);

    fetch(`acciones/controladorProducto.php?accion=filtrar&${params.toString()}`)
        .then(res => res.json())
        .then(productos => renderizarProductos(productos))
        .catch(err => console.error("❌ Error al aplicar filtros:", err));
}

// ▶️ Cargar productos iniciales
function cargarProductos() {
    fetch(`acciones/controladorProducto.php?accion=cargar&offset=${offset}`)
        .then(res => res.json())
        .then(data => {
            if (data.length === 0) {
                if (btnCargarMas) {
                    btnCargarMas.textContent = "No hay más productos";
                    btnCargarMas.disabled = true;
                }
                return;
            }
            renderizarProductos(data);
            offset += limite;
        })
        .catch(err => {
            if (btnCargarMas) {
                btnCargarMas.textContent = "Error al cargar";
                btnCargarMas.disabled = true;
            }
            console.error("❌ Error al cargar productos:", err);
        });
}

// ▶️ Listado de categorías dinámicas
if (listaCategorias) {
    fetch("acciones/controladorProducto.php?accion=categorias")
        .then(res => res.json())
        .then(data => {
            const todas = document.createElement("li");
            todas.innerHTML = `
                <div class="d-flex justify-content-between fruite-name">
                    <a href="#" data-id="0"><i class="fas fa-apple-alt me-2"></i>Todas</a>
                    <span></span>
                </div>`;
            listaCategorias.appendChild(todas);

            data.forEach(cat => {
                const item = document.createElement("li");
                item.innerHTML = `
                    <div class="d-flex justify-content-between fruite-name">
                        <a href="#" data-id="${cat.id_categoria}"><i class="fas fa-apple-alt me-2"></i>${cat.nombre_categoria}</a>
                        <span>(${cat.cantidad})</span>
                    </div>`;
                listaCategorias.appendChild(item);
            });

            listaCategorias.querySelectorAll("a").forEach(link => {
                link.addEventListener("click", (e) => {
                    e.preventDefault();
                    listaCategorias.querySelectorAll("a").forEach(el => el.classList.remove("categoria-activa"));
                    link.classList.add("categoria-activa");
                    aplicarFiltros();
                });
            });
        })
        .catch(err => console.error("Error al cargar categorías:", err));
}

// ▶️ Escuchas de eventos

document.addEventListener("DOMContentLoaded", () => {
    obtenerPrecioMaximo();
    cargarProductos();

    if (btnCargarMas) {
        btnCargarMas.addEventListener("click", () => {
            cargarProductos();
        });
    }

    if (inputBusqueda) {
        inputBusqueda.addEventListener("input", aplicarFiltros);
    }

    if (sliderPrecio) {
        sliderPrecio.addEventListener("input", () => {
            valorPrecio.textContent = sliderPrecio.value;
            aplicarFiltros();
        });
    }

});
document.addEventListener("click", function (e) {
    if (e.target.closest(".btn-agregar-carrito")) {
        e.preventDefault();
        const btn = e.target.closest(".btn-agregar-carrito");
        const id = btn.dataset.id;
        const nombre = btn.dataset.nombre;
        const precio = parseFloat(btn.dataset.precio);
        const imagen = btn.dataset.imagen;


        let carrito = JSON.parse(localStorage.getItem("carrito")) || {};

        if (carrito[id]) {
            carrito[id].cantidad += 1;
        } else {
            carrito[id] = {
                nombre,
                precio,
                cantidad: 1,
                imagen
            };
        }

        localStorage.setItem("carrito", JSON.stringify(carrito));
        actualizarContador();
        alert(`✅ ${nombre} añadido al carrito`);
    }
});

