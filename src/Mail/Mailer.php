<?php

namespace app\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    private string $host;
    private string $username;
    private string $password;
    private int $port;

    public function __construct(string $host = 'smtp.gmail.com', string $username = 'yoiber696@gmail.com', string $password = 'mlmkfzjycvqyjkcm', int $port = 587)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->port = $port;
    }

    public function sendEmail(string $to, string $subject, string $body): bool
    {
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor
            $mail->isSMTP();
            $mail->Host = $this->host;
            $mail->SMTPAuth = true;
            $mail->Username = $this->username;
            $mail->Password = $this->password;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $this->port;

            // Destinatarios
            $mail->setFrom($this->username, 'Nombre del Remitente');
            $mail->addAddress($to);

            // Contenido
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            // Manejo de errores
            error_log("Error al enviar el correo: {$mail->ErrorInfo}");
            echo 'Error: ' . $mail->ErrorInfo . ' ' . $e->getMessage();
            return false;
        }
    }
}
