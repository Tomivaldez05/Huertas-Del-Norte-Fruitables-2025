<?php
$host = "localhost";
$port = 3307;
$db = "huertas_del_norte";
$user = "root";
$pass = "";

try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8", $user, $pass);
    // Configura PDO para que lance excepciones si hay errores
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
