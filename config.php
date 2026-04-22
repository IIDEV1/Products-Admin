<?php
// Supabase PostgreSQL Configuration
$host = 'aws-1-ap-northeast-1.pooler.supabase.com';
$port = '6543';
$db   = 'postgres';
$user = 'postgres.gjethtscgyafrypdvfes';
$pass = 'asdasdasdasdasdasdsadasdasdasdasdasdsa'; // TODO: Replace with actual password

define('ADMIN_USER', 'admin');
define('ADMIN_PASS', 'password123');

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$lang = $_SESSION['lang'] ?? 'ru';
$lang_file = __DIR__ . "/languages/{$lang}.php";
$lang_data = file_exists($lang_file) ? require $lang_file : [];

function __($key) {
    global $lang_data;
    return $lang_data[$key] ?? $key;
}
