<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'products_db');
define('DB_USER', 'root');
define('DB_PASS', '');

define('ADMIN_USER', 'admin');
define('ADMIN_PASS', 'password123');

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

session_start();

$lang = $_SESSION['lang'] ?? 'ru';
$lang_file = __DIR__ . "/languages/{$lang}.php";
$lang_data = file_exists($lang_file) ? require $lang_file : [];

function __($key) {
    global $lang_data;
    return $lang_data[$key] ?? $key;
}
