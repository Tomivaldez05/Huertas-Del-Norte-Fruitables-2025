<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>Registro | Huertas del Norte</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/css/style.css">
</head>
<body class="img js-fullheight" style="background-image: url(assets/img/fondo-login.png);">
  <section class="ftco-section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 text-center mb-5">
          <h2 class="heading-section">Crear una cuenta</h2>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
          <div class="login-wrap p-0">

            <!-- Mensajes de feedback -->
            <?php if (isset($_SESSION['error_registro'])): ?>
              <div class="alert alert-danger text-center">
                <?= $_SESSION['error_registro']; unset($_SESSION['error_registro']); ?>
              </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['mensaje_registro'])): ?>
              <div class="alert alert-success text-center">
                <?= $_SESSION['mensaje_registro']; unset($_SESSION['mensaje_registro']); ?>
              </div>
            <?php endif; ?>

            <form action="controladores/procesar_registro.php" method="POST" class="signin-form">
              <div class="form-group">
                <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
              </div>
              <div class="form-group">
                <input type="text" name="apellido" class="form-control" placeholder="Apellido" required>
              </div>
              <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
              </div>

              <div class="form-group">
              <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" required>
            </div>

            <!-- Validación en vivo -->
            <div id="password-requisitos" class="text-white small mb-3">
              <p id="largo" class="mb-1"><i class="fa fa-times-circle text-danger"></i> Mínimo 8 caracteres</p>
              <p id="mayuscula" class="mb-1"><i class="fa fa-times-circle text-danger"></i> Al menos una mayúscula</p>
              <p id="minuscula" class="mb-1"><i class="fa fa-times-circle text-danger"></i> Al menos una minúscula</p>
              <p id="numero" class="mb-1"><i class="fa fa-times-circle text-danger"></i> Al menos un número</p>
              <p id="especial" class="mb-1"><i class="fa fa-times-circle text-danger"></i> Al menos un caracter especial (!@#$%^&*)</p>
            </div>

              <div class="form-group">
                <button type="submit" class="form-control btn btn-primary submit px-3">Registrarse</button>
              </div>
            </form>

            <p class="w-100 text-center">&mdash; ¿Ya tienes una cuenta? &mdash;</p>
            <div class="form-group">
              <a href="login.php" class="form-control btn btn-secondary submit px-3">Iniciar sesión</a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/popper.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/main.js"></script>

<script>
const passwordInput = document.getElementById('password');

passwordInput.addEventListener('input', function() {
const value = passwordInput.value;

// Requisitos
document.getElementById('largo').innerHTML = value.length >= 8
  ? '<i class="fa fa-check-circle text-success"></i> Mínimo 8 caracteres'
  : '<i class="fa fa-times-circle text-danger"></i> Mínimo 8 caracteres';

document.getElementById('mayuscula').innerHTML = /[A-Z]/.test(value)
  ? '<i class="fa fa-check-circle text-success"></i> Al menos una mayúscula'
  : '<i class="fa fa-times-circle text-danger"></i> Al menos una mayúscula';

document.getElementById('minuscula').innerHTML = /[a-z]/.test(value)
  ? '<i class="fa fa-check-circle text-success"></i> Al menos una minúscula'
  : '<i class="fa fa-times-circle text-danger"></i> Al menos una minúscula';

document.getElementById('numero').innerHTML = /[0-9]/.test(value)
  ? '<i class="fa fa-check-circle text-success"></i> Al menos un número'
  : '<i class="fa fa-times-circle text-danger"></i> Al menos un número';

document.getElementById('especial').innerHTML = /[!@#$%^&*]/.test(value)
  ? '<i class="fa fa-check-circle text-success"></i> Al menos un caracter especial (!@#$%^&*)'
  : '<i class="fa fa-times-circle text-danger"></i> Al menos un caracter especial (!@#$%^&*)';
});
</script>

</body>
</html>
