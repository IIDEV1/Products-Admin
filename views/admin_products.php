<?php
$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
    <div>
        <h1 class="text-3xl font-black uppercase tracking-tighter text-slate-900">Управление <span class="text-indigo-600">Товарами</span></h1>
        <p class="text-slate-500 text-sm mt-1 font-medium">Добавление, редактирование и удаление товаров в каталоге.</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 md:gap-12">
    <div class="lg:col-span-1">
        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200 sticky top-24">
            <h2 class="text-xs font-black uppercase tracking-widest text-slate-800 mb-6 border-b border-slate-100 pb-4">Добавить новый товар</h2>
            
            <form action="/?action=product_add" method="POST" class="space-y-4">
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Название товара</label>
                    <input type="text" name="title_ru" required class="w-full bg-slate-50 border border-slate-200 text-slate-900 px-4 py-3 rounded-xl text-sm font-medium outline-none focus:border-indigo-600 transition-colors mt-1">
                </div>
                
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Описание</label>
                    <textarea name="description_ru" rows="4" required class="w-full bg-slate-50 border border-slate-200 text-slate-900 px-4 py-3 rounded-xl text-sm font-medium outline-none focus:border-indigo-600 transition-colors mt-1 resize-none"></textarea>
                </div>
                
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Цена (฿)</label>
                    <input type="number" name="price" step="0.01" required class="w-full bg-slate-50 border border-slate-200 text-slate-900 px-4 py-3 rounded-xl text-sm font-medium outline-none focus:border-indigo-600 transition-colors mt-1">
                </div>

                <div>
                    <label class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest ml-1">Ссылка на картинку (URL)</label>
                    <input type="url" name="image_url" placeholder="https://..." required class="w-full bg-slate-50 border border-slate-200 text-slate-900 px-4 py-3 rounded-xl text-sm font-medium outline-none focus:border-indigo-600 transition-colors mt-1">
                    <p class="text-[9px] text-slate-400 mt-1 ml-1 uppercase">Скопируйте URL картинки из интернета</p>
                </div>
                
                <button type="submit" class="w-full bg-slate-900 text-white font-black uppercase tracking-widest text-[10px] py-4 rounded-xl hover:bg-indigo-600 transition-colors shadow-sm mt-4 active:scale-95">
                    Опубликовать товар
                </button>
            </form>
        </div>
    </div>

    <div class="lg:col-span-2 space-y-4">
        <?php if (empty($products)): ?>
            <div class="bg-white border-2 border-dashed border-slate-200 rounded-2xl p-10 text-center">
                <p class="text-slate-400 font-bold uppercase tracking-widest text-sm">Товаров пока нет</p>
            </div>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="bg-white border border-slate-200 rounded-2xl p-4 flex flex-col sm:flex-row gap-6 items-center shadow-sm hover:shadow-md transition-all">
                    <?php if (!empty($product['image_url'])): ?>
                        <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="IMG" class="w-full sm:w-24 aspect-square object-cover rounded-xl border border-slate-100">
                    <?php else: ?>
                        <div class="w-full sm:w-24 aspect-square bg-slate-50 rounded-xl flex items-center justify-center border border-slate-100">
                            <span class="text-[10px] font-bold text-slate-300 uppercase">NO IMG</span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="flex-1 text-center sm:text-left">
                        <h3 class="font-bold text-slate-900 text-base"><?= htmlspecialchars($product['title_ru'] ?? 'Без названия') ?></h3>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-1 font-medium"><?= htmlspecialchars($product['description_ru'] ?? '') ?></p>
                        <div class="text-indigo-600 font-black mt-2 text-lg"><?= number_format($product['price'] ?? 0, 0, '.', ' ') ?> ฿</div>
                    </div>
                    
                    <div class="w-full sm:w-auto flex flex-col gap-2 sm:border-l sm:border-slate-100 sm:pl-6 pt-4 sm:pt-0 border-t sm:border-t-0 border-slate-100">
                        <a href="?action=product_delete&id=<?= $product['id'] ?>" onclick="return confirm('Удалить этот товар?')" class="bg-red-50 text-red-600 border border-red-100 px-6 py-2 rounded-lg text-[10px] font-bold uppercase hover:bg-red-600 hover:text-white transition-all text-center">
                            Удалить
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
