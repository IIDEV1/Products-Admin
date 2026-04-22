<?php
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll();
?>
<div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-16">
    <div>
        <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 mb-2 uppercase"><?= __('asset_registry') ?></h1>
        <p class="text-slate-500 font-medium uppercase text-xs tracking-[0.4em]"><?= __('system_backend') ?></p>
    </div>
    <button onclick="document.getElementById('productForm').classList.toggle('hidden')" 
            class="bg-indigo-600 text-white px-8 py-4 text-xs font-bold uppercase tracking-widest rounded-2xl shadow-xl shadow-indigo-100 hover:bg-slate-900 transition-all active:scale-95">
        <?= __('create_registry') ?>
    </button>
</div>

<div id="productForm" class="hidden luxury-card rounded-3xl p-10 mb-16 max-w-4xl mx-auto border border-slate-200">
    <h3 class="text-xs font-bold uppercase tracking-[0.4em] mb-12 text-center text-slate-400"><?= __('registry_module') ?></h3>
    <form action="actions/admin.php?action=product_add" method="POST" enctype="multipart/form-data" class="space-y-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-2">
                <label class="text-[10px] uppercase tracking-widest text-slate-400 font-bold ml-1"><?= __('label_ru') ?></label>
                <input type="text" name="title_ru" placeholder="Наименование (RU)" required 
                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm font-semibold outline-none focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] uppercase tracking-widest text-slate-400 font-bold ml-1"><?= __('label_en') ?></label>
                <input type="text" name="title_en" placeholder="Identification Label (EN)" 
                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm font-semibold outline-none focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 transition-all">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-2">
                <label class="text-[10px] uppercase tracking-widest text-slate-400 font-bold ml-1"><?= __('desc_ru') ?></label>
                <textarea name="description_ru" placeholder="Манифест (RU)" 
                          class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm font-semibold outline-none focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 transition-all h-32"></textarea>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] uppercase tracking-widest text-slate-400 font-bold ml-1"><?= __('desc_en') ?></label>
                <textarea name="description_en" placeholder="Manifest (EN)" 
                          class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm font-semibold outline-none focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 transition-all h-32"></textarea>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-2">
                <label class="text-[10px] uppercase tracking-widest text-slate-400 font-bold ml-1"><?= __('valuation') ?></label>
                <input type="number" step="0.01" name="price" placeholder="0.00" required 
                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm font-semibold outline-none focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] uppercase tracking-widest text-slate-400 font-bold ml-1"><?= __('attachment') ?></label>
                <input type="file" name="image" accept="image/*" required
                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-3.5 text-xs font-bold outline-none focus:ring-2 focus:ring-indigo-600/20 transition-all">
            </div>
        </div>
        <button type="submit" class="w-full bg-slate-900 text-white rounded-2xl py-5 text-xs font-bold uppercase tracking-[0.3em] shadow-xl shadow-slate-200 transition-all hover:bg-indigo-600 active:scale-[0.98]"><?= __('commit_registry') ?></button>
    </form>
</div>

<div class="luxury-card rounded-3xl overflow-hidden bg-white shadow-sm border border-slate-200">
    <div class="overflow-x-auto">
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
                        <td class="px-8 py-6 text-xs font-bold text-slate-400 tracking-tighter">#<?= $p['id'] ?></td>
                        <td class="px-8 py-6">
                            <div class="w-14 h-14 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200">
                                <img src="<?= htmlspecialchars($p['image_url'] ?: 'https://via.placeholder.com/100') ?>" class="w-full h-full object-cover">
                            </div>
                        </td>
                        <td class="px-8 py-6 text-sm font-bold text-slate-900 uppercase tracking-tight"><?= htmlspecialchars($p['title_ru']) ?></td>
                        <td class="px-8 py-6 text-sm font-extrabold text-indigo-600"><?= number_format($p['price'], 0, '.', ' ') ?> ฿</td>
                        <td class="px-8 py-6 text-right">
                            <a href="actions/admin.php?action=product_delete&id=<?= $p['id'] ?>" 
                               onclick="return confirm('<?= __('confirm_delete') ?>')"
                               class="text-[10px] font-bold uppercase tracking-widest text-slate-300 hover:text-red-500 px-4 py-2 rounded-xl hover:bg-red-50 transition-all"><?= __('btn_delete') ?></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
