<?php
// Fix N+1: fetch all orders with their items in one go
$orders = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC")->fetchAll();

$orderItems = [];
if (!empty($orders)) {
    $orderIds = array_column($orders, 'id');
    $placeholders = str_repeat('?,', count($orderIds) - 1) . '?';
    $itemStmt = $pdo->prepare("SELECT oi.*, COALESCE(p.title_ru, p.name) as title_ru FROM order_items oi LEFT JOIN products p ON oi.product_id = p.id WHERE oi.order_id IN ($placeholders) ORDER BY oi.id");
    $itemStmt->execute($orderIds);
    $allItems = $itemStmt->fetchAll();
    foreach ($allItems as $item) {
        $orderItems[$item['order_id']][] = $item;
    }
}
?>

<div class="breadcrumbs">
    <a href="/"><?= __('nav_home') ?></a>
    <span class="separator">›</span>
    <a href="/?page=admin_dashboard"><?= __('nav_dashboard') ?></a>
    <span class="separator">›</span>
    <span class="current"><?= __('nav_orders') ?></span>
</div>

<div class="mb-12 border-b border-slate-200 pb-10">
    <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 mb-2 uppercase"><?= __('log_manifests') ?></h1>
    <p class="text-slate-500 font-medium uppercase text-[10px] tracking-[0.4em]"><?= __('trans_hub') ?></p>
</div>

<?php if (empty($orders)): ?>
    <div class="text-center py-32 bg-white rounded-3xl border-2 border-dashed border-slate-200">
        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </div>
        <p class="text-slate-300 text-xs font-bold uppercase tracking-widest"><?= __('zero_manifests') ?></p>
    </div>
<?php else: ?>
    <div class="space-y-6">
        <?php foreach ($orders as $o): ?>
            <?php $items = $orderItems[$o['id']] ?? []; ?>
            <div class="bg-white border border-slate-200 rounded-3xl p-6 md:p-8 hover:shadow-lg transition-all">
                <div class="flex flex-col lg:flex-row justify-between items-start gap-8">
                    <div class="space-y-6 flex-1 w-full">
                        <div class="flex flex-wrap items-center gap-4">
                            <span class="text-xs font-bold text-slate-400 tracking-tighter uppercase">ID #<?= $o['id'] ?></span>
                            <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest bg-slate-50 px-3 py-1.5 rounded-full border border-slate-100">
                                <?= date('d.m.Y // H:i', strtotime($o['created_at'])) ?>
                            </span>
                            <span class="text-[9px] font-bold uppercase tracking-widest px-4 py-1.5 rounded-full border <?= $o['status'] === 'new' ? 'border-amber-100 text-amber-600 bg-amber-50' : 'border-green-100 text-green-600 bg-green-50' ?>">
                                <?= __('status_' . strtolower($o['status'])) ?>
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest block mb-2"><?= __('col_client') ?></span>
                                <div class="text-base font-bold text-slate-900 mb-1 uppercase tracking-tight"><?= htmlspecialchars($o['customer_name']) ?></div>
                                <div class="text-xs text-indigo-600 font-bold tracking-wider mb-2"><?= htmlspecialchars($o['customer_phone']) ?></div>
                            </div>
                            <div>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest block mb-2"><?= __('address_label') ?></span>
                                <div class="text-xs text-slate-500 font-medium leading-relaxed"><?= htmlspecialchars($o['customer_address']) ?></div>
                            </div>
                        </div>

                        <!-- Status change -->
                        <form action="/?action=order_status" method="POST" class="flex items-center gap-3">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= $o['id'] ?>">
                            <?php if ($o['status'] === 'new'): ?>
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="text-[10px] font-bold uppercase tracking-widest bg-green-50 text-green-600 border border-green-100 px-4 py-2 rounded-lg hover:bg-green-600 hover:text-white transition-all">
                                    ✓ <?= __('mark_completed') ?>
                                </button>
                            <?php else: ?>
                                <input type="hidden" name="status" value="new">
                                <button type="submit" class="text-[10px] font-bold uppercase tracking-widest bg-amber-50 text-amber-600 border border-amber-100 px-4 py-2 rounded-lg hover:bg-amber-600 hover:text-white transition-all">
                                    ↺ <?= __('mark_new') ?>
                                </button>
                            <?php endif; ?>
                        </form>
                    </div>

                    <div class="w-full lg:w-96 space-y-4">
                        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6">
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block mb-4"><?= __('order_contents') ?>:</span>
                            <div class="space-y-3">
                                <?php if (empty($items)): ?>
                                    <p class="text-[10px] text-slate-400 italic"><?= __('no_items_data') ?></p>
                                <?php else: ?>
                                    <?php foreach($items as $item): ?>
                                        <div class="flex justify-between items-center text-xs font-bold text-slate-600 uppercase tracking-tight">
                                            <span class="truncate pr-4"><?= htmlspecialchars($item['title_ru'] ?? __('no_title')) ?></span>
                                            <span class="bg-white px-2 py-1 rounded border border-slate-200 text-[10px] shrink-0">x<?= $item['quantity'] ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mt-6 pt-6 border-t border-slate-200 flex justify-between items-center">
                                <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400"><?= __('col_total') ?>:</span>
                                <span class="text-2xl font-black text-slate-900 tracking-tighter"><?= number_format($o['total_amount'], 0, '.', ' ') ?> <span class="text-indigo-600 text-sm">₽</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
