<?php
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll();
?>

<div class="orb orb-white w-[500px] h-[500px] top-40 left-[-100px] animate-orbital"></div>
<div class="orb orb-orange w-[600px] h-[600px] top-[800px] right-[-200px] animate-orbital-slow" style="animation-delay: -20s"></div>
<div class="orb orb-white w-[400px] h-[400px] top-[1500px] left-[200px] animate-orbital" style="animation-delay: -45s"></div>
<div class="orb orb-orange w-[700px] h-[700px] top-[2200px] right-[100px] animate-orbital-slow" style="animation-delay: -10s"></div>
<div class="orb orb-white w-[500px] h-[500px] top-[3000px] left-[-200px] animate-orbital" style="animation-delay: -70s"></div>
<div class="orb orb-orange w-[450px] h-[450px] top-[3800px] right-[300px] animate-orbital-slow" style="animation-delay: -35s"></div>

<div class="text-center mb-32 relative z-20">
    <h1 class="text-7xl font-black tracking-tighter uppercase mb-8">
        <span class="text-zinc-700">Storage</span><br>
        <span class="bg-gradient-to-r from-white to-zinc-500 bg-clip-text text-transparent">Orbital Buffer</span>
    </h1>
    <div class="flex justify-center items-center gap-6">
        <div class="h-[1px] w-20 bg-orange-600/30"></div>
        <p class="text-orange-500 text-[10px] uppercase tracking-[0.8em] font-black">Secure Matrix Interface</p>
        <div class="h-[1px] w-20 bg-orange-600/30"></div>
    </div>
</div>

<div class="flex flex-wrap gap-8 items-center bg-[#0d0d0d]/80 backdrop-blur-xl border border-white/5 p-10 rounded-sm mb-32 relative z-20">
    <div class="flex-grow max-w-2xl relative">
        <input type="text" id="catalogSearch" placeholder="<?= __('search_placeholder') ?>" 
               class="w-full bg-black border border-white/10 text-white px-8 py-5 text-[10px] font-bold uppercase tracking-[0.4em] outline-none focus:border-orange-600/50 transition-all">
    </div>
    <div class="flex gap-6">
        <input type="number" id="priceMin" placeholder="MIN" 
               class="w-32 bg-black border border-white/10 text-white px-6 py-5 text-[10px] font-bold uppercase tracking-widest outline-none focus:border-orange-600/50 transition-all">
        <input type="number" id="priceMax" placeholder="MAX" 
               class="w-32 bg-black border border-white/10 text-white px-6 py-5 text-[10px] font-bold uppercase tracking-widest outline-none focus:border-orange-600/50 transition-all">
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-12 relative z-20" id="productGrid">
    <?php foreach ($products as $i => $product): ?>
        <?php 
            $lang = $_SESSION['lang'] ?? 'ru';

            // Безопасное получение названия
            $title_ru = $product['title_ru'] ?? $product['title'] ?? 'Без названия';
            $title_en = $product['title_en'] ?? '';
            $current_title = ($lang === 'en' && !empty($title_en)) ? $title_en : $title_ru;

            // Безопасное получение описания
            $desc_ru = $product['description_ru'] ?? $product['description'] ?? '';
            $desc_en = $product['description_en'] ?? '';
            $current_desc = ($lang === 'en' && !empty($desc_en)) ? $desc_en : $desc_ru;
        ?>
        <div class="product-card group relative flex flex-col bg-[#1a1a1a] border border-white/20 hover:border-orange-500/50 transition-all duration-700 p-6 hover:shadow-[0_0_50px_rgba(234,88,12,0.15)]" 
             style="animation: fadeUp 1s ease-out forwards; animation-delay: <?= 0.05 * $i ?>s; opacity: 0;"
             data-title="<?= strtolower(htmlspecialchars($current_title)) ?>" 
             data-price="<?= (float)$product['price'] ?>">
            
            <a href="?page=product&id=<?= $product['id'] ?>" class="block aspect-square overflow-hidden bg-black mb-8 relative border border-white/10">
                <img src="<?= htmlspecialchars($product['image_url'] ?: 'https://via.placeholder.com/600x600') ?>" 
                     alt="<?= htmlspecialchars($current_title) ?>" 
                     class="w-full h-full object-cover grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-1000 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-60"></div>
            </a>
            
            <div class="flex-grow flex flex-col">
                <a href="?page=product&id=<?= $product['id'] ?>" class="block">
                    <h3 class="text-xl font-bold text-white group-hover:text-orange-500 transition-colors mb-3 uppercase tracking-tight">
                        <?= htmlspecialchars($current_title) ?>
                    </h3>
                </a>
                
                <p class="text-xs text-zinc-400 line-clamp-3 mb-8 leading-relaxed">
                    <?= htmlspecialchars($current_desc) ?>
                </p>

                <div class="mt-auto flex items-end justify-between border-t border-white/5 pt-6">
                    <div class="flex flex-col">
                        <span class="text-[9px] text-zinc-600 uppercase tracking-widest font-black mb-1">ЦЕНА</span>
                        <span class="text-2xl font-black text-white tracking-tighter"><?= number_format($product['price'], 0, '.', ' ') ?> <span class="text-orange-600"><?= __('currency') ?></span></span>
                    </div>
                    <a href="actions/cart.php?action=add&id=<?= $product['id'] ?>" 
                            class="bg-orange-600 text-white text-[9px] font-black uppercase tracking-[0.3em] py-4 px-8 hover:bg-white hover:text-black transition-all active:scale-95 text-center">
                        Корзина 
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
const cards = document.querySelectorAll('.product-card');

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