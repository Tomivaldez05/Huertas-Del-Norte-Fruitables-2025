<?php
session_start();
?>
<!doctype html>
<html lang="es">
  <head>
    <title>Inicio de sesión | Huertas del Norte</title>
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
            <h2 class="heading-section">Login</h2>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-6 col-lg-4">
            <div class="login-background">
              <div class="login-wrap p-0">
                <h3 class="mb-4 text-center">¿Tienes una cuenta?</h3>

                <!-- Mostrar errores -->
                <?php if (isset($_SESSION['error_login'])): ?>
                  <div class="alert alert-danger text-center">
                    <?= $_SESSION['error_login']; unset($_SESSION['error_login']); ?>
                  </div>
                <?php endif; ?>

                <form action="controladores/autenticacion_login.php" method="POST" class="signin-form">
                  <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
                  </div>
                  <div class="form-group">
                    <input id="password-field" name="password" type="password" class="form-control" placeholder="Contraseña" required>
                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="form-control btn btn-primary submit px-3">Iniciar Sesión</button>
                  </div>
                </form>

                <p class="w-100 text-center">&mdash; ¿No tienes una cuenta? &mdash;</p>
                <div class="form-group">
                  <a href="registro.php" class="form-control btn btn-secondary submit px-3">Regístrate aquí</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/login/main.js"></script>
  </body>
</html>
