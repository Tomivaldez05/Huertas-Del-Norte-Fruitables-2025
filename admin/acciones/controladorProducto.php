<?php
require_once '../../includes/db.php';

$accion = $_GET['accion'] ?? '';

switch ($accion) {
    case 'listar':
        try {
            $stmt = $conn->query("SELECT p.*, c.nombre_categoria 
                                  FROM productos p
                                  JOIN categorias c ON p.id_categoria = c.id_categoria
                                  WHERE p.activo = 1
                                  ORDER BY p.nombre_producto ASC");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    case 'guardar':
        try {
            $id = $_POST['id_producto'] ?? null;
            $nombre = $_POST['nombre'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            $categoria = $_POST['categoria'] ?? '';
            $precio_minorista = $_POST['precio_minorista'] ?? 0;
            $precio_mayorista = $_POST['precio_mayorista'] ?? 0;
            $unidad = $_POST['unidad'] ?? '';
            $cantidad_minima_mayorista = $_POST['cantidad_minima_mayorista'] ?? 1;
            $activo = isset($_POST['activo']) ? 1 : 0;
            $imagenNombre = null;

            // Validaciones básicas
            if (empty($nombre) || empty($categoria) || empty($unidad)) {
                echo json_encode(['ok' => false, 'mensaje' => 'Faltan campos obligatorios']);
                exit;
            }

            // Crear directorio si no existe
            $directorioImagenes = "../../assets/img/productos/";
            if (!is_dir($directorioImagenes)) {
                mkdir($directorioImagenes, 0777, true);
            }

            // Manejo de imagen
            if (!empty($_FILES['imagen']['name'])) {
                $nombreOriginal = basename($_FILES['imagen']['name']);
                $imagenNombre = uniqid() . "_" . $nombreOriginal;
                $destino = $directorioImagenes . $imagenNombre;

                if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
                    echo json_encode(['ok' => false, 'mensaje' => 'Error al subir imagen']);
                    exit;
                }
            }

            if ($id) {
                // Actualizar
                $sql = "UPDATE productos SET 
                            nombre_producto = ?, 
                            descripcion = ?, 
                            id_categoria = ?, 
                            precio_minorista = ?, 
                            precio_mayorista = ?, 
                            unidad_medida = ?, 
                            cantidad_minima_mayorista = ?,
                            activo = ?";

                $parametros = [$nombre, $descripcion, $categoria, $precio_minorista, $precio_mayorista, $unidad, $cantidad_minima_mayorista, $activo];

                if ($imagenNombre) {
                    $sql .= ", imagen = ?";
                    $parametros[] = $imagenNombre;
                }

                $sql .= " WHERE id_producto = ?";
                $parametros[] = $id;

                $stmt = $conn->prepare($sql);
                $stmt->execute($parametros);
            } else {
                // Insertar
                $sql = "INSERT INTO productos (nombre_producto, descripcion, id_categoria, precio_minorista, precio_mayorista, unidad_medida, cantidad_minima_mayorista, imagen, activo) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    $nombre, $descripcion, $categoria, $precio_minorista, $precio_mayorista,
                    $unidad, $cantidad_minima_mayorista, $imagenNombre, $activo
                ]);
            }

            echo json_encode(['ok' => true, 'mensaje' => 'Producto guardado correctamente']);
        } catch (PDOException $e) {
            echo json_encode(['ok' => false, 'mensaje' => 'Error de base de datos: ' . $e->getMessage()]);
        }
        break;

    case 'obtener':
        try {
            $id = $_GET['id'] ?? 0;
            $stmt = $conn->prepare("SELECT * FROM productos WHERE id_producto = ?");
            $stmt->execute([$id]);
            $producto = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($producto ?: ['error' => 'Producto no encontrado']);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    case 'eliminar':
        try {
            $id = $_GET['id'] ?? 0;
            $stmt = $conn->prepare("UPDATE productos SET activo = 0 WHERE id_producto = ?");
            $ok = $stmt->execute([$id]);
            echo json_encode(['ok' => $ok]);
        } catch (PDOException $e) {
            echo json_encode(['ok' => false, 'mensaje' => $e->getMessage()]);
        }
        break;

    case 'categorias':
        try {
            $stmt = $conn->query("SELECT id_categoria, nombre_categoria FROM categorias ORDER BY nombre_categoria");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;
    case 'guardarCategoria':
        $id = $_POST['id_categoria'] ?? null;
        $nombre = $_POST['nombre_categoria'] ?? '';

        try {
            if ($id) {
                $sql = "UPDATE categorias SET nombre_categoria = ? WHERE id_categoria = ?";
                $stmt = $conn->prepare($sql);
                $ok = $stmt->execute([$nombre, $id]); // 👈 parámetro corregido
            } else {
                $sql = "INSERT INTO categorias(nombre_categoria) VALUES (?)";
                $stmt = $conn->prepare($sql);
                $ok = $stmt->execute([$nombre]);
            }

            echo json_encode(["ok" => $ok]);
        } catch (PDOException $e) {
            echo json_encode(["ok" => false, "mensaje" => $e->getMessage()]);
        }
        break;

    case 'eliminarCategoria':
        try {
            $id = $_GET['id'] ?? null;

            if (!$id) {
                echo json_encode(['ok' => false, 'mensaje' => 'ID no proporcionado']);
                break;
            }

            $stmt = $conn->prepare("DELETE FROM categorias WHERE id_categoria = ?");
            $ok = $stmt->execute([$id]);
            echo json_encode(["ok" => $ok]);
        } catch (PDOException $e) {
            echo json_encode(["ok" => false, "mensaje" => $e->getMessage()]);
        }
        break;

    case 'historial':
        $idProducto = $_GET['id_producto'] ?? null;
        if (!$idProducto) {
            echo json_encode([]);
            break;
        }
        $stmt = $conn->prepare("SELECT fecha_ultima_actualizacion as fecha, tipo_operacion as operacion, cantidad, observaciones FROM historial_stock WHERE id_producto = ? ORDER BY fecha_ultima_actualizacion DESC");
        $stmt->execute([$idProducto]);
        $historial = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($historial);
        break;

    default:
        http_response_code(400);
        echo json_encode(['error' => 'Acción no válida']);
}
?>