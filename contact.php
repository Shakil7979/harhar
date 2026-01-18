<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// PHPMailer include
require __DIR__ . '/phpmailer/PHPMailer.php';
require __DIR__ . '/phpmailer/SMTP.php';
require __DIR__ . '/phpmailer/Exception.php';

// Only POST allowed
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(403);
    exit;
}

// Receive data
$full_name = trim($_POST['full_name'] ?? '');
$email     = trim($_POST['email'] ?? '');
$phone     = trim($_POST['phone'] ?? '');
$consent   = !empty($_POST['consent']) ? 'כן' : 'לא';

// Validation
if ($full_name === '' || $email === '' || $phone === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo 'error';
    exit;
}

$mail = new PHPMailer(true);

try {
    // 🔹 SMTP CONFIG (CLIENT SERVER FRIENDLY)
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';          // or client SMTP
    $mail->SMTPAuth   = true;
    $mail->Username   = 'finance@refresh-market.co.il'; // SMTP email
    $mail->Password   = 'SMTP_PASSWORD_HERE';      // SMTP / App Password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->CharSet = 'UTF-8';

    // 🔹 From / To
    $mail->setFrom('finance@refresh-market.co.il', 'Website Contact');
    $mail->addAddress('dudubuzaglo@gmail.com'); 

    // 🔹 Content
    $mail->Subject = 'טופס התקשרות חדש';
    $mail->Body =
        "שם מלא: $full_name\n" .
        "אימייל: $email\n" .
        "טלפון: $phone\n" .
        "אישור דיוור: $consent";

    $mail->send();
    echo 'success';

} catch (Exception $e) {
    echo 'error';
}
