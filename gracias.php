<?php
include_once 'includes/header.php';
?>

<?php
require_once 'includes/db.php';

$numeroPedido = $_GET['pedido'] ?? null;

if (!$numeroPedido) {
    echo "Pedido no especificado.";
    exit;
}

// Buscar el pedido
$stmt = $conn->prepare("SELECT * FROM pedidos WHERE numero_pedido = ?");
$stmt->execute([$numeroPedido]);
$pedido = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pedido) {
    echo "Pedido no encontrado.";
    exit;
}

// Buscar detalles
$stmt = $conn->prepare("SELECT dp.*, p.nombre_producto 
                        FROM detalle_pedidos dp
                        JOIN productos p ON dp.id_producto = p.id_producto
                        WHERE dp.id_pedido = ?");
$stmt->execute([$pedido['id_pedido']]);
$detalles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h2>¡Gracias por tu compra!</h2>
    <p>Número de pedido: <strong><?= htmlspecialchars($numeroPedido) ?></strong></p>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detalles as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['nombre_producto']) ?></td>
                    <td><?= $item['cantidad'] ?></td>
                    <td>$<?= number_format($item['precio_unitario'], 2) ?></td>
                    <td>$<?= number_format($item['subtotal'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Total:</th>
                <th>$<?= number_format($pedido['total'], 2) ?></th>
            </tr>
        </tfoot>
    </table>

    <a href="descargar_factura.php?pedido=<?= urlencode($numeroPedido) ?>" class="btn btn-success">Descargar factura PDF</a>
</div>
        <!-- Checkout Page End -->
<?php
    include_once 'includes/footer.php';
?>

 