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
    <title>Орбитальная Система | Luxury</title>
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
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }

        .luxury-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .btn-luxury {
            background-color: #0F172A;
            color: white;
            transition: all 0.2s ease;
        }

        .btn-luxury:hover {
            background-color: #1E293B;
            transform: translateY(-1px);
        }

        .btn-indigo {
            background-color: #4F46E5;
            color: white;
            transition: all 0.2s ease;
        }

        .btn-indigo:hover {
            background-color: #4338CA;
        }
        
        ::selection { background: #4F46E5; color: #ffffff; }
    </style>
</head>
<body class="antialiased">
<nav class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md border-b border-slate-200">
    <div class="container mx-auto px-8 py-5 flex justify-between items-center">
        <a href="/" class="text-xl font-extrabold tracking-tight flex items-center gap-3">
            <span class="w-1.5 h-6 bg-indigo-600 rounded-full"></span>
            ORBITAL<span class="text-indigo-600">SYSTEM</span>
        </a>
        <div class="flex items-center space-x-10">
            <a href="/?page=catalog" class="text-xs font-semibold uppercase tracking-widest text-slate-600 hover:text-indigo-600 transition-colors">
                <?= __('nav_catalog') ?>
            </a>
            
            <?php if (isset($_SESSION['admin_logged_in'])): ?>
                <a href="/?page=admin_products" class="text-xs font-semibold uppercase tracking-widest text-slate-600 hover:text-indigo-600 transition-colors">
                    <?= __('nav_admin') ?>
                </a>
                <a href="/?page=admin_orders" class="text-xs font-semibold uppercase tracking-widest text-slate-600 hover:text-indigo-600 transition-colors">
                    <?= __('nav_orders') ?>
                </a>
                <a href="actions/admin.php?action=logout" class="text-xs font-semibold uppercase tracking-widest text-slate-400 hover:text-red-500 transition-colors">
                    <?= __('nav_exit') ?>
                </a>
            <?php else: ?>
                <a href="/?page=admin_login" class="text-xs font-semibold uppercase tracking-widest text-slate-400 hover:text-indigo-600 transition-colors border-l border-slate-200 pl-10">ВХОД</a>
            <?php endif; ?>

            <a href="/?page=cart" class="btn-luxury px-8 py-2.5 text-[11px] font-bold uppercase tracking-widest rounded-full relative group">
                <?= __('nav_cart') ?>
                <span id="cartCount" class="absolute -top-1.5 -right-1.5 bg-indigo-600 text-white text-[9px] w-5 h-5 flex items-center justify-center font-bold rounded-full shadow-lg"><?= array_sum($_SESSION['cart'] ?? []) ?></span>
            </a>
        </div>
    </div>
</nav>
<main class="container mx-auto px-8 pt-40 pb-20">
