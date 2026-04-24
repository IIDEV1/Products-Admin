<?php
$productCount = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$orderCount = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$newOrderCount = $pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'new'")->fetchColumn();
$totalRevenue = $pdo->query("SELECT COALESCE(SUM(total_amount), 0) FROM orders")->fetchColumn();
$recentOrders = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>

<div class="mb-10">
    <h1 class="text-3xl font-black uppercase tracking-tighter text-slate-900"><?= __('admin_dashboard') ?></h1>
    <p class="text-slate-500 text-sm mt-1 font-medium"><?= __('dashboard_desc') ?></p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
    <div class="stat-card">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-slate-900"><?= $productCount ?></div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest"><?= __('stat_products') ?></div>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-slate-900"><?= $orderCount ?></div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest"><?= __('stat_orders') ?></div>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-amber-600"><?= $newOrderCount ?></div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest"><?= __('stat_new_orders') ?></div>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-slate-900"><?= number_format($totalRevenue, 0, '.', ' ') ?> <span class="text-sm text-indigo-600">₽</span></div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest"><?= __('stat_revenue') ?></div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-sm font-extrabold text-slate-900 uppercase tracking-widest"><?= __('recent_orders') ?></h2>
            <a href="/?page=admin_orders" class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest hover:text-slate-900 transition-colors"><?= __('view_all') ?> →</a>
        </div>
        <div class="space-y-3">
            <?php if (empty($recentOrders)): ?>
                <div class="bg-white border-2 border-dashed border-slate-200 rounded-2xl p-8 text-center">
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest"><?= __('no_orders_yet') ?></p>
                </div>
            <?php else: ?>
                <?php foreach ($recentOrders as $o): ?>
                <div class="bg-white border border-slate-200 rounded-xl p-4 flex items-center justify-between hover:shadow-sm transition-all">
                    <div>
                        <span class="text-xs font-bold text-slate-900">#<?= $o['id'] ?> — <?= htmlspecialchars($o['customer_name']) ?></span>
                        <div class="text-[10px] text-slate-400 font-bold mt-0.5"><?= date('d.m.Y H:i', strtotime($o['created_at'])) ?></div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-extrabold text-slate-900"><?= number_format($o['total_amount'], 0, '.', ' ') ?> ₽</div>
                        <span class="text-[9px] font-bold uppercase tracking-widest px-2 py-0.5 rounded-full <?= $o['status'] === 'new' ? 'bg-amber-50 text-amber-600 border border-amber-100' : 'bg-green-50 text-green-600 border border-green-100' ?>">
                            <?= __('status_' . strtolower($o['status'])) ?>
                        </span>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <div>
        <h2 class="text-sm font-extrabold text-slate-900 uppercase tracking-widest mb-6"><?= __('quick_actions') ?></h2>
        <div class="space-y-3">
            <a href="/?page=admin_products" class="block bg-white border border-slate-200 rounded-xl p-5 hover:shadow-sm hover:border-indigo-200 transition-all group">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center group-hover:bg-indigo-100 transition-colors">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-900"><?= __('manage_products') ?></div>
                        <div class="text-[10px] text-slate-400 font-medium"><?= __('manage_products_desc') ?></div>
                    </div>
                </div>
            </a>
            <a href="/?page=admin_orders" class="block bg-white border border-slate-200 rounded-xl p-5 hover:shadow-sm hover:border-indigo-200 transition-all group">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center group-hover:bg-green-100 transition-colors">
                        <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-900"><?= __('manage_orders') ?></div>
                        <div class="text-[10px] text-slate-400 font-medium"><?= __('manage_orders_desc') ?></div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
