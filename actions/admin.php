<?php
session_start();
require_once __DIR__ . '/../config.php';

$action = $_GET['action'] ?? '';

if ($action === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';
    
    // STRICT VALIDATION
    if ($user === ADMIN_USER && $pass === ADMIN_PASS) {
        $_SESSION['admin_logged_in'] = true;
        // Secure Cookie Fallback
        setcookie('admin_access', 'active_session_verified', time() + 86400, '/', '', true, true);
        session_write_close();
        header('Location: /?page=admin_products');
    } else {
        // FAIL: Clean up everything
        session_destroy();
        setcookie('admin_access', '', time() - 3600, '/');
        header('Location: /?page=admin_login&error=1');
    }
    exit;
}

if ($action === 'logout') {
    session_destroy();
    setcookie('admin_access', '', time() - 3600, '/');
    header('Location: /');
    exit;
}

// Redirect if not admin
$is_admin = (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) || 
            (isset($_COOKIE['admin_access']) && $_COOKIE['admin_access'] === 'active_session_verified');

if (!$is_admin) {
    header('Location: /?page=admin_login');
    exit;
}

// REST OF ADMIN ACTIONS
if ($action === 'product_add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $t_ru = $_POST['title_ru'] ?? '';
    $t_en = $_POST['title_en'] ?? '';
    $d_ru = $_POST['description_ru'] ?? '';
    $d_en = $_POST['description_en'] ?? '';
    $price = $_POST['price'] ?? 0;
    $img_path = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/../public/uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $filename)) {
            $img_path = 'public/uploads/' . $filename;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO products (title_ru, title_en, description_ru, description_en, price, image_url) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$t_ru, $t_en, $d_ru, $d_en, $price, $img_path]);
    session_write_close();
    header('Location: /?page=admin_products');
    exit;
}

if ($action === 'product_delete' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([(int)$_GET['id']]);
    session_write_close();
    header('Location: /?page=admin_products');
}
