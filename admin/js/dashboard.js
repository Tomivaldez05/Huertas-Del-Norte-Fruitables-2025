export function inicializarDashboard() {
    cargarResumenDashboard();
    cargarProductosCriticos();
    cargarActividadesRecientes();
}

function cargarResumenDashboard() {
    fetch('acciones/controladorDashboard.php?accion=resumen')
        .then(res => res.json())
        .then(data => {
            document.getElementById('totalProductos').textContent = data.total_productos;
            document.getElementById('stockBajo').textContent = data.stock_bajo;
            document.getElementById('sinStock').textContent = data.sin_stock;
            document.getElementById('pedidosPendientes').textContent = data.pedidos_pendientes;
            // Muestra alertas si corresponde
            mostrarAlertasDashboard(data.stock_bajo, data.sin_stock);
        });
}

function mostrarAlertasDashboard(stockBajo, sinStock) {
    const alertas = [];
    if (sinStock > 0) alertas.push(`<div class="alert alert-danger">¡Hay productos sin stock!</div>`);
    if (stockBajo > 0) alertas.push(`<div class="alert alert-warning">¡Hay productos con stock bajo!</div>`);
    document.getElementById('alertasDashboard').innerHTML = alertas.join('');
}

function cargarProductosCriticos() {
    fetch('acciones/controladorDashboard.php?accion=productos_criticos')
        .then(res => res.json())
        .then(data => {
            const tbody = document.querySelector('#tablaCriticos tbody');
            tbody.innerHTML = '';
            data.forEach(p => {
                let clase = '';
                if (p.cantidad_disponible == 0) clase = 'table-danger';
                else clase = 'table-warning';
                tbody.innerHTML += `<tr class="${clase}">
                    <td>${p.nombre_producto}</td>
                    <td>${p.cantidad_disponible} ${p.unidad_medida}</td>
                    <td>${p.nombre_categoria}</td>
                </tr>`;
            });
        });
}

function cargarActividadesRecientes() {
    fetch('acciones/controladorDashboard.php?accion=actividades_recientes')
        .then(res => res.json())
        .then(data => {
            const contenedor = document.getElementById('actividadesRecientesCards');
            contenedor.innerHTML = '';
            data.forEach(a => {
                let color = '';
                let icono = '';
                let titulo = '';
                if (a.operacion === 'sumar') {
                    color = 'success';
                    icono = '<i class="mdi mdi-plus-circle"></i>';
                    titulo = 'Ingreso de stock';
                } else if (a.operacion === 'restar') {
                    color = 'danger';
                    icono = '<i class="mdi mdi-minus-circle"></i>';
                    titulo = 'Egreso de stock';
                } else if (a.operacion === 'ajustar') {
                    color = 'warning';
                    icono = '<i class="mdi mdi-tune"></i>';
                    titulo = 'Ajuste de stock';
                }
                contenedor.innerHTML += `
                  <div class="col-md-4 mb-3">
                    <div class="card border-${color}">
                      <div class="card-body">
                        <h6 class="card-title text-${color}">${icono} ${titulo}</h6>
                        <p class="mb-1"><strong>Producto:</strong> ${a.nombre_producto}</p>
                        <p class="mb-1"><strong>Cantidad:</strong> ${a.cantidad}</p>
                        <p class="mb-1"><strong>Usuario:</strong> ${a.usuario}</p>
                        <p class="mb-1"><strong>Fecha:</strong> ${a.fecha}</p>
                        ${a.observaciones ? `<p class="mb-0"><strong>Obs:</strong> ${a.observaciones}</p>` : ''}
                      </div>
                    </div>
                  </div>
                `;
            });
        });
}