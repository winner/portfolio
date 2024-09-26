<?php

require_once('vendor/autoload.php');

use SendGrid\Mail\Mail;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$emailBody = $_REQUEST['contactMessage'];
$senderEmail = $_REQUEST['contactEmail'];
$email = new Mail();
$email->setFrom($_SERVER['MAIL_FROM_ADDR'], $_SERVER['MAIL_FROM_NAME']);
$email->setSubject($_REQUEST['contactSubject']);
$email->addTo($_SERVER['MAIL_TO_ADDR'], $_SERVER['MAIL_TO_NAME']);
$email->addContent(
    'text/html',
    "<p>Sender Email: $senderEmail</p>".
    "<p>$emailBody</p>"
);

$sendgrid = new SendGrid($_SERVER['SENDGRID_API_KEY']);
try {
    $response = $sendgrid->send($email);
    echo 'Successfully submitted!';
} catch (Exception $e) {
    echo 'Caught exception: '.  $e->getMessage(). "\n";
}