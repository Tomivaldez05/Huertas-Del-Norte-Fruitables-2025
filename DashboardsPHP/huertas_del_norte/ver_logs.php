<?php
// Archivo simple para ver los logs de debug
?>
<!DOCTYPE html>
<html>
<head>
    <title>Debug Logs</title>
    <style>
        body { font-family: monospace; margin: 20px; }
        .log-container { background: #f5f5f5; padding: 20px; border-radius: 5px; }
        .clear-btn { background: #dc3545; color: white; padding: 10px 20px; border: none; border-radius: 3px; cursor: pointer; margin-bottom: 10px; }
        .refresh-btn { background: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 3px; cursor: pointer; margin-bottom: 10px; margin-left: 10px; }
    </style>
</head>
<body>
    <h2>Debug Logs - Producto</h2>
    
    <form method="post" style="margin-bottom: 20px;">
        <button type="submit" name="clear_log" class="clear-btn">Limpiar Log</button>
        <button type="submit" name="refresh" class="refresh-btn">Actualizar</button>
    </form>
    
    <?php
    $log_file = 'debug_producto.log';
    
    // Limpiar log si se solicita
    if (isset($_POST['clear_log'])) {
        file_put_contents($log_file, '');
        echo "<p><strong>Log limpiado.</strong></p>";
    }
    
    // Mostrar contenido del log
    if (file_exists($log_file)) {
        $log_content = file_get_contents($log_file);
        if (!empty($log_content)) {
            echo "<div class='log-container'>";
            echo "<h3>Contenido del log:</h3>";
            echo "<pre>" . htmlspecialchars($log_content) . "</pre>";
            echo "</div>";
        } else {
            echo "<p>El archivo de log está vacío.</p>";
        }
    } else {
        echo "<p>El archivo de log no existe aún.</p>";
    }
    
    // También mostrar el debug.log si existe
    $debug_log = 'debug.log';
    if (file_exists($debug_log)) {
        $debug_content = file_get_contents($debug_log);
        if (!empty($debug_content)) {
            echo "<div class='log-container' style='margin-top: 20px;'>";
            echo "<h3>Debug.log:</h3>";
            echo "<pre>" . htmlspecialchars($debug_content) . "</pre>";
            echo "</div>";
        }
    }
    ?>
    
    <script>
        // Auto-refresh cada 5 segundos
        setTimeout(function() {
            location.reload();
        }, 5000);
    </script>
</body>
</html>
