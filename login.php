<?php
session_start();
?>
<!doctype html>
<html lang="es">
  <head>
    <title>Inicio de sesión | Huertas del Norte</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <style>
      * {
        box-sizing: border-box;
      }
      
      body, input, label, p, button, h2, h3 {
        font-family: 'Abel', sans-serif !important;
        font-size: 20px;
      }

      body {
        margin: 0;
        padding: 0;
        height: 100vh;
        background-image: url('assets/img/fondo-login.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
      }

      h2 {
        font-size: 40px !important;
        font-weight: bold;
        margin-bottom: 20px;
        color: #111;
      }

      h3 {
        font-size: 28px !important;
        font-weight: bold;
        margin-bottom: 25px;
        color: #111;
      }

      .login-container {
        width: 550px;
        min-height: 450px;
        margin: 80px auto;
        background: rgba(255, 255, 255, 0.98) !important;
        padding: 35px 40px;
        border-radius: 12px;
        box-shadow: 0 0 25px rgba(0, 0, 0, 0.4);
        text-align: center;
        position: relative;
        z-index: 10 !important;
      }

      .signin-form {
        width: 100%;
        position: relative;
        z-index: 20 !important;
      }

      .form-group-custom {
        position: relative;
        width: 100%;
        margin-bottom: 20px;
        z-index: 30 !important;
      }

      .input-custom {
        width: 100% !important;
        padding: 18px 15px !important;
        font-size: 18px !important;
        border: 2px solid #666 !important; /* Cambiado de #ddd a #666 para gris más oscuro */
        border-radius: 8px !important;
        background: #fff !important;
        text-align: left !important;
        color: #333 !important;
        position: relative !important;
        z-index: 40 !important;
        outline: none !important;
        display: block !important;
        margin: 0 !important;
      }

      .input-custom::placeholder {
        color: #000 !important; /* Cambiado de #999 a #000 para negro */
        font-size: 16px !important;
        font-weight: bold !important; /* Agregado para negrita */
      }

      .input-custom:focus {
        border-color: #6c63ff !important;
        box-shadow: 0 0 8px rgba(108, 99, 255, 0.3) !important;
      }

      .password-input {
        padding-right: 50px !important;
      }

      .eye-icon {
        position: absolute !important;
        top: 50% !important;
        right: 15px !important;
        transform: translateY(-50%) !important;
        cursor: pointer !important;
        z-index: 50 !important;
        color: #888 !important;
        font-size: 18px !important;
        pointer-events: auto !important;
      }

      /* ESTILOS CORREGIDOS PARA EL BOTÓN */
      .btn-custom {
        width: 100% !important;
        padding: 18px !important;
        font-size: 18px !important;
        font-weight: bold !important;
        border: none !important;
        border-radius: 8px !important;
        cursor: pointer !important;
        transition: all 0.3s ease !important;
        text-decoration: none !important;
        display: block !important;
        text-align: center !important;
        margin: 10px 0 !important;
        position: relative !important;
        z-index: 100 !important; /* Z-index más alto */
        opacity: 1 !important;
        visibility: visible !important;
        appearance: none !important; /* Eliminar estilos predeterminados del navegador */
        -webkit-appearance: none !important;
        -moz-appearance: none !important;
      }

      .btn-primary-custom {
        background: #4CAF50 !important; /* Sin -color */
        color: #ffffff !important;
        border: 2px solid #4CAF50 !important;
        font-size: 18px !important;
        font-weight: bold !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
        line-height: 1.2 !important;
        height: 54px !important; /* Altura fija */
        min-height: 54px !important;
        box-shadow: none !important; /* Eliminar sombras que puedan interferir */
      }

      .btn-primary-custom:hover {
        background: #45a049 !important;
        border-color: #45a049 !important;
        color: #ffffff !important;
      }

      .btn-primary-custom:focus,
      .btn-primary-custom:active {
        background: #4CAF50 !important;
        border-color: #4CAF50 !important;
        color: #ffffff !important;
        outline: none !important;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.3) !important;
      }

      .btn-secondary-custom {
        background: #6c63ff !important;
        color: #ffffff !important;
        border: 2px solid #6c63ff !important;
      }

      .btn-secondary-custom:hover {
        background: #5848d1 !important;
        border-color: #5848d1 !important;
        color: #ffffff !important;
      }

      .alert-custom {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid #f5c6cb;
        border-radius: 6px;
        background-color: #f8d7da;
        color: #721c24;
        text-align: center;
        position: relative;
        z-index: 25;
      }

      .text-custom {
        margin: 15px 0;
        color: #666;
        position: relative;
        z-index: 25;
      }

      .link-custom {
        color: #6c63ff !important;
        text-decoration: none !important;
      }

      .link-custom:hover {
        color: #5848d1 !important;
        text-decoration: underline !important;
      }

      /* Asegurar que todos los elementos sean visibles */
      .login-container * {
        position: relative;
      }

      .login-container input,
      .login-container button,
      .login-container a {
        opacity: 1 !important;
        visibility: visible !important;
      }
    </style>
  </head>
  <body>
    
    <div class="login-container">
      <h2>Iniciar Sesión</h2>
      <h3>¿Tienes una cuenta?</h3>

      <!-- Mostrar errores -->
      <?php if (isset($_SESSION['error_login'])): ?>
        <div class="alert-custom">
          <?= $_SESSION['error_login']; unset($_SESSION['error_login']); ?>
        </div>
      <?php endif; ?>

      <form action="controladores/autenticacion_login.php" method="POST" class="signin-form">
        <div class="form-group-custom">
          <input type="email" name="email" class="input-custom" placeholder="Correo electrónico" required>
        </div>
        
        <div class="form-group-custom">
          <input id="password-field" name="password" type="password" class="input-custom password-input" placeholder="Contraseña" required>
          <span toggle="#password-field" class="fa fa-fw fa-eye eye-icon toggle-password"></span>
        </div>
        
        <div class="form-group-custom">
          <button type="submit" class="btn-custom btn-primary-custom">INICIAR SESIÓN</button>
        </div>
      </form>
      
      <p class="text-custom">
        <a href="recuperacion_contrasena.php" class="link-custom">¿Olvidaste tu contraseña?</a>
      </p>

      <p class="text-custom">&mdash; ¿No tienes una cuenta? &mdash;</p>
      
      <div class="form-group-custom">
        <a href="registro.php" class="btn-custom btn-secondary-custom">REGÍSTRATE AQUÍ</a>
      </div>
    </div>

    <script>
      // Script para mostrar/ocultar contraseña
      document.querySelectorAll('.toggle-password').forEach(function (eye) {
        eye.addEventListener('click', function () {
          const input = document.querySelector(this.getAttribute('toggle'));
          const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
          input.setAttribute('type', type);
          this.classList.toggle('fa-eye');
          this.classList.toggle('fa-eye-slash');
        });
      });

      // Asegurar visibilidad inmediata de todos los elementos
      document.addEventListener('DOMContentLoaded', function() {
        // Forzar visibilidad de todos los botones
        const buttons = document.querySelectorAll('.btn-custom');
        buttons.forEach(function(button) {
          button.style.display = 'block';
          button.style.visibility = 'visible';
          button.style.opacity = '1';
          button.style.zIndex = '100';
          
          // Para botones primarios (INICIAR SESIÓN)
          if (button.classList.contains('btn-primary-custom')) {
            button.style.backgroundColor = '#4CAF50';
            button.style.color = '#ffffff';
            button.style.border = '2px solid #4CAF50';
          }
          
          // Para botones secundarios (REGÍSTRATE)
          if (button.classList.contains('btn-secondary-custom')) {
            button.style.backgroundColor = '#6c63ff';
            button.style.color = '#ffffff';
            button.style.border = '2px solid #6c63ff';
          }
        });

        // Asegurar inputs visibles
        const inputs = document.querySelectorAll('.input-custom');
        inputs.forEach(function(input) {
          input.style.display = 'block';
          input.style.visibility = 'visible';
          input.style.opacity = '1';
          input.style.zIndex = '100';
          input.style.backgroundColor = '#ffffff';
          input.style.borderColor = '#666'; // Aplicar borde gris oscuro via JavaScript también
        });
        
        // Asegurar que los placeholders mantengan el estilo
        const placeholderStyle = document.createElement('style');
        placeholderStyle.textContent = `
          .input-custom::placeholder {
            color: #000 !important;
            font-weight: bold !important;
          }
        `;
        document.head.appendChild(placeholderStyle);
      });
    </script>
  </body>
</html>