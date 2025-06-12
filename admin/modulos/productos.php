<div class="card">
  <div class="card-header">Listado de Productos</div>
  <div class="card-body">
    <button class="btn btn-primary mb-3" id="btnAbrirModal" data-bs-toggle="modal" data-bs-target="#modalProducto">+ Agregar Producto</button>
    <button class="btn btn-primary mb-3" id="btnCategorias" >+ Gestionar Cateogorías</button>
    <table class="table table-striped" id="tablaProductos">
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


<!-- Modal de Categorías -->
<div class="modal fade" id="modalCategorias" tabindex="-1" aria-labelledby="tituloCategorias" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="formCategoria">
        <div class="modal-header">
          <h5 class="modal-title" id="tituloCategorias">Categorías</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">

          <input type="hidden" id="id_categoria" name="id_categoria">

          <div class="mb-3">
            <label for="nombre_categoria" class="form-label">Nombre de categoría</label>
            <input type="text" class="form-control" id="nombre_categoria" name="nombre_categoria" required>
          </div>

          <table class="table table-striped" id="tablaCategorias">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalProducto" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="formProducto" class="modal-content" enctype="multipart/form-data">
      <input type="hidden" id="id_producto" name="id_producto">
      <div class="modal-header">
        <h5 class="modal-title">Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Nombre *</label>
              <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Categoría *</label>
              <select name="categoria" id="categoria" class="form-control" required>
                <option value="">Seleccione</option>
              </select>
            </div>
          </div>
        </div>
        
        <div class="mb-3">
          <label class="form-label">Descripción</label>
          <textarea name="descripcion" id="descripcion" class="form-control" rows="2"></textarea>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Unidad de medida *</label>
              <input name="unidad" id="unidad" class="form-control" required placeholder="ej: kg, unidad, litro">
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Cantidad Mínima Mayorista</label>
              <input type="number" name="cantidad_minima_mayorista" id="cantidad_minima_mayorista" class="form-control" value="1" min="1">
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Precio Minorista *</label>
              <input type="number" name="precio_minorista" id="precio_minorista" class="form-control" step="0.01" min="0" required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Precio Mayorista *</label>
              <input type="number" name="precio_mayorista" id="precio_mayorista" class="form-control" step="0.01" min="0" required>
            </div>
          </div>
        </div>
        
        <div class="mb-3">
          <label class="form-label">Imagen</label>
          <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
          <small class="text-muted">Opcional - Solo si quieres cambiar la imagen</small>
        </div>
        
        <div class="mb-3">
          <div class="form-check form-switch">
            <input type="checkbox" id="activo" name="activo" class="form-check-input" checked>
            <label class="form-check-label" for="activo">Producto Activo</label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success">Guardar</button>
      </div>
    </form>
  </div>
</div>