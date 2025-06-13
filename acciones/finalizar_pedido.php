<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../includes/db.php';

// Obtener el contenido JSON enviado por fetch
$data = json_decode(file_get_contents("php://input"), true);

// Validación mínima
if (!$data || !isset($data['cliente']) || !isset($data['carrito'])) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'JSON inválido o incompleto']);
    exit;
}

$cliente = $data['cliente'];
$carrito = $data['carrito'];

try {
    $conn->beginTransaction();

    // Número de pedido único
    $numeroPedido = 'P' . time();

    // Calcular subtotal del pedido
    $subtotal = 0;
    foreach ($carrito as $item) {
        $subtotal += $item['precio'] * $item['cantidad'];
    }

    // Insertar en tabla pedidos
    $stmt = $conn->prepare("INSERT INTO pedidos 
        (id_usuario, numero_pedido, tipo_venta, subtotal, total, direccion_entrega, observaciones) 
        VALUES (NULL, ?, 'minorista', ?, ?, ?, ?)");
    $stmt->execute([
        $numeroPedido,
        $subtotal,
        $subtotal,
        $cliente['direccion'] ?? '',
        $cliente['observaciones'] ?? null
    ]);

    $idPedido = $conn->lastInsertId();

    // Insertar detalle del pedido
    $stmt = $conn->prepare("INSERT INTO detalle_pedidos 
        (id_pedido, id_producto, cantidad, precio_unitario, subtotal) 
        VALUES (?, ?, ?, ?, ?)");

    foreach ($carrito as $id => $item) {
        $cantidad = $item['cantidad'];
        $precio = isset($item['precio_final']) ? $item['precio_final'] : $item['precio'];
        $subtotalItem = $cantidad * $precio;

        $stmt->execute([$idPedido, $id, $cantidad, $precio, $subtotalItem]);
    }

    $conn->commit();

    echo json_encode(['ok' => true, 'numero_pedido' => $numeroPedido]);
} catch (PDOException $e) {
    $conn->rollBack();
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Error al guardar pedido: ' . $e->getMessage()]);
}
