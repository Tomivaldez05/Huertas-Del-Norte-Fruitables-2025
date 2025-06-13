<div class="container-fluid">
  <!-- Encabezado de Bienvenida -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card bg-primary text-white">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h3 class="mb-1">¡Bienvenido al Sistema de Gestión de Stock!</h3>
              <p class="mb-0">Panel de control para el encargado de inventario - Huertas del Norte</p>
            </div>
            <div class="text-end">
              <i class="mdi mdi-warehouse" style="font-size: 3rem; opacity: 0.7;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Tarjetas de Resumen -->
  <div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                Total de Productos
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">127</div>
            </div>
            <div class="col-auto">
              <i class="mdi mdi-package-variant text-primary" style="font-size: 2rem;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                Stock Bajo
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">8</div>
            </div>
            <div class="col-auto">
              <i class="mdi mdi-alert-circle text-warning" style="font-size: 2rem;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
      <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                Sin Stock
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">3</div>
            </div>
            <div class="col-auto">
              <i class="mdi mdi-close-circle text-danger" style="font-size: 2rem;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                Pedidos Pendientes
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
            </div>
            <div class="col-auto">
              <i class="mdi mdi-truck text-success" style="font-size: 2rem;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Alertas Importantes -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h6 class="m-0 font-weight-bold text-primary">
            <i class="mdi mdi-alert-circle me-2"></i>Alertas Importantes
          </h6>
        </div>
        <div class="card-body">
          <div class="alert alert-danger d-flex align-items-center mb-3" role="alert">
            <i class="mdi mdi-alert-octagon me-2"></i>
            <div>
              <strong>¡Crítico!</strong> 3 productos sin stock: Lechuga Mantecosa, Apio, Brócoli
            </div>
          </div>
          <div class="alert alert-warning d-flex align-items-center mb-3" role="alert">
            <i class="mdi mdi-alert-triangle me-2"></i>
            <div>
              <strong>Stock Bajo:</strong> 8 productos requieren reposición urgente
            </div>
          </div>
          <div class="alert alert-info d-flex align-items-center mb-0" role="alert">
            <i class="mdi mdi-information me-2"></i>
            <div>
              <strong>Recordatorio:</strong> Pedido a Proveedor Local A programado para mañana
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Acciones Rápidas -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h6 class="m-0 font-weight-bold text-primary">
            <i class="mdi mdi-lightning-bolt me-2"></i>Acciones Rápidas
          </h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-3 mb-3">
              <button class="btn btn-success w-100 h-100 d-flex flex-column align-items-center justify-content-center" style="min-height: 100px;">
                <i class="mdi mdi-plus-circle mb-2" style="font-size: 2rem;"></i>
                <span>Ajustar Stock</span>
              </button>
            </div>
            <div class="col-md-3 mb-3">
              <button class="btn btn-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center" style="min-height: 100px;">
                <i class="mdi mdi-truck mb-2" style="font-size: 2rem;"></i>
                <span>Generar Pedido</span>
              </button>
            </div>
            <div class="col-md-3 mb-3">
              <button class="btn btn-info w-100 h-100 d-flex flex-column align-items-center justify-content-center" style="min-height: 100px;">
                <i class="mdi mdi-file-document mb-2" style="font-size: 2rem;"></i>
                <span>Subir Factura</span>
              </button>
            </div>
            <div class="col-md-3 mb-3">
              <button class="btn btn-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center" style="min-height: 100px;">
                <i class="mdi mdi-chart-line mb-2" style="font-size: 2rem;"></i>
                <span>Ver Reportes</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Productos Críticos y Actividad Reciente -->
  <div class="row">
    <!-- Productos Críticos -->
    <div class="col-lg-6 mb-4">
      <div class="card">
        <div class="card-header">
          <h6 class="m-0 font-weight-bold text-danger">
            <i class="mdi mdi-alert-circle me-2"></i>Productos Críticos
          </h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-sm">
              <thead>
                <tr>
                  <th>Producto</th>
                  <th>Stock</th>
                  <th>Estado</th>
                  <th>Acción</th>
                </tr>
              </thead>
              <tbody>
                <tr class="table-danger">
                  <td>Lechuga Mantecosa</td>
                  <td>0 unidades</td>
                  <td><span class="badge bg-danger">Sin Stock</span></td>
                  <td>
                    <button class="btn btn-sm btn-outline-primary">
                      <i class="mdi mdi-plus"></i>
                    </button>
                  </td>
                </tr>
                <tr class="table-danger">
                  <td>Apio</td>
                  <td>0 kg</td>
                  <td><span class="badge bg-danger">Sin Stock</span></td>
                  <td>
                    <button class="btn btn-sm btn-outline-primary">
                      <i class="mdi mdi-plus"></i>
                    </button>
                  </td>
                </tr>
                <tr class="table-warning">
                  <td>Tomate</td>
                  <td>3 kg</td>
                  <td><span class="badge bg-warning text-dark">Stock Bajo</span></td>
                  <td>
                    <button class="btn btn-sm btn-outline-primary">
                      <i class="mdi mdi-plus"></i>
                    </button>
                  </td>
                </tr>
                <tr class="table-warning">
                  <td>Pimiento Rojo</td>
                  <td>5 kg</td>
                  <td><span class="badge bg-warning text-dark">Stock Bajo</span></td>
                  <td>
                    <button class="btn btn-sm btn-outline-primary">
                      <i class="mdi mdi-plus"></i>
                    </button>
                  </td>
                </tr>
                <tr class="table-warning">
                  <td>Cebolla</td>
                  <td>2 kg</td>
                  <td><span class="badge bg-warning text-dark">Stock Bajo</span></td>
                  <td>
                    <button class="btn btn-sm btn-outline-primary">
                      <i class="mdi mdi-plus"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Actividad Reciente -->
    <div class="col-lg-6 mb-4">
      <div class="card">
        <div class="card-header">
          <h6 class="m-0 font-weight-bold text-primary">
            <i class="mdi mdi-history me-2"></i>Actividad Reciente
          </h6>
        </div>
        <div class="card-body">
          <div class="timeline">
            <div class="timeline-item mb-3">
              <div class="d-flex">
                <div class="flex-shrink-0">
                  <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="mdi mdi-plus text-white"></i>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <div class="small text-muted">Hace 2 horas</div>
                  <div>Se agregaron 25 kg de Zanahoria Orgánica</div>
                  <div class="small text-muted">Por: Juan Pérez</div>
                </div>
              </div>
            </div>

            <div class="timeline-item mb-3">
              <div class="d-flex">
                <div class="flex-shrink-0">
                  <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="mdi mdi-truck text-white"></i>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <div class="small text-muted">Hace 4 horas</div>
                  <div>Pedido generado para Proveedor Local A</div>
                  <div class="small text-muted">5 productos solicitados</div>
                </div>
              </div>
            </div>

            <div class="timeline-item mb-3">
              <div class="d-flex">
                <div class="flex-shrink-0">
                  <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="mdi mdi-alert text-white"></i>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <div class="small text-muted">Ayer</div>
                  <div>Alerta: Lechuga Mantecosa sin stock</div>
                  <div class="small text-muted">Requiere atención inmediata</div>
                </div>
              </div>
            </div>

            <div class="timeline-item mb-3">
              <div class="d-flex">
                <div class="flex-shrink-0">
                  <div class="bg-info rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="mdi mdi-file-document text-white"></i>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <div class="small text-muted">Ayer</div>
                  <div>Factura procesada automáticamente</div>
                  <div class="small text-muted">8 productos actualizados</div>
                </div>
              </div>
            </div>

            <div class="timeline-item">
              <div class="d-flex">
                <div class="flex-shrink-0">
                  <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="mdi mdi-minus text-white"></i>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <div class="small text-muted">Hace 2 días</div>
                  <div>Ajuste de stock: Papa Andina</div>
                  <div class="small text-muted">Reducción por venta mayorista</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Próximos Vencimientos -->
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h6 class="m-0 font-weight-bold text-warning">
            <i class="mdi mdi-calendar-clock me-2"></i>Próximos Vencimientos (Próxima Funcionalidad)
          </h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-sm">
              <thead>
                <tr>
                  <th>Producto</th>
                  <th>Lote</th>
                  <th>Fecha de Vencimiento</th>
                  <th>Cantidad</th>
                  <th>Días Restantes</th>
                  <th>Estado</th>
                </tr>
              </thead>
              <tbody>
                <tr class="table-warning">
                  <td>Lechuga Hidropónica</td>
                  <td>LH-2025-001</td>
                  <td>18/01/2025</td>
                  <td>15 unidades</td>
                  <td>3 días</td>
                  <td><span class="badge bg-warning text-dark">Próximo a vencer</span></td>
                </tr>
                <tr>
                  <td>Tomate Cherry</td>
                  <td>TC-2025-003</td>
                  <td>22/01/2025</td>
                  <td>8 kg</td>
                  <td>7 días</td>
                  <td><span class="badge bg-success">Normal</span></td>
                </tr>
                <tr>
                  <td>Espinaca</td>
                  <td>ESP-2025-002</td>
                  <td>25/01/2025</td>
                  <td>12 paquetes</td>
                  <td>10 días</td>
                  <td><span class="badge bg-success">Normal</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.border-left-primary {
  border-left: 0.25rem solid #4e73df !important;
}

.border-left-warning {
  border-left: 0.25rem solid #f6c23e !important;
}

.border-left-danger {
  border-left: 0.25rem solid #e74a3b !important;
}

.border-left-success {
  border-left: 0.25rem solid #1cc88a !important;
}

.timeline-item {
  position: relative;
}

.timeline-item:not(:last-child)::after {
  content: '';
  position: absolute;
  left: 15px;
  top: 40px;
  bottom: -20px;
  width: 2px;
  background-color: #e3e6f0;
}

.text-xs {
  font-size: 0.7rem;
}

.shadow {
  box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}
</style>