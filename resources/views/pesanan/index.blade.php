<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pesanan Saya — ECOutdoor</title>
  <link rel="icon" type="image/png" href="{{ asset('images/image_1.png') }}">
  <meta name="description" content="Pantau status pesananmu di ECOutdoor." />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@700&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            forest:    { 50:'#f0f7f0',100:'#d8ecd8',200:'#b3d9b3',300:'#7dbf7d',400:'#4da34d',500:'#2d8a2d',600:'#1e6e1e',700:'#175517',800:'#124012',900:'#0b2d0b' },
            stone:     { 400:'#918e84',500:'#787469',600:'#625f55',950:'#1f1e1b' },
            adventure: { 400:'#ff9b33',500:'#ff7c0a' },
          },
          fontFamily: { outfit:['Outfit','sans-serif'], playfair:['"Playfair Display"','serif'] },
          keyframes: {
            fadeUp: { '0%':{ opacity:'0', transform:'translateY(20px)' }, '100%':{ opacity:'1', transform:'translateY(0)' } },
            popIn:  { '0%':{ opacity:'0', transform:'scale(0.92)' }, '100%':{ opacity:'1', transform:'scale(1)' } },
            spin:   { to:{ transform:'rotate(360deg)' } },
          },
          animation: {
            'fade-up': 'fadeUp 0.5s ease-out both',
            'pop-in':  'popIn 0.4s cubic-bezier(0.34,1.56,0.64,1) both',
            'spin':    'spin 1s linear infinite',
          },
        },
      },
    };
  </script>
  <style>
    * { box-sizing: border-box; }
    body {
      font-family: 'Outfit', sans-serif;
      background: radial-gradient(ellipse at top left, #0b2d0b 0%, #1f1e1b 55%);
      min-height: 100vh;
    }
    .glass {
      background: rgba(36,36,32,0.82);
      backdrop-filter: blur(16px);
      border: 1px solid rgba(77,163,77,0.18);
    }
    .mini-step {
      width: 1.5rem; height: 1.5rem;
      border-radius: 9999px;
      border: 2px solid rgba(77,163,77,0.2);
      background: rgba(11,45,11,0.4);
      display: flex; align-items: center; justify-content: center;
      font-size: 0.6rem;
      flex-shrink: 0;
      transition: all 0.3s;
    }
    .mini-step.done   { border-color: #4da34d; background: linear-gradient(135deg, #2d8a2d, #1e6e1e); }
    .mini-step.current{ border-color: #ff9b33; background: rgba(255,124,10,0.15); box-shadow: 0 0 0 3px rgba(255,124,10,0.1); }
    .mini-line { flex: 1; height: 2px; border-radius: 9999px; background: rgba(77,163,77,0.12); transition: background 0.3s; }
    .mini-line.done { background: linear-gradient(90deg, #2d8a2d, #4da34d); }
    .order-card {
      background: rgba(36,36,32,0.82);
      border: 1px solid rgba(77,163,77,0.18);
      backdrop-filter: blur(16px);
      border-radius: 1.25rem;
      transition: border-color 0.25s, transform 0.25s;
    }
    .order-card:hover { border-color: rgba(77,163,77,0.35); transform: translateY(-2px); }
    .spinner {
      width: 2.5rem; height: 2.5rem;
      border: 3px solid rgba(77,163,77,0.15);
      border-top-color: #4da34d;
      border-radius: 50%;
      animation: spin 0.8s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
  </style>
  {{-- CSRF Token untuk fetch POST --}}
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  {{-- Migrasi kode lama dari PHP session ke localStorage (one-time fallback) --}}
  <script>
    (function() {
      var LS_KEY = 'ecoutdoor_pesanan';
      var fromSession = @json(session('pesanan_saya', []));
      if (fromSession && fromSession.length > 0) {
        try {
          var existing = JSON.parse(localStorage.getItem(LS_KEY) || '[]');
          var changed = false;
          fromSession.forEach(function(kode) {
            if (!existing.includes(kode)) { existing.push(kode); changed = true; }
          });
          if (changed) localStorage.setItem(LS_KEY, JSON.stringify(existing.slice(0, 50)));
        } catch(e) {}
      }
    })();
  </script>
</head>
<body class="text-white">

  <!-- Navbar -->
  <nav style="background:rgba(11,45,11,0.7); backdrop-filter:blur(20px); border-bottom:1px solid rgba(77,163,77,0.15); position:sticky; top:0; z-index:50;">
    <div class="max-w-3xl mx-auto px-4 py-3 flex items-center justify-between">
      <a href="{{ url('/') }}" class="flex items-center group">
        <img src="{{ asset('images/image_1.png') }}" alt="ECOutdoor" class="h-10 w-auto object-contain group-hover:scale-105 transition-transform" />
      </a>
      <a href="{{ url('/') }}" class="text-stone-400 hover:text-forest-400 transition-colors text-sm flex items-center gap-1.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Beranda
      </a>
    </div>
  </nav>

  <main class="max-w-3xl mx-auto px-4 py-10">

    <!-- Header -->
    <div class="mb-8 animate-fade-up">
      <h1 class="font-playfair text-3xl sm:text-4xl font-bold text-white">
        Pesanan <span style="color:#4da34d;">Saya</span>
      </h1>
      <p class="text-stone-500 text-sm mt-1" id="pesanan-count">Memuat pesanan...</p>
    </div>

    <!-- Loading state -->
    <div id="state-loading" class="flex flex-col items-center justify-center py-20 gap-4">
      <div class="spinner"></div>
      <p class="text-stone-500 text-sm">Memuat data pesanan...</p>
    </div>

    <!-- Empty state -->
    <div id="state-empty" class="glass rounded-2xl p-12 text-center animate-pop-in hidden">
      <p class="text-6xl mb-5">📭</p>
      <h2 class="text-white font-bold text-xl mb-2">Belum ada pesanan</h2>
      <p class="text-stone-500 text-sm mb-6 max-w-xs mx-auto">
        Pesananmu akan otomatis muncul di sini setelah kamu selesai checkout di perangkat ini.
      </p>
      <a href="{{ url('/#produk') }}"
         class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white font-bold text-sm transition-all hover:-translate-y-0.5"
         style="background:linear-gradient(135deg,#ff7c0a,#f06000); box-shadow:0 6px 20px rgba(255,124,10,0.3);">
        🏕️ Mulai Belanja
      </a>
    </div>

    <!-- Orders list -->
    <div id="state-orders" class="space-y-4 hidden"></div>

    <!-- Cari pesanan manual (untuk recover pesanan lama) -->
    <div id="cari-section" class="mt-8">
      <div class="glass rounded-2xl p-5">
        <p class="text-stone-500 text-xs font-semibold mb-3 uppercase tracking-wider">🔍 Cari Pesanan via Kode</p>
        <div class="flex gap-2">
          <input id="input-kode"
                 type="text"
                 placeholder="Contoh: ECO-ABCD1234"
                 maxlength="20"
                 class="flex-1 rounded-xl px-4 py-2.5 text-sm text-white outline-none"
                 style="background:rgba(11,45,11,0.4); border:1.5px solid rgba(77,163,77,0.2); font-family:Outfit,sans-serif;"
                 onkeydown="if(event.key==='Enter') addKode()" />
          <button onclick="addKode()"
                  class="px-4 py-2.5 rounded-xl text-sm font-bold text-white transition-all hover:-translate-y-0.5"
                  style="background:linear-gradient(135deg,#2d8a2d,#1e6e1e); box-shadow:0 4px 12px rgba(45,138,45,0.3);">
            Tambah
          </button>
        </div>
        <p id="cari-msg" class="text-xs mt-2 hidden"></p>
      </div>
    </div>

    <p id="footer-hint" class="text-center text-stone-700 text-xs mt-6 hidden">
      💡 Pesananmu tersimpan di perangkat ini. Gunakan browser yang sama untuk melihat riwayat.
    </p>

  </main>

  <!-- =====================================================================
       MODAL REVIEW (Premium Redesign)
       ===================================================================== -->
  <div id="review-modal" class="fixed inset-0 z-[100] hidden flex items-end sm:items-center justify-center">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/70 backdrop-blur-md" onclick="closeReviewModal()"></div>
    
    <!-- Panel -->
    <div id="review-modal-content"
         class="relative w-full sm:max-w-lg mx-auto sm:rounded-3xl rounded-t-3xl transform translate-y-4 opacity-0 transition-all duration-400"
         style="background: linear-gradient(160deg, #1a1f1a 0%, #0f1a0f 100%); border: 1px solid rgba(77,163,77,0.25); box-shadow: 0 -20px 60px rgba(0,0,0,0.5), 0 0 0 1px rgba(77,163,77,0.08);">

      <!-- Drag Handle -->
      <div class="flex justify-center pt-3 pb-1 sm:hidden">
        <div class="w-10 h-1 rounded-full" style="background:rgba(255,255,255,0.15);"></div>
      </div>

      <!-- Header -->
      <div class="px-6 pt-4 pb-5 border-b" style="border-color:rgba(77,163,77,0.12);">
        <div class="flex items-start justify-between">
          <div>
            <div class="flex items-center gap-2 mb-1">
              <span class="text-lg">⭐</span>
              <h3 class="text-lg font-bold text-white">Beri Ulasan Produk</h3>
            </div>
            <p class="text-xs" style="color:rgba(145,142,132,0.8);">Produk: <span class="font-semibold" style="color:#4da34d;" id="review-product-name">-</span></p>
          </div>
          <button onclick="closeReviewModal()" class="p-2 rounded-xl hover:bg-white/10 transition-colors ml-2 flex-shrink-0" style="color:#787469;">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>
      </div>

      <!-- Body -->
      <form id="review-form" onsubmit="submitReview(event)" class="px-6 py-5 space-y-5 max-h-[75vh] overflow-y-auto">
        <input type="hidden" id="review-order-id" />

        <!-- Nama Reviewer -->
        <div>
          <label class="block text-xs font-semibold mb-2" style="color:#918e84;">NAMA ANDA <span class="text-red-400">*</span></label>
          <div class="relative">
            <span class="absolute left-4 top-1/2 -translate-y-1/2" style="color:#4da34d;">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
            </span>
            <input type="text" id="review-nama" required maxlength="100"
                   class="w-full pl-11 pr-4 py-3 rounded-xl text-sm text-stone-200 outline-none transition-all"
                   style="background:rgba(255,255,255,0.05); border:1.5px solid rgba(77,163,77,0.2); font-family:Outfit,sans-serif;"
                   onfocus="this.style.borderColor='rgba(77,163,77,0.6)'; this.style.background='rgba(77,163,77,0.05)'"
                   onblur="this.style.borderColor='rgba(77,163,77,0.2)'; this.style.background='rgba(255,255,255,0.05)'"
                   placeholder="Contoh: Budi Santoso" />
          </div>
        </div>

        <!-- Pilihan Bintang -->
        <div>
          <label class="block text-xs font-semibold mb-3" style="color:#918e84;">RATING PRODUK <span class="text-red-400">*</span></label>
          <div class="flex gap-1 mb-2" id="star-rating">
            <span class="cursor-pointer text-4xl transition-all duration-150" onclick="setRating(1)" onmouseenter="hoverRating(1)" onmouseleave="hoverRating(0)" style="color:#3a3732;">★</span>
            <span class="cursor-pointer text-4xl transition-all duration-150" onclick="setRating(2)" onmouseenter="hoverRating(2)" onmouseleave="hoverRating(0)" style="color:#3a3732;">★</span>
            <span class="cursor-pointer text-4xl transition-all duration-150" onclick="setRating(3)" onmouseenter="hoverRating(3)" onmouseleave="hoverRating(0)" style="color:#3a3732;">★</span>
            <span class="cursor-pointer text-4xl transition-all duration-150" onclick="setRating(4)" onmouseenter="hoverRating(4)" onmouseleave="hoverRating(0)" style="color:#3a3732;">★</span>
            <span class="cursor-pointer text-4xl transition-all duration-150" onclick="setRating(5)" onmouseenter="hoverRating(5)" onmouseleave="hoverRating(0)" style="color:#3a3732;">★</span>
          </div>
          <input type="hidden" id="review-rating">
          <p id="rating-label" class="text-xs font-medium" style="color:#787469;">Pilih bintang untuk memberi rating</p>
          <p id="rating-error" class="text-red-400 text-xs mt-1 hidden">⚠ Silakan pilih rating terlebih dahulu</p>
        </div>

        <!-- Komentar -->
        <div>
          <label class="block text-xs font-semibold mb-2" style="color:#918e84;">ULASAN <span class="text-red-400">*</span></label>
          <textarea id="review-komentar" rows="4" required maxlength="1000"
                    class="w-full px-4 py-3 rounded-xl text-sm text-stone-200 outline-none transition-all resize-none"
                    style="background:rgba(255,255,255,0.05); border:1.5px solid rgba(77,163,77,0.2); font-family:Outfit,sans-serif;"
                    onfocus="this.style.borderColor='rgba(77,163,77,0.6)'; this.style.background='rgba(77,163,77,0.05)'"
                    onblur="this.style.borderColor='rgba(77,163,77,0.2)'; this.style.background='rgba(255,255,255,0.05)'"
                    oninput="updateCharCount(this)"
                    placeholder="Ceritakan pengalaman kamu menggunakan produk ini secara jujur dan detail..."></textarea>
          <div class="flex justify-end mt-1">
            <span id="char-count" class="text-xs" style="color:#5a5750;">0/1000</span>
          </div>
        </div>

        <!-- Upload Foto -->
        <div>
          <label class="block text-xs font-semibold mb-2" style="color:#918e84;">FOTO BARANG <span class="text-xs font-normal" style="color:#5a5750;">(opsional, max 3MB)</span></label>
          <label for="review-gambar" id="upload-label"
                 class="flex flex-col items-center justify-center gap-2 w-full py-6 rounded-xl cursor-pointer transition-all"
                 style="background:rgba(255,255,255,0.03); border:2px dashed rgba(77,163,77,0.25);"
                 ondragover="this.style.borderColor='rgba(77,163,77,0.6)'; this.style.background='rgba(77,163,77,0.05)'"
                 ondragleave="this.style.borderColor='rgba(77,163,77,0.25)'; this.style.background='rgba(255,255,255,0.03)'"
                 onmouseenter="this.style.borderColor='rgba(77,163,77,0.45)'"
                 onmouseleave="this.style.borderColor='rgba(77,163,77,0.25)'">
            <div id="upload-preview-container" class="hidden">
              <img id="upload-preview" class="h-24 w-24 object-cover rounded-xl" />
            </div>
            <div id="upload-placeholder">
              <div class="flex flex-col items-center gap-2">
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center" style="background:rgba(77,163,77,0.12);">
                  <svg class="w-5 h-5" style="color:#4da34d;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                </div>
                <p class="text-xs text-center" style="color:#787469;">Klik atau seret foto barang ke sini<br><span style="color:#4da34d; font-weight:600;">JPG, PNG, WEBP</span></p>
              </div>
            </div>
            <input type="file" id="review-gambar" accept="image/*" class="hidden" onchange="previewImage(this)" />
          </label>
          <p id="remove-photo" class="text-xs mt-2 cursor-pointer text-red-400 hover:text-red-300 hidden text-right" onclick="removePhoto()">✕ Hapus foto</p>
        </div>

        <!-- Actions -->
        <div class="flex gap-3 pt-1 pb-2">
          <button type="button" onclick="closeReviewModal()"
                  class="flex-1 py-3.5 rounded-2xl font-bold text-sm transition-all"
                  style="background:rgba(255,255,255,0.06); color:#918e84; border:1px solid rgba(255,255,255,0.1);"
                  onmouseover="this.style.background='rgba(255,255,255,0.1)'"
                  onmouseout="this.style.background='rgba(255,255,255,0.06)'">Batal</button>
          <button type="submit" id="review-submit-btn"
                  class="flex-1 py-3.5 rounded-2xl font-bold text-sm text-white transition-all shadow-lg"
                  style="background:linear-gradient(135deg,#2d8a2d,#1e6e1e); box-shadow:0 6px 20px rgba(45,138,45,0.3);"
                  onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 28px rgba(45,138,45,0.4)'"
                  onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 6px 20px rgba(45,138,45,0.3)'">
            <span id="submit-btn-label">🚀 Kirim Ulasan</span>
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- =====================================================================
       MODAL RETURN BARANG
       ===================================================================== -->
  <div id="return-modal" class="fixed inset-0 z-[101] hidden flex items-end sm:items-center justify-center">
    <div class="absolute inset-0 bg-black/75 backdrop-blur-md" onclick="closeReturnModal()"></div>
    <div id="return-modal-content"
         class="relative w-full sm:max-w-lg mx-auto sm:rounded-3xl rounded-t-3xl transform translate-y-4 opacity-0 transition-all duration-400"
         style="background:linear-gradient(160deg,#1f1510 0%,#1a0f0f 100%); border:1px solid rgba(220,38,38,0.25); box-shadow:0 -20px 60px rgba(0,0,0,0.5);">

      <!-- Drag Handle (mobile) -->
      <div class="flex justify-center pt-3 pb-1 sm:hidden">
        <div class="w-10 h-1 rounded-full" style="background:rgba(255,255,255,0.15);"></div>
      </div>

      <!-- Header -->
      <div class="px-6 pt-4 pb-5 border-b" style="border-color:rgba(220,38,38,0.15);">
        <div class="flex items-start justify-between">
          <div>
            <div class="flex items-center gap-2 mb-1">
              <span class="text-lg">↩️</span>
              <h3 class="text-lg font-bold text-white">Ajukan Return Barang</h3>
            </div>
            <p class="text-xs" style="color:rgba(145,142,132,0.8);">Produk: <span class="font-semibold" style="color:#f87171;" id="return-product-name">-</span></p>
          </div>
          <button onclick="closeReturnModal()" class="p-2 rounded-xl hover:bg-white/10 transition-colors ml-2 flex-shrink-0" style="color:#787469;">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        </div>
      </div>

      <!-- Body -->
      <div class="px-6 py-5 max-h-[80vh] overflow-y-auto space-y-5">

        <!-- Syarat penting -->
        <div class="flex items-start gap-3 px-4 py-3 rounded-2xl" style="background:rgba(255,124,10,0.08); border:1px solid rgba(255,124,10,0.25);">
          <span class="text-lg flex-shrink-0">📹</span>
          <div>
            <p class="text-xs font-bold" style="color:#ff9b33;">Wajib: Siapkan Video Unboxing!</p>
            <p class="text-xs mt-0.5" style="color:rgba(255,155,51,0.7);">Rekam video tanpa jeda/pause dari paket masih tersegel hingga terlihat kerusakannya. Video akan dikirim via WhatsApp setelah form ini disubmit.</p>
          </div>
        </div>

        <!-- Kode Pesanan (pre-filled, readonly) -->
        <div>
          <label class="block text-xs font-semibold mb-1.5" style="color:#918e84;">KODE PESANAN</label>
          <div class="flex items-center gap-3 px-4 py-3 rounded-xl" style="background:rgba(255,255,255,0.04); border:1.5px solid rgba(220,38,38,0.2);">
            <span class="text-xs font-mono tracking-wider font-bold text-white" id="return-kode-display">-</span>
            <span class="text-xs ml-auto" style="color:rgba(77,163,77,0.7);">✓ Terisi otomatis</span>
          </div>
          <input type="hidden" id="return-kode-pesanan">
          <input type="hidden" id="return-order-id">
        </div>

        <!-- Nama Pembeli -->
        <div>
          <label class="block text-xs font-semibold mb-1.5" style="color:#918e84;">NAMA ANDA <span class="text-red-400">*</span></label>
          <input type="text" id="return-nama" required placeholder="Nama lengkap Anda"
                 class="w-full px-4 py-3 rounded-xl text-sm text-stone-200 outline-none transition-all"
                 style="background:rgba(255,255,255,0.05); border:1.5px solid rgba(220,38,38,0.2); font-family:Outfit,sans-serif;"
                 onfocus="this.style.borderColor='rgba(220,38,38,0.5)'"
                 onblur="this.style.borderColor='rgba(220,38,38,0.2)'">
        </div>

        <!-- WhatsApp -->
        <div>
          <label class="block text-xs font-semibold mb-1.5" style="color:#918e84;">NOMOR WHATSAPP <span class="text-red-400">*</span></label>
          <input type="tel" id="return-wa" required placeholder="08xxxxxxxxxx"
                 class="w-full px-4 py-3 rounded-xl text-sm text-stone-200 outline-none transition-all"
                 style="background:rgba(255,255,255,0.05); border:1.5px solid rgba(220,38,38,0.2); font-family:Outfit,sans-serif;"
                 onfocus="this.style.borderColor='rgba(220,38,38,0.5)'"
                 onblur="this.style.borderColor='rgba(220,38,38,0.2)'">
        </div>

        <!-- Nomor Rekening -->
        <div>
          <label class="block text-xs font-semibold mb-1.5" style="color:#918e84;">REKENING PENGEMBALIAN DANA <span class="text-stone-500 font-normal">(Opsional)</span></label>
          <input type="text" id="return-rekening" maxlength="255"
                 placeholder="Contoh: BCA 123456789 a.n Budi"
                 class="w-full px-4 py-3 rounded-xl text-sm text-stone-200 outline-none transition-all"
                 style="background:rgba(255,255,255,0.05); border:1.5px solid rgba(220,38,38,0.2); font-family:Outfit,sans-serif;"
                 onfocus="this.style.borderColor='rgba(220,38,38,0.5)'"
                 onblur="this.style.borderColor='rgba(220,38,38,0.2)'">
          <p class="text-[10px] mt-1.5 text-stone-500 leading-tight">Masukkan bank, no. rekening, dan atas nama jika Anda ingin dana dikembalikan (jika disetujui).</p>
        </div>

        <!-- Alasan -->
        <div>
          <label class="block text-xs font-semibold mb-2" style="color:#918e84;">ALASAN RETURN <span class="text-red-400">*</span></label>
          <div class="grid grid-cols-2 gap-2" id="return-alasan-group">
            <label class="return-alasan-opt flex items-center gap-2 px-3 py-2.5 rounded-xl cursor-pointer transition-all"
                   style="background:rgba(255,255,255,0.03); border:1.5px solid rgba(220,38,38,0.15);">
              <input type="radio" name="return_alasan" value="barang_rusak" class="hidden">
              <span class="text-xs text-stone-300">🔨 Barang Rusak</span>
            </label>
            <label class="return-alasan-opt flex items-center gap-2 px-3 py-2.5 rounded-xl cursor-pointer transition-all"
                   style="background:rgba(255,255,255,0.03); border:1.5px solid rgba(220,38,38,0.15);">
              <input type="radio" name="return_alasan" value="barang_berbeda" class="hidden">
              <span class="text-xs text-stone-300">📦 Barang Berbeda</span>
            </label>
            <label class="return-alasan-opt flex items-center gap-2 px-3 py-2.5 rounded-xl cursor-pointer transition-all"
                   style="background:rgba(255,255,255,0.03); border:1.5px solid rgba(220,38,38,0.15);">
              <input type="radio" name="return_alasan" value="barang_tidak_sesuai_deskripsi" class="hidden">
              <span class="text-xs text-stone-300">📝 Tidak Sesuai Deskripsi</span>
            </label>
            <label class="return-alasan-opt flex items-center gap-2 px-3 py-2.5 rounded-xl cursor-pointer transition-all"
                   style="background:rgba(255,255,255,0.03); border:1.5px solid rgba(220,38,38,0.15);">
              <input type="radio" name="return_alasan" value="lainnya" class="hidden">
              <span class="text-xs text-stone-300">❓ Lainnya</span>
            </label>
          </div>
          <p id="return-alasan-error" class="text-red-400 text-xs mt-1 hidden">⚠ Pilih alasan return</p>
        </div>

        <!-- Deskripsi -->
        <div>
          <label class="block text-xs font-semibold mb-1.5" style="color:#918e84;">DESKRIPSI MASALAH <span class="text-red-400">*</span></label>
          <textarea id="return-deskripsi" rows="4" required maxlength="1000"
                    placeholder="Jelaskan detail kerusakan/perbedaan barang yang Anda terima..."
                    class="w-full px-4 py-3 rounded-xl text-sm text-stone-200 outline-none resize-none transition-all"
                    style="background:rgba(255,255,255,0.05); border:1.5px solid rgba(220,38,38,0.2); font-family:Outfit,sans-serif;"
                    onfocus="this.style.borderColor='rgba(220,38,38,0.5)'"
                    onblur="this.style.borderColor='rgba(220,38,38,0.2)'"></textarea>
        </div>

        <!-- Info video via WA -->
        <div class="rounded-2xl p-4" style="background:rgba(37,211,102,0.06); border:1px solid rgba(37,211,102,0.2);">
          <p class="text-xs font-bold mb-1" style="color:#25d366;">📱 Video Unboxing via WhatsApp</p>
          <p class="text-xs" style="color:rgba(37,211,102,0.7);">Setelah submit, Anda akan diarahkan ke WhatsApp Admin dengan detail pengajuan sudah terisi. Kirimkan video unboxing Anda di sana.</p>
        </div>

        <!-- Tombol -->
        <div class="flex gap-3 pb-2">
          <button type="button" onclick="closeReturnModal()"
                  class="flex-1 py-3.5 rounded-2xl font-bold text-sm transition-all"
                  style="background:rgba(255,255,255,0.06); color:#918e84; border:1px solid rgba(255,255,255,0.1);"
                  onmouseover="this.style.background='rgba(255,255,255,0.1)'"
                  onmouseout="this.style.background='rgba(255,255,255,0.06)'">Batal</button>
          <button type="button" onclick="submitReturn()"
                  class="flex-1 py-3.5 rounded-2xl font-bold text-sm text-white transition-all"
                  style="background:linear-gradient(135deg,#dc2626,#b91c1c); box-shadow:0 6px 20px rgba(220,38,38,0.3);"
                  onmouseover="this.style.transform='translateY(-2px)'"
                  onmouseout="this.style.transform='translateY(0)'">
            <span id="return-submit-label">📨 Submit & Buka WhatsApp</span>
          </button>
        </div>

      </div>
    </div>
      </div>
    </div>
  </div>

  <!-- =====================================================================
       MODAL DETAIL RETURN BARANG
       ===================================================================== -->
  <div id="return-detail-modal" class="fixed inset-0 z-[101] hidden flex items-end sm:items-center justify-center">
    <div class="absolute inset-0 bg-black/75 backdrop-blur-md" onclick="closeReturnDetailModal()"></div>
    <div id="return-detail-modal-content"
         class="relative w-full sm:max-w-lg mx-auto sm:rounded-3xl rounded-t-3xl transform translate-y-4 opacity-0 transition-all duration-400"
         style="background:linear-gradient(160deg,#1f1510 0%,#1a0f0f 100%); border:1px solid rgba(255,155,51,0.25); box-shadow:0 -20px 60px rgba(0,0,0,0.5);">

      <!-- Drag Handle (mobile) -->
      <div class="flex justify-center pt-3 pb-1 sm:hidden">
        <div class="w-10 h-1 rounded-full" style="background:rgba(255,255,255,0.15);"></div>
      </div>

      <!-- Header -->
      <div class="px-6 pt-4 pb-5 border-b" style="border-color:rgba(255,155,51,0.15);">
        <div class="flex items-start justify-between">
          <div>
            <div class="flex items-center gap-2 mb-1">
              <span class="text-lg">📄</span>
              <h3 class="text-lg font-bold text-white">Detail Pengajuan Return</h3>
            </div>
            <p class="text-xs" style="color:rgba(145,142,132,0.8);">Status saat ini: <span class="font-semibold px-2 py-0.5 rounded ml-1" id="rd-status-badge"></span></p>
          </div>
          <button onclick="closeReturnDetailModal()" class="p-2 rounded-xl hover:bg-white/10 transition-colors ml-2 flex-shrink-0" style="color:#787469;">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        </div>
      </div>

      <!-- Body -->
      <div class="px-6 py-5 max-h-[80vh] overflow-y-auto space-y-4">

        <!-- Info Basic -->
        <div class="grid grid-cols-2 gap-4">
          <div>
            <p class="text-[10px] font-bold tracking-wider" style="color:rgba(145,142,132,0.6);">KODE PESANAN</p>
            <p class="text-sm font-mono text-stone-200" id="rd-kode">-</p>
          </div>
          <div>
            <p class="text-[10px] font-bold tracking-wider" style="color:rgba(145,142,132,0.6);">TANGGAL PENGAJUAN</p>
            <p class="text-sm text-stone-200" id="rd-tanggal">-</p>
          </div>
        </div>

        <div class="w-full h-px" style="background:rgba(255,255,255,0.05);"></div>

        <!-- Alasan -->
        <div>
          <p class="text-[10px] font-bold tracking-wider mb-1" style="color:rgba(145,142,132,0.6);">ALASAN RETURN</p>
          <p class="text-sm font-semibold" style="color:#ff9b33;" id="rd-alasan">-</p>
        </div>

        <!-- Rekening -->
        <div id="rd-rekening-container" class="hidden">
          <p class="text-[10px] font-bold tracking-wider mb-1" style="color:rgba(145,142,132,0.6);">REKENING PENGEMBALIAN DANA</p>
          <p class="text-sm font-medium text-stone-200" id="rd-rekening">-</p>
        </div>

        <!-- Deskripsi -->
        <div>
          <p class="text-[10px] font-bold tracking-wider mb-1" style="color:rgba(145,142,132,0.6);">DESKRIPSI MASALAH</p>
          <div class="p-3 rounded-xl text-sm text-stone-300" style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.05);" id="rd-deskripsi">
            -
          </div>
        </div>

        <!-- Catatan Admin -->
        <div id="rd-admin-note-container" class="mt-2 hidden">
          <p class="text-[10px] font-bold tracking-wider mb-1" style="color:#4da34d;">💬 BALASAN ADMIN</p>
          <div class="p-4 rounded-xl text-sm" style="background:rgba(77,163,77,0.08); border:1px solid rgba(77,163,77,0.2); color:#e7e6e2;" id="rd-admin-note">
            -
          </div>
        </div>

        <!-- Tombol -->
        <div class="pt-4">
          <button type="button" onclick="closeReturnDetailModal()"
                  class="w-full py-3.5 rounded-2xl font-bold text-sm transition-all text-white"
                  style="background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1);"
                  onmouseover="this.style.background='rgba(255,255,255,0.1)'"
                  onmouseout="this.style.background='rgba(255,255,255,0.06)'">Tutup Detail</button>
        </div>

      </div>
    </div>
  </div>

  <script>
    // =====================================================================
    // KONSTANTA & KONFIGURASI
    // =====================================================================
    const FETCH_URL   = '{{ route("pesanan.fetch") }}';
    const ASSET_BASE  = '{{ asset("images") }}';
    const CSRF_TOKEN  = document.querySelector('meta[name="csrf-token"]').content;
    const LS_KEY      = 'ecoutdoor_pesanan';

    // =====================================================================
    // HELPER: baca/tulis localStorage
    // =====================================================================
    function getKodeList() {
      try {
        const raw = localStorage.getItem(LS_KEY);
        const list = raw ? JSON.parse(raw) : [];
        return Array.isArray(list) ? list : [];
      } catch (e) {
        return [];
      }
    }

    // =====================================================================
    // RENDER BADGE
    // =====================================================================
    function getBadge(order) {
      const buktisudahUpload = order.status === 'pending' && order.has_bukti;
      if (buktisudahUpload) {
        return { bg:'rgba(234,179,8,0.12)', border:'rgba(234,179,8,0.35)', color:'#fbbf24', label:'🕐 Menunggu Konfirmasi Admin' };
      }
      const map = {
        pending:   { bg:'rgba(255,124,10,0.12)', border:'rgba(255,124,10,0.3)', color:'#ff9b33', label:'📋 Pesanan Diterima' },
        confirmed: { bg:'rgba(45,138,45,0.12)',  border:'rgba(77,163,77,0.3)',  color:'#4da34d', label:'✅ Pembayaran Dikonfirmasi' },
        shipped:   { bg:'rgba(26,115,232,0.12)', border:'rgba(26,115,232,0.3)', color:'#60a5fa', label:'🚚 Sedang Dikirim' },
        done:      { bg:'rgba(45,138,45,0.2)',   border:'rgba(77,163,77,0.5)',  color:'#7dbf7d', label:'🎁 Pesanan Selesai' },
        cancelled: { bg:'rgba(220,38,38,0.12)',  border:'rgba(220,38,38,0.3)',  color:'#f87171', label:'❌ Dibatalkan' },
      };
      return map[order.status] || map.pending;
    }

    // =====================================================================
    // RENDER STEPPER
    // =====================================================================
    function getStepsDone(status) {
      return { pending:1, confirmed:2, shipped:3, done:4 }[status] ?? 1;
    }

    function renderStepper(status) {
      if (status === 'cancelled') return '';
      const stepsDone = getStepsDone(status);
      const steps = [
        { label:'Diterima' },
        { label:'Dikonfirmasi' },
        { label:'Dikirim' },
        { label:'Selesai' },
      ];
      let dots = '';
      steps.forEach((step, j) => {
        const n        = j + 1;
        const isDone   = stepsDone >= n;
        const isCurrent= stepsDone === n;
        const cls      = isDone && !isCurrent ? 'done' : (isCurrent ? 'current' : '');
        const inner    = isDone && !isCurrent
          ? `<svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>`
          : `<span style="font-size:0.55rem; color:${isCurrent?'#ff9b33':'rgba(120,116,105,0.5)'}">${n}</span>`;
        dots += `<div class="mini-step ${cls}">${inner}</div>`;
        if (j < steps.length - 1) {
          dots += `<div class="mini-line ${stepsDone > n ? 'done' : ''}"></div>`;
        }
      });

      const labels = steps.map((step, j) => {
        const isDone = stepsDone >= (j+1);
        const align  = j === 0 ? 'text-left' : (j === steps.length-1 ? 'text-right' : 'text-center');
        return `<p class="text-[10px] ${isDone ? 'text-forest-400' : 'text-stone-700'} ${align}">${step.label}</p>`;
      }).join('');

      return `
        <div class="px-5 pb-4">
          <div class="flex items-center gap-0">${dots}</div>
          <div class="grid grid-cols-4 mt-1.5">${labels}</div>
        </div>`;
    }

    // =====================================================================
    // RENDER BANNER MENUNGGU KONFIRMASI
    // =====================================================================
    function renderBanner(order) {
      const buktisudahUpload = order.status === 'pending' && order.has_bukti;
      if (!buktisudahUpload) return '';
      return `
        <div class="mx-5 mb-4 px-4 py-3 rounded-xl flex items-start gap-3"
             style="background:rgba(234,179,8,0.08); border:1px solid rgba(234,179,8,0.25);">
          <span class="text-xl flex-shrink-0 mt-0.5">🕐</span>
          <div>
            <p class="text-xs font-bold" style="color:#fbbf24;">Menunggu Konfirmasi Admin</p>
            <p class="text-xs mt-0.5" style="color:rgba(251,191,36,0.7);">
              Bukti transfermu sudah kami terima. Admin sedang memverifikasi pembayaranmu — biasanya dalam 1×24 jam.
            </p>
          </div>
        </div>`;
    }

    // =====================================================================
    // RENDER BANNER KONFIRMASI SUKSES
    // =====================================================================
    function renderConfirmedBanner(order) {
      if (order.status !== 'confirmed' && order.status !== 'shipped' && order.status !== 'done') return '';
      const msgs = {
        confirmed: { icon:'✅', text:'Pembayaranmu telah dikonfirmasi oleh admin.', color:'rgba(45,138,45,0.08)', border:'rgba(77,163,77,0.25)', textColor:'#4da34d' },
        shipped:   { icon:'🚚', text:'Pesananmu sedang dalam proses pengiriman.', color:'rgba(26,115,232,0.08)', border:'rgba(26,115,232,0.25)', textColor:'#60a5fa' },
        done:      { icon:'🎁', text:'Pesananmu sudah selesai. Terima kasih!', color:'rgba(45,138,45,0.1)', border:'rgba(77,163,77,0.35)', textColor:'#7dbf7d' },
      };
      const m = msgs[order.status];
      if (!m) return '';
      return `
        <div class="mx-5 mb-4 px-4 py-3 rounded-xl flex items-center gap-3"
             style="background:${m.color}; border:1px solid ${m.border};">
          <span class="text-xl">${m.icon}</span>
          <p class="text-xs font-semibold" style="color:${m.textColor};">${m.text}</p>
        </div>`;
    }

    // =====================================================================
    // RENDER SATU ORDER CARD
    // =====================================================================
    function renderOrderCard(order, index) {
      const badge  = getBadge(order);
      let imgSrc = `${ASSET_BASE}/placeholder.png`;
      if (order.product_gambar) {
        if (order.product_gambar.startsWith('data:image')) {
          imgSrc = order.product_gambar;
        } else {
          imgSrc = `${ASSET_BASE}/${order.product_gambar}`;
        }
      }
      const metode = { transfer:'🏦 Transfer Bank', cod:'💵 COD' }[order.metode_bayar] ?? order.metode_bayar;
      const total  = 'Rp ' + Number(order.total_harga).toLocaleString('id-ID');

      const buktisudahUpload = order.status === 'pending' && order.has_bukti;
      const needUpload       = order.status === 'pending' && order.metode_bayar === 'transfer' && !order.has_bukti;

      let actions = '';
      if (needUpload) {
        actions += `<a href="${order.thankyou_url}" class="text-xs font-bold px-3 py-1.5 rounded-lg transition-all"
                       style="background:rgba(255,124,10,0.15); color:#ff9b33; border:1px solid rgba(255,124,10,0.3);">
                      📤 Upload Bukti
                    </a>`;
      }
      if (buktisudahUpload) {
        actions += `<span class="text-xs font-medium px-3 py-1.5 rounded-lg"
                         style="background:rgba(234,179,8,0.1); color:#fbbf24; border:1px solid rgba(234,179,8,0.25);">
                      ✓ Bukti Terkirim
                    </span>`;
      }
      if (order.status === 'shipped') {
        actions += `<button onclick="completeOrder('${order.id}')" class="text-xs font-bold px-3 py-1.5 rounded-lg transition-all hover:-translate-y-0.5"
                       style="background:linear-gradient(135deg, #2d8a2d, #1e6e1e); color:#fff; border:1px solid rgba(77,163,77,0.5); box-shadow: 0 4px 12px rgba(45,138,45,0.3);">
                      ✅ Pesanan Diterima
                    </button>`;
      }
      if (order.status === 'done' && !order.has_reviewed) {
        actions += `<button onclick="openReviewModal('${order.id}', '${order.product_nama.replace(/'/g, "\\'")}')" class="text-xs font-bold px-3 py-1.5 rounded-lg transition-all hover:-translate-y-0.5"
                       style="background:linear-gradient(135deg, #ff7c0a, #f06000); color:#fff; border:1px solid rgba(255,124,10,0.5); box-shadow: 0 4px 12px rgba(255,124,10,0.3);">
                      ⭐ Beri Ulasan
                    </button>`;
      }
      if (order.status === 'done' && order.has_reviewed && order.product_id) {
        actions += `<a href="/product/${order.product_id}#ulasan" class="text-xs font-bold px-3 py-1.5 rounded-lg transition-all hover:-translate-y-0.5"
                       style="background:rgba(255,155,51,0.12); color:#ff9b33; border:1px solid rgba(255,155,51,0.35);">
                      ⭐ Ulasan Saya
                    </a>`;
      }
      actions += `<a href="${order.thankyou_url}" class="text-xs font-semibold px-3 py-1.5 rounded-lg transition-all hover:bg-white/10"
                     style="background:rgba(255,255,255,0.05); color:#918e84; border:1px solid rgba(255,255,255,0.08);">
                    Lihat Detail →
                  </a>`;

      return `
        <div class="order-card animate-fade-up" style="animation-delay:${index * 0.07}s;">

          {{-- Header --}}
          <div class="flex items-start justify-between gap-3 p-5 pb-4">
            <div class="flex gap-4 flex-1 min-w-0">
              <img src="${imgSrc}" alt="${order.product_nama}"
                   class="w-14 h-14 object-cover rounded-xl flex-shrink-0"
                   style="border:1.5px solid rgba(77,163,77,0.2);"
                   onerror="this.src='${ASSET_BASE}/placeholder.png'" />
              <div class="min-w-0">
                <p class="text-white font-bold text-sm leading-snug truncate">${order.product_nama}</p>
                <p class="text-stone-500 text-xs mt-0.5">${order.jumlah} unit · ${order.created_at}</p>
                <p class="font-black text-base mt-1" style="color:#ff9b33;">${total}</p>
                <p class="text-xs mt-1 font-mono tracking-wider" style="color:rgba(77,163,77,0.6);">🔖 ${order.kode_pesanan}</p>
              </div>
            </div>
            <span class="flex-shrink-0 text-xs font-bold px-3 py-1.5 rounded-full whitespace-nowrap"
                  style="background:${badge.bg}; border:1px solid ${badge.border}; color:${badge.color};">
              ${badge.label}
            </span>
          </div>

          ${renderStepper(order.status)}
          ${renderBanner(order)}
          ${renderConfirmedBanner(order)}

          <div style="height:1px; background:rgba(77,163,77,0.1); margin:0 1.25rem;"></div>

          <div class="px-5 py-3.5 flex items-center justify-between gap-3 flex-wrap">
            <div class="flex items-center gap-2">
              <span class="text-stone-500 text-xs">${metode}</span>
              ${order.status === 'done' ? (
                order.return_status ? `
                  <button onclick="openReturnDetailModal('${order.kode_pesanan}', '${order.return_status}', '${order.return_alasan}', '${order.return_deskripsi.replace(/'/g, "\\'")}', '${order.return_catatan ? order.return_catatan.replace(/'/g, "\\'") : ''}', '${order.return_created_at}', '${order.return_rekening ? order.return_rekening.replace(/'/g, "\\'") : ''}')"
                          class="text-xs font-semibold px-2.5 py-1 rounded-lg flex items-center gap-1.5 transition-all"
                          style="background:rgba(220,38,38,0.08); color:rgba(248,113,113,0.8); border:1px solid rgba(220,38,38,0.2);"
                          onmouseover="this.style.background='rgba(220,38,38,0.15)'; this.style.color='#f87171'"
                          onmouseout="this.style.background='rgba(220,38,38,0.08)'; this.style.color='rgba(248,113,113,0.8)'">
                    ${
                      order.return_status === 'pending' ? '⏳ Detail Return' :
                      order.return_status === 'diproses' ? '⚙️ Detail Return' :
                      order.return_status === 'disetujui' ? '✅ Detail Return' :
                      '❌ Detail Return'
                    }
                  </button>
                ` : `
                  <button onclick="openReturnModal('${order.id}', '${order.kode_pesanan}', '${order.product_nama.replace(/'/g, "\\'")}')"
                    class="text-xs font-semibold px-2.5 py-1 rounded-lg transition-all"
                    style="background:rgba(220,38,38,0.08); color:rgba(248,113,113,0.8); border:1px solid rgba(220,38,38,0.2);"
                    onmouseover="this.style.background='rgba(220,38,38,0.15)'; this.style.color='#f87171'"
                    onmouseout="this.style.background='rgba(220,38,38,0.08)'; this.style.color='rgba(248,113,113,0.8)'">↩ Return</button>
                `
              ) : ''}
            </div>
            <div class="flex items-center gap-2">${actions}</div>
          </div>

        </div>`;
    }

    // =====================================================================
    // MAIN: fetch dari server & render
    // =====================================================================
    async function loadPesanan() {
      const kodeList = getKodeList();

      if (kodeList.length === 0) {
        showEmpty();
        return;
      }

      try {
        const res = await fetch(FETCH_URL, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN':  CSRF_TOKEN,
            'Accept':        'application/json',
          },
          body: JSON.stringify({ kode_list: kodeList }),
        });

        if (!res.ok) throw new Error('Server error ' + res.status);
        const data = await res.json();
        renderOrders(data.orders || []);
      } catch (err) {
        console.error('Gagal memuat pesanan:', err);
        showEmpty('Gagal memuat data. Coba refresh halaman.');
      }
    }

    function renderOrders(orders) {
      document.getElementById('state-loading').classList.add('hidden');

      if (!orders || orders.length === 0) {
        showEmpty();
        return;
      }

      document.getElementById('pesanan-count').textContent =
        orders.length + ' pesanan ditemukan di perangkat ini';

      const container = document.getElementById('state-orders');
      container.innerHTML = orders.map((o, i) => renderOrderCard(o, i)).join('');
      container.classList.remove('hidden');
      document.getElementById('footer-hint').classList.remove('hidden');
    }

    function showEmpty(msg) {
      document.getElementById('state-loading').classList.add('hidden');
      document.getElementById('pesanan-count').textContent = '0 pesanan ditemukan di perangkat ini';
      if (msg) {
        const el = document.getElementById('state-empty');
        el.querySelector('h2').textContent = msg;
      }
      document.getElementById('state-empty').classList.remove('hidden');
    }

    // =====================================================================
    // TAMBAH KODE MANUAL (untuk recover pesanan lama)
    // =====================================================================
    async function addKode() {
      const input = document.getElementById('input-kode');
      const msg   = document.getElementById('cari-msg');
      const raw   = (input.value || '').trim().toUpperCase();

      if (!raw) return;

      msg.className   = 'text-xs mt-2';
      msg.textContent = '⏳ Memeriksa kode pesanan...';
      msg.classList.remove('hidden');

      try {
        const res = await fetch(FETCH_URL, {
          method:  'POST',
          headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN':CSRF_TOKEN, 'Accept':'application/json' },
          body:    JSON.stringify({ kode_list: [raw] }),
        });
        const data = await res.json();
        if (data.orders && data.orders.length > 0) {
          // Kode valid — simpan ke localStorage
          const existing = getKodeList();
          if (!existing.includes(raw)) {
            existing.unshift(raw);
            localStorage.setItem(LS_KEY, JSON.stringify(existing.slice(0, 50)));
          }
          input.value     = '';
          msg.textContent = '✅ Pesanan ditemukan dan ditambahkan!';
          msg.style.color = '#4da34d';
          setTimeout(() => { msg.classList.add('hidden'); }, 3000);
          loadPesanan(); // refresh tampilan
        } else {
          msg.textContent = '❌ Kode pesanan tidak ditemukan. Pastikan kode sudah benar.';
          msg.style.color = '#f87171';
        }
      } catch(e) {
        msg.textContent = '⚠️ Gagal menghubungi server. Coba lagi.';
        msg.style.color = '#ff9b33';
      }
    }

    // =====================================================================
    // SELESAIKAN PESANAN (Bila status shipped)
    // =====================================================================
    async function completeOrder(id) {
      if (!confirm('Apakah pesanan sudah benar-benar kamu terima dalam kondisi baik?')) return;
      
      const el = document.getElementById('state-loading');
      el.classList.remove('hidden');
      
      try {
        const res = await fetch(`/pesanan-saya/${id}/complete`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' }
        });
        const data = await res.json();
        
        if (data.success) {
          alert('Berhasil menyelesaikan pesanan! Terima kasih sudah berbelanja.');
          loadPesanan(); // Refresh tampilan
        } else {
          alert('Gagal menyelesaikan pesanan: ' + (data.message || 'Error'));
          el.classList.add('hidden');
        }
      } catch (err) {
        console.error(err);
        alert('Terjadi kesalahan. Silakan coba lagi nanti.');
        el.classList.add('hidden');
      }
    }

    // =====================================================================
    // REVIEW PESANAN (UI/UX Premium)
    // =====================================================================
    let currentRating = 0;

    const RATING_LABELS = ['', 'Sangat Buruk 😭', 'Kurang Baik 😕', 'Cukup 😐', 'Bagus 😊', 'Sangat Bagus! 🤩'];
    
    function openReviewModal(orderId, productName) {
      document.getElementById('review-order-id').value = orderId;
      document.getElementById('review-product-name').textContent = productName;
      document.getElementById('review-form').reset();
      document.getElementById('char-count').textContent = '0/1000';
      document.getElementById('upload-preview-container').classList.add('hidden');
      document.getElementById('upload-placeholder').classList.remove('hidden');
      document.getElementById('remove-photo').classList.add('hidden');
      document.getElementById('rating-label').textContent = 'Pilih bintang untuk memberi rating';
      document.getElementById('submit-btn-label').textContent = '🚀 Kirim Ulasan';
      setRating(0);
      
      const modal = document.getElementById('review-modal');
      const content = document.getElementById('review-modal-content');
      modal.classList.remove('hidden');
      void modal.offsetWidth;
      content.classList.remove('translate-y-4', 'opacity-0');
      content.classList.add('translate-y-0', 'opacity-100');
      document.body.style.overflow = 'hidden';
    }
    
    function closeReviewModal() {
      const modal = document.getElementById('review-modal');
      const content = document.getElementById('review-modal-content');
      content.classList.remove('translate-y-0', 'opacity-100');
      content.classList.add('translate-y-4', 'opacity-0');
      document.body.style.overflow = '';
      setTimeout(() => { modal.classList.add('hidden'); }, 350);
    }
    
    function hoverRating(rating) {
      const stars = document.getElementById('star-rating').children;
      const active = rating > 0 ? rating : currentRating;
      for (let i = 0; i < stars.length; i++) {
        stars[i].style.color = i < active ? '#ff9b33' : '#3a3732';
        stars[i].style.transform = i < active ? 'scale(1.1)' : 'scale(1)';
      }
    }
    
    function setRating(rating) {
      currentRating = rating;
      document.getElementById('review-rating').value = rating > 0 ? rating : '';
      document.getElementById('rating-error').classList.add('hidden');
      document.getElementById('rating-label').textContent = rating > 0
        ? `${RATING_LABELS[rating]} (${'★'.repeat(rating)}${'☆'.repeat(5 - rating)})`
        : 'Pilih bintang untuk memberi rating';
      document.getElementById('rating-label').style.color = rating > 0 ? '#ff9b33' : '#787469';
      hoverRating(0);
    }

    function updateCharCount(el) {
      const len = el.value.length;
      const counter = document.getElementById('char-count');
      counter.textContent = `${len}/1000`;
      counter.style.color = len > 900 ? '#f87171' : len > 700 ? '#fbbf24' : '#5a5750';
    }

    function previewImage(input) {
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('upload-preview').src = e.target.result;
          document.getElementById('upload-preview-container').classList.remove('hidden');
          document.getElementById('upload-placeholder').classList.add('hidden');
          document.getElementById('remove-photo').classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
      }
    }

    function removePhoto() {
      document.getElementById('review-gambar').value = '';
      document.getElementById('upload-preview-container').classList.add('hidden');
      document.getElementById('upload-placeholder').classList.remove('hidden');
      document.getElementById('remove-photo').classList.add('hidden');
    }
    
    async function submitReview(e) {
      e.preventDefault();
      if (currentRating === 0) {
        document.getElementById('rating-error').classList.remove('hidden');
        document.getElementById('star-rating').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        return;
      }
      
      const orderId   = document.getElementById('review-order-id').value;
      const nama      = document.getElementById('review-nama').value.trim();
      const komentar  = document.getElementById('review-komentar').value.trim();
      const fileInput = document.getElementById('review-gambar');
      const btn       = document.getElementById('review-submit-btn');
      const btnLabel  = document.getElementById('submit-btn-label');

      if (!nama) { document.getElementById('review-nama').focus(); return; }
      if (!komentar) { document.getElementById('review-komentar').focus(); return; }
      
      const formData = new FormData();
      formData.append('reviewer_name', nama);
      formData.append('rating', currentRating);
      formData.append('komentar', komentar);
      if (fileInput.files.length > 0) {
        formData.append('gambar', fileInput.files[0]);
      }
      
      btn.disabled = true;
      btnLabel.innerHTML = '<svg class="inline w-4 h-4 animate-spin mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>Mengirim...';
      
      try {
        const res = await fetch(`/pesanan-saya/${orderId}/review`, {
          method: 'POST',
          headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' },
          body: formData
        });
        const data = await res.json();
        
        if (res.ok && data.success) {
          // Tampilkan sukses dengan animasi nice
          const content = document.getElementById('review-modal-content');
          content.innerHTML = `
            <div class="flex flex-col items-center justify-center py-12 px-8 text-center">
              <div class="w-20 h-20 rounded-full flex items-center justify-center mb-5" style="background:linear-gradient(135deg,#2d8a2d,#1e6e1e); box-shadow:0 10px 30px rgba(45,138,45,0.4);">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
              </div>
              <h3 class="text-xl font-bold text-white mb-2">Ulasan Terkirim!</h3>
              <p class="text-sm mb-6" style="color:#918e84;">Terima kasih, <strong style="color:#4da34d">${nama}</strong>! Ulasan kamu akan membantu pembeli lain.</p>
              <button onclick="closeReviewModal(); loadPesanan();" class="px-8 py-3 rounded-2xl text-white font-bold text-sm" style="background:linear-gradient(135deg,#2d8a2d,#1e6e1e);">Selesai</button>
            </div>`;
          setTimeout(() => { closeReviewModal(); loadPesanan(); }, 3500);
        } else {
          alert('Gagal mengirim ulasan: ' + (data.message || 'Error tidak diketahui'));
          btnLabel.textContent = '🚀 Kirim Ulasan';
          btn.disabled = false;
        }
      } catch (err) {
        console.error(err);
        alert('Terjadi kesalahan. Silakan coba lagi.');
        btnLabel.textContent = '🚀 Kirim Ulasan';
        btn.disabled = false;
      }
    }

    // =====================================================================
    // RETURN PESANAN
    // =====================================================================
    const CS_WA = '6285804049637'; // Nomor WhatsApp CS ECOutdoor

    function openReturnModal(orderId, kodePesanan, productName) {
      document.getElementById('return-order-id').value = orderId;
      document.getElementById('return-kode-pesanan').value = kodePesanan;
      document.getElementById('return-kode-display').textContent = kodePesanan;
      document.getElementById('return-product-name').textContent = productName;
      // Reset form
      document.getElementById('return-nama').value = '';
      document.getElementById('return-wa').value = '';
      document.getElementById('return-deskripsi').value = '';
      document.getElementById('return-alasan-error').classList.add('hidden');
      document.querySelectorAll('[name="return_alasan"]').forEach(r => r.checked = false);
      document.querySelectorAll('.return-alasan-opt').forEach(el => {
        el.style.background = 'rgba(255,255,255,0.03)';
        el.style.borderColor = 'rgba(220,38,38,0.15)';
      });

      const modal = document.getElementById('return-modal');
      const content = document.getElementById('return-modal-content');
      modal.classList.remove('hidden');
      void modal.offsetWidth;
      content.classList.remove('translate-y-4','opacity-0');
      content.classList.add('translate-y-0','opacity-100');
      document.body.style.overflow = 'hidden';
    }

    function closeReturnModal() {
      const modal = document.getElementById('return-modal');
      const content = document.getElementById('return-modal-content');
      content.classList.remove('translate-y-0','opacity-100');
      content.classList.add('translate-y-4','opacity-0');
      document.body.style.overflow = '';
      setTimeout(() => modal.classList.add('hidden'), 350);
    }

    // Modal Detail Return
    function openReturnDetailModal(kode, status, alasan, deskripsi, catatan, tanggal, rekening) {
      document.getElementById('rd-kode').textContent = kode;
      document.getElementById('rd-tanggal').textContent = tanggal;
      document.getElementById('rd-alasan').textContent = alasan || '-';
      document.getElementById('rd-deskripsi').textContent = deskripsi || '-';
      
      const rekContainer = document.getElementById('rd-rekening-container');
      const rekText = document.getElementById('rd-rekening');
      if (rekening && rekening.trim() !== '') {
        rekText.textContent = rekening;
        rekContainer.classList.remove('hidden');
      } else {
        rekContainer.classList.add('hidden');
      }

      const badge = document.getElementById('rd-status-badge');
      if (status === 'pending') {
        badge.textContent = '⏳ Menunggu Admin';
        badge.style.background = 'rgba(234,179,8,0.15)'; badge.style.color = '#facc15';
      } else if (status === 'diproses') {
        badge.textContent = '⚙️ Sedang Diproses';
        badge.style.background = 'rgba(26,115,232,0.15)'; badge.style.color = '#60a5fa';
      } else if (status === 'disetujui') {
        badge.textContent = '✅ Disetujui';
        badge.style.background = 'rgba(77,163,77,0.15)'; badge.style.color = '#4da34d';
      } else {
        badge.textContent = '❌ Ditolak';
        badge.style.background = 'rgba(220,38,38,0.15)'; badge.style.color = '#f87171';
      }

      const adminNoteContainer = document.getElementById('rd-admin-note-container');
      const adminNote = document.getElementById('rd-admin-note');
      if (catatan && catatan.trim() !== '') {
        adminNote.textContent = catatan;
        adminNoteContainer.classList.remove('hidden');
      } else {
        adminNoteContainer.classList.add('hidden');
      }

      const modal = document.getElementById('return-detail-modal');
      const content = document.getElementById('return-detail-modal-content');
      modal.classList.remove('hidden');
      void modal.offsetWidth;
      content.classList.remove('translate-y-4','opacity-0');
      content.classList.add('translate-y-0','opacity-100');
      document.body.style.overflow = 'hidden';
    }

    function closeReturnDetailModal() {
      const modal = document.getElementById('return-detail-modal');
      const content = document.getElementById('return-detail-modal-content');
      content.classList.remove('translate-y-0','opacity-100');
      content.classList.add('translate-y-4','opacity-0');
      document.body.style.overflow = '';
      setTimeout(() => modal.classList.add('hidden'), 350);
    }

    // Style radio tombol alasan
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('.return-alasan-opt').forEach(label => {
        label.addEventListener('click', () => {
          document.querySelectorAll('.return-alasan-opt').forEach(el => {
            el.style.background = 'rgba(255,255,255,0.03)';
            el.style.borderColor = 'rgba(220,38,38,0.15)';
          });
          label.style.background = 'rgba(220,38,38,0.12)';
          label.style.borderColor = 'rgba(220,38,38,0.5)';
        });
      });
    });

    async function submitReturn() {
      const kode     = document.getElementById('return-kode-pesanan').value;
      const nama     = document.getElementById('return-nama').value.trim();
      const wa       = document.getElementById('return-wa').value.trim();
      const rekening = document.getElementById('return-rekening').value.trim();
      const deskripsi= document.getElementById('return-deskripsi').value.trim();
      const alasanEl = document.querySelector('[name="return_alasan"]:checked');
      const btnLabel = document.getElementById('return-submit-label');

      // Validasi
      if (!nama) { document.getElementById('return-nama').focus(); return; }
      if (!wa)   { document.getElementById('return-wa').focus(); return; }
      if (!alasanEl) {
        document.getElementById('return-alasan-error').classList.remove('hidden');
        return;
      }
      if (!deskripsi) { document.getElementById('return-deskripsi').focus(); return; }

      const alasanLabels = {
        barang_rusak: 'Barang Rusak / Cacat',
        barang_berbeda: 'Barang Berbeda dari Pesanan',
        barang_tidak_sesuai_deskripsi: 'Tidak Sesuai Deskripsi',
        lainnya: 'Lainnya'
      };

      btnLabel.textContent = 'Menyimpan...';

      // Simpan ke server dulu
      try {
        const formData = new FormData();
        formData.append('kode_pesanan', kode);
        formData.append('nama_pembeli', nama);
        formData.append('whatsapp', wa);
        formData.append('alasan', alasanEl.value);
        formData.append('deskripsi', deskripsi);
        if (rekening) formData.append('info_rekening', rekening);

        const res = await fetch('/return/ajukan', {
          method: 'POST',
          headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' },
          body: formData
        });

        if (!res.ok && res.status !== 422) throw new Error('Server error');
      } catch(e) {
        // Lanjutkan ke WA walaupun ada error
        console.warn('Return save error:', e);
      }

      // Buka WhatsApp CS dengan pesan pre-filled
      let waText = `Halo Admin ECOutdoor, saya ingin mengajukan *Return Barang* 🔴\n\n` +
        `📦 *Kode Pesanan:* ${kode}\n` +
        `👤 *Nama:* ${nama}\n` +
        `📱 *WA:* ${wa}\n`;
      if (rekening) waText += `💳 *Rekening:* ${rekening}\n`;
      waText += `❓ *Alasan:* ${alasanLabels[alasanEl.value]}\n` +
        `📝 *Detail Masalah:*\n${deskripsi}\n\n` +
        `_(Video unboxing akan saya kirimkan di sini)_`;

      const waUrl = `https://wa.me/${CS_WA}?text=${encodeURIComponent(waText)}`;

      closeReturnModal();
      setTimeout(() => window.open(waUrl, '_blank'), 400);
    }

    // Jalankan saat halaman load
    loadPesanan();
  </script>

</body>
</html>
