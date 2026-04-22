<?php
$stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
$orders = $stmt->fetchAll();
?>
<div class="mb-12 border-b border-slate-200 pb-10">
    <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 mb-2 uppercase"><?= __('log_manifests') ?></h1>
    <p class="text-slate-500 font-medium uppercase text-[10px] tracking-[0.4em]"><?= __('trans_hub') ?></p>
</div>

<div class="space-y-6">
    <?php foreach ($orders as $o): ?>
        <?php
        $itemStmt = $pdo->prepare("SELECT oi.*, p.title_ru FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
        $itemStmt->execute([$o['id']]);
        $items = $itemStmt->fetchAll();
        ?>
        <div class="bg-white border border-slate-200 rounded-3xl p-6 md:p-8 hover:shadow-lg transition-all">
            <div class="flex flex-col lg:flex-row justify-between items-start gap-8">
                <div class="space-y-6 flex-1 w-full">
                    <div class="flex flex-wrap items-center gap-4">
                        <span class="text-xs font-bold text-slate-400 tracking-tighter uppercase">ID #<?= $o['id'] ?></span>
                        <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest bg-slate-50 px-3 py-1.5 rounded-full border border-slate-100">
                            <?= date('d.m.Y // H:i', strtotime($o['created_at'])) ?>
                        </span>
                        <span class="text-[9px] font-bold uppercase tracking-widest px-4 py-1.5 rounded-full border border-indigo-100 text-indigo-600 bg-indigo-50">
                            <?= __('status_' . strtolower($o['status'])) ?>
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest block mb-2">Клиент</span>
                            <div class="text-base font-bold text-slate-900 mb-1 uppercase tracking-tight"><?= htmlspecialchars($o['customer_name']) ?></div>
                            <div class="text-xs text-indigo-600 font-bold tracking-wider mb-2"><?= htmlspecialchars($o['customer_phone']) ?></div>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest block mb-2">Адрес</span>
                            <div class="text-xs text-slate-500 font-medium leading-relaxed"><?= htmlspecialchars($o['customer_address']) ?></div>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-96 space-y-4">
                    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block mb-4">Состав заказа:</span>
                        <div class="space-y-3">
                            <?php foreach($items as $item): ?>
                                <div class="flex justify-between items-center text-xs font-bold text-slate-600 uppercase tracking-tight">
                                    <span class="truncate pr-4"><?= htmlspecialchars($item['title_ru']) ?></span>
                                    <span class="bg-white px-2 py-1 rounded border border-slate-200 text-[10px] shrink-0">x<?= $item['quantity'] ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="mt-6 pt-6 border-t border-slate-200 flex justify-between items-center">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Итого:</span>
                            <span class="text-2xl font-black text-slate-900 tracking-tighter"><?= number_format($o['total_amount'], 0, '.', ' ') ?> <span class="text-indigo-600 text-sm">฿</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php if (empty($orders)): ?>
    <div class="text-center py-32 bg-white rounded-3xl border-2 border-dashed border-slate-200">
        <p class="text-slate-300 text-xs font-bold uppercase tracking-widest"><?= __('zero_manifests') ?></p>
    </div>
<?php endif; ?>
