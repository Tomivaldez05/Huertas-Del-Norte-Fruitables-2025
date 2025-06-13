<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Incluir las clases de PHPMailer (asegúrate de tener la carpeta "PHPMailer/src/")
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function enviarCodigoPorCorreo($correoDestino, $codigo) {
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';

    try {
        // Configuración del servidor SMTP de Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'huertasdelnorte.soporte@gmail.com'; // ✅ Tu cuenta de Gmail
        $mail->Password = 'folaagiiajandvyd'; // ⛔ Pegá aquí la contraseña de aplicación SIN espacios
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Datos del correo
        $mail->setFrom('huertasdelnorte.soporte@gmail.com', 'Huertas del Norte');
        $mail->addAddress($correoDestino);

        $mail->isHTML(true);
        $mail->Subject = 'Código de recuperación de contraseña';
        $mail->Body    = "Tu código de recuperación es: <strong>$codigo</strong>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>
