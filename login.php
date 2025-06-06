<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
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
				  <?php
					if (isset($_SESSION['error_login'])) {
    					echo "<div class='alert alert-danger'>" . $_SESSION['error_login'] . "</div>";
    					unset($_SESSION['error_login']);
					}
					?>

		      	<form action="controladores/auntenticacion.php" method="POST" class="signin-form">
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
	            <div class="form-group d-md-flex">
	            	<div class="w-50">
		            	<label class="checkbox-wrap checkbox-primary">Recordarme
									  <input type="checkbox" checked>
									  <span class="checkmark"></span>
									</label>
								</div>
								<div class="w-50 text-md-right">
									<a href="#" style="color: #fff">Olvidé mi contraseña</a>
								</div>
	            </div>
	          </form>
	          <p class="w-100 text-center">&mdash; Iniciar Sesión con &mdash;</p>
	          <div class="social d-flex text-center">
	          	<a href="#" class="btn btn-light d-flex align-items-center justify-content-center mr-2">
					<img src="assets/img/google-icon-logo-symbol-free-png.png" alt="Google" style="height: 20px; margin-right: 8px;">Google</a>
	          	<a href="#" class="btn btn-light d-flex align-items-center justify-content-center ml-2">
					<img src="assets/img/Facebook_Logo_(2019).png" alt="Facebook" style="height: 20px; margin-right: 8px;">Facebook</a>
	          </div>
		      </div>
			  <p class="w-100 text-center">&mdash; ¿No tienes una cuenta? &mdash;</p>
				<div class="form-group">
  				<a href="registro.php" class="form-control btn btn-secondary submit px-3">Regístrate aquí</a>
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

