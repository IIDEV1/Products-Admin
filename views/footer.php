</main>

<footer class="bg-white border-t border-slate-200 py-16 mt-20">
    <div class="max-w-7xl mx-auto px-4 md:px-8 text-center md:text-left flex flex-col md:flex-row justify-between items-center gap-8">
        <div>
            <div class="font-bold text-xl tracking-tight text-slate-900 flex items-center gap-2 justify-center md:justify-start">
                <span class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-black">O</span>
                <span class="uppercase tracking-widest text-sm font-extrabold">Orbital<span class="text-indigo-600">Store</span></span>
            </div>
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.4em] mt-4">Premium Assets Distribution Network</p>
        </div>
        
        <div class="flex flex-wrap justify-center gap-8">
            <a href="/?page=catalog" class="text-[10px] font-bold uppercase tracking-widest text-slate-500 hover:text-indigo-600 transition-colors"><?= __('nav_catalog') ?></a>
            <a href="/?page=cart" class="text-[10px] font-bold uppercase tracking-widest text-slate-500 hover:text-indigo-600 transition-colors"><?= __('nav_cart') ?></a>
            <?php if ($is_admin): ?>
                <a href="/?page=admin_dashboard" class="text-[10px] font-bold uppercase tracking-widest text-slate-500 hover:text-indigo-600 transition-colors"><?= __('nav_dashboard') ?></a>
            <?php else: ?>
                <a href="/?page=admin_login" class="text-[10px] font-bold uppercase tracking-widest text-slate-500 hover:text-indigo-600 transition-colors"><?= __('nav_login') ?></a>
            <?php endif; ?>
        </div>

        <p class="text-slate-400 text-[9px] font-bold uppercase tracking-[0.3em]">&copy; 2026 ORBITAL SYSTEM. ALL RIGHTS RESERVED.</p>
    </div>
</footer>

<script src="/public/app.js"></script>
</body>
</html>
