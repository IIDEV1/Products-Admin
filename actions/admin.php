<?php
// Вызывается из api/index.php

$action = $_GET['action'] ?? '';

// --- 1. ЛОГИН ---
if ($action === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';
    
    if ($user === 'admin' && $pass === '12345') {
        $_SESSION['admin_logged_in'] = true;
        setcookie('admin_access', 'active_session_verified', time() + 86400, '/', '', true, true);
        session_write_close();
        header('Location: /?page=admin_products');
    } else {
        session_destroy();
        setcookie('admin_access', '', time() - 3600, '/');
        header('Location: /?page=admin_login&error=1');
    }
    exit;
}

// --- 2. ЛОГАУТ ---
if ($action === 'logout') {
    session_destroy();
    setcookie('admin_access', '', time() - 3600, '/');
    header('Location: /');
    exit;
}

// Защита админки
if (!isset($is_admin) || !$is_admin) {
    header('Location: /?page=admin_login');
    exit;
}

// --- 3. ДОБАВЛЕНИЕ ТОВАРА ---
if ($action === 'product_add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $t_ru = $_POST['title_ru'] ?? '';
    $d_ru = $_POST['description_ru'] ?? '';
    $price = (float)($_POST['price'] ?? 0);
    $img_url = $_POST['image_url'] ?? '';

    // ВАЖНО: Добавили колонку 'name', передаем туда $t_ru
    $stmt = $pdo->prepare("INSERT INTO products (name, title_ru, description_ru, price, image_url) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$t_ru, $t_ru, $d_ru, $price, $img_url]);
    
    session_write_close();
    header('Location: /?page=admin_products');
    exit;
}

// --- 4. УДАЛЕНИЕ ТОВАРА ---
if ($action === 'product_delete' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([(int)$_GET['id']]);
    session_write_close();
    header('Location: /?page=admin_products');
    exit;
}

// --- 5. РЕДАКТИРОВАНИЕ ТОВАРА ---
if ($action === 'product_edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $t_ru = $_POST['title_ru'] ?? '';
    $d_ru = $_POST['description_ru'] ?? '';
    $price = (float)($_POST['price'] ?? 0);
    $img_url = $_POST['image_url'] ?? '';
    
    // ВАЖНО: Обновляем и 'name' тоже
    $stmt = $pdo->prepare("UPDATE products SET name = ?, title_ru = ?, description_ru = ?, price = ?, image_url = ? WHERE id = ?");
    $stmt->execute([$t_ru, $t_ru, $d_ru, $price, $img_url, $id]);
    
    session_write_close();
    header('Location: /?page=admin_products');
    exit;
}