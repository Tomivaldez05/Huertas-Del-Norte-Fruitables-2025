<?php
// index.php
session_start();
require_once 'config/db.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

// Definir constantes para los permisos
define('PERMISO_VER', 1);
define('PERMISO_CREAR', 2);
define('PERMISO_EDITAR', 3);
define('PERMISO_ELIMINAR', 4);
define('PERMISO_ADMINISTRAR', 5);

// Obtener permisos de la sesión
$permisos = $_SESSION['permisos_productos'] ?? [];

// Verificar permisos específicos
$puede_ver = in_array(PERMISO_VER, $permisos) || in_array(PERMISO_ADMINISTRAR, $permisos);
$puede_crear = in_array(PERMISO_CREAR, $permisos) || in_array(PERMISO_ADMINISTRAR, $permisos);
$puede_editar = in_array(PERMISO_EDITAR, $permisos) || in_array(PERMISO_ADMINISTRAR, $permisos);
$puede_eliminar = in_array(PERMISO_ELIMINAR, $permisos) || in_array(PERMISO_ADMINISTRAR, $permisos);

// Si no tiene permiso para ver, redirigir a una página de acceso denegado
if (!$puede_ver) {
    header("Location: acceso_denegado.php");
    exit;
}

// Función para obtener todas las categorías activas
function obtenerCategorias($pdo) {
    $stmt = $pdo->query("SELECT * FROM categorias WHERE activo = 1 ORDER BY nombre_categoria");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener productos con información de categoría
function obtenerProductos($pdo) {
    $stmt = $pdo->query("
        SELECT p.*, c.nombre_categoria 
        FROM productos p
        LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
        ORDER BY c.nombre_categoria, p.nombre_producto
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener estadísticas
function obtenerEstadisticas($pdo) {
    $stats = [];
    
    // Total de productos
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM productos");
    $stats['total_productos'] = $stmt->fetch()['total'];
    
    // Productos activos
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM productos WHERE activo = 1");
    $stats['productos_activos'] = $stmt->fetch()['total'];
    
    // Total de categorías
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM categorias WHERE activo = 1");
    $stats['categorias_total'] = $stmt->fetch()['total'];
    
    return $stats;
}

// Obtener datos para la página
$categorias = obtenerCategorias($pdo);
$productos = obtenerProductos($pdo);
$estadisticas = obtenerEstadisticas($pdo);

// Incluir la plantilla HTML del dashboard
include 'templates/dashboard.php';
?>
