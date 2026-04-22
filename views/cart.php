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

$lang = $_SESSION['lang'] ?? 'ru';
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-12 border-b border-white/20 pb-8 flex justify-between items-end">
        <div>
            <h1 class="text-5xl font-black text-white tracking-tighter uppercase leading-none">Inventory</h1>
            <p class="text-[10px] text-orange-500 font-black tracking-[0.6em] uppercase mt-4">Sector Cart Registry</p>
        </div>
        <div class="hidden md:block text-right">
            <span class="text-zinc-400 text-[10px] uppercase font-bold tracking-[0.3em] block mb-2">Active Buffer</span>
            <div class="h-1 w-32 bg-orange-600/30 ml-auto">
                <div class="h-full bg-orange-600 w-2/3 animate-pulse"></div>
            </div>
        </div>
    </div>

    <?php if (empty($cartProducts)): ?>
        <div class="bg-[#18181b] border-2 border-dashed border-white/10 p-24 text-center rounded-sm shadow-2xl">
            <div class="mb-8 flex justify-center">
                <div class="w-16 h-16 border-2 border-orange-600/20 rounded-full flex items-center justify-center animate-pulse">
                    <div class="w-8 h-8 border-2 border-orange-600 rounded-full"></div>
                </div>
            </div>
            <p class="text-white text-xl font-black uppercase tracking-[0.4em] mb-6">Database Empty</p>
            <p class="text-zinc-400 text-sm mb-10 max-w-md mx-auto uppercase tracking-widest font-bold">No assets identified in the current buffer sector.</p>
            <a href="?page=catalog" class="inline-block bg-orange-600 text-white px-12 py-5 text-xs font-black uppercase tracking-[0.3em] hover:bg-white hover:text-black transition-all shadow-xl">Return to Catalog</a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-10">
            <div class="xl:col-span-2 space-y-6">
                <?php foreach ($cartProducts as $p):
                    $qty = $cart[$p['id']] ?? 0;
                    $itemTotal = $p['price'] * $qty;
                    $subtotal += $itemTotal;

                    $t_ru = $p['title_ru'] ?? $p['title'] ?? 'Без названия';
                    $t_en = $p['title_en'] ?? '';
                    $display_title = ($lang === 'en' && !empty($t_en)) ? $t_en : $t_ru;
                ?>
                    <div class="bg-[#18181b] border border-white/20 p-6 sm:p-8 flex flex-col sm:flex-row items-center gap-8 shadow-2xl hover:border-orange-500/50 transition-all group relative overflow-hidden">
                        <div class="w-32 h-32 bg-black border border-white/10 shrink-0 overflow-hidden relative">
                            <img src="<?= htmlspecialchars($p['image_url'] ?: 'https://via.placeholder.com/300') ?>" class="w-full h-full object-cover grayscale opacity-80 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-700">
                            <div class="absolute inset-0 border border-orange-600/0 group-hover:border-orange-600/20 transition-all"></div>
                        </div>

                        <div class="flex-grow text-center sm:text-left">
                            <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-4">
                                <h3 class="text-xl font-black text-white uppercase tracking-tight group-hover:text-orange-500 transition-colors"><?= htmlspecialchars($display_title) ?></h3>
                                <span class="bg-orange-600/10 text-orange-500 text-[9px] font-black px-3 py-1 border border-orange-600/20 tracking-widest uppercase rounded-sm self-center sm:self-auto">Unit ID: #<?= $p['id'] ?></span>
                            </div>

                            <div class="flex flex-wrap justify-center sm:justify-start items-center gap-8">
                                <div class="flex flex-col">
                                    <span class="text-[9px] text-zinc-400 font-bold uppercase tracking-widest mb-1">Valuation</span>
                                    <span class="text-white font-black text-lg"><?= number_format($p['price'], 0, '.', ' ') ?> <span class="text-orange-600 italic">฿</span></span>
                                </div>
                                <div class="w-[1px] h-8 bg-white/10 hidden sm:block"></div>
                                <div class="flex flex-col">
                                    <span class="text-[9px] text-zinc-400 font-bold uppercase tracking-widest mb-1">Quantity</span>
                                    <div class="flex items-center gap-4 bg-black/40 border border-white/10 px-4 py-1 rounded-sm">
                                        <a href="actions/cart.php?action=remove&id=<?= $p['id'] ?>" class="text-zinc-500 hover:text-orange-500 transition-colors font-bold">-</a>
                                        <span class="text-white font-black"><?= $qty ?></span>
                                        <a href="actions/cart.php?action=add&id=<?= $p['id'] ?>" class="text-zinc-500 hover:text-orange-500 transition-colors font-bold">+</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-row sm:flex-col items-center sm:items-end justify-between sm:justify-center w-full sm:w-auto gap-6 border-t sm:border-t-0 border-white/10 pt-6 sm:pt-0">
                            <div class="text-right">
                                <span class="text-[9px] text-zinc-400 font-bold uppercase tracking-widest block mb-1">Total Sector Value</span>
                                <span class="text-2xl font-black text-white tracking-tighter"><?= number_format($itemTotal, 0, '.', ' ') ?> <span class="text-orange-600">฿</span></span>
                            </div>
                            <a href="actions/cart.php?action=remove&id=<?= $p['id'] ?>" class="bg-[#27272a] hover:bg-red-600/20 border border-white/10 hover:border-red-500/50 text-zinc-300 hover:text-red-500 w-12 h-12 flex items-center justify-center transition-all shadow-xl group/del">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover/del:rotate-90 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        </div>
                        <div class="absolute top-0 right-0 w-24 h-24 bg-orange-600/5 blur-3xl rounded-full -mr-12 -mt-12 group-hover:bg-orange-600/20 transition-all"></div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="xl:col-span-1">
                <div class="bg-[#18181b] border-2 border-orange-500/30 p-8 sm:p-10 shadow-2xl relative overflow-hidden sticky top-32">
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-10">
                            <div class="w-2 h-8 bg-orange-600"></div>
                            <h4 class="text-xs font-black text-white uppercase tracking-[0.4em]">Checkout Protocol</h4>
                        </div>

                        <div class="bg-black/40 border border-white/10 p-6 mb-10">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-zinc-400 text-[10px] font-bold uppercase tracking-widest">Asset Valuation</span>
                                <span class="text-zinc-200 font-bold tracking-widest"><?= number_format($subtotal, 0, '.', ' ') ?> ฿</span>
                            </div>
                            <div class="flex justify-between items-center mb-6">
                                <span class="text-zinc-400 text-[10px] font-bold uppercase tracking-widest">Logistics</span>
                                <span class="text-orange-500 text-[10px] font-black tracking-widest uppercase italic">Free Sector Delivery</span>
                            </div>
                            <div class="h-[1px] bg-white/10 mb-6"></div>
                            <div class="flex justify-between items-end">
                                <span class="text-zinc-300 text-xs font-black uppercase tracking-[0.2em]">Total Manifest Value</span>
                                <span class="text-4xl font-black text-white tracking-tighter drop-shadow-[0_0_15px_rgba(234,88,12,0.3)]"><?= number_format($subtotal, 0, '.', ' ') ?> <span class="text-orange-600">฿</span></span>
                            </div>
                        </div>

                        <form action="actions/checkout.php" method="POST" class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-[9px] font-black text-zinc-400 uppercase tracking-widest ml-1">Consignee Full Identification</label>
                                <input type="text" name="customer_name" placeholder="ENTER FULL NAME" required 
                                       class="w-full bg-black border border-white/20 text-white px-6 py-5 text-xs font-bold uppercase tracking-[0.2em] outline-none focus:border-orange-600 transition-all placeholder:text-zinc-700">
                            </div>

                            <div class="space-y-2">
                                <label class="text-[9px] font-black text-zinc-400 uppercase tracking-widest ml-1">Secure Comms Frequency</label>
                                <input type="tel" name="customer_phone" placeholder="+7 (___) ___-__-__" required 
                                       class="w-full bg-black border border-white/20 text-white px-6 py-5 text-xs font-bold uppercase tracking-[0.2em] outline-none focus:border-orange-600 transition-all placeholder:text-zinc-700">
                            </div>

                            <div class="space-y-2">
                                <label class="text-[9px] font-black text-zinc-400 uppercase tracking-widest ml-1">Deployment Coordinates</label>
                                <textarea name="customer_address" placeholder="DESTINATION SECTOR / STREET / UNIT" required rows="3"
                                          class="w-full bg-black border border-white/20 text-white px-6 py-5 text-xs font-bold uppercase tracking-[0.2em] outline-none focus:border-orange-600 transition-all placeholder:text-zinc-700 resize-none"></textarea>
                            </div>

                            <button type="submit" 
                                    class="w-full bg-gradient-to-br from-orange-600 to-orange-800 text-white font-black uppercase tracking-[0.4em] text-[11px] py-7 shadow-[0_10px_30px_rgba(234,88,12,0.3)] hover:shadow-[0_15px_40px_rgba(234,88,12,0.5)] hover:-translate-y-1 transition-all active:scale-[0.98] border border-orange-500/30">
                                Initiate Final Transaction
                            </button>
                        </form>

                        <div class="mt-8 pt-8 border-t border-white/5 flex items-center justify-center gap-6 opacity-30">
                             <div class="h-4 w-auto grayscale brightness-200 opacity-50"><img src="https://via.placeholder.com/60x20?text=VISA" alt="visa"></div>
                             <div class="h-4 w-auto grayscale brightness-200 opacity-50"><img src="https://via.placeholder.com/60x20?text=MASTERCARD" alt="mc"></div>
                             <div class="h-4 w-auto grayscale brightness-200 opacity-50"><img src="https://via.placeholder.com/60x20?text=CRYPTO" alt="crypto"></div>
                        </div>
                    </div>
                    <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-orange-600/5 blur-[100px] rounded-full"></div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
