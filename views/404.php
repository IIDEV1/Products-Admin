<div class="min-h-[60vh] flex flex-col items-center justify-center text-center p-8 fade-in-up">
    <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mb-8">
        <svg class="w-12 h-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>
    <h1 class="text-5xl md:text-7xl font-extrabold text-slate-900 tracking-tighter mb-4">404</h1>
    <p class="text-slate-500 text-sm font-bold uppercase tracking-widest mb-2"><?= __('page_not_found') ?></p>
    <p class="text-slate-400 text-sm mb-10 max-w-md"><?= __('page_not_found_desc') ?></p>
    <a href="/" class="bg-slate-900 text-white px-8 py-4 rounded-xl text-[11px] font-bold uppercase tracking-widest hover:bg-indigo-600 transition-all active:scale-95 shadow-sm">
        <?= __('go_home') ?>
    </a>
</div>
