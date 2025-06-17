<?php
// Habilitar reporte de errores para debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Establecer header JSON desde el inicio
header('Content-Type: application/json; charset=utf-8');

try {
    require_once '../includes/db.php';
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error de conexión a la base de datos: ' . $e->getMessage()]);
    exit;
}

$accion = $_GET['accion'] ?? '';

// Log de la acción solicitada
error_log("Acción solicitada: " . $accion);

switch ($accion) {
    // Obtener el precio máximo
    case 'precioMax':
        try {
            $stmt = $conn->query("SELECT MAX(precio_minorista) AS maximo FROM productos WHERE activo = 1");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $maximo = $row ? floatval($row['maximo']) : 0;

            echo json_encode(['maximo' => $maximo]);
        } catch (PDOException $e) {
            error_log("Error en precioMax: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Error al obtener el precio máximo: ' . $e->getMessage()]);
        }
        break;

    // Filtrar productos por búsqueda, categoría y precio
    case 'filtrar':
        try {
            $q = isset($_GET['q']) ? trim($_GET['q']) : '';
            $categoria = isset($_GET['categoria']) ? intval($_GET['categoria']) : 0;
            $precioMax = isset($_GET['precioMax']) ? floatval($_GET['precioMax']) : 0;

            $condiciones = ["p.activo = 1"];
            $parametros = [];

            if ($q !== '') {
                $condiciones[] = "(p.nombre_producto LIKE :q OR p.descripcion LIKE :q)";
                $parametros[':q'] = "%$q%";
            }

            if ($categoria > 0) {
                $condiciones[] = "p.id_categoria = :categoria";
                $parametros[':categoria'] = $categoria;
            }

            if ($precioMax > 0) {
                $condiciones[] = "p.precio_minorista <= :precioMax";
                $parametros[':precioMax'] = $precioMax;
            }

            $sql = "
                SELECT 
                    p.id_producto,
                    p.nombre_producto,
                    p.precio_minorista,
                    p.imagen,
                    p.descripcion,
                    p.unidad_medida,
                    p.fecha_creacion,
                    c.nombre_categoria,
                    s.cantidad_disponible AS stock
                FROM productos p
                JOIN categorias c ON p.id_categoria = c.id_categoria
                JOIN stock s ON p.id_producto = s.id_producto
            ";

            if (!empty($condiciones)) {
                $sql .= " WHERE " . implode(" AND ", $condiciones);
            }

            $sql .= " ORDER BY p.fecha_creacion DESC";

            $stmt = $conn->prepare($sql);
            foreach ($parametros as $clave => $valor) {
                $stmt->bindValue($clave, $valor);
            }

            $stmt->execute();
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($productos);
        } catch (PDOException $e) {
            error_log("Error en filtrar: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Error al filtrar productos: ' . $e->getMessage()]);
        }
        break;

    // Cargar productos paginados por offset
    case 'cargar':
        try {
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limite = 6;

            $stmt = $conn->prepare("
                SELECT 
                    p.id_producto,
                    p.nombre_producto,
                    p.precio_minorista,
                    p.imagen,
                    p.descripcion,
                    p.unidad_medida,
                    p.fecha_creacion,
                    c.nombre_categoria,
                    s.cantidad_disponible AS stock
                FROM productos p
                JOIN categorias c ON p.id_categoria = c.id_categoria
                JOIN stock s ON p.id_producto = s.id_producto
                WHERE p.activo = 1
                ORDER BY p.fecha_creacion DESC
                LIMIT ? OFFSET ?
            ");

            $stmt->bindValue(1, $limite, PDO::PARAM_INT);
            $stmt->bindValue(2, $offset, PDO::PARAM_INT);

            $stmt->execute();

            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($productos);
        } catch (PDOException $e) {
            error_log("Error en cargar: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Error al cargar productos: ' . $e->getMessage()]);
        }
        break;

    // Obtener categorías con conteo de productos
    case 'categorias':
        try {
            // Primero obtenemos el total de productos activos para "Todas"
            $stmtTotal = $conn->query("SELECT COUNT(*) as total FROM productos WHERE activo = 1");
            $totalProductos = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Luego obtenemos las categorías con sus conteos (solo productos activos)
            $stmt = $conn->query("
                SELECT 
                    c.id_categoria, 
                    c.nombre_categoria, 
                    COUNT(CASE WHEN p.activo = 1 THEN p.id_producto END) AS cantidad
                FROM categorias c
                LEFT JOIN productos p ON c.id_categoria = p.id_categoria
                WHERE c.activo = 1
                GROUP BY c.id_categoria, c.nombre_categoria
                ORDER BY c.nombre_categoria
            ");

            $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Agregar el total para "Todas" al inicio
            $resultado = [
                [
                    'id_categoria' => 0,
                    'nombre_categoria' => 'Todas',
                    'cantidad' => intval($totalProductos)
                ]
            ];
            
            // Agregar las demás categorías (solo las que tienen productos activos o queremos mostrar)
            foreach ($categorias as $cat) {
                $resultado[] = [
                    'id_categoria' => intval($cat['id_categoria']),
                    'nombre_categoria' => $cat['nombre_categoria'],
                    'cantidad' => intval($cat['cantidad'])
                ];
            }

            echo json_encode($resultado);
        } catch (PDOException $e) {
            error_log("Error en categorias: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Error al cargar categorías: ' . $e->getMessage()]);
        }
        break;

    // NUEVO: Obtener precios mayoristas para productos específicos
    case 'precios-mayoristas':
        try {
            $productos = $_POST['productos'] ?? '';
            
            if (empty($productos)) {
                echo json_encode(['error' => 'No se enviaron productos']);
                break;
            }

            // Convertir string de IDs a array
            $ids = explode(',', $productos);
            $ids = array_map('intval', $ids);
            $placeholders = str_repeat('?,', count($ids) - 1) . '?';

            $stmt = $conn->prepare("
                SELECT 
                    id_producto,
                    precio_minorista,
                    precio_mayorista,
                    cantidad_minima_mayorista
                FROM productos 
                WHERE id_producto IN ($placeholders) AND activo = 1
            ");

            $stmt->execute($ids);
            $precios = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Convertir a formato clave-valor para fácil acceso
            $resultado = [];
            foreach ($precios as $precio) {
                $resultado[$precio['id_producto']] = [
                    'precio_minorista' => floatval($precio['precio_minorista']),
                    'precio_mayorista' => floatval($precio['precio_mayorista']),
                    'cantidad_minima_mayorista' => intval($precio['cantidad_minima_mayorista'])
                ];
            }

            echo json_encode($resultado);
        } catch (PDOException $e) {
            error_log("Error en precios-mayoristas: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Error al obtener precios mayoristas: ' . $e->getMessage()]);
        }
        break;

    // Acción desconocida
    default:
        http_response_code(400);
        echo json_encode(['error' => 'Acción no válida: ' . $accion]);
        break;
}
?>