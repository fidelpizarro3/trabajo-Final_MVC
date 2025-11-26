use Laminas\Mail\Message;
use Laminas\Mail\Transport\Smtp;
use Laminas\Mail\Transport\SmtpOptions;

function enviarMail($para, $asunto, $html)
{
    $mail = new Message();
    $mail->addTo($para)
         ->addFrom('tuemail@gmail.com', 'Tienda de Mates')
         ->setSubject($asunto)
         ->setBody($html);

    $mail->setEncoding("UTF-8");

    $transport = new Smtp(new SmtpOptions([
        'name' => 'gmail.com',
        'host' => 'smtp.gmail.com',
        'connection_class' => 'login',
        'port' => 587,
        'connection_config' => [
            'username' => 'tuemail@gmail.com',
            'password' => 'TU_PASSWORD',
            'ssl' => 'tls'
        ],
    ]));

    $transport->send($mail);
}
