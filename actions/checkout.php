<?php
// Called from api/index.php — session & config already loaded

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SESSION['cart'])) {
    // CSRF check
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        header('Location: /?page=cart');
        exit;
    }

    $name = trim($_POST['customer_name'] ?? '');
    $phone = trim($_POST['customer_phone'] ?? '');
    $address = trim($_POST['customer_address'] ?? '');

    // Server-side validation
    if (empty($name) || mb_strlen($name) < 2) {
        header('Location: /?page=cart&error=name');
        exit;
    }
    if (empty($phone) || !preg_match('/^[\d\s\+\-\(\)]{7,20}$/', $phone)) {
        header('Location: /?page=cart&error=phone');
        exit;
    }
    if (empty($address) || mb_strlen($address) < 5) {
        header('Location: /?page=cart&error=address');
        exit;
    }

    $ids = array_keys($_SESSION['cart']);
    $placeholders = str_repeat('?,', count($ids) - 1) . '?';
    $stmt = $pdo->prepare("SELECT id, price FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $products = $stmt->fetchAll();

    $total_price = 0;
    foreach ($products as $product) {
        $total_price += $product['price'] * $_SESSION['cart'][$product['id']];
    }

    // Begin transaction
    $pdo->beginTransaction();
    try {
        // Insert order
        $stmt = $pdo->prepare("INSERT INTO orders (customer_name, customer_phone, customer_address, total_amount, status) VALUES (?, ?, ?, ?, 'new')");
        $stmt->execute([$name, $phone, $address, $total_price]);
        $orderId = $pdo->lastInsertId();

        // Insert order items
        $itemStmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($products as $product) {
            $qty = $_SESSION['cart'][$product['id']];
            $itemStmt->execute([$orderId, $product['id'], $qty, $product['price']]);
        }

        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        header('Location: /?page=cart&error=db');
        exit;
    }

    unset($_SESSION['cart']);
    setcookie('cart_storage', '', time() - 3600, '/');

    session_write_close();
    header('Location: /?page=order_success&oid=' . $orderId);
    exit;
}

session_write_close();
header('Location: /?page=cart');
exit;
