<?php
// using SendGrid's PHP Library
// https://github.com/sendgrid/sendgrid-php
require 'vendor/autoload.php';

$sendgrid = new SendGrid('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');
$email = new SendGrid\Email();
$email 
    ->addTo('wrighthouse4@msn.com')
    ->setFrom('wrighthouse4@msn.com')
    ->setSubject('Subject goes here')
    ->setText('Hello World!')
    ->setHtml('<strong>Hello World!</strong>')
;

$sendgrid->send($email);

// Or catch the error

try {
    $sendgrid->send($email);
} catch(\SendGrid\Exception $e) {
    echo $e->getCode();
    foreach($e->getErrors() as $er) {
        echo $er;
    }
}
?>