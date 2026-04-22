<?php
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: /?page=catalog');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    header('Location: /?page=catalog');
    exit;
}

$current_title = $product['title_ru'] ?? $product['title'] ?? 'Без названия';
$current_desc = $product['description_ru'] ?? $product['description'] ?? 'Описание отсутствует';
?>

<div class="max-w-6xl mx-auto">
    <div class="luxury-card rounded-3xl overflow-hidden flex flex-col md:flex-row bg-white">
        <div class="md:w-1/2 aspect-square bg-slate-50">
            <img src="<?= htmlspecialchars($product['image_url'] ?: 'https://via.placeholder.com/800') ?>" 
                 alt="<?= htmlspecialchars($current_title) ?>" 
                 class="w-full h-full object-cover">
        </div>

        <div class="md:w-1/2 p-12 flex flex-col">
            <div class="mb-10">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-1.5 h-6 bg-indigo-600 rounded-full"></div>
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-[0.4em]"><?= __('asset_spec') ?></span>
                </div>
                <h1 class="text-4xl font-extrabold text-slate-900 uppercase tracking-tight leading-tight mb-6"><?= htmlspecialchars($current_title) ?></h1>
                <div class="inline-flex items-baseline gap-2">
                    <span class="text-4xl font-extrabold text-indigo-600 tracking-tighter"><?= number_format($product['price'], 0, '.', ' ') ?></span>
                    <span class="text-lg font-bold text-slate-400 uppercase tracking-widest italic">฿</span>
                </div>
            </div>

            <div class="flex-grow">
                <h4 class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-4 border-b border-slate-100 pb-2"><?= __('manifest_desc') ?></h4>
                <div class="text-slate-600 text-sm leading-relaxed font-medium">
                    <?= nl2br(htmlspecialchars($current_desc)) ?>
                </div>
            </div>

            <div class="mt-12">
                <a href="actions/cart.php?action=add&id=<?= $product['id'] ?>" 
                   class="btn-luxury w-full flex items-center justify-center gap-4 py-5 rounded-2xl text-xs font-bold uppercase tracking-widest shadow-xl shadow-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <?= __('transfer_to_bag') ?>
                </a>
            </div>
        </div>
    </div>
    
    <div class="mt-12 flex items-center justify-between">
        <a href="/?page=catalog" class="text-xs font-bold text-slate-400 hover:text-indigo-600 transition-colors flex items-center gap-3">
            <span>←</span> <?= __('return_to_registry') ?>
        </a>
        <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest"><?= __('sector') ?>: 07-B</span>
    </div>
</div>
