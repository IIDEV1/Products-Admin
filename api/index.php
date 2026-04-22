<?php 
session_start(); 

// 1. Сразу проверяем статус админа
$is_admin = (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) || 
            (isset($_COOKIE['admin_access']) && $_COOKIE['admin_access'] === 'active_session_verified');

require_once __DIR__ . '/../config.php';

$action = $_GET['action'] ?? '';
$page = $_GET['page'] ?? 'catalog';

// 2. ПЕРЕХВАТ ДЕЙСТВИЙ ДЛЯ VERCEL (чтобы логин работал)
if ($action !== '') {
    require_once __DIR__ . '/../actions/admin.php';
    exit; 
}

// 3. Защита админских страниц
if (str_starts_with($page, 'admin_') && $page !== 'admin_login' && !$is_admin) {
    header('Location: /?page=admin_login');
    exit;
}

// Подключаем верстку
require_once __DIR__ . '/../views/header.php';

switch ($page) {
    case 'catalog':
        require_once __DIR__ . '/../views/catalog.php';
        break;
    case 'admin_login':
        require_once __DIR__ . '/../views/admin_login.php';
        break;
    case 'admin_products':
        if (file_exists(__DIR__ . '/../views/admin_products.php')) {
            require_once __DIR__ . '/../views/admin_products.php';
        } else {
            require_once __DIR__ . '/../views/admin.php';
        }
        break;
    case 'admin_orders':
        require_once __DIR__ . '/../views/admin_orders.php';
        break;
    case 'product':
        require_once __DIR__ . '/../views/product.php';
        break;
    case 'cart':
        require_once __DIR__ . '/../views/cart.php';
        break;
    default:
        require_once __DIR__ . '/../views/catalog.php';
        break;
}

require_once __DIR__ . '/../views/footer.php';