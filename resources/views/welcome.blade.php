@extends('layouts.front')

@section('title', 'ECOutdoor — Perlengkapan Outdoor Terbaik')

@section('content')
  <!-- ====================== HERO SECTION ====================== -->
  <section id="hero" class="relative min-h-screen flex items-center justify-center overflow-hidden">

    <!-- Hero Background Image — menggunakan asset() helper Laravel -->
    <div class="absolute inset-0">
      <img
        src="{{ asset('images/hero_background.png') }}"
        alt="Mountain landscape background"
        class="w-full h-full object-cover"
      />
      <div class="hero-overlay absolute inset-0"></div>
    </div>

    <!-- Decorative particles (CSS) -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute top-1/4 left-1/4 w-64 h-64 rounded-full bg-forest-600/10 blur-3xl animate-pulse-slow"></div>
      <div class="absolute bottom-1/3 right-1/4 w-80 h-80 rounded-full bg-adventure-500/8 blur-3xl animate-pulse-slow" style="animation-delay:1.5s"></div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
      <div class="grid lg:grid-cols-2 gap-12 items-center pt-20">

        <!-- Left: Text -->
        <div class="animate-fade-up" style="animation-delay:0.1s">
          <!-- Badge -->
          <div class="inline-flex items-center gap-2 badge-shimmer text-white text-xs font-bold px-4 py-2 rounded-full mb-6 shadow-lg">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
            GEAR TERPILIH 2025
          </div>

          <h1 class="font-playfair text-5xl sm:text-6xl lg:text-7xl font-bold text-white leading-tight mb-6">
            Petualangan<br />
            <span class="text-adventure-400">Dimulai</span><br />
            dari Sini
          </h1>

          <p class="text-stone-300 text-lg sm:text-xl leading-relaxed mb-8 max-w-lg">
            Temukan perlengkapan outdoor premium untuk petualangan berikutnya — atau titipkan & jual perlengkapan bekasmu kepada ribuan petualang lain di seluruh Indonesia.
          </p>

          <!-- Stats -->
          <div class="flex items-center gap-8 mb-10">
            <div>
              <p class="text-3xl font-bold text-white">500<span class="text-adventure-400">+</span></p>
              <p class="text-stone-400 text-sm">Produk Premium</p>
            </div>
            <div class="w-px h-10 bg-stone-600"></div>
            <div>
              <p class="text-3xl font-bold text-white">12K<span class="text-adventure-400">+</span></p>
              <p class="text-stone-400 text-sm">Petualang Puas</p>
            </div>
            <div class="w-px h-10 bg-stone-600"></div>
            <div>
              <p class="text-3xl font-bold text-white">4.9<span class="text-adventure-400">★</span></p>
              <p class="text-stone-400 text-sm">Rating Rata-rata</p>
            </div>
          </div>

          <!-- Buttons -->
          <div class="flex flex-wrap gap-4">
            <a href="#produk" id="hero-shop-btn" class="btn-primary rounded-full px-8 py-4 text-white font-bold text-base shadow-xl inline-block">
              <span>🏕️ Belanja Sekarang</span>
            </a>
            @auth
              <a href="{{ route('dashboard') }}" id="hero-sell-btn" class="btn-outline rounded-full px-8 py-4 text-white font-semibold text-base inline-block flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                Mulai Berjualan
              </a>
            @else
              <a href="{{ route('register') }}" id="hero-sell-btn" class="btn-outline rounded-full px-8 py-4 text-white font-semibold text-base inline-block flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                Mulai Berjualan
              </a>
            @endauth
          </div>
        </div>

        <!-- Right: Floating Info Card -->
        <div class="hidden lg:flex flex-col items-end gap-5 animate-fade-up" style="animation-delay:0.35s">
          <!-- Big floating card -->
          <div class="floating-card rounded-2xl p-6 max-w-xs w-full">
            <div class="flex items-center gap-3 mb-4">
              <div class="w-10 h-10 rounded-full bg-adventure-500/20 flex items-center justify-center text-adventure-400">
                🏔️
              </div>
              <div>
                <p class="text-white font-bold text-sm">Pilihan #1 Pendaki</p>
                <p class="text-stone-400 text-xs">Indonesia Outdoor Community</p>
              </div>
            </div>
            <div class="flex -space-x-2 mb-3">
              <div class="w-8 h-8 rounded-full bg-forest-600 border-2 border-stone-900 flex items-center justify-center text-xs">🧗</div>
              <div class="w-8 h-8 rounded-full bg-forest-700 border-2 border-stone-900 flex items-center justify-center text-xs">⛺</div>
              <div class="w-8 h-8 rounded-full bg-forest-800 border-2 border-stone-900 flex items-center justify-center text-xs">🥾</div>
              <div class="w-8 h-8 rounded-full bg-adventure-700 border-2 border-stone-900 flex items-center justify-center text-[10px] font-bold text-white">+99</div>
            </div>
            <p class="text-stone-300 text-xs">Bergabung dengan lebih dari <strong class="text-forest-400">12.000+</strong> petualang yang telah mempercayai ECOutdoor.</p>
          </div>

          <!-- Small promo card -->
          <div class="floating-card rounded-2xl p-4 max-w-xs w-full" style="animation-delay: 0.5s">
            <div class="flex items-center gap-3">
              <div class="discount-badge w-12 h-12 rounded-xl flex items-center justify-center text-white font-black text-lg flex-shrink-0">%</div>
              <div>
                <p class="text-white font-bold text-sm">Flash Sale Hari Ini!</p>
                <p class="text-stone-400 text-xs">Diskon hingga <span class="text-adventure-400 font-bold">40%</span> untuk produk pilihan</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Scroll indicator -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 scroll-indicator">
      <a href="#features" class="flex flex-col items-center gap-2 text-stone-400 hover:text-adventure-400 transition-colors">
        <span class="text-xs font-medium tracking-widest uppercase">Scroll</span>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M19 9l-7 7-7-7"/>
        </svg>
      </a>
    </div>
  </section>


  <!-- ====================== CARA JUAL SECTION ====================== -->
  <section id="cara-jual" class="py-24" style="background: linear-gradient(180deg, #f5f3ef 0%, #ffffff 60%, #f0f7f0 100%);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      <!-- Section Header -->
      <div class="text-center mb-16">
        <span class="inline-block text-xs font-bold tracking-widest uppercase mb-4 px-4 py-1.5 rounded-full" style="background: rgba(45,138,45,0.12); color: #1e6e1e; letter-spacing: 0.12em;">✦ Untuk Penjual</span>
        <h2 class="font-playfair text-4xl sm:text-5xl font-bold mb-5" style="color: #0b2d0b;">
          Cara Mudah Menjual<br />
          <span style="color: #2d8a2d;">Alat Outdoormu</span>
        </h2>
        <p class="text-lg max-w-2xl mx-auto" style="color: #504e46;">
          Titipkan dan jual perlengkapan outdoor bekasmu dalam 3 langkah sederhana — tanpa ribet, tanpa biaya awal.
        </p>
      </div>

      <!-- Step Cards Grid -->
      <div class="grid md:grid-cols-3 gap-8 mt-8">

        <!-- Step 1: Buat Akun Gratis -->
        <div id="step-card-1" class="relative flex flex-col items-center text-center p-8 pt-10 rounded-3xl transition-all duration-300 hover:-translate-y-2 group" style="background: #ffffff; border: 1.5px solid #d8ecd8; box-shadow: 0 4px 24px rgba(45,138,45,0.08);">
          <!-- Step badge -->
          <div class="absolute -top-5 left-1/2 -translate-x-1/2 w-10 h-10 rounded-full flex items-center justify-center text-white text-base font-black shadow-lg" style="background: linear-gradient(135deg, #2d8a2d, #1e6e1e);">1</div>
          <!-- Icon -->
          <div class="w-20 h-20 rounded-2xl flex items-center justify-center mb-6 transition-transform duration-300 group-hover:scale-110" style="background: linear-gradient(135deg, #f0f7f0, #d8ecd8);">
            <svg class="w-9 h-9" fill="none" stroke="#2d8a2d" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
              <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
              <circle cx="12" cy="7" r="4"/>
            </svg>
          </div>
          <h3 class="text-xl font-bold mb-3" style="color: #124012;">Buat Akun Gratis</h3>
          <p class="text-sm leading-relaxed mb-7" style="color: #625f55;">
            Klik tombol <strong style="color: #1e6e1e;">"Daftar Gratis"</strong> di pojok kanan atas halaman ini. Isi nama, email, dan password — lalu verifikasi emailmu. Akun langsung aktif tanpa biaya pendaftaran.
          </p>
          @guest
            <a href="{{ route('register') }}" id="step1-cta" class="mt-auto inline-flex items-center gap-2 text-sm font-bold px-6 py-2.5 rounded-full transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5" style="background: linear-gradient(135deg, #2d8a2d, #1e6e1e); color: #ffffff;">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
              Daftar Sekarang
            </a>
          @else
            <span class="mt-auto inline-flex items-center gap-2 text-sm font-semibold px-6 py-2.5 rounded-full" style="background: #d8ecd8; color: #1e6e1e;">
              ✓ Sudah Terdaftar
            </span>
          @endguest
        </div>

        <!-- Step 2: Akses Partner Hub -->
        <div id="step-card-2" class="relative flex flex-col items-center text-center p-8 pt-10 rounded-3xl transition-all duration-300 hover:-translate-y-2 group" style="background: #ffffff; border: 1.5px solid #d8ecd8; box-shadow: 0 4px 24px rgba(45,138,45,0.08);">
          <div class="absolute -top-5 left-1/2 -translate-x-1/2 w-10 h-10 rounded-full flex items-center justify-center text-white text-base font-black shadow-lg" style="background: linear-gradient(135deg, #2d8a2d, #1e6e1e);">2</div>
          <!-- Icon -->
          <div class="w-20 h-20 rounded-2xl flex items-center justify-center mb-6 transition-transform duration-300 group-hover:scale-110" style="background: linear-gradient(135deg, #f0f7f0, #d8ecd8);">
            <svg class="w-9 h-9" fill="none" stroke="#2d8a2d" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
              <rect x="3" y="3" width="7" height="7" rx="1.5"/>
              <rect x="14" y="3" width="7" height="7" rx="1.5"/>
              <rect x="3" y="14" width="7" height="7" rx="1.5"/>
              <rect x="14" y="14" width="7" height="7" rx="1.5"/>
            </svg>
          </div>
          <h3 class="text-xl font-bold mb-3" style="color: #124012;">Akses Partner Hub</h3>
          <p class="text-sm leading-relaxed mb-7" style="color: #625f55;">
            Setelah login, kamu akan masuk ke <strong style="color: #1e6e1e;">ECOutdoor Partner Hub</strong> — dashboard khusus penjual. Pantau listing aktif, pesanan masuk, dan total pendapatanmu dari satu tempat.
          </p>
          @auth
            <a href="{{ route('dashboard') }}" id="step2-cta" class="mt-auto inline-flex items-center gap-2 text-sm font-bold px-6 py-2.5 rounded-full transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5" style="background: linear-gradient(135deg, #2d8a2d, #1e6e1e); color: #ffffff;">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
              Buka Dashboard
            </a>
          @else
            <a href="{{ route('login') }}" id="step2-cta" class="mt-auto inline-flex items-center gap-2 text-sm font-bold px-6 py-2.5 rounded-full transition-all duration-300 hover:shadow-md hover:-translate-y-0.5" style="background: #f0f7f0; color: #1e6e1e; border: 1.5px solid #b3d9b3;">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 16l-4-4m0 0l4-4m-4 4h14"/></svg>
              Masuk Dulu
            </a>
          @endauth
        </div>

        <!-- Step 3: Upload & Jual -->
        <div id="step-card-3" class="relative flex flex-col items-center text-center p-8 pt-10 rounded-3xl transition-all duration-300 hover:-translate-y-2 group" style="background: #ffffff; border: 1.5px solid #ffdba6; box-shadow: 0 4px 24px rgba(255,124,10,0.08);">
          <div class="absolute -top-5 left-1/2 -translate-x-1/2 w-10 h-10 rounded-full flex items-center justify-center text-white text-base font-black shadow-lg" style="background: linear-gradient(135deg, #ff7c0a, #f06000);">3</div>
          <!-- Icon -->
          <div class="w-20 h-20 rounded-2xl flex items-center justify-center mb-6 transition-transform duration-300 group-hover:scale-110" style="background: linear-gradient(135deg, #fff8ed, #ffefd3);">
            <svg class="w-9 h-9" fill="none" stroke="#f06000" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
              <rect x="3" y="3" width="18" height="13" rx="2"/>
              <path d="M3 11l4.5-4.5L11 10l3.5-4.5L21 11"/>
              <path d="M8 21h8M12 16v5"/>
              <path d="M15 7l-2-2-2 2M13 5v6" />
            </svg>
          </div>
          <h3 class="text-xl font-bold mb-3" style="color: #451600;">Upload &amp; Jual</h3>
          <p class="text-sm leading-relaxed mb-7" style="color: #625f55;">
            Di Partner Hub, klik <strong style="color: #f06000;">"Tambah Produk"</strong>, upload foto barang, isi nama, kondisi, harga, dan deskripsi singkat. Publikasikan — dan barangmu langsung tampil di katalog ECOutdoor!
          </p>
          @auth
            <a href="{{ route('dashboard') }}" id="step3-cta" class="mt-auto inline-flex items-center gap-2 text-sm font-bold px-6 py-2.5 rounded-full transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5" style="background: linear-gradient(135deg, #ff7c0a, #f06000); color: #ffffff;">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
              Upload Sekarang
            </a>
          @else
            <a href="{{ route('register') }}" id="step3-cta" class="mt-auto inline-flex items-center gap-2 text-sm font-bold px-6 py-2.5 rounded-full transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5" style="background: linear-gradient(135deg, #ff7c0a, #f06000); color: #ffffff;">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
              Mulai Gratis
            </a>
          @endauth
        </div>

      </div>

      <!-- Trust note -->
      <p class="text-center text-sm mt-12" style="color: #787469;">
        🌿 Gratis, tanpa komisi tersembunyi &nbsp;·&nbsp; 🔒 Transaksi aman &amp; terlindungi &nbsp;·&nbsp; 📦 Sistem pengiriman terintegrasi
      </p>

    </div>
  </section>


  <!-- ====================== FEATURES STRIP ====================== -->
  <section id="features" class="features-strip py-5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-forest-500/20 flex items-center justify-center flex-shrink-0 text-xl">🚚</div>
          <div>
            <p class="text-white font-semibold text-sm">Gratis Ongkir</p>
            <p class="text-stone-400 text-xs">Pembelian ≥ Rp 500rb</p>
          </div>
        </div>

        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-forest-500/20 flex items-center justify-center flex-shrink-0 text-xl">🆓</div>
          <div>
            <p class="text-white font-semibold text-sm">Gratis Biaya Admin</p>
            <p class="text-stone-400 text-xs">10 Kali Transaksi</p>
          </div>
        </div>

        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-forest-500/20 flex items-center justify-center flex-shrink-0 text-xl">↩️</div>
          <div>
            <p class="text-white font-semibold text-sm">Easy Return</p>
            <p class="text-stone-400 text-xs">30 Hari Pengembalian</p>
          </div>
        </div>

        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-forest-500/20 flex items-center justify-center flex-shrink-0 text-xl">💳</div>
          <div>
            <p class="text-white font-semibold text-sm">Bayar Aman</p>
            <p class="text-stone-400 text-xs">Sistem Rekber (Bisa Refund)</p>
          </div>
        </div>

      </div>
    </div>
  </section>


  <!-- ====================== PRODUK UNGGULAN ====================== -->
  <section id="produk" class="py-24 bg-stone-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      <!-- Section Header -->
      <div class="text-center mb-16 animate-fade-up">
        <span class="inline-block text-adventure-400 text-sm font-bold tracking-widest uppercase mb-3">— Koleksi Terbaik —</span>
        <h2 class="heading-accent font-playfair text-4xl sm:text-5xl font-bold text-white mb-4">
          Produk Unggulan
        </h2>
        <p class="text-stone-400 text-lg max-w-2xl mx-auto">
          Dirancang untuk performa ekstra, dipilih oleh para petualang sejati.
        </p>
      </div>

      <!-- Category Filter Tabs -->
      @php
          $currentCategory = request()->query('kategori');
      @endphp
      <div id="kategori" class="flex flex-wrap justify-center gap-3 mb-12">
        <a href="{{ url('/#kategori') }}" id="filter-all" class="tag {{ !$currentCategory ? 'active' : '' }} px-5 py-2 rounded-full text-sm font-medium cursor-pointer inline-block transition-colors">Semua</a>
        <a href="{{ url('/?kategori=Tenda#kategori') }}" id="filter-tenda" class="tag {{ $currentCategory == 'Tenda' ? 'active' : '' }} px-5 py-2 rounded-full text-sm font-medium cursor-pointer inline-block transition-colors">🏕️ Tenda</a>
        <a href="{{ url('/?kategori=' . urlencode('Tas & Carrier') . '#kategori') }}" id="filter-tas" class="tag {{ $currentCategory == 'Tas & Carrier' ? 'active' : '' }} px-5 py-2 rounded-full text-sm font-medium cursor-pointer inline-block transition-colors">🎒 Tas & Carrier</a>
        <a href="{{ url('/?kategori=' . urlencode('Alas Kaki') . '#kategori') }}" id="filter-sepatu" class="tag {{ $currentCategory == 'Alas Kaki' ? 'active' : '' }} px-5 py-2 rounded-full text-sm font-medium cursor-pointer inline-block transition-colors">🥾 Alas Kaki</a>
        <a href="{{ url('/?kategori=Aksesoris#kategori') }}" id="filter-aksesoris" class="tag {{ $currentCategory == 'Aksesoris' ? 'active' : '' }} px-5 py-2 rounded-full text-sm font-medium cursor-pointer inline-block transition-colors">🧭 Aksesoris</a>
      </div>

      <!-- Product Grid -->
      <div id="product-grid" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">

        @foreach($products as $index => $product)
        <article id="product-{{ $index }}" class="product-card rounded-2xl overflow-hidden group">
          <a href="{{ route('products.show', $product->id) }}" class="block relative overflow-hidden h-64">
            <img
              src="{{ asset('images/' . $product->nama_file_gambar) }}"
              alt="{{ $product->nama_produk }}"
              class="product-img w-full h-full object-cover"
            />
            <!-- Overlay on hover -->
            <div class="absolute inset-0 bg-gradient-to-t from-stone-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-5">
              <span class="text-white text-sm font-semibold">Lihat Detail →</span>
            </div>
            <!-- Badge -->
            <div class="absolute top-3 left-3">
              @if($index === 0)
                <span class="badge-shimmer text-white text-[10px] font-black px-2.5 py-1 rounded-full shadow">BESTSELLER</span>
              @elseif($index === 1)
                <span class="bg-forest-600 text-white text-[10px] font-black px-2.5 py-1 rounded-full shadow">NEW ARRIVAL</span>
              @else
                <span class="discount-badge text-white text-[10px] font-black px-2.5 py-1 rounded-full shadow">SALE 30%</span>
              @endif
            </div>
            <div class="absolute top-3 right-3">
              <button id="wish-{{ $index }}" class="btn-wish w-8 h-8 rounded-full flex items-center justify-center text-stone-300" onclick="event.preventDefault(); event.stopPropagation();">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
              </button>
            </div>
          </a>

          <div class="p-6">
            <div class="flex items-start justify-between mb-2">
              <div>
                <a href="{{ route('products.show', $product->id) }}" class="block">
                  <h3 class="text-white font-bold text-xl mt-2 group-hover:text-forest-400 transition-colors hover:text-adventure-400">
                    {{ $product->nama_produk }}
                  </h3>
                </a>
                <p class="text-stone-400 text-sm mt-1 line-clamp-2">{{ $product->deskripsi }}</p>
              </div>
            </div>

            <!-- Stars -->
            <div class="flex items-center gap-2 my-3">
              <div class="stars flex text-sm">★★★★★</div>
              <span class="text-stone-400 text-sm">Stok: {{ $product->stok }}</span>
            </div>

            <!-- Price & Cart -->
            <div class="flex items-center justify-between mt-4">
              <div>
                <p class="text-adventure-400 font-black text-2xl">
                  Rp {{ number_format($product->harga, 0, ',', '.') }}
                </p>
              </div>
              <a href="{{ route('products.show', $product->id) }}"
                 class="btn-cart rounded-xl px-4 py-2.5 font-semibold text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                  <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Lihat Detail
              </a>
            </div>
          </div>
        </article>
        @endforeach


      </div>


      <!-- View All Button -->
      <div class="text-center mt-14">
        <a href="#" id="view-all-btn" class="btn-primary rounded-full px-10 py-4 text-white font-bold text-base shadow-xl inline-block">
          <span>Lihat Semua Produk →</span>
        </a>
      </div>
    </div>
  </section>
@endsection
