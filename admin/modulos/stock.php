<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Gestión de Stock</h5>
    <div>
      <button class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#modalAjustarStock">
        <i class="mdi mdi-plus-circle"></i> Agregar/Ajustar Stock
      </button>
      <button class="btn btn-info btn-sm me-2" data-bs-toggle="modal" data-bs-target="#modalProcesarFactura">
        <i class="mdi mdi-file-document"></i> Procesar Factura OCR
      </button>
      <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalPedidoProveedor">
        <i class="mdi mdi-truck"></i> Generar Pedido a Proveedor
      </button>
    </div>
  </div>
  
  <div class="card-body">
    <!-- Sección de Filtros -->
    <div class="row mb-4">
      <div class="col-md-3">
        <label class="form-label">Buscar por nombre/código</label>
        <input type="text" class="form-control" placeholder="Buscar producto..." id="filtro-busqueda">
      </div>
      <div class="col-md-3">
        <label class="form-label">Categoría</label>
        <select class="form-control" id="filtro-categoria">
          <option value="">Todas las categorías</option>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">Estado de Stock</label>
        <select class="form-control" id="filtro-estado">
          <option value="">Todos los estados</option>
          <option value="sin_stock">Sin Stock</option>
          <option value="stock_bajo">Stock Bajo</option>
          <option value="normal">Normal</option>
        </select>
      </div>
      <div class="col-md-3 d-flex align-items-end">
        <button class="btn btn-primary" id="btnFiltrar">
          <i class="mdi mdi-filter"></i> Filtrar
        </button>
        <button class="btn btn-secondary ms-2" id="btnLimpiarFiltros">
          <i class="mdi mdi-filter-remove"></i> Limpiar
        </button>
      </div>
    </div>

    <!-- Alertas de Stock -->
    <div id="alertas-stock" class="mb-3">
      <!-- Las alertas se cargarán dinámicamente -->
    </div>

    <!-- Tabla de Stock -->
    <div class="table-responsive">
      <table class="table table-striped" id="tablaStock">
        <thead class="table-dark">
          <tr>
            <th>Producto</th>
            <th>Categoría</th>
            <th>Stock Actual</th>
            <th>Unidad</th>
            <th>Stock Mínimo</th>
            <th>Proveedor</th>
            <th>Estado</th>
            <th>Última Actualización</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <!-- Los datos se cargarán dinámicamente -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal para Procesar Factura OCR -->
<div class="modal fade" id="modalProcesarFactura" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="mdi mdi-file-document me-2"></i>Procesar Factura con OCR
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <!-- Paso 1: Cargar Factura -->
        <div id="paso-cargar-factura">
          <div class="card mb-4">
            <div class="card-header">
              <h6 class="mb-0">
                <i class="mdi mdi-upload me-2"></i>Paso 1: Cargar Imagen de la Factura
              </h6>
            </div>
            <div class="card-body">
              <div class="mb-3">
                <label class="form-label">Seleccionar archivo de factura</label>
                <input type="file" class="form-control" id="inputFactura" accept="image/*,.pdf">
                <small class="text-muted">Formatos permitidos: JPG, PNG, PDF. Tamaño máximo: 5MB</small>
              </div>
              <div class="d-flex gap-2">
                <button type="button" class="btn btn-primary" id="btnProcesarFactura">
                  <i class="mdi mdi-eye-check me-2"></i>Procesar con OCR
                </button>
                <div id="loading-ocr" class="d-none">
                  <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                  Procesando factura...
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Paso 2: Revisar y Editar Resultados OCR -->
        <div id="paso-revisar-ocr" class="d-none">
          <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h6 class="mb-0">
                <i class="mdi mdi-table-edit me-2"></i>Paso 2: Revisar y Editar Productos Detectados
              </h6>
              <button type="button" class="btn btn-sm btn-outline-primary" id="btnAgregarProducto">
                <i class="mdi mdi-plus"></i> Agregar Producto
              </button>
            </div>
            <div class="card-body">
              <div class="alert alert-info">
                <i class="mdi mdi-information me-2"></i>
                Revise los productos detectados automáticamente. Puede editar las cantidades, 
                seleccionar productos de la lista o agregar nuevos productos manualmente.
              </div>
              
              <div id="productos-container" class="table-responsive">
                <table class="table table-sm" id="ocrResultsTable">
                  <thead>
                    <tr>
                      <th>Producto Detectado</th>
                      <th>Producto en Sistema</th>
                      <th>Cantidad</th>
                      <th>Unidad</th>
                      <th>Tipo Operación</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Los resultados del OCR se cargarán aquí -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- Texto completo extraído (colapsable) -->
          <div class="card mb-4">
            <div class="card-header">
              <button class="btn btn-link p-0" type="button" data-bs-toggle="collapse" data-bs-target="#textoCompleto">
                <i class="mdi mdi-text me-2"></i>Ver texto completo extraído
              </button>
            </div>
            <div class="collapse" id="textoCompleto">
              <div class="card-body">
                <pre id="textoOCRCompleto" class="bg-light p-3" style="max-height: 200px; overflow-y: auto;"></pre>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success d-none" id="btnConfirmarStock">
          <i class="mdi mdi-check me-2"></i>Confirmar y Actualizar Stock
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para Agregar/Ajustar Stock Manual -->
<div class="modal fade" id="modalAjustarStock" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar/Ajustar Stock Manual</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="formAjustarStock">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Producto *</label>
                <select class="form-control" id="selectProductoManual" required>
                  <option value="">Seleccionar producto...</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Tipo de Operación *</label>
                <select class="form-control" id="selectOperacionManual">
                  <option value="sumar">Sumar</option>
                  <option value="restar">Restar</option>
                  <option value="ajustar">Ajustar</option>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">Cantidad *</label>
                <input type="number" class="form-control" id="inputCantidadManual">
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">Stock Actual</label>
                <input type="number" class="form-control" id="stockActualManual" readonly>
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">Stock Resultante</label>
                <input type="number" class="form-control" id="stockResultanteManual" readonly>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Observaciones</label>
            <textarea class="form-control" id="observacionesManual" rows="3" placeholder="Notas adicionales sobre el ajuste de stock..."></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" id="btnGuardarAjusteManual">Guardar Ajuste</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para Generar Pedido a Proveedor -->
<div class="modal fade" id="modalPedidoProveedor" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Generar Pedido a Proveedor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-info">
          <i class="mdi mdi-information me-2"></i>
          Esta funcionalidad estará disponible en una próxima actualización.
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para Configurar/Reactivar Producto -->
<div class="modal fade" id="modalProductoNuevo" tabindex="-1" aria-labelledby="modalProductoNuevoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalProductoNuevoLabel">Configurar Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="formProductoNuevo">
          <div class="mb-3">
            <label for="nombreProductoNuevo" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombreProductoNuevo" required>
          </div>
          <div class="mb-3">
            <label for="categoriaProductoNuevo" class="form-label">Categoría</label>
            <input type="text" class="form-control" id="categoriaProductoNuevo" required>
          </div>
          <div class="mb-3">
            <label for="unidadProductoNuevo" class="form-label">Unidad</label>
            <select class="form-control" id="unidadProductoNuevo">
              <option value="kg">kg</option>
              <option value="unidad">unidad</option>
              <option value="paquete">paquete</option>
            </select>
          </div>
          <input type="hidden" id="indexProductoNuevo">
          <input type="hidden" id="tipoEdicionProducto">
        </form>
        <div id="mensajeReactivar" class="alert alert-warning d-none">
          Este producto está inactivo. Puedes editarlo y reactivarlo.
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="guardarProductoNuevo">Guardar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalHistorialStock" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Historial de Movimientos de Stock</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <table class="table table-sm" id="tablaHistorialStock">
          <thead>
            <tr>
              <th>Fecha</th>
              <th>Operación</th>
              <th>Cantidad</th>
              <th>Observaciones</th>
            </tr>
          </thead>
          <tbody>
            <!-- Se llenará por JS -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('click', function(e) {
    let btn = e.target;
    // Si el click fue en el <i>, sube al botón
    if (btn.classList.contains('mdi-delete')) {
        btn = btn.closest('.btn-eliminar-fila');
    }
    if (btn && btn.classList.contains('btn-eliminar-fila')) {
        console.log('Click en Eliminar Fila');
        const fila = btn.closest('tr');
        if (fila) fila.remove();
    }
});

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

// Ejemplo de productosStock
// let productosStock = [{id_producto: 1, cantidad_disponible: 10, ...}, ...];

document.getElementById('selectProductoManual').addEventListener('change', function() {
    const idProducto = this.value;
    const producto = productosStock.find(p => p.id_producto == idProducto);

    // Rellenar el campo de stock actual
    document.getElementById('stockActualManual').value = producto ? producto.cantidad_disponible : '';

    // Rellenar el campo de cantidad con 0 por defecto
    document.getElementById('inputCantidadManual').value = 0;

    // Rellenar el campo de stock resultante igual al actual
    document.getElementById('stockResultanteManual').value = producto ? producto.cantidad_disponible : '';

    // Opcional: resetear la operación a "sumar"
    document.getElementById('selectOperacionManual').value = 'sumar';
});
</script>