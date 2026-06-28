/**
 * ECOutdoor - Persisten Shopping Cart System (LocalStorage)
 */

// Mendapatkan data keranjang dari LocalStorage
function getCart() {
  try {
    const cart = localStorage.getItem('ecoutdoor_cart');
    return cart ? JSON.parse(cart) : [];
  } catch (e) {
    console.error("Gagal membaca keranjang belanja:", e);
    return [];
  }
}

// Menyimpan data keranjang ke LocalStorage, update badge, dan render ulang drawer
function saveCart(cart) {
  try {
    localStorage.setItem('ecoutdoor_cart', JSON.stringify(cart));
    updateBadge();
    renderCartDrawer();
  } catch (e) {
    console.error("Gagal menyimpan keranjang belanja:", e);
  }
}

// Memperbarui badge jumlah produk di navbar
function updateBadge() {
  const cart = getCart();
  const count = cart.reduce((total, item) => total + item.qty, 0);
  const badges = document.querySelectorAll('.cart-badge');
  
  badges.forEach(badge => {
    if (count > 0) {
      badge.textContent = count;
      badge.style.display = 'flex';
      badge.classList.remove('hidden');
    } else {
      badge.style.display = 'none';
      badge.classList.add('hidden');
    }
  });
}

// Menambahkan produk ke keranjang belanja
function addToCart(id, name, price, image, stok, qty) {
  let cart = getCart();
  let existing = cart.find(item => item.id === id);
  qty = parseInt(qty) || 1;

  if (existing) {
    if (existing.qty + qty > stok) {
      showToast(`⚠️ Stok terbatas, tidak bisa menambah lebih dari ${stok} unit`, 'error');
      return;
    }
    existing.qty += qty;
  } else {
    if (qty > stok) {
      showToast(`⚠️ Stok terbatas, tidak bisa menambah lebih dari ${stok} unit`, 'error');
      return;
    }
    cart.push({ id, name, price, image, stok, qty });
  }

  saveCart(cart);
  playBadgeAnimation();
  showToast(`✓ <strong>${name}</strong> berhasil ditambahkan ke keranjang`, 'success');
}

// Memperbarui kuantitas produk di dalam keranjang (drawer)
function updateCartQty(id, delta) {
  let cart = getCart();
  let item = cart.find(item => item.id === id);
  if (item) {
    let newQty = item.qty + delta;
    if (newQty < 1) return;
    if (newQty > item.stok) {
      showToast(`⚠️ Stok terbatas, maksimal ${item.stok} unit`, 'error');
      return;
    }
    item.qty = newQty;
    saveCart(cart);
  }
}

// Menghapus produk dari keranjang belanja
function removeFromCart(id) {
  let cart = getCart();
  const item = cart.find(item => item.id === id);
  const name = item ? item.name : 'Produk';
  
  cart = cart.filter(item => item.id !== id);
  saveCart(cart);
  showToast(`✗ <strong>${name}</strong> dihapus dari keranjang`, 'info');
}

// Membuka/menutup Drawer Keranjang Belanja
function toggleCartDrawer(isOpen) {
  const drawer = document.getElementById('cart-drawer');
  const overlay = document.getElementById('cart-overlay');
  if (!drawer || !overlay) return;

  if (isOpen) {
    overlay.classList.remove('hidden');
    // Memicu transition opacity
    setTimeout(() => {
      overlay.style.opacity = '1';
      drawer.classList.remove('translate-x-full');
      drawer.classList.add('translate-x-0');
    }, 10);
    renderCartDrawer();
  } else {
    drawer.classList.remove('translate-x-0');
    drawer.classList.add('translate-x-full');
    overlay.style.opacity = '0';
    setTimeout(() => {
      overlay.classList.add('hidden');
    }, 300);
  }
}

// Men-render list produk di dalam Drawer
function renderCartDrawer() {
  const container = document.getElementById('cart-items-container');
  const countContainer = document.getElementById('cart-drawer-count');
  if (!container) return;

  let cart = getCart();
  if (cart.length === 0) {
    container.innerHTML = `
      <div class="flex flex-col items-center justify-center h-80 text-center px-4">
        <div class="w-16 h-16 rounded-2xl bg-stone-900 flex items-center justify-center text-stone-600 mb-4 border border-stone-800">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
          </svg>
        </div>
        <p class="text-stone-400 text-sm font-semibold">Keranjang Belanja Anda Kosong</p>
        <p class="text-stone-600 text-xs mt-1 max-w-[200px]">Silakan cari perlengkapan petualangan impianmu di katalog kami.</p>
        <button onclick="toggleCartDrawer(false)" class="mt-5 text-xs font-bold text-adventure-400 hover:text-adventure-500 transition-colors uppercase tracking-wider">Lanjut Belanja →</button>
      </div>
    `;
    if (countContainer) countContainer.textContent = '0 Item';
    return;
  }

  let html = '';
  let totalCount = 0;
  
  cart.forEach(item => {
    totalCount += item.qty;
    html += `
      <div class="flex gap-4 p-4 rounded-2xl bg-stone-900/40 border border-stone-800/60 items-center transition-all hover:bg-stone-900/60">
        <label class="flex items-center cursor-pointer pr-2">
           <input type="checkbox" class="cart-item-checkbox w-5 h-5 rounded border-stone-600 text-adventure-500 bg-stone-800 focus:ring-adventure-500 accent-adventure-500 cursor-pointer" value="${item.id}" checked>
        </label>
        <img src="${item.image}" alt="${item.name}" class="w-16 h-16 object-cover rounded-xl border border-forest-500/10 flex-shrink-0" />
        <div class="flex-1 min-w-0">
          <h4 class="text-white font-bold text-sm truncate" title="${item.name}">${item.name}</h4>
          <p class="text-adventure-400 font-extrabold text-sm mt-1">Rp ${(item.price).toLocaleString('id-ID')}</p>
          
          <div class="flex items-center gap-2 mt-2.5">
            <button onclick="updateCartQty(${item.id}, -1)" class="w-6 h-6 flex items-center justify-center bg-white/5 hover:bg-white/10 text-stone-300 rounded-md font-bold text-xs transition-colors">-</button>
            <span class="text-white font-bold text-xs px-1">${item.qty}</span>
            <button onclick="updateCartQty(${item.id}, 1)" class="w-6 h-6 flex items-center justify-center bg-white/5 hover:bg-white/10 text-stone-300 rounded-md font-bold text-xs transition-colors">+</button>
          </div>
        </div>
        
        <div class="flex-shrink-0 flex items-center justify-center pl-2">
          <button onclick="removeFromCart(${item.id})" class="text-stone-500 hover:text-red-500 hover:bg-red-500/10 p-2 rounded-lg transition-all" title="Hapus Item">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
          </button>
        </div>
      </div>
    `;
  });

  // Tambahkan tombol Checkout Terpilih
  html += `
    <div class="mt-4">
      <button onclick="checkoutSelected()" class="w-full block text-center bg-adventure-500 hover:bg-adventure-600 text-white font-bold py-3 rounded-xl shadow-lg transition-all duration-300 hover:-translate-y-0.5 text-sm">
        Checkout Terpilih
      </button>
    </div>
  `;

  container.innerHTML = html;
  if (countContainer) countContainer.textContent = totalCount + ' Item';
}

function checkoutSelected() {
  const checkboxes = document.querySelectorAll('.cart-item-checkbox:checked');
  const selectedIds = Array.from(checkboxes).map(cb => parseInt(cb.value));
  
  if (selectedIds.length === 0) {
    showToast('⚠️ Pilih setidaknya satu produk untuk di-checkout', 'error');
    return;
  }
  
  const cart = getCart();
  const selectedItems = cart.filter(item => selectedIds.includes(item.id));
  
  // Simpan ke sessionStorage untuk halaman checkout
  sessionStorage.setItem('ecoutdoor_checkout_items', JSON.stringify(selectedItems));
  
  window.location.href = '/checkout';
}

// Menampilkan Toast notifikasi modern
function showToast(msg, type) {
  const toast = document.createElement('div');
  toast.className = 'fixed bottom-6 left-1/2 -translate-x-1/2 z-50 px-6 py-3 rounded-full text-white font-semibold text-sm shadow-2xl flex items-center gap-2';
  
  if (type === 'success') {
    toast.style.background = 'linear-gradient(135deg, #1e6e1e, #2d8a2d)';
    toast.style.border = '1px solid rgba(77, 163, 77, 0.3)';
  } else if (type === 'error') {
    toast.style.background = 'linear-gradient(135deg, #991b1b, #b91c1c)';
    toast.style.border = '1px solid rgba(220, 38, 38, 0.3)';
  } else {
    toast.style.background = 'linear-gradient(135deg, #2e2d28, #42403b)';
    toast.style.border = '1px solid rgba(145, 142, 132, 0.2)';
  }
  
  toast.style.backdropFilter = 'blur(10px)';
  toast.style.transition = 'all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1)';
  toast.style.opacity = '0';
  toast.style.transform = 'translateX(-50%) translateY(20px)';
  toast.innerHTML = msg;
  
  document.body.appendChild(toast);
  
  requestAnimationFrame(() => {
    toast.style.opacity = '1';
    toast.style.transform = 'translateX(-50%) translateY(0)';
  });
  
  setTimeout(() => {
    toast.style.opacity = '0';
    toast.style.transform = 'translateX(-50%) translateY(20px)';
    setTimeout(() => toast.remove(), 350);
  }, 2500);
}

// Efek animasi scale pada badge navbar ketika ada barang masuk
function playBadgeAnimation() {
  const badges = document.querySelectorAll('.cart-badge');
  badges.forEach(badge => {
    badge.style.transform = 'scale(1.5)';
    badge.style.transition = 'transform 0.15s ease';
    setTimeout(() => {
      badge.style.transform = 'scale(1)';
    }, 150);
  });
}

// Inisialisasi awal saat halaman selesai dimuat
document.addEventListener('DOMContentLoaded', () => {
  updateBadge();
  
  // Daftarkan listener untuk semua tombol keranjang di navbar
  const cartBtns = document.querySelectorAll('#cart-btn');
  cartBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      toggleCartDrawer(true);
    });
  });
});
