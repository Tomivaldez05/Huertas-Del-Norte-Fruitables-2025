<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Recuperar contraseña</title>
  <link rel="stylesheet" href="estilos.css" />
  <style>
    body.img.js-fullheight {
      height: 100vh; /* Para que js-fullheight tenga efecto */
    }
    .form-box {
      width: 500px;
      min-height: 350px;
      margin: 80px auto;
      background: rgba(255, 255, 255, 0.95);
      padding: 35px 40px;
      border-radius: 12px;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.4);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center; /* Centra horizontalmente todo el contenido */
      text-align: center;  /* Centra los textos dentro */
    }

    .form-box label {
      font-size: 18px;      /* Texto de etiqueta más grande */
      font-weight: 600;
      margin-bottom: 10px;
      display: block;
    }

    input[type="email"],
    input[type="submit"] {
      width: 100%;
      padding: 15px;
      margin-top: 15px;
      margin-bottom: 20px;
      font-size: 18px;     /* Texto más grande */
      border: 1px solid #bbb;
      border-radius: 6px;
      text-align: center;  /* Centra el texto dentro del input */
    }

    input[type="submit"] {
      background-color: #4CAF50;
      color: white;
      cursor: pointer;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
      background-color: #45a049;
    }

  </style>
</head>
<body class="img js-fullheight" style="background-image: url('assets/img/fondo-login.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
  <div class="form-box">
    <h2>Recuperar contraseña</h2>
    <form method="POST" action="enviar_codigo.php">
      <label>Correo electrónico:</label>
      <input type="email" name="email" required />
      <input type="submit" value="Enviar código" />
    </form>
    <p><a href="login.php">Volver al login</a></p>
  </div>
</body>
</html>
