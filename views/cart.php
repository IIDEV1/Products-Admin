<?php
$cart = $_SESSION['cart'] ?? [];
$cartProducts = [];
$subtotal = 0;

if (!empty($cart)) {
    $ids = array_keys($cart);
    $placeholders = str_repeat('?,', count($ids) - 1) . '?';
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $cartProducts = $stmt->fetchAll();
}
?>

<div class="max-w-7xl mx-auto">
    <div class="mb-12">
        <h1 class="text-3xl md:text-5xl font-extrabold text-slate-900 tracking-tight uppercase"><?= __('inventory') ?></h1>
        <p class="text-slate-500 font-medium text-sm mt-2"><?= __('sector_cart_registry') ?></p>
    </div>

    <?php if (empty($cartProducts)): ?>
        <div class="bg-white rounded-3xl p-16 md:p-32 text-center border-2 border-dashed border-slate-200">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <p class="text-slate-900 text-xl font-bold uppercase tracking-widest mb-4"><?= __('database_empty') ?></p>
            <p class="text-slate-400 text-sm mb-10"><?= __('no_assets') ?></p>
            <a href="/?page=catalog" class="bg-indigo-600 text-white px-10 py-4 rounded-xl text-xs font-bold uppercase tracking-widest shadow-lg shadow-indigo-100 inline-block hover:bg-slate-900 transition-all"><?= __('return_to_catalog') ?></a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 md:gap-12">
            <div class="lg:col-span-2 space-y-4 md:space-y-6">
                <?php foreach ($cartProducts as $p):
                    $qty = $cart[$p['id']] ?? 0;
                    $itemTotal = $p['price'] * $qty;
                    $subtotal += $itemTotal;
                    $display_title = $p['title_ru'] ?? $p['title'] ?? 'Без названия';
                ?>
                    <div class="bg-white rounded-2xl p-4 md:p-6 flex flex-col sm:flex-row items-center gap-6 border border-slate-200 shadow-sm transition-hover hover:shadow-md">
                        <div class="w-full sm:w-32 aspect-square rounded-xl overflow-hidden bg-slate-100 shrink-0 border border-slate-100">
                            <img src="<?= htmlspecialchars($p['image_url'] ?: 'https://via.placeholder.com/300') ?>" class="w-full h-full object-cover">
                        </div>

                        <div class="flex-grow text-center sm:text-left">
                            <h3 class="text-base font-bold text-slate-900 mb-2 tracking-tight uppercase"><?= htmlspecialchars($display_title) ?></h3>
                            <div class="flex flex-col sm:flex-row items-center gap-4 sm:gap-10">
                                <div class="flex flex-col">
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1"><?= __('valuation') ?></span>
                                    <span class="text-slate-900 font-extrabold text-lg"><?= number_format($p['price'], 0, '.', ' ') ?> ฿</span>
                                </div>
                                <div class="flex flex-col items-center sm:items-start">
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1"><?= __('quantity') ?></span>
                                    <div class="flex items-center gap-4 bg-slate-50 border border-slate-200 px-3 py-1 rounded-lg">
                                        <a href="/?action=remove&id=<?= $p['id'] ?>" class="text-slate-400 hover:text-indigo-600 transition-colors font-black">-</a>
                                        <span class="text-slate-900 font-extrabold text-sm"><?= $qty ?></span>
                                        <a href="/?action=add&id=<?= $p['id'] ?>" class="text-slate-400 hover:text-indigo-600 transition-colors font-black">+</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-full sm:w-auto text-center sm:text-right sm:pr-4 pt-4 sm:pt-0 border-t sm:border-t-0 border-slate-100 flex sm:flex-col justify-between items-center sm:block">
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest block mb-1"><?= __('total_sector_value') ?></span>
                            <span class="text-xl font-extrabold text-slate-900"><?= number_format($itemTotal, 0, '.', ' ') ?> ฿</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl p-6 md:p-10 border border-slate-200 shadow-sm sticky top-24">
                    <h4 class="text-xs font-extrabold text-slate-900 uppercase tracking-[0.3em] mb-8 border-b border-slate-100 pb-5"><?= __('checkout_protocol') ?></h4>

                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 text-[10px] font-bold uppercase tracking-widest"><?= __('asset_valuation') ?></span>
                            <span class="text-slate-900 font-bold"><?= number_format($subtotal, 0, '.', ' ') ?> ฿</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 text-[10px] font-bold uppercase tracking-widest"><?= __('logistics') ?></span>
                            <span class="text-green-600 text-[10px] font-extrabold tracking-widest uppercase italic"><?= __('free_delivery') ?></span>
                        </div>
                        <div class="h-px bg-slate-100 my-6"></div>
                        <div class="flex justify-between items-end">
                            <span class="text-slate-900 text-sm font-extrabold uppercase tracking-tight"><?= __('total_manifest_value') ?></span>
                            <span class="text-3xl font-extrabold text-indigo-600 tracking-tighter"><?= number_format($subtotal, 0, '.', ' ') ?> ฿</span>
                        </div>
                    </div>

                    <form action="/?action=checkout" method="POST" class="space-y-4">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Имя получателя</label>
                            <input type="text" name="customer_name" placeholder="<?= __('consignee_id') ?>" required 
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3.5 text-sm font-semibold outline-none focus:border-indigo-600 transition-all">
                        </div>
                        
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Телефон</label>
                            <input type="tel" name="customer_phone" placeholder="<?= __('secure_comms') ?>" required 
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3.5 text-sm font-semibold outline-none focus:border-indigo-600 transition-all">
                        </div>
                        
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Адрес доставки</label>
                            <textarea name="customer_address" placeholder="<?= __('deployment_coords') ?>" required rows="3"
                                      class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3.5 text-sm font-semibold outline-none focus:border-indigo-600 transition-all resize-none"></textarea>
                        </div>

                        <button type="submit" 
                                class="w-full bg-indigo-600 text-white py-5 rounded-xl text-[11px] font-bold uppercase tracking-widest hover:bg-slate-900 transition-all shadow-lg shadow-indigo-100 mt-4 active:scale-95">
                            <?= __('initiate_transaction') ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
