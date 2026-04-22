<?php
$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="mb-10 flex justify-between items-end">
    <div>
        <h1 class="text-3xl font-black uppercase tracking-tighter text-white">Управление <span class="text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-500 to-cyan-400">Товарами</span></h1>
        <p class="text-slate-400 text-sm mt-1 uppercase tracking-widest font-medium">Добавление, редактирование и удаление товаров в каталоге.</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
    <div class="lg:col-span-1">
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl sticky top-24">
            <h2 class="text-sm font-black uppercase tracking-widest text-white mb-6 border-b border-white/10 pb-4">Добавить новый товар</h2>
            
            <form action="/?action=product_add" method="POST" class="space-y-4">
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Название товара</label>
                    <input type="text" name="title_ru" required class="w-full bg-slate-900 border border-white/10 text-white px-4 py-3 rounded-xl text-sm font-medium outline-none focus:border-cyan-500 transition-colors mt-1">
                </div>
                
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Описание</label>
                    <textarea name="description_ru" rows="4" required class="w-full bg-slate-900 border border-white/10 text-white px-4 py-3 rounded-xl text-sm font-medium outline-none focus:border-cyan-500 transition-colors mt-1 resize-none"></textarea>
                </div>
                
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Цена ($)</label>
                    <input type="number" name="price" step="0.01" required class="w-full bg-slate-900 border border-white/10 text-white px-4 py-3 rounded-xl text-sm font-medium outline-none focus:border-cyan-500 transition-colors mt-1">
                </div>

                <div>
                    <label class="text-xs font-bold text-cyan-500 uppercase tracking-widest ml-1">Ссылка на картинку (URL)</label>
                    <input type="url" name="image_url" placeholder="https://..." required class="w-full bg-slate-900 border border-white/10 text-white px-4 py-3 rounded-xl text-sm font-medium outline-none focus:border-cyan-500 transition-colors mt-1">
                    <p class="text-[10px] text-slate-500 mt-1 ml-1 uppercase">Скопируйте URL картинки из интернета</p>
                </div>
                
                <button type="submit" class="w-full bg-gradient-to-r from-cyan-500 to-fuchsia-600 text-white font-black uppercase tracking-widest text-xs py-4 rounded-xl hover:scale-[1.02] transition-all shadow-[0_0_20px_rgba(6,182,212,0.3)] mt-4">
                    Опубликовать товар
                </button>
            </form>
        </div>
    </div>

    <div class="lg:col-span-2 space-y-4">
        <?php if (empty($products)): ?>
            <div class="bg-white/5 border-2 border-dashed border-white/10 rounded-2xl p-10 text-center">
                <p class="text-slate-500 font-bold uppercase tracking-widest text-sm">Товаров пока нет</p>
            </div>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-4 flex gap-6 items-center shadow-sm hover:border-cyan-500/50 transition-all group">
                    <?php if (!empty($product['image_url'])): ?>
                        <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="IMG" class="w-24 h-24 object-cover rounded-xl border border-white/10 group-hover:scale-105 transition-transform">
                    <?php else: ?>
                        <div class="w-24 h-24 bg-slate-900 rounded-xl flex items-center justify-center border border-white/10">
                            <span class="text-xs font-bold text-slate-600 uppercase">NO IMG</span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="flex-1">
                        <h3 class="font-bold text-white"><?= htmlspecialchars($product['title_ru'] ?? 'Без названия') ?></h3>
                        <p class="text-xs text-slate-400 mt-1 line-clamp-2"><?= htmlspecialchars($product['description_ru'] ?? '') ?></p>
                        <div class="text-cyan-400 font-black mt-2 tracking-tighter">$<?= number_format($product['price'] ?? 0, 2) ?></div>
                    </div>
                    
                    <div class="flex flex-col gap-2 border-l border-white/10 pl-6">
                        <a href="?action=product_delete&id=<?= $product['id'] ?>" onclick="return confirm('Удалить этот товар?')" class="bg-red-500/10 text-red-500 border border-red-500/30 px-4 py-2 rounded-lg text-xs font-bold uppercase hover:bg-red-500/20 transition-colors text-center">
                            Удалить
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
