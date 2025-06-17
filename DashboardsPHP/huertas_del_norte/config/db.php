<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';
$dbname = 'huertas_del_norte';
$username = 'root'; // Cambia esto por tu usuario de MySQL
$password = '37468492'; // Cambia esto por tu contraseña de MySQL
$port = 3307;


try {
    $pdo = new PDO("mysql:host=$host;$port;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Configurar el modo de error para lanzar excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Configurar el modo de obtención por defecto como array asociativo
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    file_put_contents(__DIR__ . '/../db_connection.log', date('Y-m-d H:i:s') . " - Conexión exitosa a la base de datos\n", FILE_APPEND);
} catch (PDOException $e) {
    file_put_contents(__DIR__ . '/../db_connection.log', date('Y-m-d H:i:s') . " - Error de conexión: " . $e->getMessage() . "\n", FILE_APPEND);
    die("Error de conexión: " . $e->getMessage());
}
?>
