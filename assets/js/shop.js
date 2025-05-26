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
    contenedor.innerHTML = "";

    if (productos.length === 0) {
        contenedor.innerHTML = "<p class='text-center'>No se encontraron productos.</p>";
        return;
    }

    productos.forEach(p => {
        const card = `
            <div class="col-md-6 col-lg-6 col-xl-4 mb-4">
                <div class="rounded position-relative fruite-item">
                    <div class="fruite-img">
                        <img src="assets/img/${p.imagen}" class="img-fluid w-100 rounded-top" alt="${p.nombre_producto}">
                    </div>
                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">
                        ${p.nombre_categoria}
                    </div>
                    <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                        <h4>${p.nombre_producto}</h4>
                        <p class="small">${p.descripcion}</p>
                        <div class="d-flex justify-content-between flex-lg-wrap">
                            <p class="text-dark fs-5 fw-bold mb-0">$${parseFloat(p.precio_minorista).toFixed(2)} / ${p.unidad_medida}</p>
                            <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary">
                                <i class="fa fa-shopping-bag me-2 text-primary"></i> Añadir al carrito
                            </a>
                        </div>
                    </div>
                </div>
            </div>`;
        contenedor.insertAdjacentHTML("beforeend", card);
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
