<?php
$stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
$orders = $stmt->fetchAll();
?>
<div class="pt-32 mb-16 border-b border-white/5 pb-10">
    <h1 class="text-xs uppercase tracking-[0.5em] font-black text-orange-500 mb-3"><?= __('trans_hub') ?></h1>
    <h2 class="text-4xl font-black tracking-tighter uppercase text-white"><?= __('log_manifests') ?></h2>
</div>

<div class="bg-[#0a0a0a] border border-white/5 overflow-hidden shadow-2xl mb-40">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-black border-b border-orange-600/20">
                <th class="px-10 py-8 text-[10px] uppercase tracking-[0.3em] font-black text-zinc-600"><?= __('col_man_id') ?></th>
                <th class="px-10 py-8 text-[10px] uppercase tracking-[0.3em] font-black text-zinc-600"><?= __('col_ts') ?></th>
                <th class="px-10 py-8 text-[10px] uppercase tracking-[0.3em] font-black text-zinc-600"><?= __('col_client') ?></th>
                <th class="px-10 py-8 text-[10px] uppercase tracking-[0.3em] font-black text-zinc-600"><?= __('col_asset_man') ?></th>
                <th class="px-10 py-8 text-[10px] uppercase tracking-[0.3em] font-black text-zinc-600 text-right"><?= __('col_total') ?></th>
                <th class="px-10 py-8 text-[10px] uppercase tracking-[0.3em] font-black text-zinc-600 text-center"><?= __('col_status') ?></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            <?php foreach ($orders as $o): ?>
                <?php
                $lang = $_SESSION['lang'] ?? 'ru';
                $title_col = ($lang === 'en') ? 'title_en' : 'title_ru';
                $itemStmt = $pdo->prepare("SELECT oi.*, p.title_ru, p.title_en FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
                $itemStmt->execute([$o['id']]);
                $items = $itemStmt->fetchAll();
                $manifest = [];
                foreach ($items as $item) {
                    $t = (!empty($item[$title_col])) ? $item[$title_col] : $item['title_ru'];
                    $manifest[] = htmlspecialchars($t) . " (QTY:" . $item['quantity'] . ")";
                }
                ?>
                <tr class="hover:bg-orange-600/[0.02] transition-colors">
                    <td class="px-10 py-12 text-xs font-black text-zinc-700 tracking-tighter">#<?= $o['id'] ?></td>
                    <td class="px-10 py-12 text-[10px] font-black text-zinc-500 tracking-widest uppercase"><?= date('d.m.Y // H:i', strtotime($o['created_at'])) ?></td>
                    <td class="px-10 py-12">
                        <div class="text-sm font-black uppercase tracking-widest text-white mb-2"><?= htmlspecialchars($o['customer_name']) ?></div>
                        <div class="text-[10px] text-zinc-500 font-bold tracking-[0.2em] mb-2 italic"><?= __('comms') ?> <?= htmlspecialchars($o['customer_phone']) ?></div>
                        <div class="text-[9px] text-zinc-600 uppercase tracking-widest leading-loose max-w-[200px]"><?= htmlspecialchars($o['customer_address']) ?></div>
                    </td>
                    <td class="px-10 py-12">
                        <div class="text-[10px] font-bold text-zinc-400 leading-relaxed uppercase tracking-tighter space-y-1">
                            <?php foreach($manifest as $item): ?>
                                <div class="border-l-2 border-orange-600/30 pl-3"><?= $item ?></div>
                            <?php endforeach; ?>
                        </div>
                    </td>
                    <td class="px-10 py-12 text-right">
                        <span class="text-xl font-black tracking-widest text-white"><?= number_format($o['total_amount'], 0, '.', ' ') ?> <span class="text-orange-600">฿</span></span>
                    </td>
                    <td class="px-10 py-12 text-center">
                        <span class="text-[9px] font-black uppercase tracking-[0.3em] px-5 py-2 rounded-sm border border-orange-600/40 text-orange-500 bg-orange-600/5">
                            <?= __('status_' . strtolower($o['status'])) ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if (empty($orders)): ?>
    <div class="text-center py-40 bg-[#0a0a0a] border border-white/5 border-dashed rounded-sm shadow-inner">
        <p class="text-zinc-700 text-[10px] font-black uppercase tracking-[0.5em]"><?= __('zero_manifests') ?></p>
    </div>
<?php endif; ?>
