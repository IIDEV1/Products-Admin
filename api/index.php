<?php 
if (session_status() === PHP_SESSION_NONE) {
    if (strpos(php_uname(), 'Linux') !== false || getenv('VERCEL')) {
        session_save_path('/tmp');
    }
    session_start(); 
}

// Cart sync with COOKIE for Vercel
if (empty($_SESSION['cart']) && !empty($_COOKIE['cart_storage'])) {
    $_SESSION['cart'] = json_decode($_COOKIE['cart_storage'], true) ?: [];
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Admin check — SESSION only, no cookie bypass
$is_admin = (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true);

require_once __DIR__ . '/../config.php';

$action = $_GET['action'] ?? '';
$page = $_GET['page'] ?? 'landing';

// Action handling
if ($action !== '') {
    if (in_array($action, ['add', 'remove', 'get', 'delete_item'])) {
        require_once __DIR__ . '/../actions/cart.php';
    } elseif ($action === 'checkout') {
        require_once __DIR__ . '/../actions/checkout.php';
    } elseif ($action === 'lang') {
        require_once __DIR__ . '/../actions/lang.php';
    } else {
        require_once __DIR__ . '/../actions/admin.php';
    }
    exit; 
}

// Admin page protection
if (str_starts_with($page, 'admin_') && $page !== 'admin_login' && !$is_admin) {
    header('Location: /?page=admin_login');
    exit;
}

// Dynamic title
$page_title = page_title($page);

require_once __DIR__ . '/../views/header.php';

switch ($page) {
    case 'landing':
        require_once __DIR__ . '/../views/landing.php';
        break;
    case 'catalog':
        require_once __DIR__ . '/../views/catalog.php';
        break;
    case 'admin_login':
        require_once __DIR__ . '/../views/admin_login.php';
        break;
    case 'admin_dashboard':
        require_once __DIR__ . '/../views/admin_dashboard.php';
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
    case 'order_success':
        require_once __DIR__ . '/../views/order_success.php';
        break;
    default:
        require_once __DIR__ . '/../views/404.php';
        break;
}

require_once __DIR__ . '/../views/footer.php';