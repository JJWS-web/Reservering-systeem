<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

date_default_timezone_set('Etc/UTC');

require __DIR__ . '/../../vendor/autoload.php'; 

$data = json_decode(file_get_contents("php://input"), true);

$twoFACode = isset($data['twoFACode']) ? $data['twoFACode'] : null;

if (!$twoFACode) {
    die('Error: Missing 2FA code in the request.');
}

$mail = new PHPMailer();
$mail->isSMTP();
$mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->SMTPAuth = true;
$mail->Username = 'jj.wesje@gmail.com';
$mail->Password = 'ajpy lrys xelb rtaj';
$mail->setFrom('jj.wesje@gmail.com', 'Josia');
$mail->addReplyTo('mrpatat12a@gmail.com', 'Jayden');

$mail->addAddress('yaboypforlife@gmail.com', 'Fixed Recipient');

$mail->Subject = 'Your 2FA Code';
$mail->msgHTML("<h1>Your 2FA Code</h1><p>Your two-factor authentication code is: <strong>$twoFACode</strong></p>");
$mail->AltBody = "Your two-factor authentication code is: $twoFACode";

if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
}
