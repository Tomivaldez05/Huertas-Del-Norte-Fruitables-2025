<?php
// config/permissions.php
// Definición de constantes para los permisos

// Módulos
define('MODULO_PRODUCTOS', 1);
define('MODULO_CATEGORIAS', 2);
define('MODULO_USUARIOS', 3);

// Permisos
define('PERMISO_VER', 1);
define('PERMISO_CREAR', 2);
define('PERMISO_EDITAR', 3);
define('PERMISO_ELIMINAR', 4);
define('PERMISO_ADMINISTRAR', 5);

/**
 * Función para verificar si un usuario tiene un permiso específico
 * 
 * @param int $id_usuario ID del usuario
 * @param int $id_modulo ID del módulo
 * @param int $id_permiso ID del permiso
 * @return bool True si tiene permiso, False si no
 */
function tienePermiso($id_usuario, $id_modulo, $id_permiso) {
    global $pdo;
    
    $stmt = $pdo->prepare("
        SELECT COUNT(*) as tiene 
        FROM usuario_modulo_permisos 
        WHERE id_usuario = ? 
        AND id_modulo = ? 
        AND id_permiso = ? 
        AND activo = 1
    ");
    
    $stmt->execute([$id_usuario, $id_modulo, $id_permiso]);
    $resultado = $stmt->fetch();
    
    return $resultado['tiene'] > 0;
}

/**
 * Función para obtener todos los permisos de un usuario para un módulo
 * 
 * @param int $id_usuario ID del usuario
 * @param int $id_modulo ID del módulo
 * @return array Array con los IDs de los permisos
 */
function obtenerPermisos($id_usuario, $id_modulo) {
    global $pdo;
    
    $stmt = $pdo->prepare("
        SELECT id_permiso 
        FROM usuario_modulo_permisos 
        WHERE id_usuario = ? 
        AND id_modulo = ? 
        AND activo = 1
    ");
    
    $stmt->execute([$id_usuario, $id_modulo]);
    $permisos = [];
    
    while ($row = $stmt->fetch()) {
        $permisos[] = $row['id_permiso'];
    }
    
    return $permisos;
}
