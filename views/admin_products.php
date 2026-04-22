<?php
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll();
?>
<div class="flex justify-between items-end mb-16 border-b border-slate-200 pb-10">
    <div>
        <h1 class="text-xs uppercase tracking-[0.5em] font-extrabold text-indigo-600 mb-3"><?= __('system_backend') ?></h1>
        <h2 class="text-4xl font-extrabold tracking-tight text-slate-900 uppercase"><?= __('asset_registry') ?></h2>
    </div>
    <button onclick="document.getElementById('productForm').classList.toggle('hidden')" 
            class="btn-indigo px-8 py-4 text-[11px] font-bold uppercase tracking-widest rounded-xl shadow-lg shadow-indigo-100">
        <?= __('create_registry') ?>
    </button>
</div>

<div id="productForm" class="hidden luxury-card rounded-3xl p-10 mb-20 max-w-4xl mx-auto">
    <h3 class="text-xs font-bold uppercase tracking-[0.4em] mb-10 text-center text-slate-400"><?= __('registry_module') ?></h3>
    <form action="actions/admin.php?action=product_add" method="POST" enctype="multipart/form-data" class="space-y-8">
        <div class="grid grid-cols-2 gap-8">
            <div class="space-y-2">
                <label class="text-[10px] uppercase tracking-widest text-slate-400 font-bold ml-1"><?= __('label_ru') ?></label>
                <input type="text" name="title_ru" placeholder="Название (RU)" required 
                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm font-semibold outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] uppercase tracking-widest text-slate-400 font-bold ml-1"><?= __('label_en') ?></label>
                <input type="text" name="title_en" placeholder="Title (EN)" 
                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm font-semibold outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-8">
            <div class="space-y-2">
                <label class="text-[10px] uppercase tracking-widest text-slate-400 font-bold ml-1"><?= __('desc_ru') ?></label>
                <textarea name="description_ru" placeholder="Описание (RU)" 
                          class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm font-semibold outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all h-32"></textarea>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] uppercase tracking-widest text-slate-400 font-bold ml-1"><?= __('desc_en') ?></label>
                <textarea name="description_en" placeholder="Description (EN)" 
                          class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm font-semibold outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all h-32"></textarea>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-8">
            <div class="space-y-2">
                <label class="text-[10px] uppercase tracking-widest text-slate-400 font-bold ml-1"><?= __('valuation') ?></label>
                <input type="number" step="0.01" name="price" placeholder="0.00" required 
                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm font-semibold outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] uppercase tracking-widest text-slate-400 font-bold ml-1"><?= __('attachment') ?></label>
                <input type="file" name="image" accept="image/*" required
                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-3 text-[10px] font-bold outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all">
            </div>
        </div>
        <button type="submit" class="w-full btn-luxury rounded-2xl py-5 text-xs font-bold uppercase tracking-[0.3em] shadow-xl shadow-slate-200 transition-all active:scale-[0.98]"><?= __('commit_registry') ?></button>
    </form>
</div>

<div class="luxury-card rounded-2xl overflow-hidden mb-20">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-50 border-b border-slate-200">
                <th class="px-8 py-6 text-[10px] uppercase tracking-widest font-extrabold text-slate-400"><?= __('col_ref') ?></th>
                <th class="px-8 py-6 text-[10px] uppercase tracking-widest font-extrabold text-slate-400"><?= __('col_media') ?></th>
                <th class="px-8 py-6 text-[10px] uppercase tracking-widest font-extrabold text-slate-400"><?= __('col_id') ?></th>
                <th class="px-8 py-6 text-[10px] uppercase tracking-widest font-extrabold text-slate-400"><?= __('col_val') ?></th>
                <th class="px-8 py-6 text-[10px] uppercase tracking-widest font-extrabold text-slate-400 text-right"><?= __('col_ctrl') ?></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            <?php foreach ($products as $p): ?>
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-8 py-6 text-xs font-bold text-slate-400">#<?= $p['id'] ?></td>
                    <td class="px-8 py-6">
                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                            <img src="<?= htmlspecialchars($p['image_url'] ?: 'https://via.placeholder.com/100') ?>" class="w-full h-full object-cover">
                        </div>
                    </td>
                    <td class="px-8 py-6 text-sm font-bold text-slate-900 uppercase tracking-tight"><?= htmlspecialchars($p['title_ru']) ?></td>
                    <td class="px-8 py-6 text-sm font-extrabold text-indigo-600"><?= number_format($p['price'], 0, '.', ' ') ?> ฿</td>
                    <td class="px-8 py-6 text-right">
                        <a href="actions/admin.php?action=product_delete&id=<?= $p['id'] ?>" 
                           onclick="return confirm('<?= __('confirm_delete') ?>')"
                           class="text-[10px] font-bold uppercase tracking-widest text-slate-400 hover:text-red-600 transition-colors"><?= __('btn_delete') ?></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
