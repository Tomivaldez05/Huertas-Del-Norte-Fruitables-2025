<?php
session_start();
require 'conexion.php';
require 'correo.php';

$mensaje = '';
$paso = $_POST['paso'] ?? 'solicitar';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($paso === 'solicitar') {
        $email = $_POST['email'];
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $codigo = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6);
            $stmt = $conn->prepare("INSERT INTO recuperacion_contrasena (email, codigo) VALUES (?, ?)");
            $stmt->execute([$email, $codigo]);

            if (enviarCodigoPorCorreo($email, $codigo)) {
                $mensaje = "Código enviado correctamente a tu correo.";
                $paso = 'verificar';
            } else {
                $mensaje = "No se pudo enviar el correo.";
            }
        } else {
            $mensaje = "El correo no está registrado.";
        }

    } elseif ($paso === 'verificar') {
        $email = $_POST['email'];
        $codigo = $_POST['codigo'];
        $stmt = $conn->prepare("SELECT * FROM recuperacion_contrasena WHERE email = ? AND codigo = ? AND estado_uso_codigo = 0 ORDER BY fecha_solicitud_codigo DESC LIMIT 1");
        $stmt->execute([$email, $codigo]);

        if ($stmt->rowCount() > 0) {
            $mensaje = "Código verificado correctamente.";
            $paso = 'cambiar';
        } else {
            $mensaje = "Código inválido o ya utilizado.";
            $paso = 'verificar';
        }

    } elseif ($paso === 'cambiar') {
        $email = $_POST['email'];
        $codigo = $_POST['codigo'];
        $nueva = password_hash($_POST['nueva_contrasena'], PASSWORD_BCRYPT);

        $stmt = $conn->prepare("SELECT * FROM recuperacion_contrasena WHERE email = ? AND codigo = ? AND estado_uso_codigo = 0 ORDER BY fecha_solicitud_codigo DESC LIMIT 1");
        $stmt->execute([$email, $codigo]);

        if ($stmt->rowCount() > 0) {
            $conn->prepare("UPDATE usuarios SET password_hash = ? WHERE email = ?")->execute([$nueva, $email]);
            $conn->prepare("UPDATE recuperacion_contrasena SET estado_uso_codigo = 1 WHERE email = ? AND codigo = ?")->execute([$email, $codigo]);
            $mensaje = "Contraseña actualizada correctamente.";
            $paso = 'finalizado';
        } else {
            $mensaje = "Código inválido o expirado.";
            $paso = 'verificar';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Recuperar contraseña</title>
  <link rel="stylesheet" href="estilos.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    .text-success { color: green; }
    .text-danger { color: red; }
    .form-box {
      width: 500px;
      margin: 80px auto;
      background: rgba(255, 255, 255, 0.95);
      padding: 35px 40px;
      border-radius: 12px;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.4);
      text-align: center;
    }
    input[type="email"],
    input[type="text"],
    input[type="password"],
    input[type="submit"] {
      width: 100%;
      padding: 15px;
      margin: 10px 0;
      font-size: 18px;
      border-radius: 6px;
    }
    input[type="submit"] {
      background-color: #4CAF50;
      color: white;
      font-weight: bold;
      cursor: pointer;
    }
  </style>
</head>
<body style="background-image: url('assets/img/fondo-login.png'); background-size: cover;">
  <div class="form-box">
    <h2>Recuperar contraseña</h2>
    <p style="color:blue;"><?= $mensaje ?></p>

    <?php if ($paso === 'solicitar'): ?>
      <form method="POST">
        <input type="hidden" name="paso" value="solicitar" />
        <label>Correo electrónico:</label>
        <input type="email" name="email" required />
        <input type="submit" value="Enviar código" />
      </form>

    <?php elseif ($paso === 'verificar'): ?>
      <form method="POST">
        <input type="hidden" name="paso" value="verificar" />
        <input type="hidden" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" />
        <label>Ingresa el código recibido:</label>
        <input type="text" name="codigo" required />
        <input type="submit" value="Verificar código" />
      </form>

    <?php elseif ($paso === 'cambiar'): ?>
      <form method="POST">
        <input type="hidden" name="paso" value="cambiar" />
        <input type="hidden" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" />
        <input type="hidden" name="codigo" value="<?= htmlspecialchars($_POST['codigo'] ?? '') ?>" />
        <label>Nueva contraseña:</label>
        <input type="password" id="nueva_contrasena" name="nueva_contrasena" required />

        <div id="password-requisitos" class="text-black small mb-3" style="text-align:left;">
          <p id="largo"><i class="fa fa-times-circle text-danger"></i> Mínimo 8 caracteres</p>
          <p id="mayuscula"><i class="fa fa-times-circle text-danger"></i> Al menos una mayúscula</p>
          <p id="minuscula"><i class="fa fa-times-circle text-danger"></i> Al menos una minúscula</p>
          <p id="numero"><i class="fa fa-times-circle text-danger"></i> Al menos un número</p>
          <p id="especial"><i class="fa fa-times-circle text-danger"></i> Al menos un carácter especial</p>
        </div>

        <input type="submit" value="Cambiar contraseña" />
      </form>

    <?php elseif ($paso === 'finalizado'): ?>
      <p style="color:green;">✅ Tu contraseña fue cambiada exitosamente.</p>
    <?php endif; ?>

    <p><a href="login.php">Volver al login</a></p>
  </div>

<?php if ($paso === 'cambiar'): ?>
<script>
document.addEventListener("DOMContentLoaded", function () {
  const pass = document.getElementById("nueva_contrasena");
  if (!pass) return;

  const reglas = {
    largo: document.getElementById("largo"),
    mayuscula: document.getElementById("mayuscula"),
    minuscula: document.getElementById("minuscula"),
    numero: document.getElementById("numero"),
    especial: document.getElementById("especial")
  };

  pass.addEventListener("input", () => {
    const valor = pass.value;

    reglas.largo.innerHTML = valor.length >= 8
      ? '<i class="fa fa-check-circle text-success"></i> Mínimo 8 caracteres'
      : '<i class="fa fa-times-circle text-danger"></i> Mínimo 8 caracteres';

    reglas.mayuscula.innerHTML = /[A-Z]/.test(valor)
      ? '<i class="fa fa-check-circle text-success"></i> Al menos una mayúscula'
      : '<i class="fa fa-times-circle text-danger"></i> Al menos una mayúscula';

    reglas.minuscula.innerHTML = /[a-z]/.test(valor)
      ? '<i class="fa fa-check-circle text-success"></i> Al menos una minúscula'
      : '<i class="fa fa-times-circle text-danger"></i> Al menos una minúscula';

    reglas.numero.innerHTML = /\d/.test(valor)
      ? '<i class="fa fa-check-circle text-success"></i> Al menos un número'
      : '<i class="fa fa-times-circle text-danger"></i> Al menos un número';

    reglas.especial.innerHTML = /[^A-Za-z0-9]/.test(valor)
      ? '<i class="fa fa-check-circle text-success"></i> Al menos un carácter especial'
      : '<i class="fa fa-times-circle text-danger"></i> Al menos un carácter especial';
  });
});
</script>
<?php endif; ?>
</body>
</html>