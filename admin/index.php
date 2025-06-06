<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Admin</title>
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

  <script src="assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="assets/js/off-canvas.js"></script>
  <script src="assets/js/hoverable-collapse.js"></script>
  <script src="assets/js/misc.js"></script>
  <script>
    document.querySelectorAll('[data-modulo]').forEach(link => {
      link.addEventListener('click', e => {
        e.preventDefault();
        const modulo = e.currentTarget.getAttribute('data-modulo');
        document.getElementById('contenedor-modulo').innerHTML = `<h4 class='text-center'>Cargando: <strong>${modulo}</strong></h4>`;
        // Aquí podrías usar fetch(`modulos/${modulo}.php`) para cargar dinámicamente
      });
    });
  </script>
</body>

</html>
