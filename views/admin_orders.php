<?php
$stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
$orders = $stmt->fetchAll();
?>
<div class="mb-16 border-b border-slate-200 pb-10">
    <h1 class="text-xs uppercase tracking-[0.5em] font-extrabold text-indigo-600 mb-3"><?= __('trans_hub') ?></h1>
    <h2 class="text-4xl font-extrabold tracking-tight text-slate-900 uppercase"><?= __('log_manifests') ?></h2>
</div>

<div class="luxury-card rounded-2xl overflow-hidden mb-20">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-50 border-b border-slate-200">
                <th class="px-8 py-6 text-[10px] uppercase tracking-widest font-extrabold text-slate-400"><?= __('col_man_id') ?></th>
                <th class="px-8 py-6 text-[10px] uppercase tracking-widest font-extrabold text-slate-400"><?= __('col_ts') ?></th>
                <th class="px-8 py-6 text-[10px] uppercase tracking-widest font-extrabold text-slate-400"><?= __('col_client') ?></th>
                <th class="px-8 py-6 text-[10px] uppercase tracking-widest font-extrabold text-slate-400"><?= __('col_total') ?></th>
                <th class="px-8 py-6 text-[10px] uppercase tracking-widest font-extrabold text-slate-400 text-center"><?= __('col_status') ?></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            <?php foreach ($orders as $o): ?>
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-8 py-10 text-xs font-bold text-slate-400">#<?= $o['id'] ?></td>
                    <td class="px-8 py-10 text-[10px] font-bold text-slate-500 uppercase tracking-widest"><?= date('d.m.Y // H:i', strtotime($o['created_at'])) ?></td>
                    <td class="px-8 py-10">
                        <div class="text-sm font-bold text-slate-900 mb-1 uppercase tracking-tight"><?= htmlspecialchars($o['customer_name']) ?></div>
                        <div class="text-[10px] text-slate-400 font-semibold tracking-wider italic mb-2"><?= htmlspecialchars($o['customer_phone']) ?></div>
                        <div class="text-[10px] text-slate-500 font-medium leading-relaxed max-w-[200px]"><?= htmlspecialchars($o['customer_address']) ?></div>
                    </td>
                    <td class="px-8 py-10">
                        <span class="text-lg font-extrabold text-slate-900"><?= number_format($o['total_amount'], 0, '.', ' ') ?> <span class="text-indigo-600">฿</span></span>
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

<?php if (empty($orders)): ?>
    <div class="text-center py-32 luxury-card rounded-3xl border-dashed">
        <p class="text-slate-300 text-xs font-bold uppercase tracking-widest"><?= __('zero_manifests') ?></p>
    </div>
<?php endif; ?>
