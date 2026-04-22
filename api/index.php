<?php
require_once '../config.php';

$page = $_GET['page'] ?? 'catalog';
$is_admin = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'];

if (str_starts_with($page, 'admin_') && !$is_admin && $page !== 'admin_login') {
    header('Location: ?page=admin_login');
    exit;
}

require_once '../views/header.php';

switch ($page) {
    case 'catalog':
        require_once '../views/catalog.php';
        break;
    case 'admin_login':
        require_once '../views/admin_login.php';
        break;
    case 'admin_products':
        require_once '../views/admin_products.php';
        break;
    case 'admin_orders':
        require_once '../views/admin_orders.php';
        break;
    case 'product':
        require_once '../views/product.php';
        break;
    case 'cart':
        require_once '../views/cart.php';
        break;
    default:
        require_once '../views/catalog.php';
        break;
}

require_once '../views/footer.php';
