<?php
require('../model/phpmailer/send_mail.php');
require('../model/mvc/model_mvc_login.php');

$email = new SendEmail();
$user = new MVCLogin();

$psswd = substr( sha1(microtime()), 1, 8);

$email->setDataEmail($_POST['email']);
$email->setPassword($psswd);

if( $email->sendEmail()){
    $user->setEmail($_POST['email']);
    $user->setPassword($psswd);
    echo $user->restorePass();
}else {
    echo json_encode(array(
        'Error' => 'EmailNoEnviado',
        'Detail' => 'Hubo un error al enviar el correo ' .$email->sendEmail()
    ));
}

