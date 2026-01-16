<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit;
}

$full_name = trim($_POST['full_name'] ?? '');
$email     = trim($_POST['email'] ?? '');
$phone     = trim($_POST['phone'] ?? '');
$consent   = isset($_POST['consent']) && $_POST['consent'] == 1 ? 'כן' : 'לא';

// Validation (server-side)
if ($full_name === '' || $email === '' || $phone === '') {
    echo 'error';
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo 'error';
    exit;
}

// Email settings
$to = "dudubuzaglo@gmail.com"; 
$subject = "טופס התקשרות חדש";

$message = "
שם מלא: $full_name
אימייל: $email
טלפון: $phone
אישור דיוור: $consent
";

$headers  = "From: $full_name <$email>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8";
$headers .= "From: finance@refresh-market.co.il"."\r\n" ;

if (mail($to, $subject, $message, $headers)) {
    echo 'success';
} else {
    echo 'error';
}
