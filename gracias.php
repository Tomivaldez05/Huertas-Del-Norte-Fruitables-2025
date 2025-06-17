<?php
include_once 'includes/header.php';
require_once 'includes/db.php';
// Si no viene número de pedido pero sí viene confirmación de Mercado Pago
if (!$numeroPedido && ($_GET['collection_status'] ?? '') === 'approved') {
    echo '<div class="container mt-5">';
    echo '<h2>¡Gracias por tu pago!</h2>';
    echo '<p>Tu pago fue aprobado. Procesaremos tu pedido a la brevedad.</p>';
    echo '</div>';
    include_once 'includes/footer.php';
    exit;
}

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

// Determinar si hay algún producto con cantidad mayor o igual a 10
$mostrar_columna_descuento = false;
$total_con_descuento = 0;

foreach ($detalles as $item) {
    if ($item['cantidad'] >= 10) {
        $mostrar_columna_descuento = true;
    }
}
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
                <?php if ($mostrar_columna_descuento): ?>
                    <th>Precio con descuento</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detalles as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['nombre_producto']) ?></td>
                    <td><?= $item['cantidad'] ?></td>
                    <td>$<?= number_format($item['precio_unitario'], 2) ?></td>
                    <td>
                        <?php if ($item['cantidad'] >= 10): ?>
                            <s>$<?= number_format($item['subtotal'], 2) ?></s>
                        <?php else: ?>
                            $<?= number_format($item['subtotal'], 2) ?>
                        <?php endif; ?>
                    </td>
                    <?php if ($mostrar_columna_descuento): ?>
                        <td>
                            <?php
                                if ($item['cantidad'] >= 10) {
                                    $descuento = 0.10;
                                    $subtotal_desc = $item['precio_unitario'] * $item['cantidad'] * (1 - $descuento);
                                } else {
                                    $subtotal_desc = $item['subtotal'];
                                }

                                $total_con_descuento += $subtotal_desc;
                                echo '$' . number_format($subtotal_desc, 2);
                            ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="<?= $mostrar_columna_descuento ? '4' : '3' ?>" class="text-end">Total:</th>
                <th>
                    <?php if ($mostrar_columna_descuento): ?>
                        <s>$<?= number_format($pedido['total'], 2) ?></s><br>
                        $<?= number_format($total_con_descuento, 2) ?>
                    <?php else: ?>
                        $<?= number_format($pedido['total'], 2) ?>
                    <?php endif; ?>
                </th>
            </tr>
        </tfoot>
    </table>

    <a href="descargar_factura.php?pedido=<?= urlencode($numeroPedido) ?>" class="btn btn-success">Descargar factura PDF</a>
</div>

<?php
// Guardar el total con descuento en la base de datos (si hay descuento)
if ($mostrar_columna_descuento && $total_con_descuento > 0) {
    $stmt = $conn->prepare("UPDATE pedidos SET total_con_descuento = ? WHERE id_pedido = ?");
    $stmt->execute([$total_con_descuento, $pedido['id_pedido']]);
}

include_once 'includes/footer.php';
?>
