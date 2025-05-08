<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

date_default_timezone_set('Etc/UTC');

require __DIR__ . '/../../vendor/autoload.php'; 

$data = json_decode(file_get_contents("php://input"), true);


$twoFACode = $data['twoFACode'] ?? null;
$recipientEmail = $data['mail'] ?? null;

if (!$twoFACode || !$recipientEmail) {
    die('Error: Missing 2FA code or email in the request.');
}

$mailer = new PHPMailer();
$mailer->isSMTP();
$mailer->SMTPDebug = SMTP::DEBUG_SERVER;
$mailer->Host = 'smtp.gmail.com';
$mailer->Port = 587;
$mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mailer->SMTPAuth = true;
$mailer->Username = 'jj.wesje@gmail.com';
$mailer->Password = 'ajpy lrys xelb rtaj'; // ⚠️ Use env variable instead
$mailer->setFrom('jj.wesje@gmail.com', 'Josia');
$mailer->addReplyTo('mrpatat12a@gmail.com', 'Jayden');

$mailer->addAddress($recipientEmail, '2FA Recipient');

$mailer->Subject = 'Your 2FA Code';
$mailer->msgHTML("<h1>Your 2FA Code</h1><p>Your two-factor authentication code is: <strong>$twoFACode</strong></p>");
$mailer->AltBody = "Your two-factor authentication code is: $twoFACode";

if (!$mailer->send()) {
    echo 'Mailer Error: ' . $mailer->ErrorInfo;
} else {
    echo 'Message sent!';
}
