<?php

use Laminas\Mail\Message;
use Laminas\Mail\Transport\Smtp;
use Laminas\Mail\Transport\SmtpOptions;
use Laminas\Mime\Part as MimePart;
use Laminas\Mime\Message as MimeMessage;

require_once __DIR__ . "/../vendor/autoload.php";

class Correo {

    private static function enviarSMTP(Message $mail) {

        $transport = new Smtp();

        $options = new SmtpOptions([
            'name'              => 'sandbox.smtp.mailtrap.io',
            'host'              => 'sandbox.smtp.mailtrap.io',
            'connection_class'  => 'login',
            'port'              => 2525,
            'connection_config' => [
                'username' => 'ff844b3491fdde',   // User Mailtrap
                'password' => 'e4e4b56aa9fb02',   // Pass Mailtrap
            ],
        ]);

        $transport->setOptions($options);
        $transport->send($mail);
    }


    /* ==========================================================
       MÉTODO GENERAL PARA ENVIAR CUALQUIER MAIL
       ========================================================== */
    public static function enviar($email, $nombre, $asunto, $detalleHTML) {

        $html = new MimePart($detalleHTML);
        $html->type = "text/html";

        $body = new MimeMessage();
        $body->setParts([$html]);

        $mail = new Message();
        $mail->addTo($email, $nombre);
        $mail->addFrom("no-reply@mate-store.com", "Tienda de Mates");
        $mail->setSubject($asunto);
        $mail->setBody($body);

        self::enviarSMTP($mail);
    }


    /* ==========================================================
       MAIL DE COMPRA ACEPTADA (CLIENTE FINALIZA COMPRA)
       ========================================================== */
    public static function enviarCompraAceptada($email, $nombre, $idCompra, $detalleHTML) {

        $html = new MimePart($detalleHTML);
        $html->type = "text/html";

        $body = new MimeMessage();
        $body->setParts([$html]);

        $mail = new Message();
        $mail->addTo($email, $nombre);
        $mail->addFrom("no-reply@mate-store.com", "Tienda de Mates");
        $mail->setSubject("Tu compra #$idCompra fue aceptada");
        $mail->setBody($body);

        self::enviarSMTP($mail);
    }

}
