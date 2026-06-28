<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'ECOutdoor — Perlengkapan Outdoor Terbaik')</title>
  <link rel="icon" type="image/png" href="{{ asset('images/image_1.png') }}">
  <meta name="description" content="ECOutdoor menyediakan perlengkapan outdoor premium — tenda, carrier, sepatu hiking, dan lebih banyak lagi. Siap menemani setiap petualangan Anda." />
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
              50:  '#f0f7f0',
              100: '#d8ecd8',
              200: '#b3d9b3',
              300: '#7dbf7d',
              400: '#4da34d',
              500: '#2d8a2d',
              600: '#1e6e1e',
              700: '#175517',
              800: '#124012',
              900: '#0b2d0b',
              950: '#061a06',
            },
            stone: {
              50:  '#f5f5f3',
              100: '#e7e6e2',
              200: '#d0cec8',
              300: '#b3b0a6',
              400: '#918e84',
              500: '#787469',
              600: '#625f55',
              700: '#504e46',
              800: '#42403b',
              900: '#393733',
              950: '#1f1e1b',
            },
            adventure: {
              50:  '#fff8ed',
              100: '#ffefd3',
              200: '#ffdba6',
              300: '#ffc06d',
              400: '#ff9b33',
              500: '#ff7c0a',
              600: '#f06000',
              700: '#c74900',
              800: '#9e3a00',
              900: '#7f3100',
              950: '#451600',
            },
          },
          fontFamily: {
            outfit: ['Outfit', 'sans-serif'],
            playfair: ['"Playfair Display"', 'serif'],
          },
          animation: {
            'fade-up': 'fadeUp 0.7s ease-out both',
            'fade-in': 'fadeIn 0.6s ease-out both',
            'slide-right': 'slideRight 0.6s ease-out both',
            'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            'bounce-subtle': 'bounceSub 2s ease-in-out infinite',
          },
          keyframes: {
            fadeUp: {
              '0%':   { opacity: '0', transform: 'translateY(30px)' },
              '100%': { opacity: '1', transform: 'translateY(0)' },
            },
            fadeIn: {
              '0%':   { opacity: '0' },
              '100%': { opacity: '1' },
            },
            slideRight: {
              '0%':   { opacity: '0', transform: 'translateX(-30px)' },
              '100%': { opacity: '1', transform: 'translateX(0)' },
            },
            bounceSub: {
              '0%, 100%': { transform: 'translateY(0)' },
              '50%':      { transform: 'translateY(-8px)' },
            },
          },
        },
      },
    };
  </script>
  <style>
    * { box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    body { font-family: 'Outfit', sans-serif; background-color: #1f1e1b; }

    /* Glassmorphism Navbar */
    .navbar-glass {
      background: rgba(11, 45, 11, 0.6);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(77, 163, 77, 0.15);
    }

    /* Hero overlay gradient */
    .hero-overlay {
      background: linear-gradient(
        135deg,
        rgba(6, 26, 6, 0.80) 0%,
        rgba(11, 45, 11, 0.55) 40%,
        rgba(69, 22, 0, 0.45) 100%
      );
    }

    /* Product card hover glow */
    .product-card {
      background: linear-gradient(145deg, #242420, #2e2d28);
      border: 1px solid rgba(77, 163, 77, 0.12);
      transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1),
                  box-shadow 0.35s ease,
                  border-color 0.35s ease;
    }
    .product-card:hover {
      transform: translateY(-8px) scale(1.015);
      box-shadow: 0 24px 60px rgba(0, 0, 0, 0.55),
                  0 0 40px rgba(77, 163, 77, 0.15);
      border-color: rgba(77, 163, 77, 0.35);
    }
    .product-card:hover .product-img {
      transform: scale(1.08);
    }
    .product-img {
      transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    /* Badge shimmer */
    .badge-shimmer {
      background: linear-gradient(90deg, #ff7c0a, #ffb347, #ff7c0a);
      background-size: 200% auto;
      animation: shimmer 2.5s linear infinite;
    }
    @keyframes shimmer {
      to { background-position: 200% center; }
    }

    /* CTA button */
    .btn-primary {
      background: linear-gradient(135deg, #ff7c0a, #f06000);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    .btn-primary::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, #ffb347, #ff7c0a);
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    .btn-primary:hover::before { opacity: 1; }
    .btn-primary span { position: relative; z-index: 1; }
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 30px rgba(255, 124, 10, 0.45);
    }

    /* Outline button */
    .btn-outline {
      border: 2px solid rgba(255, 255, 255, 0.5);
      background: rgba(255,255,255,0.05);
      backdrop-filter: blur(8px);
      transition: all 0.3s ease;
    }
    .btn-outline:hover {
      border-color: #ff7c0a;
      color: #ff7c0a;
      background: rgba(255, 124, 10, 0.1);
      transform: translateY(-2px);
    }

    /* Cart badge */
    .cart-badge {
      background: linear-gradient(135deg, #ff7c0a, #f06000);
      animation: pulse-ring 2s ease-in-out infinite;
    }
    @keyframes pulse-ring {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.15); }
    }

    /* Star rating */
    .stars { color: #ff9b33; }

    /* Features strip */
    .features-strip {
      background: linear-gradient(90deg, #0b2d0b 0%, #175517 50%, #0b2d0b 100%);
      border-top: 1px solid rgba(77, 163, 77, 0.2);
      border-bottom: 1px solid rgba(77, 163, 77, 0.2);
    }

    /* Section heading accent */
    .heading-accent::after {
      content: '';
      display: block;
      width: 60px;
      height: 4px;
      background: linear-gradient(90deg, #ff7c0a, #ffb347);
      border-radius: 2px;
      margin: 12px auto 0;
    }

    /* Scroll indicator */
    .scroll-indicator {
      animation: bounceSub 2s ease-in-out infinite;
    }

    /* Nav links hover */
    .nav-link {
      position: relative;
      transition: color 0.3s;
    }
    .nav-link::after {
      content: '';
      position: absolute;
      bottom: -4px;
      left: 0;
      width: 0;
      height: 2px;
      background: #ff7c0a;
      border-radius: 1px;
      transition: width 0.3s ease;
    }
    .nav-link:hover::after { width: 100%; }
    .nav-link:hover { color: #ff9b33; }

    /* Category tags */
    .tag {
      background: rgba(77, 163, 77, 0.15);
      border: 1px solid rgba(77, 163, 77, 0.25);
      color: #7dbf7d;
      transition: all 0.3s;
    }
    .tag:hover {
      background: rgba(77, 163, 77, 0.3);
      color: #b3d9b3;
    }
    .tag.active {
      background: rgba(77, 163, 77, 0.9);
      color: #ffffff;
      border-color: rgba(77, 163, 77, 1);
      box-shadow: 0 4px 15px rgba(77, 163, 77, 0.4);
    }

    /* Add to cart button */
    .btn-cart {
      background: rgba(255, 124, 10, 0.1);
      border: 1px solid rgba(255, 124, 10, 0.35);
      color: #ff9b33;
      transition: all 0.3s;
    }
    .btn-cart:hover {
      background: linear-gradient(135deg, #ff7c0a, #f06000);
      border-color: #ff7c0a;
      color: #ffffff;
      transform: scale(1.04);
      box-shadow: 0 6px 20px rgba(255, 124, 10, 0.35);
    }

    /* Wishlist */
    .btn-wish {
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(255,255,255,0.1);
      transition: all 0.3s;
    }
    .btn-wish:hover {
      background: rgba(239, 68, 68, 0.15);
      border-color: rgba(239, 68, 68, 0.4);
      color: #f87171;
    }

    /* Hero floating card */
    .floating-card {
      background: rgba(11, 45, 11, 0.55);
      backdrop-filter: blur(16px);
      border: 1px solid rgba(77, 163, 77, 0.25);
      animation: bounceSub 3s ease-in-out infinite;
    }

    /* Discount badge */
    .discount-badge {
      background: linear-gradient(135deg, #ff7c0a, #f06000);
    }
  </style>
</head>
<body class="text-stone-100 flex flex-col min-h-screen">

  <!-- ====================== NAVBAR ====================== -->
  <nav id="navbar" class="navbar-glass fixed top-0 left-0 right-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-18 py-3">

        <!-- Logo -->
        <a href="{{ url('/') }}" id="logo-link" class="flex items-center group">
          <img
            src="{{ asset('images/image_1.png') }}"
            alt="ECOutdoor Logo"
            class="h-12 w-auto object-contain transition-all duration-300 group-hover:scale-105 drop-shadow-lg"
            style="filter: brightness(1.05) drop-shadow(0 2px 8px rgba(77,163,77,0.3));"
          />
        </a>

        <!-- Desktop Nav Links -->
        <div class="hidden md:flex items-center gap-8">
          <a href="{{ url('/#produk') }}" id="nav-produk" class="nav-link text-stone-300 font-medium text-sm">Produk</a>
          <a href="{{ url('/#kategori') }}" id="nav-kategori" class="nav-link text-stone-300 font-medium text-sm">Kategori</a>
          <a href="{{ url('/#cara-jual') }}" id="nav-jual" class="nav-link text-stone-300 font-medium text-sm">Cara Jual Barang</a>
          <a href="{{ route('pages.about') }}" id="nav-tentang" class="nav-link text-stone-300 font-medium text-sm">Tentang Kami</a>
        </div>

        <!-- Right: Search + Cart + CTA -->
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

          <!-- Pesanan Saya -->
          <a href="{{ route('pesanan.index') }}" id="pesanan-btn"
             class="relative flex items-center gap-2 px-3.5 py-2 rounded-xl hover:bg-white/10 transition-all duration-300 group"
             title="Pesanan Saya">
            <svg class="w-5 h-5 text-stone-300 group-hover:text-forest-400 transition-colors" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            <span class="hidden lg:inline text-stone-300 group-hover:text-forest-400 text-sm font-medium transition-colors">Pesanan Saya</span>
          </a>

          <!-- Cart -->
          <button id="cart-btn" class="relative p-2.5 rounded-xl hover:bg-white/10 transition-all duration-300 group">
            <svg class="w-5 h-5 text-stone-300 group-hover:text-adventure-400 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
              <line x1="3" y1="6" x2="21" y2="6"/>
              <path d="M16 10a4 4 0 01-8 0"/>
            </svg>
            <span class="cart-badge absolute -top-0.5 -right-0.5 w-4 h-4 rounded-full text-white text-[10px] font-bold hidden items-center justify-center">0</span>
          </button>

          <!-- Auth Buttons (Breeze) -->
          @auth
            <div class="hidden sm:flex items-center gap-3">
              <span class="text-stone-400 text-sm font-medium">
                👋 {{ Auth::user()->name }}
              </span>
              <a href="{{ url('/dashboard') }}"
                 id="dashboard-btn"
                 class="flex items-center gap-1.5 bg-forest-600/20 border border-forest-500/40 hover:bg-forest-600/35 hover:border-forest-400/60 text-forest-300 hover:text-forest-200 rounded-full px-5 py-2.5 font-semibold text-sm transition-all duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
              </a>
            </div>
          @else
            <div class="hidden sm:flex items-center gap-2">
              <a href="{{ route('login') }}"
                 id="login-btn"
                 class="flex items-center gap-1.5 bg-white/5 border border-white/15 hover:bg-forest-600/20 hover:border-forest-500/50 text-stone-300 hover:text-forest-300 rounded-full px-5 py-2.5 font-semibold text-sm transition-all duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                Masuk
              </a>
              <a href="{{ route('register') }}"
                 id="register-btn"
                 class="btn-primary rounded-full px-5 py-2.5 text-white font-semibold text-sm shadow-lg">
                <span>Daftar Gratis</span>
              </a>
            </div>
          @endauth

        </div>
      </div>
    </div>
  </nav>

  <!-- ====================== MAIN CONTENT ====================== -->
  <main class="flex-1">
    @yield('content')
  </main>

  <!-- ====================== FOOTER ====================== -->
  <footer id="footer" class="bg-stone-950 border-t border-stone-800/50 py-12 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid md:grid-cols-4 gap-10 mb-10">

        <!-- Brand -->
        <div class="md:col-span-1">
          <div class="flex items-center gap-3 mb-4">
            <img src="{{ asset('images/image_1.png') }}" alt="ECOutdoor Logo" class="h-10 w-auto object-contain drop-shadow-md rounded-lg" />
            <span class="text-xl font-bold"><span class="text-forest-400">EC</span><span class="text-white">Outdoor</span></span>
          </div>
          <p class="text-stone-400 text-sm leading-relaxed">Perlengkapan outdoor premium untuk setiap petualangan. Dari gunung ke lembah, kami siap menemani.</p>
        </div>

        <!-- Links -->
        <div>
          <h4 class="text-white font-semibold mb-4">Produk</h4>
          <ul class="space-y-2 text-stone-400 text-sm">
            <li><a href="{{ url('/?kategori=Tenda#kategori') }}" class="footer-category-link hover:text-adventure-400 transition-colors">Tenda</a></li>
            <li><a href="{{ url('/?kategori=' . urlencode('Tas & Carrier') . '#kategori') }}" class="footer-category-link hover:text-adventure-400 transition-colors">Tas & Carrier</a></li>
            <li><a href="{{ url('/?kategori=' . urlencode('Alas Kaki') . '#kategori') }}" class="footer-category-link hover:text-adventure-400 transition-colors">Alas Kaki</a></li>
            <li><a href="{{ url('/?kategori=Aksesoris#kategori') }}" class="footer-category-link hover:text-adventure-400 transition-colors">Aksesoris</a></li>
          </ul>
        </div>

        <div>
          <h4 class="text-white font-semibold mb-4">Layanan</h4>
          <ul class="space-y-2 text-stone-400 text-sm">
            <li><a href="{{ route('pages.about') }}" class="hover:text-adventure-400 transition-colors">Tentang Kami</a></li>
            <li><a href="{{ route('pages.blog') }}" class="hover:text-adventure-400 transition-colors">Blog & Panduan</a></li>
            <li><a href="{{ route('pages.faq') }}" class="hover:text-adventure-400 transition-colors">FAQ</a></li>
            <li><a href="{{ route('pages.return-policy') }}" class="hover:text-adventure-400 transition-colors">Kebijakan Return</a></li>
            <li><a href="https://wa.me/6285804049637" target="_blank" rel="noopener noreferrer" class="hover:text-adventure-400 transition-colors">Hubungi Kami</a></li>
          </ul>
        </div>

        <div>
          <h4 class="text-white font-semibold mb-4">Ikuti Kami</h4>
          <div class="flex gap-3 mb-6">
            <a href="https://www.instagram.com/_ecoutdoor_/" target="_blank" rel="noopener noreferrer" id="social-ig" class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-stone-400 hover:text-adventure-400 hover:border-adventure-400/40 transition-all">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
            </a>
            <a href="https://wa.me/6285804049637" target="_blank" rel="noopener noreferrer" id="social-wa" class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-stone-400 hover:text-adventure-400 hover:border-adventure-400/40 transition-all">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm.029 18.88a9.87 9.87 0 01-4.724-1.207L2.88 19.12l1.482-4.306a9.844 9.844 0 01-1.373-5.069C2.989 7.023 7.042 3 12.029 3c2.425 0 4.7.946 6.413 2.663A9.015 9.015 0 0121.059 12c0 4.988-4.048 9.04-9.03 9.04v-.16z"/></svg>
            </a>
          </div>
          <p class="text-stone-500 text-xs">© {{ date('Y') }} ECOutdoor. Semua hak cipta dilindungi.</p>
        </div>

      </div>

      <div class="border-t border-stone-800/50 pt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
        <p class="text-stone-500 text-xs">Dibuat dengan ❤️ untuk para petualang Indonesia</p>
        <div class="flex gap-4 text-stone-500 text-xs">
          <a href="{{ route('pages.return-policy') }}" class="hover:text-stone-300 transition-colors">Syarat & Ketentuan</a>
          <a href="#" class="hover:text-stone-300 transition-colors">Kebijakan Privasi</a>
          <a href="#" class="hover:text-stone-300 transition-colors">Sitemap</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- ====================== JAVASCRIPT ====================== -->
  <script>
    // Navbar scroll behavior
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
      if (window.scrollY > 50) {
        navbar.style.background = 'rgba(6, 26, 6, 0.92)';
      } else {
        navbar.style.background = 'rgba(11, 45, 11, 0.6)';
      }
    });

    // Cart interaction is now handled dynamically by public/js/cart.js

    // Wishlist toggle
    document.querySelectorAll('[id^="wish-"]').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const svg = btn.querySelector('svg path');
        const active = btn.dataset.active === 'true';
        if (!active) {
          svg.style.fill = '#f87171';
          svg.style.stroke = '#f87171';
          btn.dataset.active = 'true';
        } else {
          svg.style.fill = 'none';
          svg.style.stroke = 'currentColor';
          btn.dataset.active = 'false';
        }
      });
    });

    // Scroll-based fade-in animation for product cards
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry, i) => {
        if (entry.isIntersecting) {
          setTimeout(() => {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
          }, i * 150);
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });

    document.querySelectorAll('.product-card').forEach(card => {
      card.style.opacity = '0';
      card.style.transform = 'translateY(40px)';
      card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
      observer.observe(card);
    });

    // AJAX Category Filtering
    document.querySelectorAll('#kategori a, .footer-category-link').forEach(link => {
      link.addEventListener('click', function(e) {
        const grid = document.getElementById('product-grid');
        // Jika tidak ada product-grid (bukan di homepage), biarkan browser yang handle navigasi
        if (!grid) {
            return;
        }

        e.preventDefault();
        const url = this.href;
        const isFooter = this.classList.contains('footer-category-link');
        
        // Update active class
        document.querySelectorAll('#kategori a').forEach(a => {
            a.classList.remove('active');
            if (a.href === url) a.classList.add('active');
        });
        
        if (!isFooter) {
            this.classList.add('active');
        }

        // Show loading state (optional, just fade out grid a bit)
        if(grid) grid.style.opacity = '0.5';

        // Fetch new products
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
          .then(res => res.text())
          .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newGrid = doc.getElementById('product-grid');
            
            if (newGrid && grid) {
              grid.innerHTML = newGrid.innerHTML;
              grid.style.opacity = '1';
              
              // Re-initialize animations for new cards
              document.querySelectorAll('#product-grid .product-card').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(40px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
              });
            }
            
            // Update browser URL without reloading
            window.history.pushState({}, '', url);

            if (isFooter) {
                document.getElementById('produk').scrollIntoView({ behavior: 'smooth' });
            }
          })
          .catch(err => {
            console.error('Error fetching categories:', err);
            if(grid) grid.style.opacity = '1';
          });
      });
    });
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
        * Checkout akan memproses semua item sekaligus dalam satu transaksi.
      </p>
    </div>
  </div>

  <!-- Overlay -->
  <div id="cart-overlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 hidden transition-opacity duration-300 opacity-0" onclick="toggleCartDrawer(false)"></div>

  <script src="{{ asset('js/cart.js') }}"></script>
</body>
</html>
