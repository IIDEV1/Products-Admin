<?php 
// V6-SECURE-NAV
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$is_admin = (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) || 
             (isset($_COOKIE['admin_access']) && $_COOKIE['admin_access'] === 'active_session_verified');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orbital System v6</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">

<nav class="bg-white border-b-2 border-slate-200 py-5 px-10 flex justify-between items-center shadow-lg sticky top-0 z-50">
    <a href="/" class="font-black text-2xl tracking-tighter text-slate-900 uppercase">
        ORBITAL SYSTEM <span class="text-indigo-600 font-normal">v6</span>
    </a>
    
    <div class="flex items-center gap-8">
        <a href="?page=catalog" class="text-xs font-bold uppercase tracking-widest text-slate-600 hover:text-indigo-600 transition-colors">КАТАЛОГ</a>
        
        <?php if ($is_admin): ?>
            <!-- ADMIN AUTHORIZED ACCESS -->
            <a href="?page=admin_products" class="text-xs font-bold uppercase tracking-widest text-indigo-600 border-b-2 border-indigo-600">ТОВАРЫ</a>
            <a href="?page=admin_orders" class="text-xs font-bold uppercase tracking-widest text-indigo-600">ЗАКАЗЫ</a>
            <a href="?action=logout" class="text-xs font-bold uppercase tracking-widest text-red-600 font-black ml-4">ВЫХОД [X]</a>
        <?php else: ?>
            <!-- GUEST ACCESS -->
            <a href="?page=admin_login" class="text-xs font-bold uppercase tracking-widest text-slate-400 hover:text-indigo-600 border-l border-slate-200 pl-8 transition-colors">ВХОД</a>
        <?php endif; ?>
        
        <a href="?page=cart" class="bg-slate-900 text-white px-6 py-2.5 rounded-full text-xs font-bold uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-md">
            КОРЗИНА (<?= array_sum($_SESSION['cart'] ?? []) ?>)
        </a>
    </div>
</nav>

<main class="max-w-7xl mx-auto p-10 min-h-screen">
<!-- V6-SECURE-NAV-APPLIED -->
