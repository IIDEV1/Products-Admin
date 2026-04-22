<div class="min-h-screen flex flex-col items-center justify-center bg-[#050505]">
    <div class="w-full max-w-xs bg-[#0c0c0c] p-12 border border-white/5">
        <div class="mb-10 text-center">
            <h2 class="text-xl font-black uppercase tracking-widest"><?= __('nav_admin') ?></h2>
            <p class="text-[10px] text-zinc-500 uppercase tracking-widest mt-2"><?= __('login_title') ?></p>
        </div>
        
        <form action="actions/admin.php?action=login" method="POST" class="space-y-6">
            <div class="space-y-2">
                <label class="text-[9px] uppercase tracking-widest text-zinc-600 font-bold ml-1"><?= __('username') ?></label>
                <input type="text" name="username" required 
                       class="w-full bg-black border border-white/10 text-white px-4 py-4 text-xs font-bold outline-none focus:border-white/40 transition-colors">
            </div>
            <div class="space-y-2">
                <label class="text-[9px] uppercase tracking-widest text-zinc-600 font-bold ml-1"><?= __('password') ?></label>
                <input type="password" name="password" required 
                       class="w-full bg-black border border-white/10 text-white px-4 py-4 text-xs font-bold outline-none focus:border-white/40 transition-colors">
            </div>
            <button type="submit" 
                    class="w-full bg-white text-black py-5 text-[10px] font-black uppercase tracking-[0.3em] hover:bg-zinc-200 transition-colors mt-4">
                <?= __('access_system') ?>
            </button>
        </form>
        
        <?php if (isset($_GET['error'])): ?>
            <p class="mt-8 text-center text-white text-[10px] font-bold uppercase tracking-widest bg-red-950/20 border border-red-900/50 py-3"><?= __('invalid_auth') ?></p>
        <?php endif; ?>
    </div>
</div>
