<?php
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll();
?>

<div class="breadcrumbs">
    <a href="/"><?= __('nav_home') ?></a>
    <span class="separator">›</span>
    <span class="current"><?= __('nav_catalog') ?></span>
</div>

<div class="mb-12">
    <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight text-slate-900 mb-2"><?= __('nav_catalog') ?></h1>
    <p class="text-slate-500 font-medium text-sm md:text-base"><?= __('catalog_desc') ?></p>
</div>

<div class="bg-white p-4 md:p-6 rounded-2xl mb-12 flex flex-col md:flex-row gap-4 items-center shadow-sm border border-slate-200">
    <div class="flex-grow w-full relative">
        <input type="text" id="catalogSearch" placeholder="<?= __('search_placeholder') ?>" 
               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3.5 text-sm font-medium focus:border-indigo-600 outline-none transition-all">
    </div>
    <div class="flex gap-2 w-full md:w-auto">
        <input type="number" id="priceMin" placeholder="<?= __('price_min') ?>" 
               class="w-full md:w-24 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-medium outline-none focus:border-indigo-600">
        <input type="number" id="priceMax" placeholder="<?= __('price_max') ?>" 
               class="w-full md:w-24 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-medium outline-none focus:border-indigo-600">
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8" id="productGrid">
    <?php if (empty($products)): ?>
        <div class="col-span-full py-32 text-center bg-white rounded-3xl border-2 border-dashed border-slate-200">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <p class="text-slate-400 text-sm font-bold uppercase tracking-widest"><?= __('empty_catalog') ?></p>
        </div>
    <?php endif; ?>
    <?php foreach ($products as $product): ?>
        <div class="bg-white rounded-2xl flex flex-col overflow-hidden group border border-slate-200 hover:shadow-lg transition-all duration-300" 
             data-title="<?= strtolower(htmlspecialchars($product['title_ru'] ?? $product['name'] ?? '')) ?>" 
             data-price="<?= (float)$product['price'] ?>">
            
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
                
                <p class="text-slate-500 text-xs line-clamp-2 mb-6 font-medium leading-relaxed">
                    <?= htmlspecialchars($product['description_ru'] ?: __('no_description')) ?>
                </p>

                <div class="mt-auto flex items-center justify-between">
                    <span class="text-lg font-extrabold text-slate-900 tracking-tight"><?= number_format($product['price'], 0, '.', ' ') ?> ₽</span>
                    <a href="/?action=add&id=<?= $product['id'] ?>" 
                       class="add-to-cart-btn bg-indigo-600 text-white px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-slate-900 transition-all active:scale-95 shadow-sm"
                       data-id="<?= $product['id'] ?>">
                        <?= __('btn_add_cart') ?>
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
const catalogSearch = document.getElementById('catalogSearch');
const priceMin = document.getElementById('priceMin');
const priceMax = document.getElementById('priceMax');
const cards = document.querySelectorAll('#productGrid > div[data-title]');

function filterProducts() {
    const query = catalogSearch.value.toLowerCase();
    const min = parseFloat(priceMin.value) || 0;
    const max = parseFloat(priceMax.value) || Infinity;

    cards.forEach(card => {
        const title = card.getAttribute('data-title') || '';
        const price = parseFloat(card.getAttribute('data-price'));
        const matchesSearch = title.includes(query);
        const matchesPrice = price >= min && price <= max;
        card.style.display = (matchesSearch && matchesPrice) ? '' : 'none';
    });
}

if (catalogSearch && priceMin && priceMax) {
    [catalogSearch, priceMin, priceMax].forEach(el => el.addEventListener('input', filterProducts));
}
</script>
