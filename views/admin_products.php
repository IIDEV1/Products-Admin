<?php
$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$editProduct = null;
if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $editStmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $editStmt->execute([$editId]);
    $editProduct = $editStmt->fetch();
}
?>

<div class="breadcrumbs">
    <a href="/"><?= __('nav_home') ?></a>
    <span class="separator">›</span>
    <a href="/?page=admin_dashboard"><?= __('nav_dashboard') ?></a>
    <span class="separator">›</span>
    <span class="current"><?= __('nav_products') ?></span>
</div>

<div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
    <div>
        <h1 class="text-3xl font-black uppercase tracking-tighter text-slate-900"><?= __('manage_products') ?></h1>
        <p class="text-slate-500 text-sm mt-1 font-medium"><?= __('manage_products_desc') ?></p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 md:gap-12">
    <div class="lg:col-span-1">
        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200 sticky top-24">
            <h2 class="text-xs font-black uppercase tracking-widest text-slate-800 mb-6 border-b border-slate-100 pb-4">
                <?= $editProduct ? __('edit_product') : __('add_product') ?>
            </h2>
            
            <form action="/?action=<?= $editProduct ? 'product_edit' : 'product_add' ?>" method="POST" class="space-y-4">
                <?= csrf_field() ?>
                <?php if ($editProduct): ?>
                    <input type="hidden" name="id" value="<?= $editProduct['id'] ?>">
                <?php endif; ?>
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1"><?= __('product_name_label') ?></label>
                    <input type="text" name="title_ru" required value="<?= htmlspecialchars($editProduct['title_ru'] ?? '') ?>"
                           class="w-full bg-slate-50 border border-slate-200 text-slate-900 px-4 py-3 rounded-xl text-sm font-medium outline-none focus:border-indigo-600 transition-colors mt-1">
                </div>
                
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1"><?= __('description_label') ?></label>
                    <textarea name="description_ru" rows="4" required class="w-full bg-slate-50 border border-slate-200 text-slate-900 px-4 py-3 rounded-xl text-sm font-medium outline-none focus:border-indigo-600 transition-colors mt-1 resize-none"><?= htmlspecialchars($editProduct['description_ru'] ?? '') ?></textarea>
                </div>
                
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1"><?= __('price_label') ?> (₽)</label>
                    <input type="number" name="price" step="0.01" min="0.01" required value="<?= $editProduct['price'] ?? '' ?>"
                           class="w-full bg-slate-50 border border-slate-200 text-slate-900 px-4 py-3 rounded-xl text-sm font-medium outline-none focus:border-indigo-600 transition-colors mt-1">
                </div>

                <div>
                    <label class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest ml-1"><?= __('image_url_label') ?></label>
                    <input type="url" name="image_url" placeholder="https://..." required value="<?= htmlspecialchars($editProduct['image_url'] ?? '') ?>"
                           class="w-full bg-slate-50 border border-slate-200 text-slate-900 px-4 py-3 rounded-xl text-sm font-medium outline-none focus:border-indigo-600 transition-colors mt-1">
                </div>
                
                <button type="submit" class="w-full bg-slate-900 text-white font-black uppercase tracking-widest text-[10px] py-4 rounded-xl hover:bg-indigo-600 transition-colors shadow-sm mt-4 active:scale-95">
                    <?= $editProduct ? __('save_changes') : __('publish_product') ?>
                </button>
                <?php if ($editProduct): ?>
                    <a href="/?page=admin_products" class="block text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-colors mt-2"><?= __('cancel') ?></a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="lg:col-span-2 space-y-4">
        <?php if (empty($products)): ?>
            <div class="bg-white border-2 border-dashed border-slate-200 rounded-2xl p-10 text-center">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <p class="text-slate-400 font-bold uppercase tracking-widest text-sm"><?= __('empty_catalog') ?></p>
            </div>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="bg-white border border-slate-200 rounded-2xl p-4 flex flex-col sm:flex-row gap-6 items-center shadow-sm hover:shadow-md transition-all">
                    <?php if (!empty($product['image_url'])): ?>
                        <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="" class="w-full sm:w-24 aspect-square object-cover rounded-xl border border-slate-100" loading="lazy">
                    <?php else: ?>
                        <div class="w-full sm:w-24 aspect-square bg-slate-50 rounded-xl flex items-center justify-center border border-slate-100">
                            <span class="text-[10px] font-bold text-slate-300 uppercase">NO IMG</span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="flex-1 text-center sm:text-left">
                        <h3 class="font-bold text-slate-900 text-base"><?= htmlspecialchars($product['title_ru'] ?? $product['name'] ?? __('no_title')) ?></h3>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-1 font-medium"><?= htmlspecialchars($product['description_ru'] ?? '') ?></p>
                        <div class="text-indigo-600 font-black mt-2 text-lg"><?= number_format($product['price'] ?? 0, 0, '.', ' ') ?> ₽</div>
                    </div>
                    
                    <div class="w-full sm:w-auto flex flex-row sm:flex-col gap-2 sm:border-l sm:border-slate-100 sm:pl-6 pt-4 sm:pt-0 border-t sm:border-t-0 border-slate-100">
                        <a href="/?page=admin_products&edit=<?= $product['id'] ?>" class="flex-1 sm:flex-none bg-indigo-50 text-indigo-600 border border-indigo-100 px-6 py-2 rounded-lg text-[10px] font-bold uppercase hover:bg-indigo-600 hover:text-white transition-all text-center">
                            <?= __('edit') ?>
                        </a>
                        <form action="/?action=product_delete" method="POST" class="flex-1 sm:flex-none" onsubmit="return confirm('<?= __('confirm_delete') ?>')">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= $product['id'] ?>">
                            <button type="submit" class="w-full bg-red-50 text-red-600 border border-red-100 px-6 py-2 rounded-lg text-[10px] font-bold uppercase hover:bg-red-600 hover:text-white transition-all text-center">
                                <?= __('btn_delete') ?>
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
