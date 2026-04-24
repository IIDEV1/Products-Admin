<div class="breadcrumbs">
    <a href="/"><?= __('nav_home') ?></a>
    <span class="separator">›</span>
    <span class="current"><?= __('nav_admin') ?></span>
</div>

<div class="min-h-[70vh] flex flex-col items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-3xl p-8 md:p-12 border border-slate-200 shadow-xl">
        <div class="mb-10 text-center">
            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-6 border border-slate-100 shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight uppercase"><?= __('nav_admin') ?></h2>
            <p class="text-sm text-slate-500 mt-2 font-medium uppercase tracking-widest"><?= __('login_title') ?></p>
        </div>
        
        <form action="/?action=login" method="POST" class="space-y-6">
            <?= csrf_field() ?>
            <div class="space-y-1">
                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] ml-1"><?= __('username') ?></label>
                <input type="text" name="username" required 
                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-4 text-sm font-semibold text-slate-900 outline-none focus:border-indigo-600 focus:bg-white transition-all">
            </div>
            <div class="space-y-1">
                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] ml-1"><?= __('password') ?></label>
                <input type="password" name="password" required 
                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-4 text-sm font-semibold text-slate-900 outline-none focus:border-indigo-600 focus:bg-white transition-all">
            </div>
            <button type="submit" 
                    class="w-full bg-slate-900 text-white rounded-xl py-5 text-xs font-bold uppercase tracking-[0.3em] shadow-lg hover:bg-indigo-600 hover:scale-[1.02] transition-all active:scale-95 mt-6">
                <?= __('access_system') ?>
            </button>
        </form>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="mt-8 flex items-center gap-3 justify-center text-red-600 bg-red-50 p-4 rounded-xl border border-red-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <span class="text-[10px] font-bold uppercase tracking-widest"><?= __('invalid_auth') ?></span>
            </div>
        <?php endif; ?>
    </div>
</div>
