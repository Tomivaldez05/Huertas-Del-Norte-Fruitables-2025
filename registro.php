<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>Registro | Huertas del Norte</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
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
      min-height: 100vh;
      background-image: url('assets/img/fondo-login.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }

    h2 {
      font-size: 32px !important;
      font-weight: bold;
      margin-bottom: 25px;
      color: #111;
    }

    h3 {
      font-size: 28px !important;
      font-weight: bold;
      margin-bottom: 25px;
      color: #111;
    }

    .login-container {
      width: 500px;
      min-height: 450px;
      margin: 30px auto;
      background: rgba(255, 255, 255, 0.98) !important;
      padding: 25px 30px;
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
      margin-bottom: 15px;
      z-index: 30 !important;
    }

    .input-custom {
      width: 100% !important;
      padding: 15px 12px !important;
      font-size: 16px !important;
      font-weight: bold !important;
      border: 2px solid #888 !important;
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
      color: #000 !important;
      font-size: 16px !important;
      font-weight: bold !important;
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

    /* ESTILOS PARA BOTONES */
    .btn-custom {
      width: 100% !important;
      padding: 15px !important;
      font-size: 16px !important;
      font-weight: bold !important;
      border: none !important;
      border-radius: 8px !important;
      cursor: pointer !important;
      transition: all 0.3s ease !important;
      text-decoration: none !important;
      display: block !important;
      text-align: center !important;
      margin: 8px 0 !important;
      position: relative !important;
      z-index: 100 !important;
      opacity: 1 !important;
      visibility: visible !important;
      appearance: none !important;
      -webkit-appearance: none !important;
      -moz-appearance: none !important;
    }

    .btn-primary-custom {
      background: #4CAF50 !important;
      color: #ffffff !important;
      border: 2px solid #4CAF50 !important;
      font-size: 16px !important;
      font-weight: bold !important;
      text-transform: uppercase !important;
      letter-spacing: 1px !important;
      line-height: 1.2 !important;
      height: 48px !important;
      min-height: 48px !important;
      box-shadow: none !important;
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
      padding: 12px;
      margin-bottom: 15px;
      border-radius: 6px;
      text-align: center;
      position: relative;
      z-index: 25;
    }

    .alert-danger {
      border: 1px solid #f5c6cb;
      background-color: #f8d7da;
      color: #721c24;
    }

    .alert-success {
      border: 1px solid #c3e6cb;
      background-color: #d4edda;
      color: #155724;
    }

    .text-custom {
      margin: 12px 0;
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

    /* Estilos para validación de contraseña */
    .password-requisitos {
      text-align: left;
      margin: 12px 0;
      padding: 12px;
      background: rgba(248, 249, 250, 0.9);
      border-radius: 8px;
      border: 1px solid #e9ecef;
    }

    .password-requisitos p {
      margin: 4px 0;
      font-size: 14px;
      color: #333;
    }

    .text-success {
      color: #28a745 !important;
    }

    .text-danger {
      color: #dc3545 !important;
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

    /* Estilos para mensaje de éxito dinámico */
    .mensaje-exito {
      position: fixed;
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
      background: #d4edda;
      border: 1px solid #c3e6cb;
      color: #155724;
      padding: 15px 20px;
      border-radius: 8px;
      font-size: 16px;
      font-weight: bold;
      z-index: 9999;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      opacity: 0;
      transform: translateX(-50%) translateY(-100%);
      transition: all 0.3s ease;
    }

    .mensaje-exito.mostrar {
      opacity: 1;
      transform: translateX(-50%) translateY(0);
    }

    .mensaje-exito .cerrar {
      margin-left: 10px;
      cursor: pointer;
      font-weight: bold;
      color: #155724;
    }
  </style>
</head>

<body>
  <div class="login-container">
    <h2>Crear Cuenta</h2>

    <!-- Mensajes de feedback -->
    <?php if (isset($_SESSION['error_registro'])): ?>
      <div class="alert-custom alert-danger">
        <?= $_SESSION['error_registro']; unset($_SESSION['error_registro']); ?>
      </div>
    <?php endif; ?>

    <?php 
    // Limpiar mensaje de éxito sin mostrarlo ya que usamos JavaScript
    if (isset($_SESSION['mensaje_registro'])) {
      unset($_SESSION['mensaje_registro']);
    }
    ?>

    <form id="registroForm" action="controladores/procesar_registro.php" method="POST" class="signin-form">
      <div class="form-group-custom">
        <input type="text" name="nombre" id="nombre" class="input-custom" placeholder="Nombre" required>
      </div>
      
      <div class="form-group-custom">
        <input type="text" name="apellido" id="apellido" class="input-custom" placeholder="Apellido" required>
      </div>
      
      <div class="form-group-custom">
        <input type="email" name="email" id="email" class="input-custom" placeholder="Correo electrónico" required>
      </div>

      <div class="form-group-custom">
        <input 
          type="password" 
          id="password" 
          name="password" 
          class="input-custom password-input" 
          placeholder="Contraseña" 
          required
        >
        <i class="fas fa-eye eye-icon" id="togglePassword"></i>
      </div>

      <!-- Validación en vivo -->
      <div class="password-requisitos">
        <p id="largo"><i class="fa fa-times-circle text-danger"></i> Mínimo 8 caracteres</p>
        <p id="mayuscula"><i class="fa fa-times-circle text-danger"></i> Al menos una mayúscula</p>
        <p id="minuscula"><i class="fa fa-times-circle text-danger"></i> Al menos una minúscula</p>
        <p id="numero"><i class="fa fa-times-circle text-danger"></i> Al menos un número</p>
        <p id="especial"><i class="fa fa-times-circle text-danger"></i> Al menos un caracter especial (!@#$%^&*)</p>
      </div>

      <div class="form-group-custom">
        <button type="submit" class="btn-custom btn-primary-custom">REGISTRARSE</button>
      </div>
    </form>

    <p class="text-custom">&mdash; ¿Ya tienes una cuenta? &mdash;</p>
    
    <div class="form-group-custom">
      <a href="login.php" class="btn-custom btn-secondary-custom">INICIAR SESIÓN</a>
    </div>
  </div>

  <script>
    // Script para validación de contraseña en tiempo real
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

    // Script para mostrar/ocultar contraseña
    const togglePassword = document.getElementById("togglePassword");
    const password = document.getElementById("password");

    togglePassword.addEventListener("click", function () {
      const type = password.type === "password" ? "text" : "password";
      password.type = type;
      this.classList.toggle("fa-eye");
      this.classList.toggle("fa-eye-slash");
    });

    // Interceptar el envío del formulario para mostrar mensaje de éxito
    document.getElementById('registroForm').addEventListener('submit', function(e) {
      // Verificar que todos los campos requeridos estén llenos
      const nombre = document.getElementById('nombre').value;
      const apellido = document.getElementById('apellido').value;
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;
      
      // Verificar que la contraseña cumpla todos los requisitos
      const cumpleRequisitos = password.length >= 8 && 
                              /[A-Z]/.test(password) && 
                              /[a-z]/.test(password) && 
                              /[0-9]/.test(password) && 
                              /[!@#$%^&*]/.test(password);
      
      if (nombre && apellido && email && password && cumpleRequisitos) {
        // Prevenir el envío normal del formulario
        e.preventDefault();
        
        // Mostrar mensaje de éxito
        mostrarMensajeExito(nombre, apellido);
        
        // Enviar el formulario después de mostrar el mensaje
        setTimeout(() => {
          this.submit();
        }, 2000); // Esperar 2 segundos antes de enviar
      }
    });

    // Función para mostrar mensaje de éxito dinámico
    function mostrarMensajeExito(nombre, apellido) {
      // Crear el mensaje dinámico
      const mensaje = document.createElement('div');
      mensaje.className = 'mensaje-exito';
      mensaje.innerHTML = `
        <i class="fa fa-check-circle"></i> 
        ¡Bienvenido/a ${nombre}! Podes iniciar sesión
        <span class="cerrar" onclick="cerrarMensaje(this)">&times;</span>
      `;
      
      // Agregar al body
      document.body.appendChild(mensaje);
      
      // Mostrar con animación
      setTimeout(() => {
        mensaje.classList.add('mostrar');
      }, 100);
      
      // Auto-cerrar después de 5 segundos
      setTimeout(() => {
        if (mensaje.parentNode) {
          mensaje.classList.remove('mostrar');
          setTimeout(() => {
            if (mensaje.parentNode) {
              mensaje.parentNode.removeChild(mensaje);
            }
          }, 300);
        }
      }, 5000);
    }

    // Función para cerrar mensaje manualmente
    function cerrarMensaje(elemento) {
      const mensaje = elemento.parentNode;
      mensaje.classList.remove('mostrar');
      setTimeout(() => {
        if (mensaje.parentNode) {
          mensaje.parentNode.removeChild(mensaje);
        }
      }, 300);
    }

    // Asegurar visibilidad inmediata de todos los elementos
    document.addEventListener('DOMContentLoaded', function() {
      // Forzar visibilidad de todos los botones
      const buttons = document.querySelectorAll('.btn-custom');
      buttons.forEach(function(button) {
        button.style.display = 'block';
        button.style.visibility = 'visible';
        button.style.opacity = '1';
        button.style.zIndex = '100';
        
        // Para botones primarios (REGISTRARSE)
        if (button.classList.contains('btn-primary-custom')) {
          button.style.backgroundColor = '#4CAF50';
          button.style.color = '#ffffff';
          button.style.border = '2px solid #4CAF50';
        }
        
        // Para botones secundarios (INICIAR SESIÓN)
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
      });
    });
  </script>
</body>
</html>