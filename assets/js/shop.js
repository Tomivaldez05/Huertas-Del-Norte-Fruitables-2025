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
let productosActuales = []; // Array para mantener todos los productos cargados
let categoriasBase = []; // Almacenará las categorías con sus IDs y nombres
let categoriasYaCargadas = false; // Variable para evitar múltiples cargas de categorías

// 🧱 Función reutilizable para mostrar productos
function renderizarProductos(productos, limpiarContenedor = true) {
    const contenedor = document.getElementById("contenedor-productos");

    if (!Array.isArray(productos)) {
        console.error("❌ La respuesta no es un array:", productos);
        return;
    }

    if (!contenedor) {
        console.warn("⚠️ contenedor-productos no encontrado en el DOM.");
        return;
    }

    if (productos.length === 0 && limpiarContenedor) {
        contenedor.innerHTML = "<p class='text-center'>No se encontraron productos.</p>";
        productosActuales = []; // Limpiar productosActuales si no se encontraron productos
        return;
    }

    // Si limpiarContenedor es false, agregamos a los productos existentes
    if (limpiarContenedor) {
        contenedor.innerHTML = "";
        productosActuales = [...productos];
    } else {
        productosActuales = [...productosActuales, ...productos];
    }

    // Renderizar todos los productos actuales
    contenedor.innerHTML = "";
    console.log("Productos a renderizar:", productosActuales);
    
    productosActuales.forEach(p => {
        const card = `
            <div class="col-md-4 mb-4">
                <div class="product-item border border-secondary rounded position-relative overflow-hidden bg-light">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="assets/img/productos/${p.imagen}" alt="${p.nombre_producto}">
                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">
                            ${p.nombre_categoria}
                        </div>
                    </div>
                    <div class="text-center p-4">
                        <h6 class="fw-bold">${p.nombre_producto}</h6>
                        <p class="text-muted small">${p.descripcion || ''}</p>
                        <div class="d-flex justify-content-center mb-2">
                            <h5 class="text-primary">$${p.precio_minorista} / ${p.unidad_medida}</h5>
                        </div>
                        <p class="small ${p.stock <= 3 ? 'text-danger fw-bold' : 'text-muted'} mb-1">
                            Stock: ${p.stock}
                        </p>
                        ${p.stock > 0
                            ? `<a href="#" class="btn border border-secondary rounded-pill px-3 text-primary btn-agregar-carrito"
                                   data-id="${p.id_producto}" 
                                   data-nombre="${p.nombre_producto}" 
                                   data-precio="${p.precio_minorista}" 
                                   data-imagen="assets/img/productos/${p.imagen}" 
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

// Función simplificada que ya no recalcula contadores
function actualizarContadoresCategorias() {
    // Esta función ya no es necesaria porque usamos los conteos del servidor
    console.log("Los contadores se mantienen con los valores del servidor");
}

// ▶️ Listado de categorías dinámicas (CORREGIDO)
if (listaCategorias) {
    function cargarCategorias() {
        // Evitar cargar categorías múltiples veces
        if (categoriasYaCargadas) {
            return;
        }
        
        fetch("acciones/controladorProducto.php?accion=categorias")
            .then(res => res.json())
            .then(data => {
                categoriasBase = data; // Guardar las categorías base
                listaCategorias.innerHTML = ''; // Limpiar lista
                
                data.forEach((cat, index) => {
                    const item = document.createElement("li");
                    item.innerHTML = `
                        <div class="d-flex justify-content-between fruite-name">
                            <a href="#" data-id="${cat.id_categoria}" ${index === 0 ? 'class="categoria-activa"' : ''}>
                                <i class="fas fa-apple-alt me-2"></i>${cat.nombre_categoria}
                            </a>
                            <span>(${cat.cantidad})</span>
                        </div>`;
                    listaCategorias.appendChild(item);
                });

                // Event listeners para las categorías
                listaCategorias.querySelectorAll("a").forEach(link => {
                    link.addEventListener("click", (e) => {
                        e.preventDefault();
                        listaCategorias.querySelectorAll("a").forEach(el => el.classList.remove("categoria-activa"));
                        link.classList.add("categoria-activa");
                        
                        // Si selecciona "Todas", mostrar botón cargar más y resetear
                        if (link.dataset.id === "0") {
                            offset = 0;
                            productosActuales = [];
                            if (btnCargarMas) {
                                btnCargarMas.style.display = 'block';
                                btnCargarMas.disabled = false;
                                btnCargarMas.textContent = '↓ Cargar más';
                            }
                            cargarProductos();
                        } else {
                            // Cuando se selecciona una categoría específica
                            if (btnCargarMas) {
                                btnCargarMas.style.display = 'none';
                            }
                            aplicarFiltros();
                        }
                    });
                });
                
                categoriasYaCargadas = true; // Marcar como cargadas
            })
            .catch(err => console.error("❌ Error al cargar categorías:", err));
    }
    
    // Cargar categorías al inicio
    cargarCategorias();
}

// 💲 Obtener precio máximo para el slider
function obtenerPrecioMaximo() {
    fetch("acciones/controladorProducto.php?accion=precioMax")
        .then(res => res.json())
        .then(data => {
            if (sliderPrecio) {
                sliderPrecio.max = data.maximo;
                sliderPrecio.value = data.maximo; // Establecer valor inicial del slider al máximo
                valorPrecio.textContent = data.maximo; // Mostrar valor inicial
            }
        })
        .catch(err => console.error("❌ Error al obtener precio máximo:", err));
}

// 🧪 Aplicar filtros combinados
function aplicarFiltros() {
    const texto = inputBusqueda?.value.trim() || "";
    const categoria = document.querySelector(".categoria-activa")?.dataset.id || "";
    const precioMax = sliderPrecio?.value || "";

    const params = new URLSearchParams();
    if (texto) params.append("q", texto);
    if (categoria && categoria !== "0") params.append("categoria", categoria); // No enviar 0 para "Todas"
    if (precioMax) params.append("precioMax", precioMax);

    fetch(`acciones/controladorProducto.php?accion=filtrar&${params.toString()}`)
        .then(res => res.json())
        .then(productos => {
            renderizarProductos(productos, true); // Limpiar contenedor al filtrar
            // Resetear offset y ocultar botón cargar más cuando se filtra
            offset = 0;
            
            if (btnCargarMas) {
                if (categoria !== "0" || productos.length < limite) {
                    btnCargarMas.style.display = 'none'; // Ocultar si hay un filtro de categoría específico
                } else {
                    btnCargarMas.style.display = 'block'; // Mostrar si la categoría es "Todas" y hay potencial para más
                    btnCargarMas.disabled = false;
                    btnCargarMas.textContent = "↓ Cargar más";
                }
            }
        })
        .catch(err => console.error("❌ Error al aplicar filtros:", err));
}

// ▶️ Cargar productos iniciales
function cargarProductos(esCargarMas = false) {
    const categoriaActivaId = document.querySelector(".categoria-activa")?.dataset.id; // Obtener la categoría activa
    if (categoriaActivaId && categoriaActivaId !== "0") {
        // Si hay una categoría activa diferente de "Todas", no usar cargar, usar filtrar
        aplicarFiltros();
        return;
    }

    fetch(`acciones/controladorProducto.php?accion=cargar&offset=${offset}`)
        .then(res => res.json())
        .then(data => {
            if (data.length === 0 && productosActuales.length === 0) { // Si no hay productos inicialmente
                if (btnCargarMas) {
                    btnCargarMas.textContent = "No se encontraron productos";
                    btnCargarMas.disabled = true;
                }
                renderizarProductos([], true); // Limpiar y mostrar mensaje de no encontrados
                return;
            }

            if (data.length === 0) { // Si ya no hay más productos para cargar
                if (btnCargarMas) {
                    btnCargarMas.textContent = "No hay más productos";
                    btnCargarMas.disabled = true;
                }
                return;
            }
            
            // Si es "cargar más", no limpiar el contenedor
            renderizarProductos(data, !esCargarMas);
            
            // Solo incrementa offset si hay productos cargados
            offset += data.length;
            
            // Si se cargaron menos productos que el límite, no hay más
            if (data.length < limite && btnCargarMas) {
                btnCargarMas.textContent = "No hay más productos";
                btnCargarMas.disabled = true;
            } else if (btnCargarMas) {
                btnCargarMas.textContent = "↓ Cargar más";
                btnCargarMas.disabled = false;
            }
        })
        .catch(err => {
            if (btnCargarMas) {
                btnCargarMas.textContent = "Error al cargar";
                btnCargarMas.disabled = true;
            }
            console.error("❌ Error al cargar productos:", err);
        });
}

// Función para recargar SOLO los contadores (sin duplicar categorías)
function recargarSoloContadores() {
    if (listaCategorias && categoriasYaCargadas) {
        fetch("acciones/controladorProducto.php?accion=categorias")
            .then(res => res.json())
            .then(data => {
                // Actualizar solo los números en los spans existentes
                data.forEach(cat => {
                    const link = listaCategorias.querySelector(`a[data-id="${cat.id_categoria}"]`);
                    if (link) {
                        const span = link.parentElement.querySelector('span');
                        if (span) {
                            span.textContent = `(${cat.cantidad})`;
                        }
                    }
                });
            })
            .catch(err => console.error("❌ Error al actualizar contadores:", err));
    }
}

// 🛒 Función para agregar productos al carrito (ESTA FALTABA)
function agregarAlCarrito(producto) {
    let carrito = JSON.parse(localStorage.getItem("carrito")) || {};
    
    if (carrito[producto.id]) {
        // Si ya existe, incrementar cantidad
        carrito[producto.id].cantidad++;
    } else {
        // Si no existe, agregarlo
        carrito[producto.id] = {
            id: producto.id,
            nombre: producto.nombre,
            precio: producto.precio,
            imagen: producto.imagen,
            cantidad: 1,
            stock: producto.stock
        };
    }
    
    localStorage.setItem("carrito", JSON.stringify(carrito));
    
    // Actualizar contador del carrito
    if (typeof actualizarContador === 'function') {
        actualizarContador();
    }
    
    console.log("✅ Producto agregado al carrito:", producto);
}

// 🚀 Inicialización cuando se carga el DOM
document.addEventListener("DOMContentLoaded", () => {
    console.log("🎯 DOM cargado, inicializando aplicación...");
    
    // Inicializar precio máximo
    obtenerPrecioMaximo();
    
    // Cargar productos iniciales
    cargarProductos();
    
    // Event listener para el botón cargar más
    if (btnCargarMas) {
        btnCargarMas.addEventListener("click", (e) => {
            e.preventDefault();
            cargarProductos(true); // Solo cargar más productos, NO recargar categorías
        });
    }
    
    // Event listener para búsqueda
    if (inputBusqueda) {
        let timerBusqueda;
        inputBusqueda.addEventListener("input", () => {
            clearTimeout(timerBusqueda);
            timerBusqueda = setTimeout(() => {
                aplicarFiltros();
            }, 300); // Esperar 300ms después de dejar de escribir
        });
    }
    
    // Event listener para el slider de precio
    if (sliderPrecio && valorPrecio) {
        sliderPrecio.addEventListener("input", (e) => {
            valorPrecio.textContent = e.target.value;
        });
        
        sliderPrecio.addEventListener("change", () => {
            aplicarFiltros();
        });
    }
});

// 🛒 Event listener para el carrito (CORREGIDO)
document.addEventListener("click", (e) => {
    if (e.target.closest(".btn-agregar-carrito")) {
        e.preventDefault();
        const btn = e.target.closest(".btn-agregar-carrito");
        
        const producto = {
            id: btn.dataset.id,
            nombre: btn.dataset.nombre,
            precio: parseFloat(btn.dataset.precio),
            imagen: btn.dataset.imagen,
            stock: parseInt(btn.dataset.stock)
        };
        
        console.log("🛒 Agregando al carrito:", producto);
        
        // Llamar a la función de agregar al carrito
        agregarAlCarrito(producto);
        
        // Feedback visual temporal
        const textoOriginal = btn.innerHTML;
        btn.innerHTML = '<i class="fa fa-check me-2 text-success"></i> ¡Agregado!';
        btn.disabled = true;
        
        setTimeout(() => {
            btn.innerHTML = textoOriginal;
            btn.disabled = false;
        }, 1500);
    }
});

console.log("✅ Archivo shop.js completamente cargado y configurado");