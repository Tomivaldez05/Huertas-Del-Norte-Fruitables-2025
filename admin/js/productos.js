// js/productos.js con rutas corregidas para admin
// Inicialización directa
export function inicializarProductos() {
  cargarProductos();
  cargarCategorias();

  const form = document.getElementById("formProducto");
  if (form) {
    form.addEventListener("submit", guardarProducto);
  }

  const btnModal = document.getElementById("btnAbrirModal");
  if (btnModal) {
    btnModal.addEventListener("click", () => {
      document.getElementById("formProducto").reset();
      document.getElementById("id_producto").value = "";
      document.getElementById("cantidad_minima_mayorista").value = "1";
      const modal = new bootstrap.Modal(document.getElementById("modalProducto"));
      modal.show();
    });
  }

  // Delegación usando jQuery sigue funcionando
  $(document).on("click", ".btn-editar", function () {
    const id = this.getAttribute("data-id");
    editarProducto(id);
  });

  $(document).on("click", ".btn-eliminar", function () {
    const id = this.getAttribute("data-id");
    eliminarProducto(id);
  });
}
var tablaProductos = window.tablaProductos || null;

function cargarProductos() {
  fetch("acciones/controladorProducto.php?accion=listar")
    .then(res => res.json())
    .then(data => {
      // ⚠️ Destruir tabla si ya existe
      if ($.fn.DataTable.isDataTable("#tablaProductos")) {
        $('#tablaProductos').DataTable().destroy();
      }

      // Inicializar tabla con nuevos datos
      tablaProductos = $("#tablaProductos").DataTable({
        data,
        columns: [
          { data: "nombre_producto" },
          { data: "nombre_categoria" },
          {
            data: "precio_minorista",
            render: data => `$${parseFloat(data).toFixed(2)}`
          },
          { data: "unidad_medida" },
          {
            data: "id_producto",
            render: id => `
              <button class="btn btn-sm btn-warning btn-editar" data-id="${id}">Editar</button>
              <button class="btn btn-sm btn-danger btn-eliminar" data-id="${id}">Eliminar</button>
            `
          }
        ]
      });
    })
    .catch(error => {
      console.error('Error al cargar productos:', error);
      alert('Error al cargar productos');
    });
}

function cargarCategorias() {
  fetch("acciones/controladorProducto.php?accion=categorias")
    .then(res => res.json())
    .then(data => {
      const select = document.getElementById("categoria");
      select.innerHTML = "<option value=''>Seleccione</option>";
      data.forEach(cat => {
        const option = document.createElement("option");
        option.value = cat.id_categoria;
        option.textContent = cat.nombre_categoria;
        select.appendChild(option);
      });
    })
    .catch(error => {
      console.error('Error al cargar categorías:', error);
    });
}

function guardarProducto(e) {
  e.preventDefault();
  const form = document.getElementById("formProducto");
  const datos = new FormData(form);
  datos.set("activo", document.getElementById("activo").checked ? 1 : 0);
  
  fetch("acciones/controladorProducto.php?accion=guardar", {
    method: "POST",
    body: datos
  })
    .then(res => res.json())
    .then(data => {
      if (data.ok) {
        document.getElementById("formProducto").reset();
        const modal = bootstrap.Modal.getInstance(document.getElementById("modalProducto"));
        modal.hide();
        cargarProductos();
        alert('Producto guardado correctamente');
      } else {
        alert("Error al guardar producto: " + (data.mensaje || 'Error desconocido'));
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert("Error al guardar producto");
    });
}

function editarProducto(id) {
  fetch(`acciones/controladorProducto.php?accion=obtener&id=${id}`)
    .then(res => res.json())
    .then(p => {
      document.getElementById("id_producto").value = p.id_producto;
      document.getElementById("nombre").value = p.nombre_producto;
      document.getElementById("categoria").value = p.id_categoria;
      document.getElementById("descripcion").value = p.descripcion || "";
      document.getElementById("precio_minorista").value = p.precio_minorista;
      document.getElementById("precio_mayorista").value = p.precio_mayorista;
      document.getElementById("cantidad_minima_mayorista").value = p.cantidad_minima_mayorista || 1;
      document.getElementById("activo").checked = p.activo == 1;
      document.getElementById("unidad").value = p.unidad_medida;
      const modal = new bootstrap.Modal(document.getElementById("modalProducto"));
      modal.show();
    })
    .catch(error => {
      console.error('Error al cargar producto:', error);
      alert('Error al cargar producto');
    });
}

function eliminarProducto(id) {
  if (confirm("¿Seguro que deseas eliminar este producto?")) {
    fetch(`acciones/controladorProducto.php?accion=eliminar&id=${id}`)
      .then(res => res.json())
      .then(data => {
        if (data.ok) {
          cargarProductos();
          alert('Producto eliminado correctamente');
        } else {
          alert("No se pudo eliminar el producto.");
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert("Error al eliminar producto");
      });
  }
}


