<?php
session_start();
require_once __DIR__ . '/../config.php';

$page = $_GET['page'] ?? 'catalog';
$is_admin = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;

// Admin Guard
if (str_starts_with($page, 'admin_') && $page !== 'admin_login' && !$is_admin) {
    header('Location: /?page=admin_login');
    exit;
}

require_once __DIR__ . '/../views/header.php';

switch ($page) {
    case 'catalog':
        require_once __DIR__ . '/../views/catalog.php';
        break;
    case 'admin_login':
        require_once __DIR__ . '/../views/admin_login.php';
        break;
    case 'admin_products':
        require_once __DIR__ . '/../views/admin_products.php';
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
