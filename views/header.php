<?php 
// МАРКЕР ДЛЯ ПРОВЕРКИ: V5-FORCE-UPDATE
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$is_admin = (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) || 
             (isset($_COOKIE['admin_access']) && $_COOKIE['admin_access'] === 'active_session_verified');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Orbital System v5</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50">

<nav class="bg-white border-b-4 border-indigo-600 py-6 px-10 flex justify-between items-center shadow-2xl sticky top-0 z-50">
    <a href="/" class="font-black text-2xl text-slate-900 uppercase tracking-tighter">
        ORBITAL SYSTEM <span class="text-indigo-600">v5</span>
    </a>
    
    <div class="flex items-center gap-10">
        <a href="?page=catalog" class="font-bold text-slate-600 hover:text-indigo-600 uppercase text-xs tracking-widest transition-colors">КАТАЛОГ</a>
        
        <?php if ($is_admin): ?>
            <!-- ADMIN AUTHORIZED -->
            <a href="?page=admin_products" class="font-bold text-indigo-600 underline uppercase text-xs tracking-widest">ТОВАРЫ</a>
            <a href="?page=admin_orders" class="font-bold text-indigo-600 uppercase text-xs tracking-widest">ЗАКАЗЫ</a>
            <a href="?logout=1" class="font-bold text-red-600 uppercase text-xs tracking-widest">ВЫХОД</a>
        <?php else: ?>
            <!-- GUEST MODE -->
            <a href="?page=admin_login" class="font-bold text-slate-400 hover:text-indigo-600 uppercase text-xs tracking-widest transition-colors">ВХОД</a>
        <?php endif; ?>
        
        <a href="?page=cart" class="bg-indigo-600 text-white px-8 py-3 rounded-xl font-black shadow-lg hover:bg-indigo-700 transition-all uppercase text-xs tracking-widest">
            КОРЗИНА (<?= array_sum($_SESSION['cart'] ?? []) ?>)
        </a>
    </div>
</nav>

<main class="max-w-7xl mx-auto p-10 min-h-screen">
