<?php
file_put_contents(__DIR__ . '/.log', date('Y-m-d H:i:s') . ' - Entrando a api_permisos.php' . PHP_EOL, FILE_APPEND);

error_log('API Permisos iniciada');

require_once 'config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    file_put_contents(__DIR__ . '/debug_test.log', date('Y-m-d H:i:s') . ' - POST recibido' . PHP_EOL, FILE_APPEND);
    $input = json_decode(file_get_contents('php://input'), true);
    
    $action = $input['action'] ?? '';
    
    switch ($action) {
        case 'get_perfiles':
            try {
                $stmt = $pdo->query("SELECT id_usuario as id, nombre as usuario, email, password_hash as password, cargo, activo FROM usuarios ORDER BY nombre");
                $perfiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($perfiles);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
            break;

        case 'get_perfil':
            try {
                $id = $input['id'];
                $stmt = $pdo->prepare("SELECT id_usuario as id, nombre as usuario, email, password_hash as password, cargo, activo FROM usuarios WHERE id_usuario = ?");
                $stmt->execute([$id]);
                $perfil = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode($perfil);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
            break;

        case 'create_perfil':
            try {
                $perfil = $input['perfil'];
                
                // Verificar si el usuario ya existe
                $stmt = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE nombre = ? OR email = ?");
                $stmt->execute([$perfil['usuario'], $perfil['email']]);
                if ($stmt->fetch()) {
                    echo json_encode(['success' => false, 'error' => 'El usuario o email ya existe']);
                    break;
                }
                
                // Insertar nuevo perfil
                $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, email, password_hash, cargo, activo, fecha_registro) VALUES (?, '', ?, ?, ?, ?, NOW())");
                $stmt->execute([
                    $perfil['usuario'],
                    $perfil['email'],
                    password_hash($perfil['password'], PASSWORD_DEFAULT),
                    $perfil['cargo'],
                    $perfil['activo']
                ]);
                
                echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            }
            break;

        case 'update_perfil':
            try {
                $perfil = $input['perfil'];
                
                // Verificar si el usuario/email ya existe en otro registro
                $stmt = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE (nombre = ? OR email = ?) AND id_usuario != ?");
                $stmt->execute([$perfil['usuario'], $perfil['email'], $perfil['id']]);
                if ($stmt->fetch()) {
                    echo json_encode(['success' => false, 'error' => 'El usuario o email ya existe en otro perfil']);
                    break;
                }
                
                // Actualizar perfil
                $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, email = ?, password_hash = ?, cargo = ?, activo = ?, fecha_actualizacion = NOW() WHERE id_usuario = ?");
                $stmt->execute([
                    $perfil['usuario'],
                    $perfil['email'],
                    password_hash($perfil['password'], PASSWORD_DEFAULT),
                    $perfil['cargo'],
                    $perfil['activo'],
                    $perfil['id']
                ]);
                
                echo json_encode(['success' => true]);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            }
            break;

        case 'delete_perfil':
            try {
                $id = $input['id'];
                
                // Primero eliminar todos los permisos del usuario
                $stmt = $pdo->prepare("DELETE FROM usuario_modulo_permisos WHERE id_usuario = ?");
                $stmt->execute([$id]);
                
                // Luego eliminar el usuario
                $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
                $stmt->execute([$id]);
                
                if ($stmt->rowCount() > 0) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Perfil no encontrado']);
                }
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            }
            break;

        case 'save_permisos':
            error_log('Acción save_permisos detectada');
            try {
                $usuarioId = $input['id_usuario'];
                $moduloId = $input['id_modulo'];
                $permisos = $input['id_permisos'] ?? [];
                if (!is_array($permisos)) {
                    $permisos = [];
                }

                // Log para depuración
                file_put_contents(__DIR__ . '/debug_permisos.log', date('Y-m-d H:i:s') . ' - Permisos antes de insertar: ' . print_r($permisos, true) . PHP_EOL, FILE_APPEND);

                // Primero eliminamos los permisos existentes para este usuario y módulo
                $stmt = $pdo->prepare("DELETE FROM usuario_modulo_permisos WHERE id_usuario = ? AND id_modulo = ?");
                $stmt->execute([$usuarioId, $moduloId]);

                // Filtra solo ids numéricos y no vacíos
                $permisos = array_filter($permisos, function($id) {
                    return !empty($id) && is_numeric($id);
                });

                if (!empty($permisos)) {
                    $stmt = $pdo->prepare("INSERT INTO usuario_modulo_permisos (id_usuario, id_modulo, id_permiso, activo, fecha_asignacion) VALUES (?, ?, ?, 1, NOW())");
                    foreach ($permisos as $permisoId) {
                        file_put_contents(__DIR__ . '/debug_permisos.log', date('Y-m-d H:i:s') . ' - Insertando: ' . $permisoId . PHP_EOL, FILE_APPEND);
                        $stmt->execute([$usuarioId, $moduloId, $permisoId]);
                    }
                }
                
                error_log('Permisos guardados: ' . print_r($permisos, true));
                
                echo json_encode(['success' => true]);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            }
            break;

        case 'get_permisos':
            try {
                $usuarioId = $input['usuario_id'];
                $moduloId = $input['modulo_id'];
                
                $stmt = $pdo->prepare("
                    SELECT p.id_permiso 
                    FROM usuario_modulo_permisos ump 
                    JOIN permisos p ON ump.id_permiso = p.id_permiso 
                    WHERE ump.id_usuario = ? AND ump.id_modulo = ? AND ump.activo = 1
                ");
                $stmt->execute([$usuarioId, $moduloId]);
                $permisos = $stmt->fetchAll(PDO::FETCH_COLUMN);
                
                file_put_contents(__DIR__ . '/debug_get_permisos.log', date('Y-m-d H:i:s') . ' - Permisos devueltos: ' . print_r($permisos, true) . PHP_EOL, FILE_APPEND);
                
                echo json_encode($permisos);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
            break;

        case 'get_modulos':
            try {
                $stmt = $pdo->query("SELECT id_modulo as id, nombre, descripcion, activo FROM modulos WHERE activo = 1 ORDER BY nombre");
                $modulos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($modulos);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
            break;

        case 'get_all_permisos':
            try {
                $stmt = $pdo->query("SELECT id_permiso as id, nombre_permiso as nombre, codigo, descripcion FROM permisos ORDER BY nombre_permiso");
                $permisos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($permisos);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
            break;

        case 'get_user_permissions':
            try {
                $usuarioId = $input['usuario_id'];
                
                $stmt = $pdo->prepare("
                    SELECT 
                        m.id_modulo,
                        m.nombre as modulo_nombre,
                        m.descripcion as modulo_descripcion,
                        GROUP_CONCAT(p.codigo) as permisos
                    FROM modulos m
                    LEFT JOIN usuario_modulo_permisos ump ON m.id_modulo = ump.id_modulo AND ump.id_usuario = ? AND ump.activo = 1
                    LEFT JOIN permisos p ON ump.id_permiso = p.id_permiso
                    WHERE m.activo = 1
                    GROUP BY m.id_modulo, m.nombre, m.descripcion
                    ORDER BY m.nombre
                ");
                $stmt->execute([$usuarioId]);
                $permissions = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Convertir permisos de string a array
                foreach ($permissions as &$permission) {
                    $permission['permisos'] = $permission['permisos'] ? explode(',', $permission['permisos']) : [];
                }
                
                echo json_encode($permissions);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
            break;

        case 'check_permission':
            try {
                $usuarioId = $input['usuario_id'];
                $moduloNombre = $input['modulo_nombre'];
                $permisoCodigo = $input['permiso_codigo'];
                
                $stmt = $pdo->prepare("
                    SELECT COUNT(*) as tiene_permiso
                    FROM usuario_modulo_permisos ump
                    JOIN modulos m ON ump.id_modulo = m.id_modulo
                    JOIN permisos p ON ump.id_permiso = p.id_permiso
                    WHERE ump.id_usuario = ? 
                    AND m.nombre = ? 
                    AND p.codigo = ?
                    AND ump.activo = 1
                    AND m.activo = 1
                ");
                $stmt->execute([$usuarioId, $moduloNombre, $permisoCodigo]);
                $result = $stmt->fetch();
                
                echo json_encode(['has_permission' => (bool)$result['tiene_permiso']]);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
            break;

        default:
            echo json_encode(['error' => 'Acción no válida']);
            break;
    }
} else {
    file_put_contents(__DIR__ . '/debug_test.log', date('Y-m-d H:i:s') . ' - NO POST: ' . $_SERVER['REQUEST_METHOD'] . PHP_EOL, FILE_APPEND);
    echo json_encode(['error' => 'Método no permitido']);
}
?>
