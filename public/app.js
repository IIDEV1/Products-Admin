const cartModal = document.getElementById('cartModal');
const cartOverlay = document.getElementById('cartOverlay');
const cartBtn = document.getElementById('cartBtn');
const closeCart = document.getElementById('closeCart');
const cartItemsContainer = document.getElementById('cartItems');
const cartTotalElement = document.getElementById('cartTotal');
const cartCountElement = document.getElementById('cartCount');
const checkoutForm = document.getElementById('checkoutForm');

const toggleCart = () => {
    cartModal.classList.toggle('open');
    cartOverlay.classList.toggle('hidden');
};

cartBtn.onclick = toggleCart;
closeCart.onclick = toggleCart;
cartOverlay.onclick = toggleCart;

async function updateCartUI() {
    const response = await fetch('actions/cart.php?action=get');
    const data = await response.json();
    
    cartItemsContainer.innerHTML = '';
    let total = 0;
    let count = 0;

    data.items.forEach(item => {
        total += item.price * item.quantity;
        count += item.quantity;
        
        const div = document.createElement('div');
        div.className = 'flex items-center justify-between bg-black border border-white/5 p-6 rounded-sm shadow-xl group';
        div.innerHTML = `
            <div class="flex-grow">
                <h4 class="font-black text-white uppercase tracking-widest text-[11px] group-hover:text-orange-500 transition-colors">${item.title}</h4>
                <p class="text-[10px] text-zinc-600 font-bold tracking-widest mt-1 uppercase">${item.price} ฿ x ${item.quantity}</p>
            </div>
            <button onclick="removeFromCart(${item.id})" class="text-zinc-700 hover:text-orange-600 text-2xl ml-4 transition-colors">&times;</button>
        `;
        cartItemsContainer.appendChild(div);
    });

    cartTotalElement.innerText = `${total.toLocaleString('ru-RU')} ฿`;
    cartCountElement.innerText = count;
}

async function addToCart(productId) {
    const formData = new FormData();
    formData.append('product_id', productId);
    await fetch('actions/cart.php?action=add', { method: 'POST', body: formData });
    updateCartUI();
    if (!cartModal.classList.contains('open')) toggleCart();
}

async function removeFromCart(productId) {
    const formData = new FormData();
    formData.append('product_id', productId);
    await fetch('actions/cart.php?action=remove', { method: 'POST', body: formData });
    updateCartUI();
}

checkoutForm.onsubmit = async (e) => {
    e.preventDefault();
    const formData = new FormData(checkoutForm);
    const response = await fetch('actions/checkout.php', { method: 'POST', body: formData });
    const result = await response.json();
    
    if (result.success) {
        alert('PURCHASE SUCCESSFUL. LOGISTICS INITIATED.');
        checkoutForm.reset();
        updateCartUI();
        toggleCart();
    } else {
        alert(result.error || 'ERROR IN REGISTRY');
    }
};

document.addEventListener('DOMContentLoaded', updateCartUI);
