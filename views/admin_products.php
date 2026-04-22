<?php
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll();
?>
<div class="pt-32 mb-16 flex justify-between items-end border-b border-white/5 pb-10">
    <div>
        <h1 class="text-xs uppercase tracking-[0.5em] font-black text-orange-500 mb-3"><?= __('system_backend') ?></h1>
        <h2 class="text-4xl font-black tracking-tighter uppercase text-white"><?= __('asset_registry') ?></h2>
    </div>
    <button onclick="document.getElementById('productForm').classList.toggle('hidden')" 
            class="bg-orange-600 text-white px-10 py-5 text-[11px] font-black uppercase tracking-widest hover:bg-orange-500 transition-all shadow-[0_0_20px_rgba(234,88,12,0.2)]">
        <?= __('create_registry') ?>
    </button>
</div>

<div id="productForm" class="hidden bg-[#0a0a0a] p-12 border border-orange-600/20 mb-20 max-w-4xl mx-auto shadow-2xl">
    <h3 class="text-xs font-black uppercase tracking-[0.4em] mb-12 text-center text-zinc-500"><?= __('registry_module') ?></h3>
    <form action="actions/admin.php?action=product_add" method="POST" enctype="multipart/form-data" class="space-y-8">
        <div class="grid grid-cols-2 gap-8">
            <div class="space-y-2">
                <div class="flex items-center gap-2 ml-1">
                    <span class="bg-orange-600 text-[8px] font-black px-2 py-0.5 text-white">RU</span>
                    <label class="text-[10px] uppercase tracking-widest text-zinc-600 font-black"><?= __('label_ru') ?></label>
                </div>
                <input type="text" name="title_ru" placeholder="<?= __('label_ru') ?>" required 
                       class="w-full bg-black border border-white/10 text-white px-8 py-5 text-xs font-bold uppercase tracking-widest outline-none focus:border-orange-600/50 transition-colors">
            </div>
            <div class="space-y-2">
                <div class="flex items-center gap-2 ml-1">
                    <span class="bg-orange-600 text-[8px] font-black px-2 py-0.5 text-white">EN</span>
                    <label class="text-[10px] uppercase tracking-widest text-zinc-600 font-black"><?= __('label_en') ?></label>
                </div>
                <input type="text" name="title_en" placeholder="<?= __('label_en') ?>" 
                       class="w-full bg-black border border-white/10 text-white px-8 py-5 text-xs font-bold uppercase tracking-widest outline-none focus:border-orange-600/50 transition-colors">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-8">
            <div class="space-y-2">
                <div class="flex items-center gap-2 ml-1">
                    <span class="bg-orange-600 text-[8px] font-black px-2 py-0.5 text-white">RU</span>
                    <label class="text-[10px] uppercase tracking-widest text-zinc-600 font-black"><?= __('desc_ru') ?></label>
                </div>
                <textarea name="description_ru" placeholder="<?= __('desc_ru') ?>" 
                          class="w-full bg-black border border-white/10 text-white px-8 py-5 text-xs font-bold uppercase tracking-widest outline-none focus:border-orange-600/50 transition-colors h-40"></textarea>
            </div>
            <div class="space-y-2">
                <div class="flex items-center gap-2 ml-1">
                    <span class="bg-orange-600 text-[8px] font-black px-2 py-0.5 text-white">EN</span>
                    <label class="text-[10px] uppercase tracking-widest text-zinc-600 font-black"><?= __('desc_en') ?></label>
                </div>
                <textarea name="description_en" placeholder="<?= __('desc_en') ?>" 
                          class="w-full bg-black border border-white/10 text-white px-8 py-5 text-xs font-bold uppercase tracking-widest outline-none focus:border-orange-600/50 transition-colors h-40"></textarea>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-8">
            <div class="space-y-2">
                <label class="text-[10px] uppercase tracking-widest text-zinc-600 font-black ml-1"><?= __('valuation') ?></label>
                <input type="number" step="0.01" name="price" placeholder="0.00" required 
                       class="w-full bg-black border border-white/10 text-white px-8 py-5 text-xs font-bold uppercase tracking-widest outline-none focus:border-orange-600/50 transition-colors">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] uppercase tracking-widest text-zinc-600 font-black ml-1"><?= __('attachment') ?></label>
                <input type="file" name="image" accept="image/*" required
                       class="w-full bg-black border border-white/10 text-white px-8 py-4 text-[10px] font-bold uppercase tracking-widest outline-none focus:border-orange-600/50 transition-colors">
            </div>
        </div>
        <button type="submit" class="w-full bg-orange-600 text-white py-6 text-[11px] font-black uppercase tracking-[0.4em] hover:bg-orange-500 transition-all shadow-xl"><?= __('commit_registry') ?></button>
    </form>
</div>

<div class="mb-12 max-w-lg">
    <div class="relative">
        <span class="absolute left-6 top-1/2 -translate-y-1/2 text-orange-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </span>
        <input type="text" id="adminProductSearch" placeholder="<?= __('search_placeholder') ?>" 
               class="w-full bg-black border border-white/10 text-white pl-16 pr-8 py-5 text-xs font-bold uppercase tracking-[0.3em] outline-none focus:border-orange-600/50 transition-all rounded-sm">
    </div>
</div>

<div class="bg-[#0a0a0a] border border-white/5 overflow-hidden shadow-2xl mb-40">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-black border-b border-orange-600/20">
                <th class="px-10 py-8 text-[10px] uppercase tracking-[0.3em] font-black text-zinc-600"><?= __('col_ref') ?></th>
                <th class="px-10 py-8 text-[10px] uppercase tracking-[0.3em] font-black text-zinc-600"><?= __('col_media') ?></th>
                <th class="px-10 py-8 text-[10px] uppercase tracking-[0.3em] font-black text-zinc-600"><?= __('col_id') ?></th>
                <th class="px-10 py-8 text-[10px] uppercase tracking-[0.3em] font-black text-zinc-600"><?= __('col_val') ?></th>
                <th class="px-10 py-8 text-[10px] uppercase tracking-[0.3em] font-black text-zinc-600 text-right"><?= __('col_ctrl') ?></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5" id="adminProductRows">
            <?php foreach ($products as $p): ?>
                <tr class="admin-product-row hover:bg-orange-600/[0.02] transition-colors group">
                    <td class="px-10 py-10 text-xs font-black text-zinc-700 tracking-tighter">#<?= $p['id'] ?></td>
                    <td class="px-10 py-10">
                        <div class="w-14 h-14 rounded-sm overflow-hidden border border-white/10 grayscale group-hover:grayscale-0 transition-all duration-500">
                            <img src="<?= htmlspecialchars($p['image_url'] ?: 'https://via.placeholder.com/100') ?>" class="w-full h-full object-cover">
                        </div>
                    </td>
                    <td class="px-10 py-10 text-sm font-black uppercase tracking-widest text-white admin-product-title"><?= htmlspecialchars($p['title_ru']) ?></td>
                    <td class="px-10 py-10 text-sm font-black tracking-widest text-orange-500"><?= number_format($p['price'], 0, '.', ' ') ?> ฿</td>
                    <td class="px-10 py-10 text-right">
                        <a href="actions/admin.php?action=product_delete&id=<?= $p['id'] ?>" 
                           onclick="return confirm('<?= __('confirm_delete') ?>')"
                           class="text-[10px] font-black uppercase tracking-widest text-zinc-600 hover:text-white hover:bg-orange-600 px-6 py-3 transition-all border border-transparent hover:border-orange-500"><?= __('btn_delete') ?></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
document.getElementById('adminProductSearch').addEventListener('input', function(e) {
    const term = e.target.value.toLowerCase();
    document.querySelectorAll('.admin-product-row').forEach(row => {
        const title = row.querySelector('.admin-product-title').textContent.toLowerCase();
        row.style.display = title.includes(term) ? '' : 'none';
    });
});
</script>
