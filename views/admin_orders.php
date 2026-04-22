<?php
$stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
$orders = $stmt->fetchAll();
?>
<div class="mb-16 border-b border-slate-200 pb-10">
    <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 mb-2 uppercase"><?= __('log_manifests') ?></h1>
    <p class="text-slate-500 font-medium uppercase text-xs tracking-[0.4em]"><?= __('trans_hub') ?></p>
</div>

<div class="luxury-card rounded-3xl overflow-hidden bg-white shadow-sm border border-slate-200">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-8 py-6 text-[10px] uppercase tracking-widest font-extrabold text-slate-400"><?= __('col_man_id') ?></th>
                    <th class="px-8 py-6 text-[10px] uppercase tracking-widest font-extrabold text-slate-400"><?= __('col_ts') ?></th>
                    <th class="px-8 py-6 text-[10px] uppercase tracking-widest font-extrabold text-slate-400"><?= __('col_client') ?></th>
                    <th class="px-8 py-6 text-[10px] uppercase tracking-widest font-extrabold text-slate-400"><?= __('col_asset_man') ?></th>
                    <th class="px-8 py-6 text-[10px] uppercase tracking-widest font-extrabold text-slate-400 text-right"><?= __('col_total') ?></th>
                    <th class="px-8 py-6 text-[10px] uppercase tracking-widest font-extrabold text-slate-400 text-center"><?= __('col_status') ?></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach ($orders as $o): ?>
                    <?php
                    $itemStmt = $pdo->prepare("SELECT oi.*, p.title_ru FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
                    $itemStmt->execute([$o['id']]);
                    $items = $itemStmt->fetchAll();
                    ?>
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-10 text-xs font-bold text-slate-400 tracking-tighter">#<?= $o['id'] ?></td>
                        <td class="px-8 py-10 text-[10px] font-bold text-slate-500 uppercase tracking-widest"><?= date('d.m.Y // H:i', strtotime($o['created_at'])) ?></td>
                        <td class="px-8 py-10">
                            <div class="text-sm font-bold text-slate-900 mb-1 uppercase tracking-tight"><?= htmlspecialchars($o['customer_name']) ?></div>
                            <div class="text-[10px] text-slate-400 font-semibold tracking-wider italic mb-2"><?= __('comms') ?> <?= htmlspecialchars($o['customer_phone']) ?></div>
                            <div class="text-[10px] text-slate-500 font-medium leading-relaxed max-w-[200px]"><?= htmlspecialchars($o['customer_address']) ?></div>
                        </td>
                        <td class="px-8 py-10">
                            <div class="text-[10px] font-bold text-slate-400 leading-relaxed uppercase tracking-tighter space-y-1">
                                <?php foreach($items as $item): ?>
                                    <div class="border-l-2 border-indigo-100 pl-3"><?= htmlspecialchars($item['title_ru']) ?> (x<?= $item['quantity'] ?>)</div>
                                <?php endforeach; ?>
                            </div>
                        </td>
                        <td class="px-8 py-10 text-right">
                            <span class="text-lg font-extrabold text-slate-900 tracking-tighter"><?= number_format($o['total_amount'], 0, '.', ' ') ?> <span class="text-indigo-600 text-sm">฿</span></span>
                        </td>
                        <td class="px-8 py-10 text-center">
                            <span class="text-[9px] font-bold uppercase tracking-widest px-4 py-1.5 rounded-full border border-indigo-100 text-indigo-600 bg-indigo-50">
                                <?= __('status_' . strtolower($o['status'])) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if (empty($orders)): ?>
    <div class="text-center py-32 luxury-card rounded-3xl border-dashed bg-white">
        <p class="text-slate-300 text-xs font-bold uppercase tracking-widest"><?= __('zero_manifests') ?></p>
    </div>
<?php endif; ?>
