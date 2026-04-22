<?php
// Инициализация системы перевода
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
    <title>Орбитальная Система | Luxury Light</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #F8FAFC; 
            color: #0F172A; 
            min-height: 100vh;
        }

        .luxury-card {
            background: white;
            border: 1px solid #E2E8F0;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .luxury-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }

        .btn-indigo {
            background-color: #4F46E5;
            color: white;
            transition: all 0.2s ease;
        }

        .btn-indigo:hover {
            background-color: #4338CA;
            transform: translateY(-1px);
        }
        
        ::selection { background: #4F46E5; color: #ffffff; }

        .nav-link {
            position: relative;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: #4F46E5;
            transition: width 0.3s ease;
        }
        .nav-link:hover::after {
            width: 100%;
        }
    </style>
</head>
<body class="antialiased text-slate-900 bg-slate-50">
<nav class="sticky top-0 w-full z-50 bg-white/90 backdrop-blur-md border-b border-slate-200">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <a href="/" class="text-xl font-extrabold tracking-tight flex items-center gap-2">
            <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white text-lg">O</div>
            ORBITAL<span class="text-indigo-600">SYSTEM</span>
        </a>
        <div class="flex items-center space-x-8">
            <a href="/?page=catalog" class="nav-link text-xs font-bold uppercase tracking-widest text-slate-600 hover:text-indigo-600 transition-colors">
                <?= __('nav_catalog') ?>
            </a>
            
            <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
                <a href="/?page=admin_products" class="nav-link text-xs font-bold uppercase tracking-widest text-slate-600 hover:text-indigo-600 transition-colors">
                    <?= __('nav_admin') ?>
                </a>
                <a href="/?page=admin_orders" class="nav-link text-xs font-bold uppercase tracking-widest text-slate-600 hover:text-indigo-600 transition-colors">
                    <?= __('nav_orders') ?>
                </a>
                <a href="/?logout=1" class="text-xs font-bold uppercase tracking-widest text-slate-400 hover:text-red-500 transition-colors border-l border-slate-200 pl-8">
                    <?= __('nav_exit') ?>
                </a>
            <?php else: ?>
                <a href="/?page=admin_login" class="nav-link text-xs font-bold uppercase tracking-widest text-slate-500 hover:text-indigo-600 transition-colors border-l border-slate-200 pl-8">ВХОД</a>
            <?php endif; ?>

            <a href="/?page=cart" class="flex items-center gap-2 bg-slate-900 text-white px-6 py-2.5 rounded-full text-xs font-bold uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-md relative group">
                <?= __('nav_cart') ?>
                <span id="cartCount" class="bg-indigo-600 text-white text-[10px] w-5 h-5 flex items-center justify-center font-bold rounded-full group-hover:scale-110 transition-transform"><?= array_sum($_SESSION['cart'] ?? []) ?></span>
            </a>
        </div>
    </div>
</nav>
<main class="container mx-auto px-6 pt-12 pb-24">
