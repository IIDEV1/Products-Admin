<?php
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 8");
$featured = $stmt->fetchAll();
$countStmt = $pdo->query("SELECT COUNT(*) as total FROM products");
$totalProducts = $countStmt->fetch()['total'] ?? 0;
?>

<div class="hero-gradient rounded-3xl p-8 md:p-16 lg:p-20 mb-16 relative overflow-hidden fade-in-up">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 left-10 w-72 h-72 bg-indigo-500 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-purple-500 rounded-full blur-3xl"></div>
    </div>
    <div class="relative z-10 max-w-3xl">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-1.5 h-8 bg-indigo-500 rounded-full"></div>
            <span class="text-[10px] text-indigo-400 font-extrabold uppercase tracking-[0.4em]"><?= __('premium_network') ?></span>
        </div>
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white tracking-tight leading-[1.1] mb-6">
            <?= __('hero_title_1') ?><br>
            <span class="hero-gradient-accent"><?= __('hero_title_2') ?></span>
        </h1>
        <p class="text-slate-400 text-sm md:text-base font-medium mb-10 max-w-lg leading-relaxed">
            <?= __('hero_desc') ?>
        </p>
        <div class="flex flex-wrap gap-4">
            <a href="/?page=catalog" class="bg-indigo-600 text-white px-8 py-4 rounded-xl text-[11px] font-bold uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-900/30 active:scale-95">
                <?= __('hero_cta') ?>
            </a>
            <div class="flex items-center gap-3 px-6 py-4 bg-white/5 rounded-xl border border-white/10">
                <span class="text-3xl font-extrabold text-white"><?= $totalProducts ?></span>
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest"><?= __('hero_products_count') ?></span>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-16">
    <div class="stat-card text-center p-6">
        <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        </div>
        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest"><?= __('advantage_delivery') ?></div>
    </div>
    <div class="stat-card text-center p-6">
        <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        </div>
        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest"><?= __('advantage_guarantee') ?></div>
    </div>
    <div class="stat-card text-center p-6">
        <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
        </div>
        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest"><?= __('advantage_fast') ?></div>
    </div>
    <div class="stat-card text-center p-6">
        <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
        </div>
        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest"><?= __('advantage_quality') ?></div>
    </div>
</div>

<?php if (!empty($featured)): ?>
<div class="mb-16">
    <div class="flex items-end justify-between mb-10">
        <div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight"><?= __('featured_title') ?></h2>
            <p class="text-slate-500 text-sm font-medium mt-1"><?= __('featured_desc') ?></p>
        </div>
        <a href="/?page=catalog" class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest hover:text-slate-900 transition-colors hidden md:block"><?= __('view_all') ?> →</a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
        <?php foreach ($featured as $product): ?>
            <div class="bg-white rounded-2xl flex flex-col overflow-hidden group border border-slate-200 hover:shadow-lg transition-all duration-300">
                <a href="/?page=product&id=<?= $product['id'] ?>" class="block aspect-[4/5] overflow-hidden bg-slate-100">
                    <img src="<?= htmlspecialchars($product['image_url'] ?: '/public/placeholder.svg') ?>"
                         alt="<?= htmlspecialchars($product['title_ru'] ?? $product['name'] ?? '') ?>"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                         loading="lazy">
                </a>
                <div class="p-6 flex flex-col flex-grow">
                    <a href="/?page=product&id=<?= $product['id'] ?>" class="block mb-2">
                        <h3 class="text-base font-bold text-slate-900 group-hover:text-indigo-600 transition-colors tracking-tight line-clamp-1">
                            <?= htmlspecialchars($product['title_ru'] ?? $product['name'] ?? __('no_title')) ?>
                        </h3>
                    </a>
                    <div class="mt-auto flex items-center justify-between">
                        <span class="text-lg font-extrabold text-slate-900 tracking-tight"><?= number_format($product['price'], 0, '.', ' ') ?> ₽</span>
                        <a href="/?action=add&id=<?= $product['id'] ?>" class="add-to-cart-btn bg-indigo-600 text-white px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-slate-900 transition-all active:scale-95 shadow-sm" data-id="<?= $product['id'] ?>">
                            <?= __('btn_add_cart') ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="text-center mt-8 md:hidden">
        <a href="/?page=catalog" class="text-xs font-bold text-indigo-600 uppercase tracking-widest"><?= __('view_all') ?> →</a>
    </div>
</div>
<?php endif; ?>
