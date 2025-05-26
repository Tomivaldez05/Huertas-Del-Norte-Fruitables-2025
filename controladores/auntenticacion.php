<?php
session_start();
require_once '../includes/db.php';

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email AND activo = 1 LIMIT 1");
        $stmt->execute(['email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($password, $usuario['password_hash'])) {
            $_SESSION['usuario_id'] = $usuario['id_usuario'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_email'] = $usuario['email'];
            $_SESSION['usuario_tipo'] = $usuario['tipo_cliente'];

            header("Location: ../index.php");
            exit();
        } else {
            $_SESSION['error_login'] = "Correo o contraseña incorrectos.";
            header("Location: ../login.php");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error_login'] = "Error interno. Intente más tarde.";
        header("Location: ../login.php");
        exit();
    }
} else {
    $_SESSION['error_login'] = "Faltan datos.";
    header("Location: ../login.php");
    exit();
}
