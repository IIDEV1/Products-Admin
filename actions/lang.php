<?php
// Called from api/index.php — session already started

if (isset($_GET['l']) && in_array($_GET['l'], ['ru', 'en'])) {
    $_SESSION['lang'] = $_GET['l'];
}

// Validate referer
$referer = $_SERVER['HTTP_REFERER'] ?? '/';
$parsed = parse_url($referer);
$host = $parsed['host'] ?? '';
$serverHost = $_SERVER['HTTP_HOST'] ?? '';
if ($host && $host !== $serverHost) {
    $referer = '/';
}

session_write_close();
header("Location: $referer");
exit;