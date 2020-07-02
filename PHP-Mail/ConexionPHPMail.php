<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);
$nombre = $_POST['nombre'];
$correoUsuario = $_POST['correo'];
$asunto = $_POST['asunto'];
$mensaje = $_POST['mensaje'];
try {
    //Server settings
    $mail->SMTPDebug = 2;                      // Enable verbose debug output 2= pasos del servicio del email 0 = es el comando de anulaxion derespuesta mustra codigo error true or error false  
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'prueba.php.inacap@gmail.com';                     // SMTP username
    $mail->Password   = 'correo1234';                               // SMTP password
    $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('noreply@eduWeb.com', 'EdduWeb');
    $mail->addAddress($correoUsuario); // Name is optional
    $mail->addReplyTo('noreply@eduWeb.com', 'EdduWeb');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    // Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    //echo("<script>console.log('PHP: ".$data."');</script>");
    //echo("<script>console.log('mail pasa por aca');</script>");
   

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $asunto;
    $mail->Body    = $mensaje;
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    //echo("<script>console.log('mail pasa por aca2);</script>");
    echo 'su correo ha sido enviado con exito';
} catch (Exception $e) {
    //echo "su mensaje a fallado error codigo: {$mail->ErrorInfo}";
}
header('Location: ../contacto.php');

?>