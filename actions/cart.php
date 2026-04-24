<?php
// Called from api/index.php — session & config already loaded

$action = $_GET['action'] ?? '';
$id = (int)($_GET['id'] ?? 0);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle AJAX get request
if ($action === 'get') {
    $items = [];
    if (!empty($_SESSION['cart'])) {
        $ids = array_keys($_SESSION['cart']);
        $placeholders = str_repeat('?,', count($ids) - 1) . '?';
        $stmt = $pdo->prepare("SELECT id, COALESCE(title_ru, name) as title, price FROM products WHERE id IN ($placeholders)");
        $stmt->execute($ids);
        $products = $stmt->fetchAll();
        foreach ($products as $p) {
            $items[] = [
                'id' => $p['id'],
                'title' => $p['title'],
                'price' => (float)$p['price'],
                'quantity' => $_SESSION['cart'][$p['id']]
            ];
        }
    }
    header('Content-Type: application/json');
    echo json_encode(['items' => $items, 'count' => array_sum($_SESSION['cart'])]);
    exit;
}

// Delete entire item from cart
if ($action === 'delete_item' && $id > 0) {
    $id_key = (string)$id;
    unset($_SESSION['cart'][$id_key]);
    setcookie('cart_storage', json_encode($_SESSION['cart']), time() + 86400 * 30, '/');
    session_write_close();
    
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'count' => array_sum($_SESSION['cart'])]);
        exit;
    }
    header('Location: /?page=cart');
    exit;
}

if ($id > 0) {
    $id_key = (string)$id;
    if ($action === 'add') {
        if (isset($_SESSION['cart'][$id_key])) {
            $_SESSION['cart'][$id_key]++;
        } else {
            $_SESSION['cart'][$id_key] = 1;
        }
    }

    if ($action === 'remove') {
        if (isset($_SESSION['cart'][$id_key])) {
            if ($_SESSION['cart'][$id_key] > 1) {
                $_SESSION['cart'][$id_key]--;
            } else {
                unset($_SESSION['cart'][$id_key]);
            }
        }
    }
}

// Save cookie for Vercel
setcookie('cart_storage', json_encode($_SESSION['cart']), time() + 86400 * 30, '/');
session_write_close();

// AJAX response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'count' => array_sum($_SESSION['cart'])]);
    exit;
}

// Validate referer for redirect
$referer = $_SERVER['HTTP_REFERER'] ?? '/?page=catalog';
$parsed = parse_url($referer);
$host = $parsed['host'] ?? '';
$serverHost = $_SERVER['HTTP_HOST'] ?? '';
if ($host && $host !== $serverHost) {
    $referer = '/?page=catalog';
}

header("Location: $referer");
exit;
