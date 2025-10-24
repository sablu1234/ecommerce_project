<?php

// MYSQL = database name
$dbhost = 'localhost';
$dbname = 'ecommerce_project';
$dbuser = 'root';
$dbpass = '';
try {
    $pdo = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpass);
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo "Connection error :" . $e->getMessage();
}

define('SMTP_HOST', 'sandbox.smtp.mailtrap.io');
define('SMTP_PORT', '587');
define('SMTP_USERNAME', '5c500d58392d78');
define('SMTP_PASSWORD', '7dd818dd6a8c92');
define('SMTP_ENCRYPTION', 'tls');
define('SMTP_FROM', 'contact@example.com');