</main>

<!-- Cart Modal Overlay -->
<div id="cartOverlay" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden z-[60] transition-opacity duration-500"></div>

<!-- Cart Modal -->
<div id="cartModal" class="fixed top-0 right-0 w-full max-w-md h-full bg-white shadow-2xl z-[70] transform translate-x-full transition-transform duration-500 ease-in-out flex flex-col border-l border-slate-200">
    <div class="p-8 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
        <div class="flex flex-col">
            <h2 class="text-xl font-extrabold text-slate-900 tracking-tight uppercase"><?= __('inventory') ?></h2>
            <span class="text-[10px] text-indigo-600 font-extrabold tracking-[0.4em] uppercase"><?= __('sector_cart_registry') ?></span>
        </div>
        <button id="closeCart" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-slate-200 text-slate-400 hover:text-slate-900 transition-all text-2xl font-light">&times;</button>
    </div>
    
    <div id="cartItems" class="flex-grow overflow-y-auto p-8 space-y-6 scrollbar-thin scrollbar-thumb-indigo-600">
        <!-- Rendered via JS -->
    </div>
    
    <div class="p-8 border-t border-slate-100 bg-slate-50/80 backdrop-blur-xl">
        <div class="flex justify-between items-center mb-8 p-6 rounded-2xl bg-white border border-slate-200 shadow-sm">
            <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400"><?= __('total_valuation') ?></span>
            <span id="cartTotal" class="text-3xl font-extrabold text-slate-900 tracking-tighter">0 <span class="text-indigo-600 text-sm">฿</span></span>
        </div>
        
        <form id="checkoutForm" class="space-y-4">
            <div class="space-y-1">
                <input type="text" name="customer_name" placeholder="<?= __('consignee_id') ?>" required 
                       class="w-full bg-white border border-slate-200 text-slate-900 px-6 py-4 text-xs font-bold uppercase tracking-widest rounded-xl outline-none focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 transition-all placeholder:text-slate-300">
            </div>
            
            <div class="space-y-1">
                <input type="tel" name="customer_phone" id="phoneInput" placeholder="+7 (999) 000-00-00" required maxlength="18"
                       class="w-full bg-white border border-slate-200 text-slate-900 px-6 py-4 text-xs font-bold uppercase tracking-widest rounded-xl outline-none focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 transition-all placeholder:text-slate-300">
            </div>
            
            <div class="space-y-1">
                <input type="text" name="customer_address" placeholder="<?= __('deployment_coords') ?>" required 
                       class="w-full bg-white border border-slate-200 text-slate-900 px-6 py-4 text-xs font-bold uppercase tracking-widest rounded-xl outline-none focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 transition-all placeholder:text-slate-300">
            </div>
            
            <button type="submit" class="w-full bg-slate-900 text-white font-bold uppercase tracking-[0.2em] text-[11px] py-5 rounded-xl hover:bg-indigo-600 shadow-xl shadow-slate-200 transition-all active:scale-[0.98] mt-4">
                <?= __('initiate_transaction') ?>
            </button>
        </form>
    </div>
</div>

<footer class="bg-white border-t border-slate-200 py-16 mt-12">
    <div class="container mx-auto px-6 text-center">
        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.4em]">&copy; 2026 ORBITAL SYSTEM. ALL SYSTEMS OPERATIONAL.</p>
    </div>
</footer>

<script src="public/app.js"></script>
<script>
// Phone formatting logic remains same
const phoneInput = document.getElementById('phoneInput');
if (phoneInput) {
    phoneInput.addEventListener('focus', () => { if (!phoneInput.value) phoneInput.value = '+7 '; });
    phoneInput.addEventListener('input', (e) => {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 0 && value[0] === '7') value = value.substring(1);
        if (value.length > 0 && value[0] === '8') value = value.substring(1);
        let formatted = '+7 ';
        if (value.length > 0) formatted += '(' + value.substring(0, 3);
        if (value.length > 3) formatted += ') ' + value.substring(3, 6);
        if (value.length > 6) formatted += '-' + value.substring(6, 8);
        if (value.length > 8) formatted += '-' + value.substring(8, 10);
        e.target.value = formatted.substring(0, 18);
    });
}
</script>
</body>
</html>
