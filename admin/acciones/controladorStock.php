<?php
// Deshabilitar la salida de errores de PHP
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Establecer header JSON desde el inicio
header('Content-Type: application/json; charset=utf-8');

// Función para manejar errores
function manejarError($mensaje, $codigo = 500) {
    error_log("Error en controladorStock: " . $mensaje);
    http_response_code($codigo);
    echo json_encode(['error' => $mensaje]);
    exit;
}

// Función para comprimir imagen
function comprimirImagen($rutaArchivo, $calidad = 80) {
    try {
        if (!file_exists($rutaArchivo)) {
            throw new Exception('El archivo no existe: ' . $rutaArchivo);
        }

        // Verificar si GD está disponible
        if (!extension_loaded('gd')) {
            error_log("Extensión GD no disponible. Intentando comprimir sin GD...");
            // Intentar comprimir usando una solución alternativa
            return comprimirImagenSinGD($rutaArchivo);
        }

        $info = getimagesize($rutaArchivo);
        if ($info === false) {
            throw new Exception('No se pudo obtener información de la imagen');
        }

        $mime = $info['mime'];
        $imagen = null;

        // Crear imagen según el tipo
        switch ($mime) {
            case 'image/jpeg':
                $imagen = imagecreatefromjpeg($rutaArchivo);
                break;
            case 'image/png':
                $imagen = imagecreatefrompng($rutaArchivo);
                break;
            default:
                throw new Exception('Tipo de imagen no soportado: ' . $mime);
        }

        if (!$imagen) {
            throw new Exception('No se pudo crear la imagen');
        }

        // Crear archivo temporal para la imagen comprimida
        $rutaComprimida = $rutaArchivo . '_compressed.jpg';
        
        // Comprimir y guardar
        if (!imagejpeg($imagen, $rutaComprimida, $calidad)) {
            throw new Exception('Error al guardar la imagen comprimida');
        }

        // Liberar memoria
        imagedestroy($imagen);

        // Verificar tamaño
        $tamano = filesize($rutaComprimida);
        if ($tamano > 1024 * 1024) { // Si aún es mayor a 1MB
            if ($calidad > 30) { // Si podemos comprimir más
                unlink($rutaComprimida); // Eliminar versión anterior
                return comprimirImagen($rutaArchivo, $calidad - 10); // Intentar con menor calidad
            }
            throw new Exception('No se pudo comprimir la imagen lo suficiente');
        }

        return $rutaComprimida;
    } catch (Exception $e) {
        error_log("Error al comprimir imagen: " . $e->getMessage());
        throw $e;
    }
}

// Función alternativa para comprimir imágenes sin GD
function comprimirImagenSinGD($rutaArchivo) {
    try {
        // Crear una copia temporal
        $rutaComprimida = $rutaArchivo . '_compressed.jpg';
        
        // Intentar comprimir usando ImageMagick si está disponible
        if (extension_loaded('imagick')) {
            $imagick = new Imagick($rutaArchivo);
            $imagick->setImageFormat('jpeg');
            $imagick->setImageCompressionQuality(80);
            $imagick->writeImage($rutaComprimida);
            $imagick->clear();
            $imagick->destroy();
        } else {
            // Si no hay ImageMagick, intentar una solución más simple
            // Convertir PNG a JPEG usando una herramienta externa
            $comando = "convert \"$rutaArchivo\" -quality 80 \"$rutaComprimida\"";
            exec($comando, $output, $return_var);
            
            if ($return_var !== 0) {
                throw new Exception('No se pudo comprimir la imagen usando herramientas externas');
            }
        }

        // Verificar tamaño
        $tamano = filesize($rutaComprimida);
        if ($tamano > 1024 * 1024) {
            throw new Exception('No se pudo comprimir la imagen lo suficiente');
        }

        return $rutaComprimida;
    } catch (Exception $e) {
        error_log("Error en comprimirImagenSinGD: " . $e->getMessage());
        throw $e;
    }
}

try {
    require_once '../../includes/db.php';
} catch (Exception $e) {
    manejarError('Error de conexión a la base de datos: ' . $e->getMessage());
}

$accion = $_GET['accion'] ?? '';

// Log de la acción solicitada
error_log("Acción de stock solicitada: " . $accion);

switch ($accion) {
    // Listar todos los productos con su información de stock
    case 'listarStock':
        try {
            $stmt = $conn->query("
                SELECT 
                    p.id_producto,
                    p.nombre_producto,
                    p.unidad_medida,
                    c.nombre_categoria,
                    s.cantidad_disponible,
                    s.cantidad_reservada,
                    s.fecha_ingreso,
                    s.fecha_ultima_actualizacion,
                    s.observaciones,
                    pr.nombre_proveedor,
                    -- Definir stock mínimo (esto podría venir de una tabla de configuración)
                    CASE 
                        WHEN p.unidad_medida = 'kg' THEN 10
                        WHEN p.unidad_medida = 'unidad' THEN 12
                        WHEN p.unidad_medida = 'paquete' THEN 8
                        ELSE 5
                    END as stock_minimo,
                    -- Determinar estado del stock
                    CASE 
                        WHEN s.cantidad_disponible = 0 THEN 'sin_stock'
                        WHEN s.cantidad_disponible <= CASE 
                            WHEN p.unidad_medida = 'kg' THEN 10
                            WHEN p.unidad_medida = 'unidad' THEN 12
                            WHEN p.unidad_medida = 'paquete' THEN 8
                            ELSE 5
                        END THEN 'stock_bajo'
                        ELSE 'normal'
                    END as estado_stock
                FROM productos p
                JOIN stock s ON p.id_producto = s.id_producto
                JOIN categorias c ON p.id_categoria = c.id_categoria
                JOIN proveedores pr ON s.id_proveedor = pr.id_proveedor
                WHERE p.activo = 1
                ORDER BY 
                    CASE 
                        WHEN s.cantidad_disponible = 0 THEN 1
                        WHEN s.cantidad_disponible <= CASE 
                            WHEN p.unidad_medida = 'kg' THEN 10
                            WHEN p.unidad_medida = 'unidad' THEN 12
                            WHEN p.unidad_medida = 'paquete' THEN 8
                            ELSE 5
                        END THEN 2
                        ELSE 3
                    END,
                    p.nombre_producto ASC
            ");
            
            $stock = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($stock);
        } catch (PDOException $e) {
            error_log("Error en listarStock: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Error al obtener el stock: ' . $e->getMessage()]);
        }
        break;

    // Procesar factura con OCR
    case 'procesarFacturaOCR':
        try {
            // Verificar que se haya subido un archivo
            if (!isset($_FILES['factura']) || $_FILES['factura']['error'] !== UPLOAD_ERR_OK) {
                $error = isset($_FILES['factura']) ? $_FILES['factura']['error'] : 'No se recibió archivo';
                error_log("Error al subir archivo: " . $error);
                manejarError('No se pudo cargar el archivo de la factura');
            }

            $archivo = $_FILES['factura'];
            $tiposPermitidos = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
            
            error_log("Tipo de archivo recibido: " . $archivo['type']);
            
            if (!in_array($archivo['type'], $tiposPermitidos)) {
                manejarError('Tipo de archivo no permitido. Use JPG, PNG o PDF');
            }

            // Crear directorio temporal si no existe
            $directorioTemp = '../temp/';
            if (!is_dir($directorioTemp)) {
                if (!mkdir($directorioTemp, 0777, true)) {
                    error_log("Error al crear directorio temporal");
                    manejarError('Error al crear directorio temporal');
                }
            }

            // Guardar archivo temporalmente
            $nombreArchivo = uniqid() . '_' . $archivo['name'];
            $rutaArchivo = $directorioTemp . $nombreArchivo;
            
            error_log("Intentando guardar archivo en: " . $rutaArchivo);
            
            if (!move_uploaded_file($archivo['tmp_name'], $rutaArchivo)) {
                error_log("Error al mover archivo: " . error_get_last()['message']);
                manejarError('Error al guardar el archivo temporalmente');
            }

            // Llamar a la API de OCR
            $resultadoOCR = procesarOCR($rutaArchivo);
            
            // Eliminar archivo temporal
            if (file_exists($rutaArchivo)) {
            unlink($rutaArchivo);
            }

            if ($resultadoOCR['error']) {
                manejarError($resultadoOCR['mensaje']);
            }

            // Procesar el texto extraído para encontrar productos
            error_log("Texto que se enviará a extraerProductosDelTexto: " . $resultadoOCR['texto']);
            $productosExtraidos = extraerProductosDelTexto($resultadoOCR['texto'], $conn);
            
            echo json_encode([
                'success' => true,
                'productos' => $productosExtraidos,
                'texto_completo' => $resultadoOCR['texto']
            ]);

        } catch (Exception $e) {
            error_log("Error en procesarFacturaOCR: " . $e->getMessage());
            manejarError('Error al procesar la factura: ' . $e->getMessage());
        }
        break;

    // Actualizar stock con los datos confirmados
    case 'actualizarStock':
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($input['productos']) || !is_array($input['productos'])) {
                echo json_encode(['error' => 'Datos de productos no válidos']);
                break;
            }

            $productosActualizados = 0;
            $errores = [];

            $conn->beginTransaction();

            foreach ($input['productos'] as $producto) {
                if (!isset($producto['id_producto']) || !isset($producto['cantidad'])) {
                    $errores[] = "Producto sin ID o cantidad válida";
                    continue;
                }

                $idProducto = intval($producto['id_producto']);
                $cantidad = floatval($producto['cantidad']);
                $tipoOperacion = $producto['tipo_operacion'] ?? 'sumar';
                $observaciones = $producto['observaciones'] ?? 'Actualización desde factura OCR';

                // Obtener stock actual
                $stmt = $conn->prepare("SELECT cantidad_disponible FROM stock WHERE id_producto = ?");
                $stmt->execute([$idProducto]);
                $stockActual = $stmt->fetchColumn();

                if ($stockActual === false) {
                    $errores[] = "Producto ID $idProducto no encontrado en stock";
                    continue;
                }

                // Calcular nueva cantidad según el tipo de operación
                $nuevaCantidad = $stockActual;
                switch ($tipoOperacion) {
                    case 'sumar':
                        $nuevaCantidad = $stockActual + $cantidad;
                        break;
                    case 'restar':
                        $nuevaCantidad = max(0, $stockActual - $cantidad);
                        break;
                    case 'ajustar':
                        $nuevaCantidad = $cantidad;
                        break;
                }

                // Actualizar stock
                $stmt = $conn->prepare("
                    UPDATE stock 
                    SET cantidad_disponible = ?, 
                        fecha_ultima_actualizacion = CURRENT_TIMESTAMP,
                        observaciones = ?
                    WHERE id_producto = ?
                ");
                
                if ($stmt->execute([$nuevaCantidad, $observaciones, $idProducto])) {
                    $productosActualizados++;

                    // === INSERTA AQUÍ EL REGISTRO EN EL HISTORIAL ===
                    $stmtHistorial = $conn->prepare("
                        INSERT INTO historial_stock (id_producto, fecha, operacion, cantidad, observaciones, usuario)
                        VALUES (?, NOW(), ?, ?, ?, ?)
                    ");
                    $stmtHistorial->execute([
                        $idProducto,
                        $tipoOperacion,
                        $cantidad,
                        $observaciones,
                        $_SESSION['usuario'] ?? 'admin'
                    ]);
                    // === FIN DEL BLOQUE DE INSERCIÓN ===

                } else {
                    $errores[] = "Error al actualizar producto ID $idProducto";
                }
            }

            $conn->commit();

            echo json_encode([
                'success' => true,
                'productos_actualizados' => $productosActualizados,
                'errores' => $errores,
                'mensaje' => "Se actualizaron $productosActualizados productos correctamente"
            ]);

        } catch (Exception $e) {
            $conn->rollBack();
            error_log("Error en actualizarStock: " . $e->getMessage());
            echo json_encode(['error' => 'Error al actualizar el stock: ' . $e->getMessage()]);
        }
        break;

    // Obtener lista de productos para autocompletar
    case 'buscarProductos':
        try {
            $termino = $_GET['termino'] ?? '';
            
            if (strlen($termino) < 2) {
                echo json_encode([]);
                break;
            }

            $stmt = $conn->prepare("
                SELECT id_producto, nombre_producto, unidad_medida
                FROM productos 
                WHERE activo = 1 AND nombre_producto LIKE ?
                ORDER BY nombre_producto
                LIMIT 10
            ");
            
            $stmt->execute(["%$termino%"]);
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode($productos);
        } catch (PDOException $e) {
            error_log("Error en buscarProductos: " . $e->getMessage());
            echo json_encode(['error' => 'Error al buscar productos']);
        }
        break;

    case 'procesarTextoPrueba':
        try {
            $texto = $_POST['texto'] ?? '';
            if (empty($texto)) {
                throw new Exception('No se proporcionó texto para procesar');
            }

            // Procesar el texto directamente
            $productosExtraidos = extraerProductosDelTexto($texto, $conn);
            
            echo json_encode([
                'success' => true,
                'productos' => $productosExtraidos,
                'texto_completo' => $texto
            ]);

        } catch (Exception $e) {
            error_log("Error en procesarTextoPrueba: " . $e->getMessage());
            manejarError('Error al procesar el texto: ' . $e->getMessage());
        }
        break;

    case 'historial':
        $idProducto = $_GET['id_producto'] ?? null;
        if (!$idProducto) {
            echo json_encode([]);
            break;
        }
        $stmt = $conn->prepare("SELECT fecha, operacion, cantidad, observaciones, usuario FROM historial_stock WHERE id_producto = ? ORDER BY fecha DESC");
        $stmt->execute([$idProducto]);
        $historial = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($historial);
        break;

    default:
        http_response_code(400);
        echo json_encode(['error' => 'Acción no válida: ' . $accion]);
        break;
}

// Función para procesar OCR usando OCR.space API
function procesarOCR($rutaArchivo) {
    try {
        // Comprimir imagen si es necesario
        $tamanoOriginal = filesize($rutaArchivo);
        if ($tamanoOriginal > 1024 * 1024) { // Si es mayor a 1MB
            error_log("Imagen demasiado grande (" . ($tamanoOriginal / 1024) . "KB), comprimiendo...");
            $rutaArchivo = comprimirImagen($rutaArchivo);
            error_log("Imagen comprimida a " . (filesize($rutaArchivo) / 1024) . "KB");
        }

        // Clave de API de OCR.space
        $apiKey = 'K88671461088957';
   
    $postData = [
        'apikey' => $apiKey,
        'language' => 'spa', // Español
            'isOverlayRequired' => 'false',
        'file' => new CURLFile($rutaArchivo),
            'isCreateSearchablePDF' => 'false',
            'isSearchablePdfHideTextLayer' => 'false',
            'scale' => 'true',
            'detectOrientation' => 'true',
            'isTable' => 'false'
        ];

        // Log de la petición
        error_log("Enviando petición a OCR.space con archivo: " . $rutaArchivo);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.ocr.space/parse/image');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        // Log de la respuesta
        error_log("Respuesta de OCR.space - HTTP Code: " . $httpCode);
        error_log("Respuesta de OCR.space - Body: " . $response);
        
        if (curl_errno($ch)) {
            throw new Exception('Error en la petición cURL: ' . curl_error($ch));
        }
        
    curl_close($ch);

        // Limpiar archivo comprimido si se creó
        if ($rutaArchivo !== $rutaArchivo . '_compressed.jpg') {
            unlink($rutaArchivo);
        }

    if ($httpCode !== 200 || !$response) {
            throw new Exception('Error al conectar con el servicio de OCR (HTTP Code: ' . $httpCode . ')');
    }

    $data = json_decode($response, true);
    
        if (!$data) {
            throw new Exception('Error al decodificar la respuesta del servicio OCR: ' . json_last_error_msg());
        }
        
        // Log de los datos decodificados
        error_log("Datos decodificados de OCR.space: " . print_r($data, true));
        
        // Verificar si hay un error en la respuesta
        if (isset($data['ErrorMessage'])) {
            if (is_array($data['ErrorMessage'])) {
                throw new Exception('Error del servicio OCR: ' . implode(', ', $data['ErrorMessage']));
            } else {
                throw new Exception('Error del servicio OCR: ' . $data['ErrorMessage']);
            }
        }
        
        if (!isset($data['ParsedResults']) || empty($data['ParsedResults'])) {
            throw new Exception('No se pudo extraer texto de la imagen. Respuesta: ' . print_r($data, true));
        }

        $texto = $data['ParsedResults'][0]['ParsedText'] ?? '';
        if (empty($texto)) {
            throw new Exception('No se encontró texto en la imagen');
    }

    return ['error' => false, 'texto' => $texto];
    } catch (Exception $e) {
        error_log("Error en procesarOCR: " . $e->getMessage());
        return ['error' => true, 'mensaje' => $e->getMessage()];
    }
}

// Función para extraer productos del texto OCR
function extraerProductosDelTexto($texto, $conn) {
    $productos = [];
    $productosInactivos = [];
    $productosNuevos = [];

    // Separar líneas de forma robusta
    $lineas = preg_split('/\r\n|\r|\n/', $texto);
    $lineas = array_map('trim', $lineas);

    // Obtener productos de la base de datos
    $stmt = $conn->query("SELECT id_producto, nombre_producto, unidad_medida FROM productos WHERE activo = 1");
    $productosDB = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt = $conn->query("SELECT id_producto, nombre_producto, unidad_medida FROM productos WHERE activo = 0");
    $productosInactivosDB = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($productosDB as &$productoDB) {
        $productoDB['nombre_normalizado'] = normalizar($productoDB['nombre_producto']);
    }
    foreach ($productosInactivosDB as &$productoDB) {
        $productoDB['nombre_normalizado'] = normalizar($productoDB['nombre_producto']);
    }

    // --- NUEVA LÓGICA ---
    $productosTemp = [];
    $cantidades = [];
    $encontradoProductos = false;
    $encontrandoCantidades = false;
    
    foreach ($lineas as $linea) {
        $linea = trim($linea);
        if (empty($linea)) continue;
        $linea_normalizada = normalizar($linea);

        // Detectar inicio de productos (después de "Total" sin dos puntos)
        if (!$encontradoProductos && $linea_normalizada === 'total') {
            $encontradoProductos = true;
            continue;
        }
        // Detectar fin de productos (cuando empieza un número)
        if ($encontradoProductos && preg_match('/^\\d/', $linea_normalizada)) {
            $encontrandoCantidades = true;
            $encontradoProductos = false;
        }
        // Guardar productos
        if ($encontradoProductos) {
            if (strlen($linea_normalizada) > 2) {
                $productosTemp[] = $linea;
            }
        }
        // Guardar cantidades
        if ($encontrandoCantidades) {
            if (preg_match('/^\\d+(?:\\.\\d+)?$/', $linea_normalizada)) {
                $cantidad = floatval($linea_normalizada);
                if ($cantidad < 1000) {
                    $cantidades[] = $cantidad;
                }
            }
        }
    }

    // LOGS para depuración
    error_log("Productos detectados: " . print_r($productosTemp, true));
    error_log("Cantidades detectadas: " . print_r($cantidades, true));

    // Asociar productos con cantidades
    $min = min(count($productosTemp), count($cantidades));
    for ($i = 0; $i < $min; $i++) {
        $nombreProducto = $productosTemp[$i];
        $cantidad = $cantidades[$i];
        $nombre_normalizado = normalizar($nombreProducto);

        $encontrado = false;
        foreach ($productosDB as $productoDB) {
            if (stripos($nombre_normalizado, $productoDB['nombre_normalizado']) !== false ||
                stripos($productoDB['nombre_normalizado'], $nombre_normalizado) !== false) {
                $productos[] = [
                    'nombre_detectado' => $nombreProducto,
                    'cantidad' => $cantidad,
                    'id_producto' => $productoDB['id_producto'],
                    'nombre_producto' => $productoDB['nombre_producto'],
                    'unidad_medida' => $productoDB['unidad_medida'],
                    'coincidencia' => true,
                    'estado' => 'activo'
                ];
                $encontrado = true;
                break;
            }
        }
        if (!$encontrado) {
            foreach ($productosInactivosDB as $productoDB) {
                if (stripos($nombre_normalizado, $productoDB['nombre_normalizado']) !== false ||
                    stripos($productoDB['nombre_normalizado'], $nombre_normalizado) !== false) {
                    $productosInactivos[] = [
                        'nombre_detectado' => $nombreProducto,
                        'cantidad' => $cantidad,
                        'id_producto' => $productoDB['id_producto'],
                        'nombre_producto' => $productoDB['nombre_producto'],
                        'unidad_medida' => $productoDB['unidad_medida'],
                        'coincidencia' => true,
                        'estado' => 'inactivo'
                    ];
                    $encontrado = true;
                    break;
                }
            }
        }
        if (!$encontrado) {
            $productosNuevos[] = [
                'nombre_detectado' => $nombreProducto,
                'cantidad' => $cantidad,
                'id_producto' => null,
                'nombre_producto' => $nombreProducto,
                'unidad_medida' => 'kg',
                'coincidencia' => false,
                'estado' => 'nuevo'
            ];
        }
    }

    return [
        'productos' => $productos,
        'productos_inactivos' => $productosInactivos,
        'productos_nuevos' => $productosNuevos
    ];
}

function normalizarTextoCompleto($texto) {
    // Convertir a minúsculas
    $texto = mb_strtolower($texto, 'UTF-8');
    
    // Reemplazar caracteres especiales
    $texto = str_replace(
        ['á', 'é', 'í', 'ó', 'ú', 'ñ', 'ü'],
        ['a', 'e', 'i', 'o', 'u', 'n', 'u'],
        $texto
    );
    
    // Eliminar caracteres no deseados
    $texto = preg_replace('/[^a-z0-9\s]/', ' ', $texto);
    
    // Eliminar espacios múltiples
    $texto = preg_replace('/\s+/', ' ', $texto);
    
    return trim($texto);
}

function normalizar($cadena) {
    $cadena = mb_strtolower($cadena, 'UTF-8');
    $cadena = preg_replace('/[áàäâ]/u', 'a', $cadena);
    $cadena = preg_replace('/[éèëê]/u', 'e', $cadena);
    $cadena = preg_replace('/[íìïî]/u', 'i', $cadena);
    $cadena = preg_replace('/[óòöô]/u', 'o', $cadena);
    $cadena = preg_replace('/[úùüû]/u', 'u', $cadena);
    $cadena = preg_replace('/[^a-z0-9 .]/u', '', $cadena); // Preservar puntos decimales
    $cadena = preg_replace('/\\s+/', ' ', $cadena); // Espacios simples
    $cadena = trim($cadena);
    return $cadena;
}
?>