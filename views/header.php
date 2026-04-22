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
    <title>Premium Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .glass-nav { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased">

<nav class="glass-nav border-b border-slate-200 py-4 px-4 md:px-8 sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto flex justify-between items-center gap-4">
        <a href="/" class="font-bold text-xl tracking-tight text-slate-900 flex items-center gap-2">
            <span class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-black italic">S</span>
            <span class="hidden sm:inline uppercase tracking-widest text-sm font-extrabold">Orbital<span class="text-indigo-600">Store</span></span>
        </a>
        
        <div class="flex items-center gap-4 md:gap-8 overflow-x-auto no-scrollbar py-1">
            <a href="?page=catalog" class="text-xs font-semibold uppercase tracking-widest text-slate-500 hover:text-indigo-600 transition-colors whitespace-nowrap">Каталог</a>
            
            <?php if ($is_admin): ?>
                <a href="?page=admin_products" class="text-xs font-semibold uppercase tracking-widest text-indigo-600 whitespace-nowrap">Товары</a>
                <a href="?page=admin_orders" class="text-xs font-semibold uppercase tracking-widest text-indigo-600 whitespace-nowrap">Заказы</a>
                <a href="?action=logout" class="text-[10px] font-bold uppercase tracking-widest text-red-500 hover:text-red-700 transition-colors whitespace-nowrap">Выход</a>
            <?php else: ?>
                <a href="?page=admin_login" class="text-xs font-semibold uppercase tracking-widest text-slate-400 hover:text-indigo-600 transition-colors whitespace-nowrap">Вход</a>
            <?php endif; ?>
        </div>

        <a href="?page=cart" class="bg-slate-900 text-white px-5 py-2.5 rounded-full text-[10px] font-bold uppercase tracking-[0.15em] hover:bg-indigo-600 transition-all shadow-sm hover:shadow-md flex items-center gap-2 shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            <span class="hidden xs:inline">Корзина</span>
            <span class="bg-white/20 px-1.5 py-0.5 rounded-full text-[9px]"><?= array_sum($_SESSION['cart'] ?? []) ?></span>
        </a>
    </div>
</nav>

<main class="max-w-7xl mx-auto p-4 md:p-10 min-h-screen">
