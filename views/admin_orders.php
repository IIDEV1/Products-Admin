<?php
$stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
$orders = $stmt->fetchAll();
?>
<div class="mb-16 border-b border-white/10 pb-10">
    <h1 class="text-4xl font-extrabold tracking-tighter text-white mb-2 uppercase"><?= __('log_manifests') ?></h1>
    <p class="text-slate-500 font-medium uppercase text-xs tracking-[0.4em]"><?= __('trans_hub') ?></p>
</div>

<div class="space-y-6">
    <?php foreach ($orders as $o): ?>
        <?php
        $itemStmt = $pdo->prepare("SELECT oi.*, p.title_ru FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
        $itemStmt->execute([$o['id']]);
        $items = $itemStmt->fetchAll();
        ?>
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 hover:border-cyan-500/50 hover:shadow-[0_0_20px_rgba(6,182,212,0.15)] transition-all group">
            <div class="flex flex-wrap justify-between items-start gap-6">
                <div class="space-y-4 flex-1 min-w-[300px]">
                    <div class="flex items-center gap-4">
                        <span class="text-xs font-bold text-slate-500 tracking-tighter uppercase">ID #<?= $o['id'] ?></span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-white/5 px-3 py-1 rounded-full border border-white/10">
                            <?= date('d.m.Y // H:i', strtotime($o['created_at'])) ?>
                        </span>
                        <?php if (strtolower($o['status']) === 'new'): ?>
                            <span class="text-[9px] font-bold uppercase tracking-widest px-4 py-1.5 rounded-full border border-fuchsia-500/30 text-fuchsia-400 bg-fuchsia-500/20 shadow-[0_0_10px_rgba(217,70,239,0.2)]">
                                <?= __('status_' . strtolower($o['status'])) ?>
                            </span>
                        <?php else: ?>
                            <span class="text-[9px] font-bold uppercase tracking-widest px-4 py-1.5 rounded-full border border-cyan-500/30 text-cyan-400 bg-cyan-500/20">
                                <?= __('status_' . strtolower($o['status'])) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <div>
                        <div class="text-lg font-bold text-white mb-1 uppercase tracking-tight"><?= htmlspecialchars($o['customer_name']) ?></div>
                        <div class="text-[10px] text-cyan-400 font-bold tracking-widest uppercase mb-3 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <?= htmlspecialchars($o['customer_phone']) ?>
                        </div>
                        <div class="text-[11px] text-slate-400 font-medium leading-relaxed max-w-md bg-slate-950/50 p-4 rounded-2xl border border-white/5">
                            <span class="text-slate-500 uppercase text-[9px] block mb-1 tracking-widest font-bold">Адрес доставки:</span>
                            <?= htmlspecialchars($o['customer_address']) ?>
                        </div>
                    </div>
                </div>

                <div class="flex-1 min-w-[300px]">
                    <div class="bg-slate-900/50 border border-white/5 rounded-2xl p-6 space-y-3">
                        <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest block mb-2">Состав заказа:</span>
                        <?php foreach($items as $item): ?>
                            <div class="flex justify-between items-center text-[11px] font-bold text-slate-300 uppercase tracking-tight border-b border-white/5 pb-2 last:border-0 last:pb-0">
                                <span class="border-l-2 border-fuchsia-500 pl-3"><?= htmlspecialchars($item['title_ru']) ?></span>
                                <span class="text-white bg-white/5 px-2 py-1 rounded">x<?= $item['quantity'] ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="mt-6 flex justify-between items-end">
                        <div class="text-right flex-grow">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-slate-500 block mb-1">Итоговая сумма</span>
                            <span class="text-3xl font-black text-white tracking-tighter"><?= number_format($o['total_amount'], 0, '.', ' ') ?> <span class="text-cyan-400 text-sm">฿</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php if (empty($orders)): ?>
    <div class="text-center py-32 bg-white/5 backdrop-blur-xl rounded-3xl border-2 border-dashed border-white/10">
        <p class="text-slate-500 text-xs font-bold uppercase tracking-widest"><?= __('zero_manifests') ?></p>
    </div>
<?php endif; ?>
