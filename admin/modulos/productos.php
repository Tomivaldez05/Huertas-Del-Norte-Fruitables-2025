<div class="card">
  <div class="card-header">Listado de Productos</div>
  <div class="card-body">
    <button class="btn btn-primary mb-3" id="btnAbrirModal" data-bs-toggle="modal" data-bs-target="#modalProducto">+ Agregar</button>

    <table class="table" id="tablaProductos">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Categoría</th>
          <th>Precio</th>
          <th>Unidad</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalProducto" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formProducto" class="modal-content" enctype="multipart/form-data">
      <input type="hidden" id="id_producto" name="id_producto">
      <div class="modal-header">
        <h5 class="modal-title">Producto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <label>Nombre</label>
          <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>
        <div class="mb-2">
          <label>Descripción</label>
          <textarea name="descripcion" id="descripcion" class="form-control" rows="2"></textarea>
        </div>
        <div class="mb-2">
          <label>Categoría</label>
          <select name="categoria" id="categoria" class="form-control" required></select>
        </div>
        <div class="mb-2">
          <label>Unidad de medida</label>
          <input name="unidad" id="unidad" class="form-control" required>
        </div>
        <div class="mb-2">
          <label>Cantidad Mínima Mayorista</label>
          <input type="number" name="precio_minorista" id="cantidad_minima_mayorista" class="form-control" required>
        </div>
        <div class="mb-2">
          <label>Precio Minorista</label>
          <input type="number" name="precio_minorista" id="precio_minorista" class="form-control" required>
        </div>
        <div class="mb-2">
          <label>Precio Mayorista</label>
          <input type="number" name="precio_mayorista" id="precio_mayorista" class="form-control" required>
        </div>
        <div class="mb-2">
          <label>Imagen</label>
          <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*" required>
        </div>
        <div class="mb-2">
          <div class="form-check form-switch">
            <label  for="activo">Activo</label>
            <div><input type="checkbox" id="activo"  name="activo" checked></div>
            
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Guardar</button>
      </div>
    </form>
  </div>
</div>
