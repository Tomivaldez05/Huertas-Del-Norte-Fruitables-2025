<?php
require_once '../../includes/db.php';

switch ($_GET['accion'] ?? '') {
    case 'resumen':
        // Total productos activos
        $totalProductos = $conn->query("SELECT COUNT(*) FROM productos WHERE activo = 1")->fetchColumn();

        // Stock bajo y sin stock
        $sql = "SELECT 
                    SUM(CASE WHEN s.cantidad_disponible = 0 THEN 1 ELSE 0 END) as sin_stock,
                    SUM(CASE WHEN s.cantidad_disponible <= 
                        CASE 
                            WHEN p.unidad_medida = 'kg' THEN 10
                            WHEN p.unidad_medida = 'unidad' THEN 12
                            WHEN p.unidad_medida = 'paquete' THEN 8
                            ELSE 5
                        END AND s.cantidad_disponible > 0 THEN 1 ELSE 0 END) as stock_bajo
                FROM productos p
                JOIN stock s ON p.id_producto = s.id_producto
                WHERE p.activo = 1";
        $res = $conn->query($sql)->fetch(PDO::FETCH_ASSOC);

        // Pedidos pendientes
        $pedidosPendientes = $conn->query("SELECT COUNT(*) FROM pedidos WHERE estado = 'pendiente'")->fetchColumn();

        echo json_encode([
            'total_productos' => $totalProductos,
            'stock_bajo' => $res['stock_bajo'],
            'sin_stock' => $res['sin_stock'],
            'pedidos_pendientes' => $pedidosPendientes
        ]);
        break;

    case 'productos_criticos':
        $sql = "SELECT p.nombre_producto, s.cantidad_disponible, p.unidad_medida, c.nombre_categoria
                FROM productos p
                JOIN stock s ON p.id_producto = s.id_producto
                JOIN categorias c ON p.id_categoria = c.id_categoria
                WHERE p.activo = 1 AND (s.cantidad_disponible = 0 OR s.cantidad_disponible <= 
                    CASE 
                        WHEN p.unidad_medida = 'kg' THEN 10
                        WHEN p.unidad_medida = 'unidad' THEN 12
                        WHEN p.unidad_medida = 'paquete' THEN 8
                        ELSE 5
                    END)
                ORDER BY s.cantidad_disponible ASC";
        $res = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($res);
        break;

    case 'actividades_recientes':
        $sql = "SELECT hs.fecha, p.nombre_producto, hs.operacion, hs.cantidad, hs.usuario, hs.observaciones
                FROM historial_stock hs
                JOIN productos p ON hs.id_producto = p.id_producto
                ORDER BY hs.fecha DESC
                LIMIT 10";
        $res = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($res);
        break;

    default:
        echo json_encode(['error' => 'Acción no válida']);
}
?>
