<?php
// Called from api/index.php — session & config already loaded

$action = $_GET['action'] ?? '';

// --- 1. LOGIN ---
if ($action === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        header('Location: /?page=admin_login&error=csrf');
        exit;
    }
    $user = $_POST['username'] ?? '';
    $pass_input = $_POST['password'] ?? '';
    
    if ($user === ADMIN_USER && password_verify($pass_input, ADMIN_PASS_HASH)) {
        $_SESSION['admin_logged_in'] = true;
        session_write_close();
        header('Location: /?page=admin_dashboard');
    } else {
        header('Location: /?page=admin_login&error=1');
    }
    exit;
}

// --- 2. LOGOUT ---
if ($action === 'logout') {
    session_destroy();
    header('Location: /');
    exit;
}

// Admin guard for everything below
if (!isset($is_admin) || !$is_admin) {
    header('Location: /?page=admin_login');
    exit;
}

// --- 3. ADD PRODUCT ---
if ($action === 'product_add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        header('Location: /?page=admin_products');
        exit;
    }
    $t_ru = trim($_POST['title_ru'] ?? '');
    $d_ru = trim($_POST['description_ru'] ?? '');
    $price = max(0, (float)($_POST['price'] ?? 0));
    $img_url = trim($_POST['image_url'] ?? '');

    if ($t_ru && $price > 0) {
        $stmt = $pdo->prepare("INSERT INTO products (name, title_ru, description_ru, price, image_url) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$t_ru, $t_ru, $d_ru, $price, $img_url]);
    }
    
    session_write_close();
    header('Location: /?page=admin_products');
    exit;
}

// --- 4. DELETE PRODUCT (POST only) ---
if ($action === 'product_delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        header('Location: /?page=admin_products');
        exit;
    }
    $id = (int)($_POST['id'] ?? 0);
    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);
    }
    session_write_close();
    header('Location: /?page=admin_products');
    exit;
}

// --- 5. EDIT PRODUCT ---
if ($action === 'product_edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        header('Location: /?page=admin_products');
        exit;
    }
    $id = (int)$_POST['id'];
    $t_ru = trim($_POST['title_ru'] ?? '');
    $d_ru = trim($_POST['description_ru'] ?? '');
    $price = max(0, (float)($_POST['price'] ?? 0));
    $img_url = trim($_POST['image_url'] ?? '');
    
    if ($id > 0 && $t_ru && $price > 0) {
        $stmt = $pdo->prepare("UPDATE products SET name = ?, title_ru = ?, description_ru = ?, price = ?, image_url = ? WHERE id = ?");
        $stmt->execute([$t_ru, $t_ru, $d_ru, $price, $img_url, $id]);
    }
    
    session_write_close();
    header('Location: /?page=admin_products');
    exit;
}

// --- 6. CHANGE ORDER STATUS ---
if ($action === 'order_status' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        header('Location: /?page=admin_orders');
        exit;
    }
    $id = (int)($_POST['id'] ?? 0);
    $status = $_POST['status'] ?? '';
    if ($id > 0 && in_array($status, ['new', 'completed'])) {
        $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
    }
    session_write_close();
    header('Location: /?page=admin_orders');
    exit;
}