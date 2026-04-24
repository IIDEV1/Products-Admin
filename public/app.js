// === Toast Notification System ===
function showToast(message, type = 'success') {
    const container = document.getElementById('toastContainer');
    if (!container) return;
    
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            ${type === 'success' 
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>'
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>'}
        </svg>
        <span>${message}</span>
    `;
    container.appendChild(toast);
    
    setTimeout(() => {
        toast.classList.add('toast-out');
        setTimeout(() => toast.remove(), 300);
    }, 2500);
}

// === Cart Badge Animation ===
function animateCartBadge() {
    const badge = document.getElementById('navCartCount');
    if (badge) {
        badge.classList.remove('badge-pop');
        void badge.offsetWidth; // force reflow
        badge.classList.add('badge-pop');
    }
}

function updateCartCount(count) {
    const badge = document.getElementById('navCartCount');
    if (badge) {
        badge.textContent = count;
        animateCartBadge();
    }
}

// === AJAX Add to Cart ===
document.addEventListener('click', async function(e) {
    const btn = e.target.closest('.add-to-cart-btn');
    if (!btn) return;
    
    e.preventDefault();
    const id = btn.dataset.id || btn.href?.match(/id=(\d+)/)?.[1];
    if (!id) {
        window.location.href = btn.href;
        return;
    }

    try {
        const response = await fetch(`/?action=add&id=${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await response.json();
        
        if (data.success) {
            updateCartCount(data.count);
            showToast('Товар добавлен в корзину');
        }
    } catch (err) {
        // Fallback to regular navigation
        window.location.href = btn.href || `/?action=add&id=${id}`;
    }
});

// === Init ===
document.addEventListener('DOMContentLoaded', function() {
    // Show order success toast if redirected
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('order') === 'success') {
        showToast('Заказ успешно оформлен!');
    }
});
