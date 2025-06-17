<?php
session_start();

// Database connection
try {
    $host = 'localhost';
    $dbname = 'huertas_del_norte'; // Change this to your database name
    $username = 'root'; // Change this to your MySQL username
    $password = ''; // Change this to your MySQL password
    $port = 3307;
    
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    die("<p style='color:red;'>Error de conexión a la base de datos.</p>");
}

// Process login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';
    
    try {
        // Find user by email
        $stmt = $pdo->prepare("SELECT id_usuario, password_hash, nombre, apellido FROM usuarios WHERE email = ?");
        $stmt->execute([$usuario]);
        $usuario_db = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($usuario_db) {
            // Authenticate password using password_hash from the 'usuarios' table
            if (password_verify($contrasena, $usuario_db['password_hash'] ?? '')) {
                
                // Check 'usuario_modulo_permisos' table for user ID and specific module/permission for dashboard access
                // Assuming id_modulo = 1 is for 'productos' and id_permiso = 1 is for 'ver'
                $stmt_access = $pdo->prepare("SELECT COUNT(*) FROM usuario_modulo_permisos WHERE id_usuario = ? AND id_modulo = ? AND id_permiso = ? AND activo = 1");
                $stmt_access->execute([$usuario_db['id_usuario'], 1, 1]); // Module 'productos' (id=1), Permission 'ver' (id=1)
                $can_access_dashboard = $stmt_access->fetchColumn();

                if ($can_access_dashboard) {
                    $_SESSION['id_usuario'] = $usuario_db['id_usuario'];
                    $_SESSION['nombre'] = $usuario_db['nombre'] ?? '';
                    $_SESSION['apellido'] = $usuario_db['apellido'] ?? '';
                    
                    header("Location: templates/dashboard.php");
                    exit();
                } else {
                    $error_message = "Acceso denegado. Su usuario no tiene los permisos necesarios para acceder al dashboard de productos.";
                }

            } else {
                $error_message = "Contraseña incorrecta.";
            }
        } else {
            $error_message = "Usuario no encontrado.";
        }
    } catch (PDOException $e) {
    die("<pre>Error en la autenticación: " . $e->getMessage() . "</pre>");
}
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesión</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: #f4f4f4;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            text-align: center;
        }
        .message.error {
            background-color: #fdd;
            color: #d00;
            border: 1px solid #d00;
        }
        .message.success {
            background-color: #dfd;
            color: #0d0;
            border: 1px solid #0d0;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"],
        input[type="password"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.2s;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    
    <?php if (isset($error_message)): ?>
        <div class="message error"><?= htmlspecialchars($error_message) ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <label for="usuario">Usuario (Email):</label>
        <input type="text" id="usuario" name="usuario" value="<?= htmlspecialchars($_POST['usuario'] ?? '') ?>" required>
        
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>
        
        <button type="submit">Iniciar Sesión</button>
    </form>
</body>
</html>
