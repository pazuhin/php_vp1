<?php
/**
 * @
 */
require_once './vendor/autoload.php';
try {
    $transport = (new Swift_SmtpTransport('smtp.yandex.ru', 465, 'ssl'))
        ->setUsername('kozloff.d4nila@yandex.ru')
        ->setPassword('123qazwsxedc');
    $mailer = new Swift_Mailer($transport);
    $message = new Swift_Message();
    $message->setSubject('New order');
    $message->setFrom(['kozloff.d4nila@yandex.ru' => 'Данила']);
    $message->setTo('andrew_1024@mail.ru');
    $message->setBody('This is the plain text body of the message');
    $mailer->send($message);
} catch (Exception $e) {
    echo $e->getMessage();
}

