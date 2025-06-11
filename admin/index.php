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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  document.querySelectorAll('[data-modulo]').forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();
      const modulo = e.currentTarget.getAttribute('data-modulo');
      const contenedor = document.getElementById('contenedor-modulo');

      contenedor.innerHTML = `<h4 class='text-center'>Cargando: <strong>${modulo}</strong></h4>`;

      fetch(`modulos/${modulo}.php`)
        .then(res => {
          if (!res.ok) throw new Error("No se pudo cargar el módulo");
          return res.text();
        })
        .then(html => {
          contenedor.innerHTML = html;

          // Si querés cargar un script asociado al módulo (opcional):
          const script = document.createElement("script");
          script.src = `js/${modulo}.js`;
          document.body.appendChild(script);

        })
        .catch(err => {
          contenedor.innerHTML = `<div class='alert alert-danger text-center'>⚠️ Error al cargar el módulo <strong>${modulo}</strong></div>`;
          console.error(err);
        });
    });
  });
</script>

</body>

</html>
