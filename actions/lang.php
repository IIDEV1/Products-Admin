<?php
session_start();

if (isset($_GET['l']) && in_array($_GET['l'], ['ru', 'en'])) {
    $_SESSION['lang'] = $_GET['l'];
}

$referer = $_SERVER['HTTP_REFERER'] ?? '../index.php';
header("Location: $referer");
exit;