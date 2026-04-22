<?php
// Инициализация системы перевода (Принудительно RU)
$_SESSION['lang'] = 'ru';
$current_lang = 'ru';
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
    <title>Орбитальная Система</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap');

        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #050505; 
            color: #ffffff; 
            overflow-x: hidden;
            position: relative;
            min-height: 100vh;
        }

        @keyframes orbitalFloat {
            0% { transform: translate(0, 0) scale(1); opacity: 0.1; }
            33% { transform: translate(100px, 200px) scale(1.2); opacity: 0.15; }
            66% { transform: translate(-150px, 100px) scale(0.9); opacity: 0.08; }
            100% { transform: translate(0, 0) scale(1); opacity: 0.1; }
        }

        @keyframes orbitalFloatReverse {
            0% { transform: translate(0, 0) scale(1.1); opacity: 0.08; }
            50% { transform: translate(-200px, -150px) scale(0.8); opacity: 0.12; }
            100% { transform: translate(0, 0) scale(1.1); opacity: 0.08; }
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            pointer-events: none;
            z-index: -1;
            will-change: transform, opacity;
        }

        .orb-white { background-color: rgba(255, 255, 255, 0.05); }
        .orb-orange { background-color: rgba(234, 88, 12, 0.08); }

        .animate-orbital { animation: orbitalFloat 90s infinite ease-in-out; }
        .animate-orbital-slow { animation: orbitalFloatReverse 120s infinite ease-in-out; }

        .cart-modal { transform: translateX(100%); transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
        .cart-modal.open { transform: translateX(0); }
        
        ::selection { background: #ea580c; color: #ffffff; }

        .glass-card {
            background-color: #0d0d0d;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body class="selection:bg-orange-600 selection:text-white">
<nav class="fixed top-0 w-full z-50 bg-black/80 backdrop-blur-xl border-b border-orange-600/20">
    <div class="container mx-auto px-8 py-6 flex justify-between items-center">
        <a href="index.php" class="text-2xl font-black uppercase tracking-tighter italic flex items-center gap-3">
            <span class="w-1 h-8 bg-orange-600"></span>
            ORBITAL<span class="text-orange-500">SYSTEM</span>
        </a>
        <div class="flex items-center space-x-12">
            <a href="?page=catalog" class="text-[10px] uppercase tracking-[0.3em] font-black text-white hover:text-orange-500 transition-colors">
                <?= __('nav_catalog') ?>
            </a>
            
            <?php if (isset($_SESSION['admin_logged_in'])): ?>
                <a href="?page=admin_products" class="text-[10px] uppercase tracking-[0.3em] font-black text-white hover:text-orange-500 transition-colors">
                    <?= __('nav_admin') ?>
                </a>
                <a href="?page=admin_orders" class="text-[10px] uppercase tracking-[0.3em] font-black text-white hover:text-orange-500 transition-colors">
                    <?= __('nav_orders') ?>
                </a>
                <a href="actions/admin.php?action=logout" class="text-[10px] uppercase tracking-[0.3em] font-black text-zinc-600 hover:text-orange-500 transition-colors">
                    <?= __('nav_exit') ?>
                </a>
            <?php else: ?>
                <a href="?page=admin_login" class="text-[10px] uppercase tracking-[0.3em] font-black text-zinc-500 hover:text-orange-500 transition-colors border-l border-white/5 pl-8">LOGIN</a>
            <?php endif; ?>

            <div class="flex items-center bg-[#0d0d0d] border border-white/10 rounded-sm overflow-hidden px-1">
                <a href="actions/lang.php?l=ru" class="px-3 py-2 text-[10px] font-black transition-colors <?= $current_lang === 'ru' ? 'text-orange-600' : 'text-zinc-500 hover:text-white' ?>">RU</a>
                <span class="w-[1px] h-3 bg-white/10"></span>
                <a href="actions/lang.php?l=en" class="px-3 py-2 text-[10px] font-black transition-colors <?= $current_lang === 'en' ? 'text-orange-600' : 'text-zinc-500 hover:text-white' ?>">EN</a>
            </div>

            <a href="?page=cart" class="bg-white text-black px-10 py-3 text-[10px] font-black uppercase tracking-[0.4em] hover:bg-orange-600 hover:text-white transition-all relative group">
                <?= __('nav_cart') ?>
                <span id="cartCount" class="absolute -top-2 -right-2 bg-orange-600 text-white text-[9px] w-5 h-5 flex items-center justify-center font-black rounded-full shadow-xl group-hover:scale-110 transition-transform"><?= array_sum($_SESSION['cart'] ?? []) ?></span>
            </a>
        </div>
    </div>
</nav>
<main class="container mx-auto px-8 relative z-10 pt-48 pb-32">