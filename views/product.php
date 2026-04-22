<?php
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: ?page=catalog');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    header('Location: ?page=catalog');
    exit;
}

$lang = 'ru';
$current_title = $product['title_ru'] ?? $product['title'] ?? 'Без названия';
$current_desc = $product['description_ru'] ?? $product['description'] ?? 'Описание отсутствует';
?>

<div class="max-w-6xl mx-auto py-20 px-6">
    <div class="flex flex-col lg:flex-row gap-16 bg-[#1a1a1a] border border-white/20 p-12 shadow-2xl relative overflow-hidden group">
        <div class="lg:w-1/2">
            <div class="aspect-square bg-black border border-white/10 overflow-hidden relative">
                <img src="<?= htmlspecialchars($product['image_url'] ?: 'https://via.placeholder.com/800') ?>" 
                     alt="<?= htmlspecialchars($current_title) ?>" 
                     class="w-full h-full object-cover grayscale opacity-50 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-1000">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-40"></div>
            </div>
        </div>

        <div class="lg:w-1/2 flex flex-col">
            <div class="mb-10">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-1 h-8 bg-orange-600"></div>
                    <span class="text-[10px] text-zinc-500 font-black uppercase tracking-[0.5em]"><?= __('asset_spec') ?></span>
                </div>
                <h1 class="text-5xl font-black text-white uppercase tracking-tighter leading-none mb-6"><?= htmlspecialchars($current_title) ?></h1>
                <div class="inline-block bg-orange-600/10 border border-orange-600/20 px-6 py-2">
                    <span class="text-3xl font-black text-orange-500 tracking-tighter"><?= number_format($product['price'], 0, '.', ' ') ?> <span class="text-white italic">฿</span></span>
                </div>
            </div>

            <div class="flex-grow">
                <h4 class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-4 border-b border-white/10 pb-2"><?= __('manifest_desc') ?></h4>
                <div class="text-zinc-300 text-sm leading-relaxed uppercase tracking-wide space-y-4">
                    <?= nl2br(htmlspecialchars($current_desc)) ?>
                </div>
            </div>

            <div class="mt-12">
                <a href="actions/cart.php?action=add&id=<?= $product['id'] ?>" 
                   class="inline-block w-full bg-orange-600 text-white text-center py-6 text-xs font-black uppercase tracking-[0.4em] hover:bg-white hover:text-black transition-all shadow-[0_10px_30px_rgba(234,88,12,0.3)] hover:shadow-[0_15px_40px_rgba(234,88,12,0.5)]">
                    <?= __('transfer_to_bag') ?>
                </a>
            </div>
        </div>
        
        <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-orange-600/5 blur-[100px] rounded-full pointer-events-none"></div>
    </div>
    
    <div class="mt-12 flex items-center justify-between">
        <a href="?page=catalog" class="text-[10px] font-black uppercase tracking-widest text-zinc-500 hover:text-orange-500 transition-colors flex items-center gap-4 group">
            <span class="group-hover:-translate-x-2 transition-transform">←</span> <?= __('return_to_registry') ?>
        </a>
        <div class="flex items-center gap-6 opacity-20">
            <div class="w-12 h-[1px] bg-white"></div>
            <span class="text-[8px] font-black text-white uppercase tracking-[0.5em]"><?= __('sector') ?>: 07-B</span>
        </div>
    </div>
</div>
