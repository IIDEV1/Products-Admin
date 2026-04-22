</main>
<div id="cartOverlay" class="fixed inset-0 bg-black/80 backdrop-blur-sm hidden z-40 transition-opacity duration-500"></div>
<div id="cartModal" class="cart-modal fixed top-0 right-0 w-full max-w-lg h-full bg-[#0a0a0a] border-l border-orange-600/20 shadow-[0_0_50px_rgba(0,0,0,0.9)] z-50 flex flex-col">
    <div class="p-8 border-b border-white/5 flex justify-between items-center bg-black/40">
        <div class="flex flex-col">
            <h2 class="text-2xl font-black text-white tracking-tighter uppercase">Inventory Buffer</h2>
            <span class="text-[10px] text-orange-500 font-bold tracking-[0.4em] uppercase">Sector Cart</span>
        </div>
        <button id="closeCart" class="text-zinc-500 hover:text-orange-500 text-4xl transition-colors">&times;</button>
    </div>
    
    <div id="cartItems" class="flex-grow overflow-y-auto p-8 space-y-6 scrollbar-thin scrollbar-thumb-orange-600">
        <!-- Rendered via JS -->
    </div>
    
    <div class="p-8 border-t border-white/5 bg-black/60 backdrop-blur-2xl">
        <div class="flex justify-between items-center mb-8 bg-orange-600/5 p-6 border border-orange-600/10">
            <span class="text-xs font-black uppercase tracking-widest text-zinc-500">Total Valuation</span>
            <span id="cartTotal" class="text-3xl font-black text-white drop-shadow-[0_0_15px_rgba(234,88,12,0.4)]">0 ฿</span>
        </div>
        
        <form id="checkoutForm" class="space-y-4">
            <input type="text" name="customer_name" placeholder="IDENTIFICATION NAME" required 
                   class="w-full bg-black border border-white/10 text-white px-6 py-5 text-xs font-bold uppercase tracking-widest outline-none focus:border-orange-500 transition-all placeholder:text-zinc-800">
            
            <input type="tel" name="customer_phone" id="phoneInput" placeholder="+7 (999) 000-00-00" required maxlength="18"
                   class="w-full bg-black border border-white/10 text-white px-6 py-5 text-xs font-bold uppercase tracking-widest outline-none focus:border-orange-500 transition-all placeholder:text-zinc-800">
            
            <input type="text" name="customer_address" placeholder="DELIVERY COORDINATES" required 
                   class="w-full bg-black border border-white/10 text-white px-6 py-5 text-xs font-bold uppercase tracking-widest outline-none focus:border-orange-500 transition-all placeholder:text-zinc-800">
            
            <button type="submit" class="w-full bg-orange-600 text-white font-black uppercase tracking-[0.3em] text-[11px] py-6 hover:bg-orange-500 shadow-xl transition-all active:scale-[0.98]">
                Execute Purchase Protocol
            </button>
        </form>
    </div>
</div>

<script src="public/app.js"></script>
<script>
const phoneInput = document.getElementById('phoneInput');

if (phoneInput) {
    phoneInput.addEventListener('focus', () => {
        if (!phoneInput.value) phoneInput.value = '+7 ';
    });

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

    phoneInput.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && phoneInput.value.length <= 4) {
            e.preventDefault();
        }
    });
}
</script>
</body>
</html>
