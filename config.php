<?php
// Load .env file
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') === false) continue;
        list($key, $value) = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }
}

// Database credentials from environment
$host = $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?: 'aws-1-ap-northeast-1.pooler.supabase.com';
$port = $_ENV['DB_PORT'] ?? getenv('DB_PORT') ?: '6543';
$db   = $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?: 'postgres';
$user = $_ENV['DB_USER'] ?? getenv('DB_USER') ?: 'postgres.gjethtscgyafrypdvfes';
$pass = $_ENV['DB_PASS'] ?? getenv('DB_PASS') ?: '';

// Admin credentials
define('ADMIN_USER', $_ENV['ADMIN_USER'] ?? getenv('ADMIN_USER') ?: 'admin');
// Pre-hashed password for 'admin' (change via: php -r "echo password_hash('your_password', PASSWORD_DEFAULT);")
define('ADMIN_PASS_HASH', $_ENV['ADMIN_PASS_HASH'] ?? getenv('ADMIN_PASS_HASH') ?: password_hash('12345', PASSWORD_DEFAULT));

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Ошибка</title><script src="https://cdn.tailwindcss.com"></script></head>';
    echo '<body class="bg-slate-50 flex items-center justify-center min-h-screen"><div class="text-center p-8">';
    echo '<h1 class="text-2xl font-extrabold text-slate-900 mb-4">Ошибка подключения</h1>';
    echo '<p class="text-slate-500 text-sm">Не удалось подключиться к базе данных. Попробуйте позже.</p>';
    echo '</div></body></html>';
    exit;
}

// Language
$lang = $_SESSION['lang'] ?? 'ru';
$lang_file = __DIR__ . "/languages/{$lang}.php";
$lang_data = file_exists($lang_file) ? require $lang_file : [];

function __($key) {
    global $lang_data;
    return $lang_data[$key] ?? $key;
}

// CSRF Token helpers
function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field() {
    return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}

function verify_csrf($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token ?? '');
}

// Page title helper
function page_title($page, $extra = '') {
    $titles = [
        'landing' => 'OrbitalStore — Премиальный магазин',
        'catalog' => 'Каталог — OrbitalStore',
        'cart' => 'Корзина — OrbitalStore',
        'admin_login' => 'Вход — OrbitalStore',
        'admin_products' => 'Товары — Админ — OrbitalStore',
        'admin_orders' => 'Заказы — Админ — OrbitalStore',
        'admin_dashboard' => 'Панель — Админ — OrbitalStore',
        'order_success' => 'Заказ оформлен — OrbitalStore',
        'product' => $extra ? $extra . ' — OrbitalStore' : 'Товар — OrbitalStore',
    ];
    return $titles[$page] ?? 'OrbitalStore';
}
