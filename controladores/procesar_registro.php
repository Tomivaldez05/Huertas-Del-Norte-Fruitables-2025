<?php
session_start();

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "45533264", "huertas_del_norte");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Recibir y validar campos
$nombre = $_POST['nombre'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($nombre) || empty($email) || empty($password)) {
    $_SESSION['error_registro'] = "Todos los campos son obligatorios.";
    header("Location: ../registro.php");
    exit();
}

// Verificar si ya existe ese email
$stmt = $conexion->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $_SESSION['error_registro'] = "Ese correo ya está registrado.";
    header("Location: ../registro.php");
    exit();
}

$stmt->close();

// Hashear contraseña
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Insertar nuevo usuario
$stmt = $conexion->prepare("INSERT INTO usuarios (nombre, email, password_hash) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nombre, $email, $password_hash);

if ($stmt->execute()) {
    $_SESSION['mensaje_registro'] = "Registro exitoso. ¡Ya podés iniciar sesión!";
    header("Location: ../login.php");
} else {
    $_SESSION['error_registro'] = "Error al registrar el usuario.";
    header("Location: ../registro.php");
}

$stmt->close();
$conexion->close();
?>
