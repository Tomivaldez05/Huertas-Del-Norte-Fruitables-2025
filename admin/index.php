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
          <h3 class="text-center">Bienvenido al Panel</h3>
        </div>
        <?php include '../includes/footerAdmin.php'; ?>
      </div>
    </div>
  </div>

  <!-- Scripts base -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Script principal como módulo -->
<script type="module">
  const contenedor = document.getElementById('contenedor-modulo');

  document.querySelectorAll('[data-modulo]').forEach(link => {
    link.addEventListener('click', async e => {
      e.preventDefault();
      const modulo = e.currentTarget.getAttribute('data-modulo');

      contenedor.innerHTML = `<h4 class='text-center'>Cargando: <strong>${modulo}</strong></h4>`;
      // Destruir DataTable anterior
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
        } else {
          console.warn(`⚠️ La función ${funcionInit} no está definida en js/${modulo}.js`);
        }

      } catch (err) {
        contenedor.innerHTML = `<div class='alert alert-danger text-center'>⚠️ Error al cargar el módulo <strong>${modulo}</strong></div>`;
        console.error(err);
      }
    });
  });
</script>
</body>
</html>
