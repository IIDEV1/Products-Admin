// Elements
const cartModal = document.getElementById('cartModal');
const cartOverlay = document.getElementById('cartOverlay');
const closeCart = document.getElementById('closeCart');
const cartItemsContainer = document.getElementById('cartItems');
const cartTotalElement = document.getElementById('cartTotal');
const cartCountElement = document.getElementById('cartCount');
const checkoutForm = document.getElementById('checkoutForm');

// Toggle Cart
const toggleCart = () => {
    cartModal.classList.toggle('translate-x-full');
    cartOverlay.classList.toggle('hidden');
};

if (closeCart) closeCart.onclick = toggleCart;
if (cartOverlay) cartOverlay.onclick = toggleCart;

// Update UI
async function updateCartUI() {
    if (!cartItemsContainer) return;

    const response = await fetch('actions/cart.php?action=get');
    const data = await response.json();
    
    cartItemsContainer.innerHTML = '';
    let total = 0;
    let count = 0;

    if (data.items.length === 0) {
        cartItemsContainer.innerHTML = '<p class="text-center text-slate-400 text-xs font-bold uppercase tracking-widest py-10">Корзина пуста</p>';
    }

    data.items.forEach(item => {
        total += item.price * item.quantity;
        count += item.quantity;
        
        const div = document.createElement('div');
        div.className = 'luxury-card rounded-2xl p-5 bg-white border border-slate-100 flex items-center justify-between group transition-all';
        div.innerHTML = `
            <div class="flex-grow">
                <h4 class="font-extrabold text-slate-900 uppercase tracking-tight text-xs group-hover:text-indigo-600 transition-colors">${item.title}</h4>
                <p class="text-[10px] text-slate-400 font-bold tracking-widest mt-1 uppercase">${item.price.toLocaleString('ru-RU')} ฿ x ${item.quantity}</p>
            </div>
            <button onclick="removeFromCart(${item.id})" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-50 text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all text-xl font-light ml-4">&times;</button>
        `;
        cartItemsContainer.appendChild(div);
    });

    if (cartTotalElement) cartTotalElement.innerHTML = `${total.toLocaleString('ru-RU')} <span class="text-indigo-600 text-sm">฿</span>`;
    if (cartCountElement) cartCountElement.innerText = count;
}

async function removeFromCart(productId) {
    await fetch(`actions/cart.php?action=remove&id=${productId}`);
    updateCartUI();
}

if (checkoutForm) {
    checkoutForm.onsubmit = async (e) => {
        e.preventDefault();
        const formData = new FormData(checkoutForm);
        const response = await fetch('actions/checkout.php', { method: 'POST', body: formData });
        
        // Note: actions/checkout.php currently redirects, but if we change it to JSON:
        // const result = await response.json();
        // if (result.success) { ... }

        alert('ТРАНЗАКЦИЯ УСПЕШНА. ЛОГИСТИКА ЗАПУЩЕНА.');
        window.location.href = '/?page=catalog&order=success';
    };
}

document.addEventListener('DOMContentLoaded', updateCartUI);
