<?php
// Habilitar reporte de errores para debugging
ini_set('display_errors', 1); // No mostrar errores en pantalla
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
            ini_set('display_errors', 1);
            error_reporting(E_ALL);

            require_once '../includes/db.php'; // asegurate de incluir tu conexión

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
            $stmt = $conn->query("SELECT c.id_categoria, c.nombre_categoria, COUNT(p.id_producto) AS cantidad
                                  FROM categorias c
                                  LEFT JOIN productos p ON c.id_categoria = p.id_categoria AND p.activo = 1
                                  GROUP BY c.id_categoria, c.nombre_categoria
                                  ORDER BY c.nombre_categoria");

            $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($categorias);
        } catch (PDOException $e) {
            error_log("Error en categorias: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Error al cargar categorías: ' . $e->getMessage()]);
        }
        break;

    // Acción desconocida
    default:
        http_response_code(400);
        echo json_encode(['error' => 'Acción no válida: ' . $accion]);
        break;
}
?>