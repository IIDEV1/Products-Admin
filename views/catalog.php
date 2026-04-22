<?php
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll();
?>

<div class="max-w-4xl mx-auto text-center mb-24">
    <h1 class="text-6xl font-extrabold tracking-tight text-slate-900 mb-6">
        <?= __('nav_catalog') ?>
    </h1>
    <p class="text-slate-500 text-lg max-w-2xl mx-auto leading-relaxed">
        Откройте для себя нашу эксклюзивную коллекцию орбитальных активов, разработанную для самых требовательных секторов.
    </p>
</div>

<div class="luxury-card rounded-2xl p-8 mb-20 flex flex-wrap gap-8 items-center bg-white">
    <div class="flex-grow max-w-xl relative">
        <input type="text" id="catalogSearch" placeholder="<?= __('search_placeholder') ?>" 
               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-6 py-4 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all">
    </div>
    <div class="flex gap-4">
        <input type="number" id="priceMin" placeholder="МИН" 
               class="w-28 bg-slate-50 border border-slate-200 rounded-xl px-4 py-4 text-sm font-medium outline-none">
        <input type="number" id="priceMax" placeholder="МАКС" 
               class="w-28 bg-slate-50 border border-slate-200 rounded-xl px-4 py-4 text-sm font-medium outline-none">
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10" id="productGrid">
    <?php foreach ($products as $i => $product): ?>
        <div class="luxury-card group rounded-2xl flex flex-col p-5 bg-white overflow-hidden" 
             data-title="<?= strtolower(htmlspecialchars($product['title_ru'])) ?>" 
             data-price="<?= (float)$product['price'] ?>">
            
            <a href="/?page=product&id=<?= $product['id'] ?>" class="block aspect-square overflow-hidden rounded-xl bg-slate-100 mb-6">
                <img src="<?= htmlspecialchars($product['image_url'] ?: 'https://via.placeholder.com/600x600') ?>" 
                     alt="<?= htmlspecialchars($product['title_ru']) ?>" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
            </a>
            
            <div class="flex-grow flex flex-col px-2">
                <a href="/?page=product&id=<?= $product['id'] ?>">
                    <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-indigo-600 transition-colors">
                        <?= htmlspecialchars($product['title_ru']) ?>
                    </h3>
                </a>
                
                <p class="text-slate-500 text-xs line-clamp-2 mb-6 leading-relaxed">
                    <?= htmlspecialchars($product['description_ru'] ?: 'Описание отсутствует') ?>
                </p>

                <div class="mt-auto flex items-center justify-between pt-5 border-t border-slate-100">
                    <div class="flex flex-col">
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1"><?= __('valuation') ?></span>
                        <span class="text-xl font-extrabold text-slate-900"><?= number_format($product['price'], 0, '.', ' ') ?> <span class="text-indigo-600"><?= __('currency') ?></span></span>
                    </div>
                    <a href="actions/cart.php?action=add&id=<?= $product['id'] ?>" 
                            class="bg-indigo-600 text-white p-3 rounded-xl hover:bg-slate-900 transition-all active:scale-95 shadow-md shadow-indigo-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
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
const cards = document.querySelectorAll('.luxury-card[data-title]');

function filterProducts() {
    const query = catalogSearch.value.toLowerCase();
    const min = parseFloat(priceMin.value) || 0;
    const max = parseFloat(priceMax.value) || Infinity;

    cards.forEach(card => {
        const title = card.getAttribute('data-title');
        const price = parseFloat(card.getAttribute('data-price'));
        const matchesSearch = title.includes(query);
        const matchesPrice = price >= min && price <= max;
        card.style.display = (matchesSearch && matchesPrice) ? '' : 'none';
    });
}

[catalogSearch, priceMin, priceMax].forEach(el => el.addEventListener('input', filterProducts));
</script>
