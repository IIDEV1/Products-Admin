<?php
$order_id = $_GET['oid'] ?? '—';
?>
<div class="min-h-[60vh] flex flex-col items-center justify-center text-center p-8 fade-in-up">
    <div class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center mb-8 border-2 border-green-100">
        <svg class="w-12 h-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
    </div>
    <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-4"><?= __('order_success_title') ?></h1>
    <p class="text-slate-500 text-sm font-medium mb-2"><?= __('order_success_desc') ?></p>
    
    <div class="bg-slate-50 border border-slate-200 rounded-2xl px-8 py-5 mt-6 mb-10 inline-block">
        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1"><?= __('order_number') ?></span>
        <span class="text-2xl font-extrabold text-indigo-600 tracking-tight">#<?= htmlspecialchars($order_id) ?></span>
    </div>

    <div class="flex flex-wrap gap-4 justify-center">
        <a href="/?page=catalog" class="bg-slate-900 text-white px-8 py-4 rounded-xl text-[11px] font-bold uppercase tracking-widest hover:bg-indigo-600 transition-all active:scale-95 shadow-sm">
            <?= __('continue_shopping') ?>
        </a>
        <a href="/" class="bg-white text-slate-700 px-8 py-4 rounded-xl text-[11px] font-bold uppercase tracking-widest border border-slate-200 hover:border-indigo-600 hover:text-indigo-600 transition-all">
            <?= __('go_home') ?>
        </a>
    </div>
</div>
