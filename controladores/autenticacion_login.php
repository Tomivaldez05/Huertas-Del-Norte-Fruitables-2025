<?php
session_start();

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "huertas_del_norte");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Validar campos vacíos
if (empty($email) || empty($password)) {
    $_SESSION['error_login'] = "Debe ingresar su correo y contraseña.";
    header("Location: ../login.php");
    exit();
}

// Buscar usuario activo por email
$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE email = ? AND activo = 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();

    if (password_verify($password, $usuario['password_hash'])) {
        // Inicio de sesión exitoso
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['email'] = $usuario['email'];
        $_SESSION['nombre_usuario'] = $usuario['nombre']; // este se usa en el header

        // Registrar fecha última sesión
        $conexion->query("UPDATE usuarios SET fecha_ultima_sesion = NOW() WHERE id_usuario = {$usuario['id_usuario']}");

        // Redirigir a la tienda (index.php)
        header("Location: ../index.php");
        exit();
        
    } else {
        $_SESSION['error_login'] = "❌ Contraseña incorrecta.";
        header("Location: ../login.php");
        exit();
    }
} else {
    $_SESSION['error_login'] = "❌ Correo no encontrado o cuenta inactiva.";
    header("Location: ../login.php");
    exit();
}

$stmt->close();
$conexion->close();
?>
