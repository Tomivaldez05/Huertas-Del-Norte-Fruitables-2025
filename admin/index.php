<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../assets/vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="../assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="../assets/css/styles/style.css">
</head>
<body>
  <div class="container-scroller">
    <?php include '../includes/nav.php'; ?>
    <div class="container-fluid page-body-wrapper">
      <?php include '../includes/sidebar.php'; ?>
      <div class="main-panel">
        <div class="content-wrapper" id="contenedor-modulo">
          <!-- El dashboard se cargará aquí automáticamente -->
          <h4 class='text-center'>Cargando Dashboard...</h4>
        </div>
        <?php include '../includes/footerAdmin.php'; ?>
      </div>
    </div>
  </div>

  <!-- Scripts base -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Script principal como módulo -->
<script type="module">
  const contenedor = document.getElementById('contenedor-modulo');

  // Función para cargar un módulo
  async function cargarModulo(modulo) {
    contenedor.innerHTML = `<h4 class='text-center'>Cargando: <strong>${modulo}</strong></h4>`;
    
    // Destruir DataTable anterior si existe
    if (window.tablaProductos) {
      if ($.fn.DataTable.isDataTable('#tablaProductos')) {
        $('#tablaProductos').DataTable().destroy();
      }
      window.tablaProductos = null;
    }

    try {
      const res = await fetch(`modulos/${modulo}.php`);
      const html = await res.text();
      contenedor.innerHTML = html;

      const moduloScript = await import(`./js/${modulo}.js?t=${Date.now()}`);

      // Capitaliza la primera letra del nombre del módulo para construir el nombre de la función
      const funcionInit = `inicializar${modulo.charAt(0).toUpperCase() + modulo.slice(1)}`;
      if (typeof moduloScript[funcionInit] === 'function') {
        moduloScript[funcionInit]();
        console.log(`✅ Módulo ${modulo} cargado e inicializado correctamente`);
      } else {
        console.warn(`⚠️ La función ${funcionInit} no está definida en js/${modulo}.js`);
      }

    } catch (err) {
      contenedor.innerHTML = `<div class='alert alert-danger text-center'>⚠️ Error al cargar el módulo <strong>${modulo}</strong></div>`;
      console.error('Error al cargar módulo:', err);
    }
  }

  // Cargar dashboard automáticamente al iniciar
  document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Cargando dashboard por defecto...');
    cargarModulo('dashboard');
    
    // Marcar el enlace del dashboard como activo si existe en el sidebar
    const dashboardLink = document.querySelector('[data-modulo="dashboard"]');
    if (dashboardLink) {
      // Remover clase activa de otros enlaces
      document.querySelectorAll('[data-modulo]').forEach(link => {
        link.classList.remove('active');
        link.parentElement.classList.remove('active');
      });
      
      // Agregar clase activa al dashboard
      dashboardLink.classList.add('active');
      dashboardLink.parentElement.classList.add('active');
    }
  });

  // Event listeners para los enlaces del sidebar
  document.querySelectorAll('[data-modulo]').forEach(link => {
    link.addEventListener('click', async e => {
      e.preventDefault();
      const modulo = e.currentTarget.getAttribute('data-modulo');

      // Actualizar clases activas
      document.querySelectorAll('[data-modulo]').forEach(l => {
        l.classList.remove('active');
        l.parentElement.classList.remove('active');
      });
      
      e.currentTarget.classList.add('active');
      e.currentTarget.parentElement.classList.add('active');

      // Cargar el módulo
      await cargarModulo(modulo);
    });
  });

  // Función global para recargar el módulo actual (útil para refrescar)
  window.recargarModuloActual = function() {
    const enlaceActivo = document.querySelector('[data-modulo].active');
    if (enlaceActivo) {
      const modulo = enlaceActivo.getAttribute('data-modulo');
      cargarModulo(modulo);
    } else {
      // Si no hay enlace activo, recargar dashboard
      cargarModulo('dashboard');
    }
  };
</script>

<style>
/* Estilos para elementos activos en el sidebar */
.nav-item.active > .nav-link,
.nav-link.active {
  background-color: rgba(255, 255, 255, 0.1) !important;
  color: #fff !important;
  border-radius: 4px;
}

.nav-item.active > .nav-link:before,
.nav-link.active:before {
  content: '';
  position: absolute;
  left: 0;
  top: 0;
  bottom: 0;
  width: 3px;
  background-color: #fff;
  border-radius: 0 3px 3px 0;
}

/* Animación suave para el contenido */
#contenedor-modulo {
  transition: opacity 0.3s ease-in-out;
}

.fade-in {
  animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>
</body>
</html>