<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/../config.php';

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
        $stmt = $pdo->prepare("SELECT id, title_ru as title, price FROM products WHERE id IN ($placeholders)");
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
    echo json_encode(['items' => $items]);
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

session_write_close();
$referer = $_SERVER['HTTP_REFERER'] ?? '/?page=catalog';
header("Location: $referer");
exit;
