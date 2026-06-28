<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $product->nama_produk }} — ECOutdoor</title>
  <link rel="icon" type="image/png" href="{{ asset('images/image_1.png') }}">
  <meta name="description" content="{{ Str::limit($product->deskripsi, 155) }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            forest: {
              50:'#f0f7f0', 100:'#d8ecd8', 200:'#b3d9b3', 300:'#7dbf7d',
              400:'#4da34d', 500:'#2d8a2d', 600:'#1e6e1e', 700:'#175517',
              800:'#124012', 900:'#0b2d0b', 950:'#061a06',
            },
            stone: {
              50:'#f5f5f3', 100:'#e7e6e2', 200:'#d0cec8', 300:'#b3b0a6',
              400:'#918e84', 500:'#787469', 600:'#625f55', 700:'#504e46',
              800:'#42403b', 900:'#393733', 950:'#1f1e1b',
            },
            adventure: {
              400:'#ff9b33', 500:'#ff7c0a', 600:'#f06000',
            },
          },
          fontFamily: {
            outfit: ['Outfit', 'sans-serif'],
            playfair: ['"Playfair Display"', 'serif'],
          },
        },
      },
    };
  </script>
  <style>
    * { box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    body { font-family: 'Outfit', sans-serif; background-color: #1f1e1b; }

    .navbar-glass {
      background: rgba(11, 45, 11, 0.6);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(77, 163, 77, 0.15);
    }
    .nav-link { position: relative; transition: color 0.3s; }
    .nav-link::after {
      content: ''; position: absolute; bottom: -4px; left: 0;
      width: 0; height: 2px; background: #ff7c0a;
      border-radius: 1px; transition: width 0.3s ease;
    }
    .nav-link:hover::after { width: 100%; }
    .nav-link:hover { color: #ff9b33; }

    /* Main image zoom */
    .product-main-img {
      transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .img-wrapper:hover .product-main-img { transform: scale(1.04); }

    /* Primary button */
    .btn-buy {
      background: linear-gradient(135deg, #ff7c0a, #f06000);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    .btn-buy::before {
      content: ''; position: absolute; inset: 0;
      background: linear-gradient(135deg, #ffb347, #ff7c0a);
      opacity: 0; transition: opacity 0.3s ease;
    }
    .btn-buy:hover::before { opacity: 1; }
    .btn-buy span { position: relative; z-index: 1; }
    .btn-buy:hover { transform: translateY(-2px); box-shadow: 0 12px 30px rgba(255,124,10,0.45); }

    /* Outline button */
    .btn-cart-outline {
      border: 2px solid rgba(255,155,51,0.6);
      background: rgba(255,124,10,0.06);
      color: #ff9b33;
      transition: all 0.3s ease;
    }
    .btn-cart-outline:hover {
      border-color: #ff7c0a;
      background: rgba(255,124,10,0.15);
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(255,124,10,0.2);
    }

    /* Chat button */
    .btn-chat {
      background: rgba(45,138,45,0.12);
      border: 2px solid rgba(77,163,77,0.4);
      color: #7dbf7d;
      transition: all 0.3s ease;
    }
    .btn-chat:hover {
      background: rgba(45,138,45,0.22);
      border-color: #4da34d;
      color: #b3d9b3;
      transform: translateY(-2px);
    }

    /* Info card */
    .info-card {
      background: linear-gradient(145deg, #242420, #2e2d28);
      border: 1px solid rgba(77,163,77,0.12);
    }

    /* Breadcrumb */
    .breadcrumb-link { color: #7dbf7d; transition: color 0.2s; }
    .breadcrumb-link:hover { color: #b3d9b3; }

    /* Seller card */
    .seller-card {
      background: linear-gradient(135deg, rgba(11,45,11,0.5), rgba(23,85,23,0.3));
      border: 1px solid rgba(77,163,77,0.2);
      backdrop-filter: blur(12px);
    }

    /* Stock badge */
    .badge-stock-ok  { background: rgba(45,138,45,0.15); color:#7dbf7d; border:1px solid rgba(77,163,77,0.25); }
    .badge-stock-low { background: rgba(202,138,4,0.12);  color:#fbbf24; border:1px solid rgba(202,138,4,0.3); }
    .badge-stock-nil { background: rgba(220,38,38,0.1);   color:#f87171; border:1px solid rgba(220,38,38,0.25);}

    /* Toast */
    .toast-enter { opacity:0; transform:translateX(-50%) translateY(20px); }
    .toast-show  { opacity:1; transform:translateX(-50%) translateY(0); }

    /* Cart badge */
    .cart-badge {
      background: linear-gradient(135deg, #ff7c0a, #f06000);
      animation: pulse-ring 2s ease-in-out infinite;
    }
    @keyframes pulse-ring {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.15); }
    }
  </style>
</head>
<body class="text-stone-100">

  <!-- ====================== NAVBAR ====================== -->
  <nav id="navbar" class="navbar-glass fixed top-0 left-0 right-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-18 py-3">

        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center group">
          <img src="{{ asset('images/image_1.png') }}" alt="ECOutdoor Logo"
               class="h-12 w-auto object-contain transition-all duration-300 group-hover:scale-105 drop-shadow-lg"
               style="filter: brightness(1.05) drop-shadow(0 2px 8px rgba(77,163,77,0.3));" />
        </a>

        <!-- Nav Links -->
        <div class="hidden md:flex items-center gap-8">
          <a href="{{ url('/') }}#produk"  class="nav-link text-stone-300 font-medium text-sm">Produk</a>
          <a href="{{ url('/') }}#kategori" class="nav-link text-stone-300 font-medium text-sm">Kategori</a>
          <a href="{{ url('/') }}#cara-jual" class="nav-link text-stone-300 font-medium text-sm">Cara Jual Barang</a>
          <a href="{{ url('/') }}#footer"   class="nav-link text-stone-300 font-medium text-sm">Tentang Kami</a>
        </div>

        <!-- Right: Auth -->
        <div class="flex items-center gap-3">
          <!-- Search -->
          <form action="{{ url('/') }}#produk" method="GET" class="hidden sm:flex items-center relative group">
            <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}"
                   class="bg-white/5 border border-white/10 rounded-full pl-10 pr-4 py-2 text-stone-200 text-sm focus:outline-none focus:bg-white/10 focus:border-forest-500/60 transition-all duration-300 w-40 lg:w-56 placeholder-stone-400" />
            <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-stone-400 group-focus-within:text-forest-400 transition-colors">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
              </svg>
            </button>
          </form>

          <!-- Wishlist -->
          <button id="wishlist-btn" class="relative p-2.5 rounded-xl hover:bg-white/10 transition-all duration-300 group">
            <svg class="w-5 h-5 text-stone-300 group-hover:text-red-400 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
            </svg>
          </button>

          <!-- Cart -->
          <button id="cart-btn" class="relative p-2.5 rounded-xl hover:bg-white/10 transition-all duration-300 group">
            <svg class="w-5 h-5 text-stone-300 group-hover:text-adventure-400 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
              <line x1="3" y1="6" x2="21" y2="6"/>
              <path d="M16 10a4 4 0 01-8 0"/>
            </svg>
            <span class="cart-badge absolute -top-0.5 -right-0.5 w-4 h-4 rounded-full text-white text-[10px] font-bold hidden items-center justify-center">0</span>
          </button>

          @auth
            <div class="hidden sm:flex items-center gap-3">
              <span class="text-stone-400 text-sm font-medium">👋 {{ Auth::user()->name }}</span>
              <a href="{{ url('/dashboard') }}"
                 class="flex items-center gap-1.5 rounded-full px-5 py-2.5 font-semibold text-sm transition-all duration-300"
                 style="background:rgba(30,110,30,0.2); border:1px solid rgba(77,163,77,0.4); color:#7dbf7d;"
                 onmouseover="this.style.background='rgba(30,110,30,0.35)'"
                 onmouseout="this.style.background='rgba(30,110,30,0.2)'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
              </a>
            </div>
          @else
            <div class="hidden sm:flex items-center gap-2">
              <a href="{{ route('login') }}"
                 class="flex items-center gap-1.5 rounded-full px-5 py-2.5 font-semibold text-sm transition-all duration-300"
                 style="background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.15); color:#b3b0a6;">Masuk</a>
              <a href="{{ route('register') }}"
                 class="btn-buy rounded-full px-5 py-2.5 text-white font-semibold text-sm shadow-lg">
                <span>Daftar Gratis</span>
              </a>
            </div>
          @endauth
        </div>
      </div>
    </div>
  </nav>


  <!-- ====================== MAIN CONTENT ====================== -->
  <main class="pt-24 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      <!-- Header Section: Back Button & Breadcrumb -->
      <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-8">
        <!-- Back Button -->
        <button onclick="window.history.length > 1 ? window.history.back() : window.location.href='{{ url('/') }}'" class="flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-full transition-all duration-300 shadow-sm" style="background:rgba(255,255,255,0.05); color:#b3b0a6; border:1px solid rgba(255,255,255,0.1);" onmouseover="this.style.background='rgba(45,138,45,0.15)'; this.style.color='#7dbf7d'; this.style.borderColor='rgba(77,163,77,0.3)';" onmouseout="this.style.background='rgba(255,255,255,0.05)'; this.style.color='#b3b0a6'; this.style.borderColor='rgba(255,255,255,0.1)';">
          <svg class="w-5 h-5 pr-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        </button>

        <!-- Breadcrumb -->
        <nav class="flex items-center flex-wrap gap-2 text-sm" aria-label="Breadcrumb">
          <a href="{{ url('/') }}" class="breadcrumb-link">Beranda</a>
          <span class="text-stone-600">/</span>
          <a href="{{ url('/') }}#produk" class="breadcrumb-link">Produk</a>
          <span class="text-stone-600">/</span>
          <span class="text-stone-400 truncate max-w-[200px] sm:max-w-xs">{{ $product->nama_produk }}</span>
        </nav>
      </div>

      <!-- Product Detail Grid -->
      <div class="grid lg:grid-cols-2 gap-12 items-start">

        <!-- ===== LEFT: IMAGE ===== -->
        <div class="sticky top-28">
          <!-- Main Image -->
          <div class="img-wrapper relative rounded-3xl overflow-hidden aspect-square"
               style="background:#242420; border:1px solid rgba(77,163,77,0.12);">
            <img id="main-product-img"
                 src="{{ $product->image_url }}"
                 alt="{{ $product->nama_produk }}"
                 class="product-main-img w-full h-full object-cover" />
            <!-- Stock badge overlay -->
            @if($product->stok === 0)
              <div class="absolute inset-0 flex items-center justify-center"
                   style="background:rgba(0,0,0,0.55);">
                <span class="text-white font-black text-2xl tracking-widest uppercase opacity-80">Stok Habis</span>
              </div>
            @endif
            <!-- Image zoom hint -->
            <div class="absolute bottom-4 right-4 px-3 py-1.5 rounded-full text-xs font-medium"
                 style="background:rgba(0,0,0,0.5); backdrop-filter:blur(8px); color:rgba(255,255,255,0.7);">
              🔍 Hover untuk zoom
            </div>
          </div>

          <!-- Trust badges -->
          <div class="grid grid-cols-3 gap-3 mt-5">
            @foreach([
              ['🚚', 'Gratis Ongkir', 'Pulau Jawa'],
              ['🆓', 'Bebas Admin', '10x Transaksi'],
              ['↩️', 'Easy Return', '30 Hari'],
            ] as [$icon, $label, $sub])
            <div class="flex flex-col items-center text-center p-3 rounded-2xl"
                 style="background:rgba(45,138,45,0.07); border:1px solid rgba(77,163,77,0.12);">
              <span class="text-xl mb-1">{{ $icon }}</span>
              <p class="text-white text-xs font-semibold">{{ $label }}</p>
              <p class="text-stone-500 text-[10px] mt-0.5">{{ $sub }}</p>
            </div>
            @endforeach
          </div>
        </div>

        <!-- ===== RIGHT: DETAIL ===== -->
        <div class="flex flex-col gap-6">

          <!-- Product name & badges -->
          <div>
            <div class="flex flex-wrap items-center gap-2 mb-3">
              <span class="px-3 py-1 rounded-full text-[10px] font-black tracking-widest uppercase"
                    style="background:linear-gradient(90deg,#ff7c0a,#ffb347); color:#fff;">
                🏕️ OUTDOOR GEAR
              </span>
              @if($product->stok > 0 && $product->stok <= 10)
                <span class="badge-stock-low px-3 py-1 rounded-full text-[10px] font-bold">⚠️ Stok Terbatas</span>
              @elseif($product->stok === 0)
                <span class="badge-stock-nil px-3 py-1 rounded-full text-[10px] font-bold">Stok Habis</span>
              @else
                <span class="badge-stock-ok px-3 py-1 rounded-full text-[10px] font-bold">✓ Tersedia</span>
              @endif
            </div>

            <h1 class="font-playfair text-3xl sm:text-4xl font-bold text-white leading-tight mb-2">
              {{ $product->nama_produk }}
            </h1>

            <!-- Stars & seller -->
            <div class="flex items-center gap-3 flex-wrap">
              <div class="flex items-center gap-1.5">
                <span class="text-adventure-400 text-base">
                  {{ str_repeat('★', round($averageRating)) }}{{ str_repeat('☆', 5 - round($averageRating)) }}
                </span>
                <span class="text-stone-400 text-sm">({{ number_format($averageRating, 1) }} dari {{ $totalReviews }} ulasan)</span>
              </div>
              <span class="text-stone-700">·</span>
              <span class="text-stone-400 text-sm">
                Dijual oleh
                <strong class="text-forest-400">{{ $product->user->name ?? 'ECOutdoor Partner' }}</strong>
              </span>
            </div>
          </div>

          <!-- Price -->
          <div class="py-5 px-6 rounded-2xl info-card">
            <p class="text-stone-400 text-sm mb-1">Harga</p>
            <p class="font-black text-4xl sm:text-5xl text-adventure-400">
              Rp {{ number_format($product->harga, 0, ',', '.') }}
            </p>
            <p class="text-stone-500 text-xs mt-2">
              <span class="text-forest-400 font-semibold">🚚 Gratis Ongkos Kirim</span> · Harga sudah termasuk ongkir
            </p>
          </div>

          <!-- Stock info -->
          <div class="flex items-center gap-4 px-1">
            <div class="flex items-center gap-2">
              <svg class="w-4 h-4 text-forest-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
              </svg>
              <span class="text-sm text-stone-300">Stok tersisa:
                <strong class="{{ $product->stok <= 10 && $product->stok > 0 ? 'text-yellow-400' : ($product->stok === 0 ? 'text-red-400' : 'text-forest-400') }}">
                  {{ $product->stok }} unit
                </strong>
              </span>
            </div>
            @if($product->stok > 0)
            <div class="flex items-center gap-2">
              <svg class="w-4 h-4 text-forest-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              <span class="text-sm text-stone-300">Siap dikirim</span>
            </div>
            @endif
          </div>

          <!-- Description -->
          <div>
            <h2 class="text-white font-bold text-base mb-3 flex items-center gap-2">
              <span class="w-1 h-5 rounded-full" style="background:#ff7c0a;"></span>
              Deskripsi Produk
            </h2>
            <div class="rounded-2xl p-5 info-card">
              <p class="text-stone-300 text-sm leading-relaxed whitespace-pre-line">{{ $product->deskripsi }}</p>
            </div>
          </div>

          <!-- Quantity selector -->
          <div>
            <label class="text-stone-400 text-sm font-medium mb-2 block">Jumlah</label>
            <div class="flex items-center gap-3">
              <div class="flex items-center rounded-xl overflow-hidden"
                   style="background:#242420; border:1px solid rgba(77,163,77,0.2);">
                <button id="qty-minus" onclick="changeQty(-1)"
                        class="px-4 py-3 text-stone-300 hover:text-adventure-400 hover:bg-white/5 transition-colors font-bold text-lg">−</button>
                <span id="qty-display" class="px-5 py-3 text-white font-bold text-base min-w-[3rem] text-center">1</span>
                <button id="qty-plus" onclick="changeQty(1)"
                        class="px-4 py-3 text-stone-300 hover:text-adventure-400 hover:bg-white/5 transition-colors font-bold text-lg">+</button>
              </div>
              <span class="text-stone-500 text-sm">/ {{ $product->stok }} unit tersedia</span>
            </div>
          </div>

          <!-- ===== ACTION BUTTONS ===== -->
          <div class="flex flex-col sm:flex-row gap-3 pt-2">

            <!-- Beli Langsung — langsung ke halaman checkout (publik) -->
            @if($product->stok > 0)
              <a href="{{ route('checkout.show', ['id' => $product->id, 'qty' => 1]) }}"
                 id="btn-beli"
                 class="btn-buy flex-1 flex items-center justify-center gap-2.5 rounded-2xl px-6 py-4 text-white font-bold text-base shadow-xl">
                <span class="relative z-10 flex items-center gap-2.5">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                  </svg>
                  Beli Langsung
                </span>
              </a>

              <!-- Masukkan Keranjang — Tambah ke keranjang lokal -->
              <button onclick="addToCart({{ $product->id }}, '{{ addslashes($product->nama_produk) }}', {{ $product->harga }}, '{{ $product->image_url }}', {{ $product->stok }}, qty)"
                 id="btn-keranjang"
                 class="btn-cart-outline flex-1 flex items-center justify-center gap-2.5 rounded-2xl px-6 py-4 font-bold text-base cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Masukkan Keranjang
              </button>
            @else
              <div class="flex-1 flex items-center justify-center gap-2.5 rounded-2xl px-6 py-4 font-bold text-base opacity-50 cursor-not-allowed"
                   style="background:rgba(255,255,255,0.05); border:2px solid rgba(255,255,255,0.1); color:#787469;">
                Stok Habis
              </div>
            @endif
          </div>

          <!-- Chat Penjual via WhatsApp — langsung tanpa login -->
          @php
            $sellerPhone = preg_replace('/[^0-9]/', '', $product->user->no_whatsapp ?? '');
            // Format to Indonesian country code (62) if it starts with 0
            if (str_starts_with($sellerPhone, '0')) {
                $sellerPhone = '62' . substr($sellerPhone, 1);
            }
            $waMsg = urlencode(
              "Halo, saya tertarik dengan produk *{$product->nama_produk}*" .
              " seharga Rp " . number_format($product->harga, 0, ',', '.') .
              ". Apakah masih tersedia? 🙏"
            );
          @endphp

          @if($sellerPhone)
            <a href="https://wa.me/{{ $sellerPhone }}?text={{ $waMsg }}"
               id="btn-chat"
               target="_blank" rel="noopener"
               class="btn-chat w-full flex items-center justify-center gap-2.5 rounded-2xl px-6 py-3.5 font-semibold text-base">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm.029 18.88a9.87 9.87 0 01-4.724-1.207L2.88 19.12l1.482-4.306a9.844 9.844 0 01-1.373-5.069C2.989 7.023 7.042 3 12.029 3c2.425 0 4.7.946 6.413 2.663A9.015 9.015 0 0121.059 12c0 4.988-4.048 9.04-9.03 9.04v-.16z"/>
              </svg>
              Chat Penjual via WhatsApp
            </a>
          @else
            <button id="btn-chat" onclick="typeof showToast === 'function' ? showToast('⚠️ Maaf, penjual ini belum mendaftarkan nomor WhatsApp.', 'error') : alert('Maaf, penjual ini belum mendaftarkan nomor WhatsApp.')"
                    class="btn-chat w-full flex items-center justify-center gap-2.5 rounded-2xl px-6 py-3.5 font-semibold text-base">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
              </svg>
              Chat Penjual
            </button>
          @endif

          <!-- Seller info card -->
          <div class="seller-card rounded-2xl p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0"
                 style="background:linear-gradient(135deg,#175517,#2d8a2d);">
              <svg class="w-6 h-6 text-forest-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-white font-bold text-sm">{{ $product->user->name ?? 'ECOutdoor Partner' }}</p>
              <p class="text-forest-400 text-xs mt-0.5">ECOutdoor Verified Seller ✓</p>
              <p class="text-stone-500 text-xs mt-1">Member sejak {{ optional($product->user->created_at)->format('M Y') ?? '-' }}</p>
            </div>
            <div class="text-right flex-shrink-0">
              <p class="text-forest-400 font-bold text-sm">{{ $product->user->products->count() ?? 1 }}</p>
              <p class="text-stone-500 text-xs">Produk</p>
            </div>
          </div>

          <!-- ====================== REVIEWS SECTION ====================== -->
          <div class="mt-8" id="ulasan">
            <h2 class="text-white font-bold text-lg mb-4 flex items-center gap-2">
              <span class="w-1 h-5 rounded-full" style="background:#ff7c0a;"></span>
              Ulasan Pelanggan ({{ $totalReviews }})
            </h2>

            @if(session('success'))
                <div class="bg-forest-900/50 border border-forest-500/30 text-forest-300 px-4 py-3 rounded-xl mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-900/50 border border-red-500/30 text-red-300 px-4 py-3 rounded-xl mb-4 text-sm">
                    {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-900/50 border border-red-500/30 text-red-300 px-4 py-3 rounded-xl mb-4 text-sm">
                    <ul class="list-disc pl-4">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- List of Reviews -->
            <div class="space-y-4 mb-8">
              @forelse($product->reviews as $review)
                @php
                  $reviewerName = $review->reviewer_name ?? optional($review->user)->name ?? 'Pengguna Anonim';
                  $initial      = mb_strtoupper(mb_substr($reviewerName, 0, 1));
                @endphp
                <div class="p-5 rounded-2xl" style="background:rgba(36,36,32,0.7); border:1px solid rgba(77,163,77,0.12);">
                  <div class="flex items-start gap-3 mb-3">
                    <!-- Avatar initial -->
                    <div class="flex-shrink-0 w-9 h-9 rounded-full flex items-center justify-center font-bold text-sm text-white"
                         style="background:linear-gradient(135deg,#175517,#2d8a2d);">
                      {{ $initial }}
                    </div>
                    <div class="flex-1 min-w-0">
                      <div class="flex items-center justify-between gap-2 flex-wrap">
                        <p class="text-white font-semibold text-sm">{{ $reviewerName }}</p>
                        <div class="text-adventure-400 text-sm tracking-wide">
                          {{ str_repeat('★', $review->rating) }}<span style="color:rgba(145,142,132,0.4);">{{ str_repeat('★', 5 - $review->rating) }}</span>
                        </div>
                      </div>
                      <p class="text-stone-500 text-xs mt-0.5">{{ $review->created_at->diffForHumans() }}</p>
                    </div>
                  </div>
                  <p class="text-stone-300 text-sm leading-relaxed mb-3 pl-12">{{ $review->komentar }}</p>
                  @if($review->gambar)
                    <div class="pl-12 mt-2">
                      <img src="{{ $review->gambar_url }}"
                           alt="Foto ulasan dari {{ $reviewerName }}"
                           class="h-28 w-28 object-cover rounded-2xl cursor-pointer hover:scale-105 transition-transform duration-300"
                           style="border:1.5px solid rgba(77,163,77,0.2);"
                           onclick="window.open(this.src, '_blank')" />
                    </div>
                  @endif
                </div>
              @empty
                <div class="p-8 text-center rounded-2xl" style="background:rgba(36,36,32,0.5); border:1px solid rgba(77,163,77,0.1);">
                  <p class="text-4xl mb-3">💬</p>
                  <p class="text-stone-400 text-sm">Belum ada ulasan untuk produk ini.</p>
                  <p class="text-stone-600 text-xs mt-1">Jadilah yang pertama memberikan ulasan setelah berbelanja!</p>
                </div>
              @endforelse
            </div>

            <!-- Form ulasan sekarang hanya tersedia melalui halaman Pesanan Saya -->
            <div class="p-4 rounded-xl border border-stone-800 bg-stone-900/30 text-center text-sm text-stone-400">
              Ingin memberikan ulasan? Anda dapat mengunggah ulasan dan foto barang setelah pesanan Anda selesai melalui halaman <a href="{{ url('/pesanan-saya') }}" class="text-forest-400 hover:underline font-semibold">Pesanan Saya</a>.
            </div>
          </div>
          <!-- ============================================================= -->

        </div>
        <!-- end RIGHT -->
      </div>

      <!-- Back to catalog -->
      <div class="mt-16 text-center">
        <a href="{{ url('/') }}#produk"
           class="inline-flex items-center gap-2 text-stone-400 hover:text-forest-400 transition-colors text-sm font-medium">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
          Kembali ke Katalog Produk
        </a>
      </div>

    </div>
  </main>


  <!-- ====================== FOOTER mini ====================== -->
  <footer style="background:#0b2d0b; border-top:1px solid rgba(77,163,77,0.15);" class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-3">
      <span class="text-forest-400 font-bold text-sm"><span class="text-forest-300">EC</span>Outdoor</span>
      <p class="text-stone-600 text-xs">© {{ date('Y') }} ECOutdoor. Dibuat dengan ❤️ untuk para petualang Indonesia.</p>
    </div>
  </footer>


  <!-- ====================== JAVASCRIPT ====================== -->
  <script>
    // Navbar scroll
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
      navbar.style.background = window.scrollY > 50
        ? 'rgba(6, 26, 6, 0.92)'
        : 'rgba(11, 45, 11, 0.6)';
    });

    // Quantity controller — sync dengan link href tombol beli
    let qty = 1;
    const maxStock       = {{ $product->stok }};
    const checkoutBase   = '{{ route("checkout.show", $product->id) }}';

    function changeQty(delta) {
      qty = Math.max(1, Math.min(maxStock, qty + delta));
      document.getElementById('qty-display').textContent = qty;
      // Update href tombol beli
      const url = checkoutBase + '?qty=' + qty;
      const btnBeli = document.getElementById('btn-beli');
      if (btnBeli) btnBeli.href = url;
    }
  </script>
  <!-- ====================== CART DRAWER ====================== -->
  <div id="cart-drawer" class="fixed inset-y-0 right-0 w-full sm:w-[450px] z-50 transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col" style="background: rgba(31, 30, 27, 0.95); backdrop-filter: blur(20px); border-left: 1px solid rgba(77, 163, 77, 0.15); box-shadow: -10px 0 30px rgba(0, 0, 0, 0.5);">
    <!-- Drawer Header -->
    <div class="p-6 border-b border-stone-800/50 flex items-center justify-between">
      <div class="flex items-center gap-2.5">
        <svg class="w-6 h-6 text-adventure-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
        </svg>
        <h3 class="text-lg font-bold text-white tracking-wide">Keranjang Belanja</h3>
      </div>
      <button onclick="toggleCartDrawer(false)" class="p-2 text-stone-400 hover:text-white rounded-xl hover:bg-white/5 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>

    <!-- Drawer Body -->
    <div id="cart-items-container" class="flex-1 overflow-y-auto p-6 space-y-4">
      <!-- Dynamic items -->
    </div>

    <!-- Drawer Footer -->
    <div class="p-6 border-t border-stone-800/50 bg-stone-900/40 space-y-4">
      <div class="flex items-center justify-between text-sm font-semibold text-stone-300">
        <span>Total Produk:</span>
        <span id="cart-drawer-count" class="font-extrabold text-white text-base">0 Item</span>
      </div>
      <p class="text-stone-500 text-[11px] leading-relaxed">
        * Checkout dilakukan per item produk secara langsung untuk kenyamanan transaksi guest.
      </p>
    </div>
  </div>

  <!-- Overlay -->
  <div id="cart-overlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 hidden transition-opacity duration-300 opacity-0" onclick="toggleCartDrawer(false)"></div>

  <script src="{{ asset('js/cart.js') }}"></script>
</body>
</html>
