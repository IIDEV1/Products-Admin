<?php
require_once '../config.php';

$action = $_GET['action'] ?? '';
$id = (int)($_GET['id'] ?? 0);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($id > 0) {
    if ($action === 'add') {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]++;
        } else {
            $_SESSION['cart'][$id] = 1;
        }
    }

    if ($action === 'remove') {
        if (isset($_SESSION['cart'][$id])) {
            if ($_SESSION['cart'][$id] > 1) {
                $_SESSION['cart'][$id]--;
            } else {
                unset($_SESSION['cart'][$id]);
            }
        }
    }
}

$referer = $_SERVER['HTTP_REFERER'] ?? '../index.php';
header("Location: $referer");
exit;
