<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$is_admin = (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) || 
             (isset($_COOKIE['admin_access']) && $_COOKIE['admin_access'] === 'active_session_verified');

// Инициализация перевода
$lang_file = __DIR__ . "/../languages/ru.php";
$trans = file_exists($lang_file) ? require $lang_file : [];
if (!function_exists('__')) {
    function __($key) {
        global $trans;
        return $trans[$key] ?? $key;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Орбитальная Система | Luxury Light</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; color: #0F172A; min-height: 100vh; }
        .luxury-card { background: white; border: 1px solid #E2E8F0; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); transition: all 0.3s ease; }
        .luxury-card:hover { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); transform: translateY(-2px); }
        ::selection { background: #4F46E5; color: #ffffff; }
    </style>
</head>
<body class="antialiased bg-slate-50 text-slate-900">

<nav class="sticky top-0 w-full z-50 bg-white/90 backdrop-blur-md border-b border-slate-200">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <a href="/" class="text-xl font-extrabold tracking-tight flex items-center gap-2">
            <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white text-lg">O</div>
            ORBITAL<span class="text-indigo-600 uppercase">System</span>
        </a>

        <div class="flex items-center gap-8">
            <a href="?page=catalog" class="text-xs font-bold uppercase tracking-widest text-slate-600 hover:text-indigo-600 transition-colors">КАТАЛОГ</a>

            <?php if ($is_admin): ?>
                <a href="?page=admin_products" class="text-xs font-bold uppercase tracking-widest text-indigo-600 border-b-2 border-indigo-600">ТОВАРЫ</a>
                <a href="?page=admin_orders" class="text-xs font-bold uppercase tracking-widest text-indigo-600">ЗАКАЗЫ</a>
                <a href="?logout=1" class="text-xs font-bold uppercase tracking-widest text-red-500 font-black ml-4">ВЫХОД [X]</a>
            <?php else: ?>
                <a href="?page=admin_login" class="text-xs font-bold uppercase tracking-widest text-slate-400 hover:text-indigo-600 border-l border-slate-200 pl-8">ВХОД</a>
            <?php endif; ?>

            <a href="?page=cart" class="bg-slate-900 text-white px-6 py-2 rounded-full text-xs font-bold uppercase tracking-widest hover:bg-indigo-600 transition-all">
                КОРЗИНА (<?= array_sum($_SESSION['cart'] ?? []) ?>)
            </a>
        </div>
    </div>
</nav>

<main class="container mx-auto px-6 pt-12 pb-24">
