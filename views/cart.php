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
    <div class="mb-16 border-b border-slate-200 pb-10 flex justify-between items-end">
        <div>
            <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight uppercase"><?= __('inventory') ?></h1>
            <p class="text-[10px] text-indigo-600 font-extrabold tracking-[0.5em] uppercase mt-4"><?= __('sector_cart_registry') ?></p>
        </div>
    </div>

    <?php if (empty($cartProducts)): ?>
        <div class="luxury-card rounded-3xl p-32 text-center border-dashed">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <p class="text-slate-900 text-xl font-bold uppercase tracking-widest mb-4"><?= __('database_empty') ?></p>
            <p class="text-slate-400 text-sm mb-10"><?= __('no_assets') ?></p>
            <a href="/?page=catalog" class="btn-indigo px-10 py-4 rounded-xl text-xs font-bold uppercase tracking-widest shadow-lg shadow-indigo-100 inline-block"><?= __('return_to_catalog') ?></a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-12">
            <div class="xl:col-span-2 space-y-6">
                <?php foreach ($cartProducts as $p):
                    $qty = $cart[$p['id']] ?? 0;
                    $itemTotal = $p['price'] * $qty;
                    $subtotal += $itemTotal;
                    $display_title = $p['title_ru'] ?? $p['title'] ?? 'Без названия';
                ?>
                    <div class="luxury-card rounded-2xl p-6 flex items-center gap-8 bg-white">
                        <div class="w-24 h-24 rounded-xl overflow-hidden bg-slate-50 shrink-0 border border-slate-100">
                            <img src="<?= htmlspecialchars($p['image_url'] ?: 'https://via.placeholder.com/300') ?>" class="w-full h-full object-cover">
                        </div>

                        <div class="flex-grow">
                            <h3 class="text-lg font-bold text-slate-900 mb-4 tracking-tight uppercase"><?= htmlspecialchars($display_title) ?></h3>
                            <div class="flex items-center gap-10">
                                <div class="flex flex-col">
                                    <span class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mb-1"><?= __('valuation') ?></span>
                                    <span class="text-slate-900 font-extrabold text-lg"><?= number_format($p['price'], 0, '.', ' ') ?> ฿</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mb-1"><?= __('quantity') ?></span>
                                    <div class="flex items-center gap-4 bg-slate-50 border border-slate-200 px-3 py-1 rounded-lg">
                                        <a href="actions/cart.php?action=remove&id=<?= $p['id'] ?>" class="text-slate-400 hover:text-indigo-600 transition-colors font-black">-</a>
                                        <span class="text-slate-900 font-extrabold text-sm"><?= $qty ?></span>
                                        <a href="actions/cart.php?action=add&id=<?= $p['id'] ?>" class="text-slate-400 hover:text-indigo-600 transition-colors font-black">+</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right pr-4">
                            <span class="text-[9px] text-slate-400 font-bold uppercase tracking-widest block mb-1"><?= __('total_sector_value') ?></span>
                            <span class="text-xl font-extrabold text-slate-900"><?= number_format($itemTotal, 0, '.', ' ') ?> ฿</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="xl:col-span-1">
                <div class="luxury-card rounded-3xl p-10 bg-white sticky top-32">
                    <h4 class="text-xs font-extrabold text-slate-900 uppercase tracking-[0.3em] mb-10 border-b border-slate-100 pb-5"><?= __('checkout_protocol') ?></h4>

                    <div class="space-y-4 mb-10">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400 text-[10px] font-bold uppercase tracking-widest"><?= __('asset_valuation') ?></span>
                            <span class="text-slate-900 font-bold"><?= number_format($subtotal, 0, '.', ' ') ?> ฿</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400 text-[10px] font-bold uppercase tracking-widest"><?= __('logistics') ?></span>
                            <span class="text-indigo-600 text-[10px] font-extrabold tracking-widest uppercase italic"><?= __('free_delivery') ?></span>
                        </div>
                        <div class="h-px bg-slate-100 my-6"></div>
                        <div class="flex justify-between items-end">
                            <span class="text-slate-900 text-xs font-extrabold uppercase tracking-tight"><?= __('total_manifest_value') ?></span>
                            <span class="text-3xl font-extrabold text-indigo-600 tracking-tighter"><?= number_format($subtotal, 0, '.', ' ') ?> ฿</span>
                        </div>
                    </div>

                    <form action="actions/checkout.php" method="POST" class="space-y-5">
                        <input type="text" name="customer_name" placeholder="<?= __('consignee_id') ?>" required 
                               class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-xs font-semibold outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all">
                        
                        <input type="tel" name="customer_phone" placeholder="<?= __('secure_comms') ?>" required 
                               class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-xs font-semibold outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all">
                        
                        <textarea name="customer_address" placeholder="<?= __('deployment_coords') ?>" required rows="3"
                                  class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-xs font-semibold outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all resize-none"></textarea>

                        <button type="submit" 
                                class="w-full btn-indigo py-5 rounded-2xl text-[11px] font-bold uppercase tracking-widest shadow-xl shadow-indigo-100 mt-4">
                            <?= __('initiate_transaction') ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
