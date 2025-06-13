<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Gestión de Stock</h5>
    <div>
      <button class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#modalAjustarStock">
        <i class="mdi mdi-plus-circle"></i> Agregar/Ajustar Stock
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
          <option value="1">Verduras</option>
          <option value="2">Hortalizas</option>
          <option value="3">Tubérculos</option>
          <option value="4">Frutas</option>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">Proveedor</label>
        <select class="form-control" id="filtro-proveedor">
          <option value="">Todos los proveedores</option>
          <option value="1">Proveedor Local A</option>
          <option value="2">Proveedor Local B</option>
          <option value="3">Distribuidor Central</option>
        </select>
      </div>
      <div class="col-md-3 d-flex align-items-end">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="filtro-stock-minimo">
          <label class="form-check-label" for="filtro-stock-minimo">
            Solo stock mínimo
          </label>
        </div>
      </div>
    </div>

    <!-- Alertas de Stock -->
    <div class="alert alert-warning d-flex align-items-center mb-3" role="alert">
      <i class="mdi mdi-alert-circle me-2"></i>
      <div>
        <strong>¡Atención!</strong> Hay 3 productos con stock por debajo del mínimo requerido.
      </div>
    </div>

    <!-- Tabla de Stock -->
    <div class="table-responsive">
      <table class="table table-striped" id="tablaStock">
        <thead class="table-dark">
          <tr>
            <th>Código</th>
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
          <!-- Producto con stock normal -->
          <tr>
            <td>PROD001</td>
            <td>Zanahoria Orgánica</td>
            <td>Verduras</td>
            <td><span class="badge bg-success">25 kg</span></td>
            <td>kg</td>
            <td>10 kg</td>
            <td>Proveedor Local A</td>
            <td><span class="badge bg-success">Normal</span></td>
            <td>2025-01-15 10:30</td>
            <td>
              <button class="btn btn-sm btn-outline-primary" title="Ajustar Stock">
                <i class="mdi mdi-pencil"></i>
              </button>
              <button class="btn btn-sm btn-outline-info" title="Ver Historial">
                <i class="mdi mdi-history"></i>
              </button>
            </td>
          </tr>
          
          <!-- Producto con stock bajo -->
          <tr class="table-warning">
            <td>PROD002</td>
            <td>Tomate</td>
            <td>Hortalizas</td>
            <td><span class="badge bg-warning text-dark">3 kg</span></td>
            <td>kg</td>
            <td>8 kg</td>
            <td>Distribuidor Central</td>
            <td><span class="badge bg-warning text-dark">Stock Bajo</span></td>
            <td>2025-01-14 16:45</td>
            <td>
              <button class="btn btn-sm btn-outline-primary" title="Ajustar Stock">
                <i class="mdi mdi-pencil"></i>
              </button>
              <button class="btn btn-sm btn-outline-danger" title="Pedir Urgente">
                <i class="mdi mdi-alert"></i>
              </button>
            </td>
          </tr>

          <!-- Producto sin stock -->
          <tr class="table-danger">
            <td>PROD003</td>
            <td>Lechuga Mantecosa</td>
            <td>Verduras</td>
            <td><span class="badge bg-danger">0 unidades</span></td>
            <td>unidad</td>
            <td>12 unidades</td>
            <td>Proveedor Local B</td>
            <td><span class="badge bg-danger">Sin Stock</span></td>
            <td>2025-01-13 09:15</td>
            <td>
              <button class="btn btn-sm btn-outline-primary" title="Ajustar Stock">
                <i class="mdi mdi-pencil"></i>
              </button>
              <button class="btn btn-sm btn-outline-danger" title="Pedir Urgente">
                <i class="mdi mdi-alert"></i>
              </button>
            </td>
          </tr>

          <!-- Más productos de ejemplo -->
          <tr>
            <td>PROD004</td>
            <td>Papa Andina</td>
            <td>Tubérculos</td>
            <td><span class="badge bg-success">45 kg</span></td>
            <td>kg</td>
            <td>15 kg</td>
            <td>Proveedor Local A</td>
            <td><span class="badge bg-success">Normal</span></td>
            <td>2025-01-15 08:20</td>
            <td>
              <button class="btn btn-sm btn-outline-primary" title="Ajustar Stock">
                <i class="mdi mdi-pencil"></i>
              </button>
              <button class="btn btn-sm btn-outline-info" title="Ver Historial">
                <i class="mdi mdi-history"></i>
              </button>
            </td>
          </tr>

          <tr class="table-warning">
            <td>PROD005</td>
            <td>Pimiento Rojo</td>
            <td>Hortalizas</td>
            <td><span class="badge bg-warning text-dark">5 kg</span></td>
            <td>kg</td>
            <td>10 kg</td>
            <td>Distribuidor Central</td>
            <td><span class="badge bg-warning text-dark">Stock Bajo</span></td>
            <td>2025-01-14 14:30</td>
            <td>
              <button class="btn btn-sm btn-outline-primary" title="Ajustar Stock">
                <i class="mdi mdi-pencil"></i>
              </button>
              <button class="btn btn-sm btn-outline-danger" title="Pedir Urgente">
                <i class="mdi mdi-alert"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal para Agregar/Ajustar Stock -->
<div class="modal fade" id="modalAjustarStock" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar/Ajustar Stock</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="formAjustarStock">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Producto *</label>
                <select class="form-control" required>
                  <option value="">Seleccionar producto...</option>
                  <option value="1">PROD001 - Zanahoria Orgánica</option>
                  <option value="2">PROD002 - Tomate</option>
                  <option value="3">PROD003 - Lechuga Mantecosa</option>
                  <option value="4">PROD004 - Papa Andina</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Tipo de Operación *</label>
                <select class="form-control" required>
                  <option value="sumar">Sumar al stock</option>
                  <option value="restar">Restar del stock</option>
                  <option value="ajustar">Ajustar stock total</option>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">Cantidad *</label>
                <input type="number" class="form-control" min="0" step="0.01" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">Stock Actual</label>
                <input type="text" class="form-control" value="25 kg" readonly>
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">Stock Resultante</label>
                <input type="text" class="form-control" value="-- kg" readonly>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Proveedor</label>
                <select class="form-control">
                  <option value="">Seleccionar proveedor...</option>
                  <option value="1">Proveedor Local A</option>
                  <option value="2">Proveedor Local B</option>
                  <option value="3">Distribuidor Central</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Fecha de Ingreso</label>
                <input type="date" class="form-control" value="2025-01-15">
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Observaciones</label>
            <textarea class="form-control" rows="3" placeholder="Notas adicionales sobre el ajuste de stock..."></textarea>
          </div>

          <!-- Sección para subir factura -->
          <div class="card bg-light">
            <div class="card-body">
              <h6 class="card-title">Subir Factura (Opcional)</h6>
              <div class="mb-3">
                <label class="form-label">Imagen de la Factura</label>
                <input type="file" class="form-control" accept="image/*">
                <small class="text-muted">Formatos permitidos: JPG, PNG, PDF</small>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="procesarFactura">
                <label class="form-check-label" for="procesarFactura">
                  Procesar automáticamente productos de la factura
                </label>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success">Guardar Ajuste</button>
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
        <form id="formPedidoProveedor">
          <div class="row mb-4">
            <div class="col-md-4">
              <label class="form-label">Proveedor *</label>
              <select class="form-control" required>
                <option value="">Seleccionar proveedor...</option>
                <option value="1">Proveedor Local A</option>
                <option value="2">Proveedor Local B</option>
                <option value="3">Distribuidor Central</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">Fecha de Entrega Estimada</label>
              <input type="date" class="form-control" value="2025-01-20">
            </div>
            <div class="col-md-4">
              <label class="form-label">Prioridad</label>
              <select class="form-control">
                <option value="normal">Normal</option>
                <option value="urgente">Urgente</option>
                <option value="critica">Crítica</option>
              </select>
            </div>
          </div>

          <!-- Productos sugeridos con stock bajo -->
          <div class="card mb-4">
            <div class="card-header">
              <h6 class="mb-0">Productos con Stock Bajo (Sugeridos)</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th>Seleccionar</th>
                      <th>Producto</th>
                      <th>Stock Actual</th>
                      <th>Stock Mínimo</th>
                      <th>Cantidad Sugerida</th>
                      <th>Cantidad a Pedir</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="table-warning">
                      <td>
                        <input class="form-check-input" type="checkbox" checked>
                      </td>
                      <td>Tomate</td>
                      <td><span class="badge bg-warning text-dark">3 kg</span></td>
                      <td>8 kg</td>
                      <td>20 kg</td>
                      <td>
                        <input type="number" class="form-control form-control-sm" value="20" min="1">
                      </td>
                    </tr>
                    <tr class="table-danger">
                      <td>
                        <input class="form-check-input" type="checkbox" checked>
                      </td>
                      <td>Lechuga Mantecosa</td>
                      <td><span class="badge bg-danger">0 unidades</span></td>
                      <td>12 unidades</td>
                      <td>25 unidades</td>
                      <td>
                        <input type="number" class="form-control form-control-sm" value="25" min="1">
                      </td>
                    </tr>
                    <tr class="table-warning">
                      <td>
                        <input class="form-check-input" type="checkbox" checked>
                      </td>
                      <td>Pimiento Rojo</td>
                      <td><span class="badge bg-warning text-dark">5 kg</span></td>
                      <td>10 kg</td>
                      <td>15 kg</td>
                      <td>
                        <input type="number" class="form-control form-control-sm" value="15" min="1">
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- Agregar productos adicionales -->
          <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h6 class="mb-0">Productos Adicionales</h6>
              <button type="button" class="btn btn-sm btn-outline-primary">
                <i class="mdi mdi-plus"></i> Agregar Producto
              </button>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th>Producto</th>
                      <th>Stock Actual</th>
                      <th>Cantidad a Pedir</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <select class="form-control form-control-sm">
                          <option value="">Seleccionar...</option>
                          <option value="1">Zanahoria Orgánica</option>
                          <option value="4">Papa Andina</option>
                        </select>
                      </td>
                      <td>25 kg</td>
                      <td>
                        <input type="number" class="form-control form-control-sm" min="1">
                      </td>
                      <td>
                        <button type="button" class="btn btn-sm btn-outline-danger">
                          <i class="mdi mdi-delete"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Observaciones del Pedido</label>
            <textarea class="form-control" rows="3" placeholder="Notas adicionales para el proveedor..."></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Generar Pedido</button>
      </div>
    </div>
  </div>
</div>