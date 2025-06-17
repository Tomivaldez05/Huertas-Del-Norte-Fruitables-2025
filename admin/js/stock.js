// Variables globales
console.log("DEBUG: public/js/stock.js cargado y ejecutándose.");
console.log("Script de stock cargado");
let tablaStock;
let productosDisponibles = [];
let resultadosOCR = [];
let productosStock = []; // Llénalo al cargar la página o con AJAX

// Función principal para cargar el stock
function cargarStock() {
    console.log("estoy cargado stick");
    fetch("acciones/controladorStock.php?accion=listarStock")
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                console.error('Error al cargar stock:', data.error);
                mostrarAlerta('Error al cargar el stock: ' + data.error, 'danger');
                return;
            }

            // Destruir tabla existente si existe
            if (tablaStock) {
                tablaStock.destroy();
                tablaStock = null;
            }

            // Crear nueva tabla
            tablaStock = $("#tablaStock").DataTable({
                data: data,
                columns: [
                    { data: "nombre_producto" },
                    { data: "nombre_categoria" },
                    {
                        data: null,
                        render: function(data, type, row) {
                            let badgeClass = 'bg-success';
                            if (row.estado_stock === 'sin_stock') badgeClass = 'bg-danger';
                            else if (row.estado_stock === 'stock_bajo') badgeClass = 'bg-warning text-dark';
                            
                            return `<span class="badge ${badgeClass}">${row.cantidad_disponible} ${row.unidad_medida}</span>`;
                        }
                    },
                    { data: "unidad_medida" },
                    { data: "stock_minimo" },
                    { data: "nombre_proveedor" },
                    {
                        data: "estado_stock",
                        render: function(data, type, row) {
                            switch(data) {
                                case 'sin_stock':
                                    return '<span class="badge bg-danger">Sin Stock</span>';
                                case 'stock_bajo':
                                    return '<span class="badge bg-warning text-dark">Stock Bajo</span>';
                                default:
                                    return '<span class="badge bg-success">Normal</span>';
                            }
                        }
                    },
                    {
                        data: "fecha_ultima_actualizacion",
                        render: function(data) {
                            return new Date(data).toLocaleDateString('es-ES');
                        }
                    },
                    {
                        data: "id_producto",
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-sm btn-outline-primary btn-ajustar-stock" data-id="${data}" title="Ajustar Stock">
                                    <i class="mdi mdi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-info btn-ver-historial" data-id="${data}" title="Ver Historial">
                                    <i class="mdi mdi-history"></i>
                                </button>
                            `;
                        }
                    }
                ],
                language: {
                    url: "../assets/js/i18n/es-ES.json"
                },
                order: [[6, 'asc']], // Ordenar por estado (sin stock primero)
                pageLength: 25
            });

            // Generar alertas de stock
            generarAlertasStock(data);

            // Delegación de eventos para los botones de la tabla
            $('#tablaStock tbody').on('click', '.btn-ajustar-stock', function() {
                const idProducto = $(this).data('id');
                // Abre el modal y selecciona el producto automáticamente
                const modal = new bootstrap.Modal(document.getElementById('modalAjustarStock'));
                modal.show();
                setTimeout(() => {
                    document.getElementById('selectProductoManual').value = idProducto;
                    // Dispara el evento change para rellenar los campos
                    document.getElementById('selectProductoManual').dispatchEvent(new Event('change'));
                }, 200); // Espera a que el modal esté visible
            });

            $('#tablaStock tbody').on('click', '.btn-ver-historial', function() {
                const idProducto = $(this).data('id');
                // Abre el modal
                const modal = new bootstrap.Modal(document.getElementById('modalHistorialStock'));
                modal.show();
                // Carga el historial por AJAX
                fetch(`acciones/controladorStock.php?accion=historial&id_producto=${idProducto}`)
                    .then(res => res.json())
                    .then(data => {
                        const tbody = document.querySelector('#tablaHistorialStock tbody');
                        tbody.innerHTML = '';
                        if (data && data.length > 0) {
                            data.forEach(item => {
                                tbody.innerHTML += `
                                    <tr>
                                        <td>${item.fecha}</td>
                                        <td>${item.operacion}</td>
                                        <td>${item.cantidad}</td>
                                        <td>${item.observaciones || ''}</td>
                                    </tr>
                                `;
                            });
                        } else {
                            tbody.innerHTML = '<tr><td colspan="4" class="text-center">Sin movimientos</td></tr>';
                        }
                    });
            });
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarAlerta('Error al cargar el stock', 'danger');
        });
}

// Función para generar alertas de stock
function generarAlertasStock(data) {
    const alertasContainer = document.getElementById('alertas-stock');
    let sinStock = data.filter(item => item.estado_stock === 'sin_stock').length;
    let stockBajo = data.filter(item => item.estado_stock === 'stock_bajo').length;

    let alertasHTML = '';

    if (sinStock > 0) {
        alertasHTML += `
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="mdi mdi-alert-octagon me-2"></i>
                <div>
                    <strong>¡Crítico!</strong> ${sinStock} producto${sinStock > 1 ? 's' : ''} sin stock
                </div>
            </div>
        `;
    }

    if (stockBajo > 0) {
        alertasHTML += `
            <div class="alert alert-warning d-flex align-items-center" role="alert">
                <i class="mdi mdi-alert-triangle me-2"></i>
                <div>
                    <strong>Stock Bajo:</strong> ${stockBajo} producto${stockBajo > 1 ? 's requieren' : ' requiere'} reposición
                </div>
            </div>
        `;
    }

    if (sinStock === 0 && stockBajo === 0) {
        alertasHTML = `
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="mdi mdi-check-circle me-2"></i>
                <div>
                    <strong>¡Excelente!</strong> Todos los productos tienen stock adecuado
                </div>
            </div>
        `;
    }

    alertasContainer.innerHTML = alertasHTML;
}

// Función para cargar productos disponibles
function cargarProductosDisponibles() {
    fetch("acciones/controladorProducto.php?accion=listar")
        .then(res => res.json())
        .then(data => {
            productosDisponibles = data;
            
            // Llenar select de productos para ajuste manual
            const select = document.getElementById('selectProductoManual');
            if (select) {
                select.innerHTML = '<option value="">Seleccionar producto...</option>';
                data.forEach(producto => {
                    const option = document.createElement('option');
                    option.value = producto.id_producto;
                    option.textContent = `${producto.nombre_producto} (${producto.unidad_medida})`;
                    option.dataset.unidad = producto.unidad_medida;
                    select.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error al cargar productos:', error);
        });
}

// Función para procesar factura con OCR
function procesarFacturaOCR() {
    console.log("DEBUG: Función procesarFacturaOCR llamada.");

    const inputFactura = document.getElementById('inputFactura');
    const archivo = inputFactura.files[0];
    console.log("DEBUG: Elemento inputFactura:", inputFactura);
    console.log("DEBUG: inputFactura.files:", inputFactura.files);
    console.log("DEBUG: archivo (inputFactura.files[0]):", archivo);

    if (!archivo) {
        console.log('DEBUG: No se seleccionó ningún archivo. Intentando mostrar alerta.');
        mostrarAlerta('Por favor seleccione un archivo de factura', 'warning');

        return;
    }

    // Mostrar loading
    document.getElementById('loading-ocr').classList.remove('d-none');
    document.getElementById('btnProcesarFactura').disabled = true;

    const formData = new FormData();
    formData.append('factura', archivo);

    fetch('acciones/controladorStock.php?accion=procesarFacturaOCR', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        // Ocultar loading
        document.getElementById('loading-ocr').classList.add('d-none');
        document.getElementById('btnProcesarFactura').disabled = false;

        if (data.error) {
            mostrarAlerta('Error al procesar la factura: ' + data.error, 'danger');
            return;
        }

        if (data.success) {
            const todosLosProductos = [
                ...data.productos.productos,
                ...data.productos.productos_inactivos,
                ...data.productos.productos_nuevos
            ];
            resultadosOCR = todosLosProductos;
            mostrarResultadosOCR(todosLosProductos, data.texto_completo);
            
            // Mostrar paso 2
            document.getElementById('paso-revisar-ocr').classList.remove('d-none');
            document.getElementById('btnConfirmarStock').classList.remove('d-none');
            
            mostrarAlerta(`Se detectaron ${todosLosProductos.length} productos en la factura`, 'success');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('loading-ocr').classList.add('d-none');
        document.getElementById('btnProcesarFactura').disabled = false;
        mostrarAlerta('Error al procesar la factura', 'danger');
    });
}

// Función para mostrar resultados del OCR
function mostrarResultadosOCR(productos, textoCompleto) {
    if (!Array.isArray(productos)) {
        console.error('Error: productos no es un array', productos);
        return;
    }
    const tbody = document.querySelector('#ocrResultsTable tbody');
    tbody.innerHTML = '';
    productos.forEach((producto, i) => {
        const fila = crearFilaProductoOCR(producto, i);
        tbody.appendChild(fila);
    });
    document.getElementById('textoOCRCompleto').textContent = textoCompleto;
    // Reasignar listeners
    reasignarListenersOCR();
}

// Función para crear una fila de producto OCR
function crearFilaProductoOCR(producto, index) {
    const fila = document.createElement('tr');
    fila.dataset.index = index;

    let claseFila = 'table-success';
    let mensaje = '';
    if (!producto.coincidencia && producto.estado === 'nuevo') {
        claseFila = 'table-warning';
        mensaje = `<br><small class="text-muted">Producto nuevo. <a href="#" class="editar-producto-nuevo" data-index="${index}">Configurar</a></small>`;
    } else if (!producto.coincidencia && producto.estado === 'inactivo') {
        claseFila = 'table-danger';
        mensaje = `<br><small class="text-danger">Producto inactivo. <a href="#" class="reactivar-producto-inactivo" data-index="${index}">Reactivar</a></small>`;
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
        <td>
            <select class="form-control form-control-sm select-producto" data-index="${index}">
                <option value="">Seleccionar producto...</option>
                ${productosDisponibles.map(p => 
                    `<option value="${p.id_producto}" ${producto.id_producto == p.id_producto ? 'selected' : ''}>
                        ${p.nombre_producto} (${p.unidad_medida})
                    </option>`
                ).join('')}
            </select>
        </td>
        <td>
            <input type="number" class="form-control form-control-sm input-cantidad" 
                   value="${producto.cantidad}" min="0" step="0.01" data-index="${index}">
        </td>
        <td>
            <span class="unidad-medida">${producto.unidad_medida}</span>
        </td>
        <td>
            <select class="form-control form-control-sm select-operacion" data-index="${index}">
                <option value="sumar" selected>Sumar al stock</option>
                <option value="restar">Restar del stock</option>
                <option value="ajustar">Ajustar stock total</option>
            </select>
        </td>
        <td>
            <button class="btn btn-sm btn-outline-danger btn-eliminar-fila" data-index="${index}">
                <i class="mdi mdi-delete"></i>
            </button>
        </td>
    `;

    return fila;
}

// Función para agregar producto manualmente
function agregarProductoManual() {
    const tbody = document.querySelector('#ocrResultsTable tbody');
    const index = tbody.children.length;
    
    const producto = {
        nombre_detectado: 'Producto manual',
        cantidad: 1,
        id_producto: null,
        nombre_producto: '',
        unidad_medida: 'unidad',
        coincidencia: false
    };

    const fila = crearFilaProductoOCR(producto, index);
    tbody.appendChild(fila);
}

// Función para confirmar y actualizar stock
function confirmarActualizacionStock() {
    const filas = document.querySelectorAll('#ocrResultsTable tbody tr');
    const productos = [];

    filas.forEach(fila => {
        const index = fila.dataset.index;
        const selectProducto = fila.querySelector('.select-producto');
        const inputCantidad = fila.querySelector('.input-cantidad');
        const selectOperacion = fila.querySelector('.select-operacion');

        const idProducto = selectProducto.value;
        const cantidad = parseFloat(inputCantidad.value);
        const tipoOperacion = selectOperacion.value;

        if (idProducto && cantidad > 0) {
            productos.push({
                id_producto: idProducto,
                cantidad: cantidad,
                tipo_operacion: tipoOperacion,
                observaciones: 'Actualización desde factura OCR'
            });
        }
    });

    if (productos.length === 0) {
        mostrarAlerta('No hay productos válidos para actualizar', 'warning');
        return;
    }

    // Confirmar acción
    if (!confirm(`¿Está seguro de actualizar el stock de ${productos.length} productos?`)) {
        return;
    }

    fetch('acciones/controladorStock.php?accion=actualizarStock', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ productos: productos })
    })
    .then(res => res.json())
    .then(data => {
        if (data.error) {
            mostrarAlerta('Error al actualizar stock: ' + data.error, 'danger');
            return;
        }

        if (data.success) {
            mostrarAlerta(data.mensaje, 'success');
            
            // Cerrar modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalProcesarFactura'));
            modal.hide();
            
            // Recargar tabla de stock
            cargarStock();
            
            // Limpiar formulario
            limpiarFormularioOCR();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarAlerta('Error al actualizar el stock', 'danger');
    });
}

// Función para limpiar formulario OCR
function limpiarFormularioOCR() {
    document.getElementById('inputFactura').value = '';
    document.getElementById('paso-revisar-ocr').classList.add('d-none');
    document.getElementById('btnConfirmarStock').classList.add('d-none');
    document.querySelector('#ocrResultsTable tbody').innerHTML = '';
    document.getElementById('textoOCRCompleto').textContent = '';
    resultadosOCR = [];
}

// Función para mostrar alertas
function mostrarAlerta(mensaje, tipo = 'info') {
    // Crear elemento de alerta
    const alerta = document.createElement('div');
    alerta.className = `alert alert-${tipo} alert-dismissible fade show`;
    alerta.innerHTML = `
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    // Buscar el contenedor correcto
    let contenedor;
    if (document.querySelector('.modal.show')) {
        // Si estamos en un modal abierto, buscar el contenedor dentro del modal
        contenedor = document.querySelector('.modal.show .modal-body');
    } else {
        // Si no estamos en un modal, usar el contenedor principal
        contenedor = document.querySelector('.card-body');
    }

    if (contenedor) {
        // Remover alertas anteriores
        const alertasAnteriores = contenedor.querySelectorAll('.alert');
        alertasAnteriores.forEach(alerta => alerta.remove());

        // Insertar nueva alerta
        contenedor.insertBefore(alerta, contenedor.firstChild);
        
        // Auto-remover después de 5 segundos
        setTimeout(() => {
            if (alerta.parentNode) {
                alerta.remove();
            }
        }, 5000);
    } else {
        console.error('No se encontró un contenedor para mostrar la alerta');
    }
}

// Event Listeners
document.addEventListener('DOMContentLoaded', function() {
    // Cargar datos iniciales
    cargarStock();
    cargarProductosDisponibles();
    console.log("DEBUG: btnProcesarFactura encontrado. Adjuntando listener de evento.");

    // Botón procesar factura OCR
    document.getElementById('btnProcesarFactura').addEventListener('click', procesarFacturaOCR);

    // Botón confirmar stock
    document.getElementById('btnConfirmarStock').addEventListener('click', confirmarActualizacionStock);

    // Botón agregar producto manual
    document.getElementById('btnAgregarProducto').addEventListener('click', agregarProductoManual);

    // Limpiar formulario al cerrar modal
    document.getElementById('modalProcesarFactura').addEventListener('hidden.bs.modal', limpiarFormularioOCR);

    // Delegación de eventos para botones dinámicos
    document.getElementById('productos-container').addEventListener('click', function(e) {
        // Si el click fue en el <i>, sube al botón
        let btn = e.target;
        if (btn.classList.contains('mdi-delete')) {
            btn = btn.closest('.btn-eliminar-fila');
        }
        if (btn && btn.classList.contains('btn-eliminar-fila')) {
            console.log('Click en Eliminar Fila');
            const fila = btn.closest('tr');
            if (fila) fila.remove();
        }
    });

    // Cambio en select de producto (actualizar unidad de medida)
    $(document).on('change', '.select-producto', function() {
        const index = this.dataset.index;
        const idProducto = this.value;
        const fila = this.closest('tr');
        const unidadSpan = fila.querySelector('.unidad-medida');
        
        if (idProducto) {
            const producto = productosDisponibles.find(p => p.id_producto == idProducto);
            if (producto) {
                unidadSpan.textContent = producto.unidad_medida;
            }
        }
    });

    // Filtros
    document.getElementById('btnFiltrar').addEventListener('click', function() {
        if (tablaStock) {
            const busqueda = document.getElementById('filtro-busqueda').value;
            const categoria = document.getElementById('filtro-categoria').value;
            const estado = document.getElementById('filtro-estado').value;
            
            // Aplicar filtros (implementación básica)
            tablaStock.search(busqueda).draw();
        }
    });

    document.getElementById('btnLimpiarFiltros').addEventListener('click', function() {
        document.getElementById('filtro-busqueda').value = '';
        document.getElementById('filtro-categoria').value = '';
        document.getElementById('filtro-estado').value = '';
        
        if (tablaStock) {
            tablaStock.search('').draw();
        }
    });

    // Botón procesar texto de prueba
    document.getElementById('btnProcesarTexto').addEventListener('click', procesarTextoPrueba);
});

document.addEventListener('click', function(e) {
    console.log('Click global:', e.target);
    let btn = e.target;
    if (btn.classList.contains('mdi-delete')) {
        btn = btn.closest('.btn-eliminar-fila');
    }
    if (btn && btn.classList.contains('btn-eliminar-fila')) {
        console.log('Click en Eliminar Fila');
        const fila = btn.closest('tr');
        if (fila) fila.remove();
    }
});

export function inicializarStock() {
    console.log("Script de stock cargado");
    
    // Cargar datos iniciales
    cargarStock();
    cargarProductosDisponibles();
   
    const btnGuardarAjuste = document.getElementById('btnGuardarAjusteManual');
    if (btnGuardarAjuste) {
        btnGuardarAjuste.addEventListener('click', function() {
            const idProducto = document.getElementById('selectProductoManual').value;
            const cantidad = parseFloat(document.getElementById('inputCantidadManual').value);
            const tipoOperacion = document.getElementById('selectOperacionManual').value;
            if (!idProducto || isNaN(cantidad) || cantidad < 0) {
                mostrarAlerta('Selecciona un producto y una cantidad válida', 'warning');
                return;
            }
            fetch('acciones/controladorStock.php?accion=actualizarStock', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    productos: [{
                        id_producto: idProducto,
                        cantidad: cantidad,
                        tipo_operacion: tipoOperacion,
                        observaciones: 'Ajuste manual'
                    }]
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    mostrarAlerta('Stock actualizado correctamente', 'success');
                    bootstrap.Modal.getInstance(document.getElementById('modalAjustarStock')).hide();
                    cargarStock(); // Recarga la tabla principal
                } else {
                    mostrarAlerta('Error al actualizar stock: ' + (data.error || ''), 'danger');
                }
            });
        });
    }

    // Agregar evento click al botón de procesar OCR
    const btnProcesar = document.getElementById('btnProcesarFactura');
    console.log("Botón procesar:", btnProcesar);
    
    if (btnProcesar) {
        btnProcesar.onclick = function() {
            console.log("Botón clickeado");
            procesarFacturaOCR();
        };
    } else {
        console.error("No se encontró el botón de procesar OCR");
    }

    // Agregar evento cuando el modal se abre
    const modalProcesarFactura = document.getElementById('modalProcesarFactura');
    if (modalProcesarFactura) {
        modalProcesarFactura.addEventListener('shown.bs.modal', function() {
            console.log("Modal abierto, verificando botón...");
            const btnProcesar = document.getElementById('btnProcesarFactura');
            if (btnProcesar) {
                btnProcesar.onclick = function() {
                    console.log("Botón clickeado");
                    procesarFacturaOCR();
                };
            }
        });
    }

    const inputCantidadManual = document.getElementById('inputCantidadManual');
    if (inputCantidadManual) {
        inputCantidadManual.addEventListener('input', actualizarStockResultante);
    }

    const selectOperacionManual = document.getElementById('selectOperacionManual');
    if (selectOperacionManual) {
        selectOperacionManual.addEventListener('change', actualizarStockResultante);
    }

    cargarProductosStock(() => {
        // Asigna el listener para abrir el modal de ajuste
        const btnAjustarStock = document.querySelector('.btn-ajustar-stock');
        if (btnAjustarStock) {
            btnAjustarStock.addEventListener('click', abrirModalAjustarStock);
        }
    });
}

function cargarProductosStock(callback) {
    fetch('acciones/controladorStock.php?accion=listarStock')
        .then(res => res.json())
        .then(data => {
            productosStock = data;
            if (typeof callback === 'function') callback();
        });
}

// Función para reasignar listeners tras actualizar el DOM del modal OCR
function reasignarListenersOCR() {
    const btnAgregar = document.getElementById('btnAgregarProducto');
    if (btnAgregar) {
        btnAgregar.onclick = function() {
            console.log('Click en Agregar Producto');
            agregarProductoManual();
        };
    } else {
        console.log('No se encontró btnAgregarProducto');
    }
    const btnConfirmar = document.getElementById('btnConfirmarStock');
    if (btnConfirmar) {
        btnConfirmar.onclick = function() {
            console.log('Click en Confirmar Stock');
            confirmarActualizacionStock();
        };
    } else {
        console.log('No se encontró btnConfirmarStock');
    }
    document.querySelectorAll('.editar-producto-nuevo').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            abrirModalProducto('nuevo', this.dataset.index);
        });
    });
    document.querySelectorAll('.reactivar-producto-inactivo').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            abrirModalProducto('inactivo', this.dataset.index);
        });
    });
}

function abrirModalProducto(tipo, index) {
    const producto = resultadosOCR[index];
    document.getElementById('nombreProductoNuevo').value = producto.nombre_detectado;
    document.getElementById('categoriaProductoNuevo').value = producto.categoria || '';
    document.getElementById('unidadProductoNuevo').value = producto.unidad_medida || 'kg';
    document.getElementById('indexProductoNuevo').value = index;
    document.getElementById('tipoEdicionProducto').value = tipo;

    // Mostrar mensaje solo si es inactivo
    document.getElementById('mensajeReactivar').classList.toggle('d-none', tipo !== 'inactivo');

    const modal = new bootstrap.Modal(document.getElementById('modalProductoNuevo'));
    modal.show();
}

document.getElementById('guardarProductoNuevo').addEventListener('click', function() {
    const index = document.getElementById('indexProductoNuevo').value;
    resultadosOCR[index].nombre_detectado = document.getElementById('nombreProductoNuevo').value;
    resultadosOCR[index].categoria = document.getElementById('categoriaProductoNuevo').value;
    resultadosOCR[index].unidad_medida = document.getElementById('unidadProductoNuevo').value;
    // Si es inactivo, podrías marcarlo para reactivar en el backend
    if (document.getElementById('tipoEdicionProducto').value === 'inactivo') {
        resultadosOCR[index].reactivar = true;
    }
    mostrarResultadosOCR(resultadosOCR, document.getElementById('textoOCRCompleto').textContent);
    bootstrap.Modal.getInstance(document.getElementById('modalProductoNuevo')).hide();
    mostrarAlerta('Producto actualizado. Recuerda dar de alta o reactivar el producto en el sistema.', 'warning');
});

function procesarTextoPrueba() {
    const texto = document.getElementById('textoPrueba').value;
    if (!texto) {
        mostrarAlerta('Por favor ingrese un texto para procesar', 'warning');
        return;
    }

    // Mostrar loading
    document.getElementById('loading-ocr').classList.remove('d-none');
    document.getElementById('btnProcesarTexto').disabled = true;

    const formData = new FormData();
    formData.append('texto', texto);

    fetch('acciones/controladorStock.php?accion=procesarTextoPrueba', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        // Ocultar loading
        document.getElementById('loading-ocr').classList.add('d-none');
        document.getElementById('btnProcesarTexto').disabled = false;

        if (data.error) {
            mostrarAlerta('Error al procesar el texto: ' + data.error, 'danger');
            return;
        }

        if (data.success) {
            const todosLosProductos = [
                ...data.productos.productos,
                ...data.productos.productos_inactivos,
                ...data.productos.productos_nuevos
            ];
            resultadosOCR = todosLosProductos;
            mostrarResultadosOCR(todosLosProductos, data.texto_completo);
            
            // Mostrar paso 2
            document.getElementById('paso-revisar-ocr').classList.remove('d-none');
            document.getElementById('btnConfirmarStock').classList.remove('d-none');
            
            mostrarAlerta(`Se detectaron ${todosLosProductos.length} productos en el texto`, 'success');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('loading-ocr').classList.add('d-none');
        document.getElementById('btnProcesarTexto').disabled = false;
        mostrarAlerta('Error al procesar el texto', 'danger');
    });
}

Swal.fire({
  icon: 'success',
  title: '¡Listo!',
  text: 'Producto actualizado correctamente'
});

document.getElementById('selectProductoManual').addEventListener('change', function() {
    const idProducto = this.value;
    const producto = productosStock.find(p => p.id_producto == idProducto);

    document.getElementById('stockActualManual').value = producto ? producto.cantidad_disponible : '';
    document.getElementById('inputCantidadManual').value = 0;
    document.getElementById('stockResultanteManual').value = producto ? producto.cantidad_disponible : '';
    document.getElementById('selectOperacionManual').value = 'sumar';
});

function actualizarStockResultante() {
    const stockActualInput = document.getElementById('stockActualManual');
    const cantidadInput = document.getElementById('inputCantidadManual');
    const operacionSelect = document.getElementById('selectOperacionManual');
    const stockResultanteInput = document.getElementById('stockResultanteManual');

    if (!stockActualInput || !cantidadInput || !operacionSelect || !stockResultanteInput) {
        return;
    }

    const stockActual = parseFloat(stockActualInput.value) || 0;
    const cantidad = parseFloat(cantidadInput.value) || 0;
    const operacion = operacionSelect.value;
    let resultante = stockActual;
    if (operacion === 'sumar') resultante += cantidad;
    else if (operacion === 'restar') resultante = Math.max(0, stockActual - cantidad);
    else if (operacion === 'ajustar') resultante = cantidad;
    stockResultanteInput.value = resultante;
}

// Guardar ajuste

function abrirModalAjustarStock() {
  // Llenar el select de productos
  const select = document.getElementById('selectProductoManual');
  select.innerHTML = '<option value="">Seleccionar producto...</option>';
  productosStock.forEach(p => {
    select.innerHTML += `<option value="${p.id_producto}">${p.nombre_producto} (${p.unidad_medida})</option>`;
  });

  // Limpiar campos
  document.getElementById('stockActualManual').value = '';
  document.getElementById('inputCantidadManual').value = '';
  document.getElementById('stockResultanteManual').value = '';
  document.getElementById('selectOperacionManual').value = 'sumar';
}

