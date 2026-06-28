<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Checkout | ECOutdoor</title>
  <link rel="icon" type="image/png" href="{{ asset('images/image_1.png') }}">
  <meta name="description" content="Checkout keranjang belanja ECOutdoor." />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            forest:    { 50:'#f0f7f0',100:'#d8ecd8',200:'#b3d9b3',300:'#7dbf7d',400:'#4da34d',500:'#2d8a2d',600:'#1e6e1e',700:'#175517',800:'#124012',900:'#0b2d0b' },
            stone:     { 50:'#f5f5f3',100:'#e7e6e2',200:'#d0cec8',300:'#b3b0a6',400:'#918e84',500:'#787469',600:'#625f55',700:'#504e46',800:'#42403b',900:'#393733',950:'#1f1e1b' },
            adventure: { 400:'#ff9b33',500:'#ff7c0a',600:'#f06000' },
          },
          fontFamily: { outfit: ['Outfit','sans-serif'] },
        },
      },
    };
  </script>
  <style>
    * { box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    body { font-family: 'Outfit', sans-serif; background: linear-gradient(135deg, #0b2d0b 0%, #1f1e1b 40%, #1f1e1b 100%); min-height: 100vh; }

    .glass-card {
      background: rgba(36, 36, 32, 0.85);
      backdrop-filter: blur(16px);
      border: 1px solid rgba(77,163,77,0.15);
    }
    .form-input {
      width: 100%;
      background: rgba(11,45,11,0.25);
      border: 1.5px solid rgba(77,163,77,0.2);
      border-radius: 0.875rem;
      padding: 0.875rem 1rem;
      color: #e7e6e2;
      font-size: 0.9rem;
      font-family: 'Outfit', sans-serif;
      transition: all 0.25s ease;
      outline: none;
    }
    .form-input::placeholder { color: rgba(125,191,125,0.45); }
    .form-input:focus {
      border-color: rgba(77,163,77,0.55);
      background: rgba(11,45,11,0.4);
      box-shadow: 0 0 0 3px rgba(45,138,45,0.12);
    }
    .form-input.error { border-color: rgba(220,38,38,0.6); }
    .form-label { display: block; font-size: 0.8rem; font-weight: 600; color: #7dbf7d; margin-bottom: 0.4rem; letter-spacing: 0.03em; }
    .form-error { color: #f87171; font-size: 0.73rem; margin-top: 0.35rem; display: flex; align-items: center; gap: 0.3rem; }

    .btn-orange {
      background: linear-gradient(135deg, #ff7c0a, #f06000);
      transition: all 0.3s ease; border: none; cursor: pointer;
    }
    .btn-orange:hover { transform: translateY(-2px); box-shadow: 0 12px 30px rgba(255,124,10,0.4); }
    .btn-orange:active { transform: translateY(0); }

    .btn-green {
      background: linear-gradient(135deg, #2d8a2d, #1e6e1e);
      transition: all 0.3s ease; border: none; cursor: pointer;
    }
    .btn-green:hover { transform: translateY(-2px); box-shadow: 0 12px 30px rgba(45,138,45,0.4); }
    .btn-green:active { transform: translateY(0); }
    .btn-green:disabled { opacity: 0.6; cursor: not-allowed; transform: none; box-shadow: none; }

    .divider { height: 1px; background: rgba(77,163,77,0.12); }
    .summary-row { display: flex; justify-content: space-between; align-items: center; }

    /* Step indicator */
    .step-dot { width: 2rem; height: 2rem; border-radius: 9999px; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700; transition: all 0.3s; }
    .step-active { background: linear-gradient(135deg, #2d8a2d, #1e6e1e); color: white; }
    .step-done   { background: rgba(45,138,45,0.2); color: #7dbf7d; border: 1.5px solid rgba(77,163,77,0.4); }
    .step-inactive { background: rgba(77,163,77,0.1); color: #625f55; border: 1.5px solid rgba(77,163,77,0.2); }

    /* Payment method cards */
    .pay-card {
      border: 2px solid rgba(77,163,77,0.15);
      border-radius: 0.875rem;
      padding: 1rem 1.125rem;
      cursor: pointer;
      transition: all 0.2s ease;
      background: rgba(11,45,11,0.2);
      display: flex; align-items: center; gap: 1rem;
    }
    .pay-card:hover { border-color: rgba(77,163,77,0.4); background: rgba(45,138,45,0.1); }
    .pay-card.selected { border-color: #2d8a2d; background: rgba(45,138,45,0.15); box-shadow: 0 0 0 3px rgba(45,138,45,0.08); }
    .radio-circle {
      width: 1.2rem; height: 1.2rem;
      border-radius: 9999px;
      border: 2px solid rgba(77,163,77,0.35);
      background: transparent;
      flex-shrink: 0;
      transition: all 0.2s;
      display: flex; align-items: center; justify-content: center;
    }
    .pay-card.selected .radio-circle {
      border-color: #2d8a2d;
      background: #2d8a2d;
    }
    .pay-card.selected .radio-inner { display: block; }
    .radio-inner {
      display: none;
      width: 0.45rem; height: 0.45rem;
      border-radius: 9999px;
      background: white;
    }

    /* Transition for step panels */
    #step-1 { transition: opacity 0.3s ease, transform 0.3s ease; }
    #step-2 { transition: opacity 0.3s ease, transform 0.3s ease; }
    .hidden-panel { display: none; }

    /* Detail row for confirm page */
    .detail-row { display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; }
  </style>
</head>
<body>

  <!-- Navbar minimal -->
  <nav style="background:rgba(11,45,11,0.7); backdrop-filter:blur(20px); border-bottom:1px solid rgba(77,163,77,0.15);" class="sticky top-0 z-50">
    <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
      <a href="{{ url('/') }}" class="flex items-center gap-2 group">
        <img src="{{ asset('images/image_1.png') }}" alt="ECOutdoor" class="h-10 w-auto object-contain group-hover:scale-105 transition-transform" />
      </a>

      <!-- Step indicator -->
      <div class="hidden md:flex items-center gap-2 text-xs">
        <div class="step-dot step-active" id="nav-dot-1">1</div>
        <span class="font-medium transition-colors" id="nav-label-1" style="color:#4da34d;">Detail Pemesanan</span>
        <div class="w-4 lg:w-8 h-px" style="background:rgba(77,163,77,0.25);"></div>
        <div class="step-dot step-inactive" id="nav-dot-2">2</div>
        <span class="font-medium transition-colors" id="nav-label-2" style="color:#625f55;">Konfirmasi & Bayar</span>
        <div class="w-4 lg:w-8 h-px" style="background:rgba(77,163,77,0.25);"></div>
        <div class="step-dot step-inactive" id="nav-dot-3">3</div>
        <span class="font-medium transition-colors" id="nav-label-3" style="color:#625f55;">Status & Bukti</span>
      </div>

      <!-- Kembali -->
      <a id="back-link" href="{{ url('/') }}"
         class="text-stone-400 hover:text-forest-400 transition-colors text-sm flex items-center gap-1.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali
      </a>
    </div>
  </nav>

  <!-- ============================================================ -->
  <!--  FORM (hidden input yang dikirim ke server) -->
  <!-- ============================================================ -->
  <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
    @csrf
    <input type="hidden" name="nama_pembeli"      id="h-nama">
    <input type="hidden" name="no_whatsapp"       id="h-wa">
    <input type="hidden" name="alamat_pengiriman" id="h-alamat">
    <input type="hidden" name="cart_items"        id="h-cart-items">
    <input type="hidden" name="metode_bayar"      id="h-metode" value="transfer">
  </form>

  <div class="max-w-5xl mx-auto px-4 py-10">

    <div id="empty-state" class="hidden text-center py-20">
      <h2 class="text-white text-2xl font-bold">Keranjang Belanja Kosong</h2>
      <p class="text-stone-400 mt-2">Pilih produk dulu yuk sebelum checkout.</p>
      <a href="{{ url('/') }}" class="inline-block mt-6 px-6 py-3 bg-adventure-500 text-white rounded-xl font-bold">Mulai Belanja</a>
    </div>

    <!-- ======================================================= -->
    <!-- STEP 1 — Isi Data                                       -->
    <!-- ======================================================= -->
    <div id="step-1" class="hidden">

      <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-white">Checkout <span style="color:#ff9b33;">— Beli Tanpa Login</span></h1>
        <p class="text-stone-400 text-sm mt-1">Isi data pengiriman, lalu lanjut ke konfirmasi & pembayaran.</p>
      </div>

      @if($errors->any())
        <div class="mb-6 p-4 rounded-2xl" style="background:rgba(220,38,38,0.1); border:1px solid rgba(220,38,38,0.3);">
          <p class="text-red-400 font-semibold text-sm mb-2">⚠️ Ada beberapa kesalahan:</p>
          <ul class="space-y-1">
            @foreach($errors->all() as $err)
              <li class="text-red-300 text-xs flex items-center gap-1.5">
                <span class="w-1 h-1 rounded-full bg-red-400 flex-shrink-0"></span>{{ $err }}
              </li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="grid lg:grid-cols-5 gap-7">

        <!-- LEFT: FORM (3/5) -->
        <div class="lg:col-span-3 space-y-5">

          <!-- Informasi Pembeli -->
          <div class="glass-card rounded-2xl p-6">
            <h2 class="text-white font-bold text-base mb-5 flex items-center gap-2">
              <span class="w-1 h-5 rounded-full" style="background:#ff7c0a;"></span>
              Informasi Pembeli
            </h2>
            <div class="space-y-4">
              <!-- Nama -->
              <div>
                <label class="form-label" for="nama_pembeli">Nama Lengkap <span style="color:#f87171;">*</span></label>
                <input type="text" id="nama_pembeli"
                       value="{{ old('nama_pembeli') }}"
                       placeholder="Contoh: Budi Santoso"
                       class="form-input {{ $errors->has('nama_pembeli') ? 'error' : '' }}"
                       autocomplete="name" />
              </div>
              <!-- WA -->
              <div>
                <label class="form-label" for="no_whatsapp">Nomor WhatsApp <span style="color:#f87171;">*</span></label>
                <div class="relative">
                  <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none" style="color:#7dbf7d; font-size:0.8rem; font-weight:700;">🇮🇩 +62</span>
                  <input type="tel" id="no_whatsapp"
                         value="{{ old('no_whatsapp') }}"
                         placeholder="81234567890"
                         class="form-input {{ $errors->has('no_whatsapp') ? 'error' : '' }}"
                         style="padding-left:4.5rem;"
                         autocomplete="tel" />
                </div>
                <p class="text-stone-500 text-xs mt-1.5">Nomor ini akan digunakan penjual untuk menghubungi kamu.</p>
              </div>
              <!-- Alamat -->
              <div>
                <label class="form-label" for="alamat_pengiriman">Alamat Pengiriman Lengkap <span style="color:#f87171;">*</span></label>
                <textarea id="alamat_pengiriman"
                          rows="4"
                          placeholder="Jl. Mawar No. 12, RT 03/RW 05, Kel. Sukamaju, Kec. Cibeunying, Kota Bandung 40135"
                          class="form-input {{ $errors->has('alamat_pengiriman') ? 'error' : '' }}"
                          style="resize:none;"
                          autocomplete="street-address">{{ old('alamat_pengiriman') }}</textarea>
              </div>
            </div>
          </div>

          <p class="text-stone-600 text-xs px-1">
            🔒 Data kamu aman. Dengan melanjutkan kamu menyetujui syarat & ketentuan ECOutdoor.
          </p>
        </div>

        <!-- RIGHT: ORDER SUMMARY (2/5) -->
        <div class="lg:col-span-2">
          <div class="glass-card rounded-2xl p-6 sticky top-24">
            <h2 class="text-white font-bold text-base mb-5 flex items-center gap-2">
              <span class="w-1 h-5 rounded-full" style="background:#2d8a2d;"></span>
              Ringkasan Pesanan (<span id="cart-item-count">0</span>)
            </h2>

            <!-- Daftar Produk (Diisi via JS) -->
            <div id="cart-products-list" class="space-y-4 max-h-60 overflow-y-auto mb-5 pr-2">
            </div>

            <div class="divider mb-4"></div>

            <div class="space-y-3 mb-4">
              <div class="summary-row">
                <span class="text-stone-400 text-sm">Ongkos kirim (Pulau Jawa)</span>
                <span class="text-forest-400 text-sm font-semibold">Gratis 🚚</span>
              </div>
              <div class="summary-row">
                <span class="text-stone-400 text-sm">Biaya Admin / Layanan</span>
                <span class="text-white text-sm font-semibold">Rp 2.500</span>
              </div>
            </div>

            <div class="divider mb-4"></div>

            <div class="summary-row mb-6">
              <span class="text-white font-bold text-base">Total</span>
              <span class="text-adventure-400 font-black text-xl" id="summary-total">
                Rp 0
              </span>
            </div>

            <!-- CTA Step 1 -->
            <button type="button" onclick="goToStep2()"
                    class="btn-orange w-full rounded-2xl py-4 text-white font-bold text-base flex items-center justify-center gap-2.5">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              Lanjut ke Konfirmasi
            </button>

            <p class="text-stone-600 text-[11px] text-center mt-3">
              Pesanan hanya diproses setelah kamu konfirmasi & bayar
            </p>
          </div>
        </div>

      </div>
    </div>
    <!-- /STEP 1 -->


    <!-- ======================================================= -->
    <!-- STEP 2 — Konfirmasi & Bayar                             -->
    <!-- ======================================================= -->
    <div id="step-2" class="hidden-panel">

      <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-white">Konfirmasi <span style="color:#ff9b33;">& Pembayaran</span></h1>
        <p class="text-stone-400 text-sm mt-1">Periksa kembali detail pesananmu, lalu pilih metode pembayaran.</p>
      </div>

      <div class="grid lg:grid-cols-5 gap-7">

        <!-- LEFT: Detail Pesanan + Metode Bayar (3/5) -->
        <div class="lg:col-span-3 space-y-5">

          <!-- Detail Pesanan -->
          <div class="glass-card rounded-2xl p-6">
            <h2 class="text-white font-bold text-base mb-5 flex items-center gap-2">
              <span class="w-1 h-5 rounded-full" style="background:#ff7c0a;"></span>
              Detail Pesanan
            </h2>

            <!-- Daftar Produk Review (Diisi via JS) -->
            <div id="cart-products-review" class="space-y-3 mb-5">
            </div>

            <!-- Info rows -->
            <div class="space-y-4">
              <div class="detail-row">
                <span class="text-stone-400 text-sm flex items-center gap-1.5 flex-shrink-0">
                  <span>👤</span> Nama Pembeli
                </span>
                <span class="text-white text-sm font-medium text-right" id="confirm-nama">—</span>
              </div>
              <div class="divider"></div>
              <div class="detail-row">
                <span class="text-stone-400 text-sm flex items-center gap-1.5 flex-shrink-0">
                  <span>📱</span> WhatsApp
                </span>
                <span class="text-white text-sm font-medium text-right" id="confirm-wa">—</span>
              </div>
              <div class="divider"></div>
              <div>
                <p class="text-stone-400 text-sm flex items-center gap-1.5 mb-2">
                  <span>📍</span> Alamat Pengiriman
                </p>
                <p class="text-white text-sm leading-relaxed p-3 rounded-xl"
                   id="confirm-alamat"
                   style="background:rgba(11,45,11,0.35); border:1px solid rgba(77,163,77,0.1);">—</p>
              </div>
            </div>
          </div>

          <!-- Metode Pembayaran -->
          <div class="glass-card rounded-2xl p-6">
            <h2 class="text-white font-bold text-base mb-5 flex items-center gap-2">
              <span class="w-1 h-5 rounded-full" style="background:#2d8a2d;"></span>
              Pilih Metode Pembayaran
            </h2>

            <div class="space-y-3">
              <!-- Transfer Bank -->
              <div class="pay-card selected" id="pay-transfer" onclick="selectPayment('transfer', this)">
                <div class="radio-circle"><div class="radio-inner"></div></div>
                <div class="text-2xl">🏦</div>
                <div class="flex-1">
                  <p class="text-white font-semibold text-sm">Transfer Bank</p>
                  <p class="text-stone-400 text-xs mt-0.5">BCA / BRI</p>
                </div>
                <span class="text-forest-400 text-xs font-bold px-2.5 py-1 rounded-full flex-shrink-0"
                      style="background:rgba(45,138,45,0.15);">Populer</span>
              </div>

              <!-- Panel Transfer — muncul saat transfer dipilih -->
              <div id="panel-transfer" class="rounded-2xl overflow-hidden" style="border:1px solid rgba(77,163,77,0.2);">
                <div class="px-4 py-3" style="background:rgba(11,45,11,0.5); border-bottom:1px solid rgba(77,163,77,0.15);">
                  <p class="text-forest-400 text-xs font-bold tracking-wider uppercase">Pilih Bank Tujuan Transfer</p>
                </div>
                <!-- BCA -->
                <div class="bank-option selected-bank" id="bank-bca" onclick="selectBank('bca', this)"
                     style="padding:1rem 1.25rem; cursor:pointer; display:flex; align-items:center; gap:1rem; border-bottom:1px solid rgba(77,163,77,0.1); transition:background 0.2s;">
                  <div style="width:1.1rem;height:1.1rem;border-radius:9999px;border:2px solid #2d8a2d;background:#2d8a2d;display:flex;align-items:center;justify-content:center;flex-shrink:0;" class="bank-radio">
                    <div style="width:0.4rem;height:0.4rem;border-radius:9999px;background:white;"></div>
                  </div>
                  <div style="width:2.5rem;height:2.5rem;border-radius:0.5rem;background:#006cb7;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-weight:900;color:white;font-size:0.7rem;">BCA</div>
                  <div class="flex-1">
                    <p class="text-white font-semibold text-sm">Bank BCA</p>
                    <p class="text-stone-400 text-xs">Bank Central Asia</p>
                  </div>
                </div>
                <!-- BCA Detail -->
                <div id="detail-bca" class="px-5 py-4" style="background:rgba(0,108,183,0.08); border-bottom:1px solid rgba(77,163,77,0.1);">
                  <p class="text-stone-400 text-xs mb-3">Silakan transfer ke rekening berikut:</p>
                  <div class="space-y-2">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                      <span class="text-stone-400 text-xs">Atas Nama</span>
                      <span class="text-white text-sm font-semibold">NIFAIL EKA NAFIE</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                      <span class="text-stone-400 text-xs">No. Rekening</span>
                      <div class="flex items-center gap-2">
                        <span class="text-white text-sm font-black tracking-wider" id="bca-norek">6140 7638 78</span>
                        <button type="button" onclick="copyRek('6140763878', 'bca')"
                                class="text-xs px-2 py-0.5 rounded-lg font-semibold transition-all"
                                id="copy-bca"
                                style="background:rgba(0,108,183,0.25);color:#7dbf7d;border:1px solid rgba(0,108,183,0.4);">Salin</button>
                      </div>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                      <span class="text-stone-400 text-xs">Jumlah Transfer</span>
                      <span class="text-adventure-400 text-sm font-black" id="bca-jumlah">—</span>
                    </div>
                  </div>
                  <p class="text-stone-500 text-[11px] mt-3">⚠️ Pastikan nominal transfer sesuai persis agar pesanan cepat dikonfirmasi.</p>
                </div>
                <!-- BRI -->
                <div class="bank-option" id="bank-bri" onclick="selectBank('bri', this)"
                     style="padding:1rem 1.25rem; cursor:pointer; display:flex; align-items:center; gap:1rem; transition:background 0.2s;">
                  <div style="width:1.1rem;height:1.1rem;border-radius:9999px;border:2px solid rgba(77,163,77,0.35);background:transparent;display:flex;align-items:center;justify-content:center;flex-shrink:0;" class="bank-radio"></div>
                  <div style="width:2.5rem;height:2.5rem;border-radius:0.5rem;background:#003d7a;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-weight:900;color:white;font-size:0.7rem;">BRI</div>
                  <div class="flex-1">
                    <p class="text-white font-semibold text-sm">Bank BRI</p>
                    <p class="text-stone-400 text-xs">Bank Rakyat Indonesia</p>
                  </div>
                </div>
                <!-- BRI Detail -->
                <div id="detail-bri" class="px-5 py-4" style="background:rgba(0,61,122,0.08); display:none;">
                  <p class="text-stone-400 text-xs mb-3">Silakan transfer ke rekening berikut:</p>
                  <div class="space-y-2">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                      <span class="text-stone-400 text-xs">Atas Nama</span>
                      <span class="text-white text-sm font-semibold">REVA TRISDIANTO</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                      <span class="text-stone-400 text-xs">No. Rekening</span>
                      <div class="flex items-center gap-2">
                        <span class="text-white text-sm font-black tracking-wider">2232 0105 5112 504</span>
                        <button type="button" onclick="copyRek('223201055112504', 'bri')"
                                class="text-xs px-2 py-0.5 rounded-lg font-semibold transition-all"
                                id="copy-bri"
                                style="background:rgba(0,61,122,0.25);color:#7dbf7d;border:1px solid rgba(0,61,122,0.4);">Salin</button>
                      </div>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                      <span class="text-stone-400 text-xs">Jumlah Transfer</span>
                      <span class="text-adventure-400 text-sm font-black" id="bri-jumlah">—</span>
                    </div>
                  </div>
                  <p class="text-stone-500 text-[11px] mt-3">⚠️ Pastikan nominal transfer sesuai persis agar pesanan cepat dikonfirmasi.</p>
                </div>
                
                <!-- Info Rekber -->
                <div class="px-5 py-3" style="background:rgba(45,138,45,0.08); border-top:1px solid rgba(77,163,77,0.15);">
                  <p class="text-stone-300 text-xs leading-relaxed flex gap-2">
                    <span class="text-base">🛡️</span>
                    <span>
                      <strong>Info Rekber (Rekening Bersama):</strong> Kedua nomor rekening di atas merupakan Rekening Bersama. Uang kamu akan ditahan di rekening ini dan belum diteruskan ke penjual. Jika barang yang datang tidak sesuai, kamu bisa mengajukan pengembalian dana (refund).
                    </span>
                  </p>
                </div>
              </div>

              <!-- COD -->
              <div class="pay-card" id="pay-cod" onclick="selectPayment('cod', this)">
                <div class="radio-circle"><div class="radio-inner"></div></div>
                <div class="text-2xl">💵</div>
                <div class="flex-1">
                  <p class="text-white font-semibold text-sm">Bayar di Tempat (COD)</p>
                  <p class="text-stone-400 text-xs mt-0.5">Bayar tunai saat barang tiba</p>
                </div>
              </div>
            </div>

            <!-- Info box -->
            <div class="mt-5 p-4 rounded-xl flex gap-3" style="background:rgba(255,124,10,0.08); border:1px solid rgba(255,124,10,0.18);">
              <svg class="w-5 h-5 text-adventure-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              <p class="text-stone-300 text-xs leading-relaxed">
                Setelah kamu klik <strong class="text-adventure-400">Bayar & Konfirmasi</strong>, penjual akan menerima notifikasi pesananmu dan menghubungimu via WhatsApp dengan instruksi pembayaran selengkapnya.
              </p>
            </div>
          </div>

          <!-- Tombol Kembali Edit -->
          <button type="button" onclick="goToStep1()"
                  class="w-full rounded-2xl py-3 text-stone-400 font-medium text-sm hover:text-white transition-colors flex items-center justify-center gap-2"
                  style="background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08);">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali Edit Data
          </button>
        </div>

        <!-- RIGHT: Total + Submit (2/5) -->
        <div class="lg:col-span-2">
          <div class="glass-card rounded-2xl p-6 sticky top-24">
            <h2 class="text-white font-bold text-base mb-5 flex items-center gap-2">
              <span class="w-1 h-5 rounded-full" style="background:#2d8a2d;"></span>
              Ringkasan Pembayaran
            </h2>

            <div class="space-y-3 mb-4">
              <div class="summary-row">
                <span class="text-stone-400 text-sm">Total Belanja</span>
                <span class="text-white text-sm font-medium" id="confirm-subtotal-right">—</span>
              </div>
              <div class="summary-row">
                <span class="text-stone-400 text-sm">Ongkos kirim (Pulau Jawa)</span>
                <span class="text-forest-400 text-sm font-semibold">Gratis 🚚</span>
              </div>
              <div class="summary-row">
                <span class="text-stone-400 text-sm">Biaya Admin / Layanan</span>
                <span class="text-white text-sm font-semibold">Rp 2.500</span>
              </div>
            </div>

            <div class="divider mb-4"></div>

            <div class="summary-row mb-2">
              <span class="text-white font-bold text-base">Total Bayar</span>
              <span class="text-adventure-400 font-black text-xl" id="confirm-total">—</span>
            </div>
            <p class="text-stone-500 text-xs mb-6">*Biaya sudah termasuk ongkos kirim dan admin</p>

            <!-- Metode terpilih badge -->
            <div class="flex items-center gap-2 p-3 rounded-xl mb-5" style="background:rgba(45,138,45,0.1); border:1px solid rgba(77,163,77,0.2);">
              <span class="text-sm" id="confirm-metode-icon">🏦</span>
              <div>
                <p class="text-forest-400 text-xs font-semibold">Metode Bayar</p>
                <p class="text-white text-sm font-medium" id="confirm-metode-label">Transfer Bank</p>
              </div>
            </div>

            <!-- Submit button -->
            <button type="button" id="btn-submit" onclick="submitOrder()"
                    class="btn-green w-full rounded-2xl py-4 text-white font-bold text-base flex items-center justify-center gap-2.5">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              <span id="btn-submit-text">Bayar & Konfirmasi Pesanan</span>
            </button>

            <p class="text-stone-600 text-[11px] text-center mt-3">
              🔒 Data aman & terenkripsi. Pesanan langsung diteruskan ke penjual.
            </p>
          </div>
        </div>

      </div>
    </div>
    <!-- /STEP 2 -->

  </div><!-- /container -->

  <script src="{{ asset('js/cart.js') }}"></script>
  <script>
    let cart = [];
    let grandTotal = 0;

    let selectedPayment = 'transfer';
    const paymentInfo = {
      transfer: { icon: '🏦', label: 'Transfer Bank' },
      cod:      { icon: '💵', label: 'Bayar di Tempat (COD)' },
    };
    let selectedBank = 'bca'; // default bank

    document.addEventListener('DOMContentLoaded', () => {
      // Baca item terpilih dari sessionStorage (dibuat di cart.js)
      const sessionData = sessionStorage.getItem('ecoutdoor_checkout_items');

      @if(isset($directCheckoutItem))
        cart = [{!! json_encode($directCheckoutItem) !!}];
        // Opsional: bersihkan sessionData agar tidak conflict jika user kembali
        sessionStorage.removeItem('ecoutdoor_checkout_items');
      @else
        if (sessionData) {
          cart = JSON.parse(sessionData);
        } else {
          // Fallback jika langsung buka /checkout (misal checkout semua)
          cart = getCart();
        }
      @endif

      if (cart.length === 0) {
        document.getElementById('empty-state').classList.remove('hidden');
      } else {
        document.getElementById('step-1').classList.remove('hidden');
        renderCheckoutCart();
      }
    });

    function renderCheckoutCart() {
      const listDiv = document.getElementById('cart-products-list');
      const reviewDiv = document.getElementById('cart-products-review');
      let htmlList = '';
      let htmlReview = '';
      grandTotal = 0;
      let totalQty = 0;

      cart.forEach(item => {
        let subtotal = item.price * item.qty;
        grandTotal += subtotal;
        totalQty += item.qty;

        htmlList += `
          <div class="flex gap-4">
            <img src="${item.image}" alt="${item.name}" class="w-16 h-16 object-cover rounded-xl border border-forest-500/20 flex-shrink-0" />
            <div class="flex-1 min-w-0">
              <p class="text-white font-bold text-sm leading-snug truncate" title="${item.name}">${item.name}</p>
              <p class="text-stone-400 text-xs mt-1">Rp ${item.price.toLocaleString('id-ID')} × ${item.qty}</p>
              <p class="text-adventure-400 font-bold text-sm mt-1">Rp ${subtotal.toLocaleString('id-ID')}</p>
            </div>
          </div>
        `;

        htmlReview += `
          <div class="flex gap-3 pb-3 border-b border-stone-800 last:border-0 last:pb-0">
             <div class="w-12 h-12 flex-shrink-0 rounded-lg overflow-hidden border border-stone-800">
               <img src="${item.image}" alt="" class="w-full h-full object-cover">
             </div>
             <div>
               <p class="text-white font-semibold text-xs leading-snug">${item.name}</p>
               <p class="text-stone-400 text-xs">Rp ${item.price.toLocaleString('id-ID')} x ${item.qty}</p>
             </div>
          </div>
        `;
      });

      const biayaAdmin = 2500;
      grandTotal += biayaAdmin;

      listDiv.innerHTML = htmlList;
      reviewDiv.innerHTML = htmlReview;
      document.getElementById('cart-item-count').textContent = totalQty;
      
      const totalFmt = 'Rp ' + grandTotal.toLocaleString('id-ID');
      document.getElementById('summary-total').textContent = totalFmt;
    }

    /* ---- Payment selection ---- */
    function selectPayment(method, el) {
      selectedPayment = method;
      document.querySelectorAll('.pay-card').forEach(c => c.classList.remove('selected'));
      el.classList.add('selected');

      // Show/hide detail panels
      document.getElementById('panel-transfer').style.display = (method === 'transfer') ? 'block' : 'none';

      // Update right sidebar badge
      const info = paymentInfo[method];
      document.getElementById('confirm-metode-icon').textContent  = info.icon;
      document.getElementById('confirm-metode-label').textContent = info.label;
    }

    /* ---- Bank sub-selection ---- */
    function selectBank(bank, el) {
      selectedBank = bank;
      // Reset all bank options
      document.querySelectorAll('.bank-option').forEach(b => {
        b.style.background = 'transparent';
        const radio = b.querySelector('.bank-radio');
        radio.style.background    = 'transparent';
        radio.style.borderColor   = 'rgba(77,163,77,0.35)';
        radio.innerHTML           = '';
      });
      // Hide all detail panels
      document.getElementById('detail-bca').style.display = 'none';
      document.getElementById('detail-bri').style.display = 'none';

      // Activate selected
      el.style.background = 'rgba(45,138,45,0.08)';
      const radio = el.querySelector('.bank-radio');
      radio.style.background  = '#2d8a2d';
      radio.style.borderColor = '#2d8a2d';
      radio.innerHTML         = '<div style="width:0.4rem;height:0.4rem;border-radius:9999px;background:white;"></div>';
      document.getElementById('detail-' + bank).style.display = 'block';
    }

    /* ---- Copy rekening ---- */
    function copyRek(norek, bank) {
      navigator.clipboard.writeText(norek).then(() => {
        const btn = document.getElementById('copy-' + bank);
        const ori = btn.textContent;
        btn.textContent = '✓ Disalin';
        btn.style.color = '#4da34d';
        setTimeout(() => { btn.textContent = ori; btn.style.color = '#7dbf7d'; }, 2000);
      });
    }

    /* ---- Validation ---- */
    function validateForm() {
      if (cart.length === 0) {
        alert('Keranjang belanja kosong.'); return false;
      }
      const nama   = document.getElementById('nama_pembeli').value.trim();
      const wa     = document.getElementById('no_whatsapp').value.trim();
      const alamat = document.getElementById('alamat_pengiriman').value.trim();
      if (!nama)               { alert('Nama lengkap wajib diisi.');                                document.getElementById('nama_pembeli').focus();      return false; }
      if (!wa)                 { alert('Nomor WhatsApp wajib diisi.');                             document.getElementById('no_whatsapp').focus();        return false; }
      if (alamat.length < 10)  { alert('Alamat pengiriman terlalu singkat, mohon tulis lebih lengkap.'); document.getElementById('alamat_pengiriman').focus(); return false; }
      return true;
    }

    /* ---- Go to Step 2 ---- */
    function goToStep2() {
      if (!validateForm()) return;

      const nama   = document.getElementById('nama_pembeli').value.trim();
      const wa     = document.getElementById('no_whatsapp').value.trim();
      const alamat = document.getElementById('alamat_pengiriman').value.trim();
      const totalFmt = 'Rp ' + grandTotal.toLocaleString('id-ID');
      const totalBelanjaFmt = 'Rp ' + (grandTotal - 2500).toLocaleString('id-ID');

      // Populate step 2 values
      document.getElementById('confirm-nama').textContent      = nama;
      document.getElementById('confirm-wa').textContent        = '+62 ' + wa;
      document.getElementById('confirm-alamat').textContent    = alamat;
      document.getElementById('confirm-total').textContent     = totalFmt;
      document.getElementById('confirm-subtotal-right').textContent = totalBelanjaFmt;

      // Update transfer nominal
      document.getElementById('bca-jumlah').textContent = totalFmt;
      document.getElementById('bri-jumlah').textContent = totalFmt;

      // Copy to hidden form fields
      document.getElementById('h-nama').value   = nama;
      document.getElementById('h-wa').value     = wa;
      document.getElementById('h-alamat').value = alamat;
      document.getElementById('h-metode').value = selectedPayment;
      document.getElementById('h-cart-items').value = JSON.stringify(cart);

      // Switch panels
      document.getElementById('step-1').style.display = 'none';
      document.getElementById('step-2').style.display = 'block';
      document.getElementById('step-2').classList.remove('hidden-panel');

      // Update navbar step indicator
      const dot1   = document.getElementById('nav-dot-1');
      const label1 = document.getElementById('nav-label-1');
      const dot2   = document.getElementById('nav-dot-2');
      const label2 = document.getElementById('nav-label-2');
      dot1.className   = 'step-dot step-done';
      dot1.textContent = '✓';
      label1.style.color = '#7dbf7d';
      dot2.className   = 'step-dot step-active';
      dot2.textContent = '2';
      label2.style.color = '#4da34d';

      // Update back link
      document.getElementById('back-link').onclick = function(e) { e.preventDefault(); goToStep1(); };
      document.getElementById('back-link').removeAttribute('href');

      window.scrollTo({ top: 0, behavior: 'smooth' });
    }


    /* ---- Go back to Step 1 ---- */
    function goToStep1() {
      document.getElementById('step-2').style.display = 'none';
      document.getElementById('step-1').style.display = 'block';

      // Reset navbar
      const dot1   = document.getElementById('nav-dot-1');
      const label1 = document.getElementById('nav-label-1');
      const dot2   = document.getElementById('nav-dot-2');
      const label2 = document.getElementById('nav-label-2');
      dot1.className   = 'step-dot step-active';
      dot1.textContent = '1';
      label1.style.color = '#4da34d';
      dot2.className   = 'step-dot step-inactive';
      dot2.textContent = '2';
      label2.style.color = '#625f55';

      // Restore back link
      document.getElementById('back-link').href = '{{ url('/') }}';
      document.getElementById('back-link').onclick = null;

      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    /* ---- Final submit ---- */
    function submitOrder() {
      const btn  = document.getElementById('btn-submit');
      const text = document.getElementById('btn-submit-text');
      btn.disabled = true;
      text.textContent = 'Memproses...';

      // Ensure hidden fields are up to date
      document.getElementById('h-metode').value = selectedPayment;

      setTimeout(() => {
        document.getElementById('checkout-form').submit();
      }, 500);
    }
  </script>
</body>
</html>
