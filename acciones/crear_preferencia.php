<?php
require '../includes/db.php';

// Clave secreta (Access Token de Mercado Pago)
$access_token = 'APP_USR-3732629042479412-060513-4fc00e10158e4a35ebe32c84b60b2ad1-2481891582';

$data = json_decode(file_get_contents("php://input"), true);
$carrito = $data['carrito'] ?? [];

if (!$carrito) {
    http_response_code(400);
    echo json_encode(['error' => 'Carrito vacío']);
    exit;
}

$total = 0;
$items = [];

foreach ($carrito as $item) {
    // Usar precio_final si está definido (mayorista), sino usar precio normal
    $precio = isset($item['precio_final']) ? (float)$item['precio_final'] : (float)$item['precio'];
    $subtotal = $precio * $item['cantidad'];
    $total += $subtotal;

    $items[] = [
        'title' => $item['nombre'],
        'quantity' => (int)$item['cantidad'],
        'unit_price' => $precio,
        'currency_id' => 'ARS'
    ];
}


$preference = [
    'items' => $items,
    'back_urls' => [
        'success' => 'http://localhost/Huertas-Del-Norte-Fruitables-2025/gracias.php',
        'failure' => 'http://localhost/Huertas-Del-Norte-Fruitables-2025/error.php',
        'pending' => 'http://localhost/Huertas-Del-Norte-Fruitables-2025/gracias.php'
    ],
    'auto_return' => 'approved'
];


// Crear preferencia usando cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.mercadopago.com/checkout/preferences');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($preference));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $access_token
]);

$result = curl_exec($ch);
curl_close($ch);

echo $result;
