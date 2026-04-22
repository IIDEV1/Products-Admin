<?php
session_start();
require_once __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SESSION['cart'])) {
    $name = htmlspecialchars(trim($_POST['customer_name'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['customer_phone'] ?? ''));
    $address = htmlspecialchars(trim($_POST['customer_address'] ?? ''));

    if ($name && $phone && $address) {
        $ids = array_keys($_SESSION['cart']);
        $placeholders = str_repeat('?,', count($ids) - 1) . '?';
        $stmt = $pdo->prepare("SELECT id, price FROM products WHERE id IN ($placeholders)");
        $stmt->execute($ids);
        $products = $stmt->fetchAll();

        $total_price = 0;
        foreach ($products as $product) {
            $total_price += $product['price'] * $_SESSION['cart'][$product['id']];
        }

        $stmt = $pdo->prepare("INSERT INTO orders (customer_name, customer_phone, customer_address, total_amount, status) VALUES (?, ?, ?, ?, 'new')");
        $stmt->execute([$name, $phone, $address, $total_price]);

        unset($_SESSION['cart']);

        session_write_close();
        header('Location: /?page=catalog&order=success');
        exit;
    }
}

session_write_close();
header('Location: /?page=catalog');
exit;
