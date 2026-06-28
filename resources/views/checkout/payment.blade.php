<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pembayaran — {{ $order->kode_pesanan }} | ECOutdoor</title>
  <link rel="icon" type="image/png" href="{{ asset('images/image_1.png') }}">
  <meta name="description" content="Selesaikan pembayaran pesanan ECOutdoor kamu dengan aman." />
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
            stone:     { 400:'#918e84',500:'#787469',600:'#625f55',950:'#1f1e1b' },
            adventure: { 400:'#ff9b33',500:'#ff7c0a' },
          },
          fontFamily: { outfit: ['Outfit', 'sans-serif'] },
        },
      },
    };
  </script>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    html, body { height: 100%; overflow: hidden; font-family: 'Outfit', sans-serif; }

    body {
      display: flex;
      flex-direction: column;
      background: #0b2d0b;
    }

    /* ===== NAVBAR ===== */
    .navbar {
      flex-shrink: 0;
      background: rgba(11,45,11,0.95);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(77,163,77,0.2);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 1.25rem;
      height: 56px;
      z-index: 100;
    }
    .navbar-left { display: flex; align-items: center; gap: 1rem; }
    .navbar-brand img { height: 38px; width: auto; object-fit: contain; }

    .order-pill {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      background: rgba(45,138,45,0.12);
      border: 1px solid rgba(77,163,77,0.25);
      border-radius: 9999px;
      padding: 0.3rem 0.9rem;
    }
    .order-pill-dot {
      width: 7px; height: 7px;
      border-radius: 50%;
      background: #4da34d;
      animation: pulse-dot 1.8s ease-in-out infinite;
    }
    @keyframes pulse-dot {
      0%,100% { opacity:1; transform: scale(1); }
      50%      { opacity:0.5; transform: scale(0.75); }
    }
    .order-pill-text { font-size: 0.78rem; font-weight: 600; color: #7dbf7d; }
    .order-kode { font-size: 0.78rem; font-weight: 800; color: #b3d9b3; letter-spacing: 0.04em; }

    /* Total badge */
    .total-badge {
      background: rgba(255,124,10,0.12);
      border: 1px solid rgba(255,124,10,0.25);
      border-radius: 9999px;
      padding: 0.3rem 0.9rem;
      font-size: 0.78rem;
      font-weight: 700;
      color: #ff9b33;
    }

    /* Back button */
    .btn-back {
      display: flex;
      align-items: center;
      gap: 0.4rem;
      font-size: 0.8rem;
      font-weight: 500;
      color: #625f55;
      background: none;
      border: none;
      cursor: pointer;
      padding: 0.4rem 0.7rem;
      border-radius: 0.5rem;
      transition: all 0.2s;
      text-decoration: none;
    }
    .btn-back:hover { color: #b3d9b3; background: rgba(77,163,77,0.08); }
    .btn-back svg { width: 14px; height: 14px; }

    /* ===== LOADING SCREEN ===== */
    #loading-screen {
      position: absolute;
      inset: 0;
      top: 56px; /* below navbar */
      background: linear-gradient(135deg, #0b2d0b 0%, #1f1e1b 100%);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      z-index: 50;
      gap: 1.25rem;
      transition: opacity 0.4s ease;
    }
    #loading-screen.fade-out { opacity: 0; pointer-events: none; }

    .spinner-ring {
      width: 60px; height: 60px;
      border-radius: 50%;
      border: 4px solid rgba(77,163,77,0.15);
      border-top-color: #4da34d;
      animation: spin 0.9s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    .loading-text { color: #7dbf7d; font-size: 0.9rem; font-weight: 500; }
    .loading-sub  { color: #625f55; font-size: 0.75rem; }

    /* ===== IFRAME WRAPPER ===== */
    #iframe-wrapper {
      flex: 1;
      position: relative;
      overflow: hidden;
    }

    #payment-iframe {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      border: none;
      background: white;
    }

    /* ===== FALLBACK BANNER ===== */
    #fallback-banner {
      display: none;
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, #0b2d0b, #1f1e1b);
      align-items: center;
      justify-content: center;
      padding: 2rem;
      z-index: 10;
    }
    #fallback-banner.show {
      display: flex;
    }
    .fallback-card {
      background: rgba(36,36,32,0.9);
      backdrop-filter: blur(16px);
      border: 1px solid rgba(77,163,77,0.2);
      border-radius: 1.5rem;
      padding: 2.5rem 2rem;
      max-width: 440px;
      width: 100%;
      text-align: center;
    }
    .btn-xendit-link {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.6rem;
      background: linear-gradient(135deg, #1a73e8, #0d47a1);
      color: white;
      font-weight: 700;
      font-size: 1rem;
      padding: 0.9rem 2rem;
      border-radius: 1rem;
      text-decoration: none;
      transition: all 0.3s;
      width: 100%;
    }
    .btn-xendit-link:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(26,115,232,0.4); }

    /* ===== SECURITY FOOTER ===== */
    .security-bar {
      flex-shrink: 0;
      background: rgba(11,45,11,0.6);
      border-top: 1px solid rgba(77,163,77,0.1);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 1rem;
      padding: 0.45rem 1rem;
      font-size: 0.7rem;
      color: #625f55;
    }
    .security-bar span { display: flex; align-items: center; gap: 0.3rem; }
    .security-bar svg { width: 12px; height: 12px; color: #4da34d; }

    /* Responsive: mobile hide some pills */
    @media (max-width: 640px) {
      .total-badge { display: none; }
      .order-kode  { display: none; }
    }
  </style>
</head>
<body>

  <!-- ===== NAVBAR ===== -->
  <nav class="navbar">
    <div class="navbar-left">
      <!-- Logo -->
      <a href="{{ url('/') }}" class="navbar-brand">
        <img src="{{ asset('images/image_1.png') }}" alt="ECOutdoor" />
      </a>

      <!-- Order pill -->
      <div class="order-pill">
        <div class="order-pill-dot"></div>
        <span class="order-pill-text">Pembayaran</span>
        <span class="order-kode">{{ $order->kode_pesanan }}</span>
      </div>
    </div>

    <div style="display:flex; align-items:center; gap:0.75rem;">
      <!-- Total -->
      <div class="total-badge">
        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
      </div>

      <!-- Back button -->
      <a href="{{ route('checkout.thankyou', ['kode' => $order->kode_pesanan]) }}" class="btn-back" id="btn-back">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Cek Pesanan
      </a>
    </div>
  </nav>

  <!-- ===== LOADING SCREEN ===== -->
  <div id="loading-screen">
    <div class="spinner-ring"></div>
    <div style="text-align:center;">
      <p class="loading-text">Memuat halaman pembayaran...</p>
      <p class="loading-sub" style="margin-top:0.3rem;">Mohon tunggu sebentar</p>
    </div>
    <!-- Product mini preview -->
    <div style="display:flex; align-items:center; gap:0.75rem; background:rgba(45,138,45,0.08); border:1px solid rgba(77,163,77,0.2); border-radius:1rem; padding:0.75rem 1rem; margin-top:0.5rem;">
      <img src="{{ $order->product->image_url }}"
           alt="{{ $order->product->nama_produk }}"
           style="width:44px; height:44px; object-fit:cover; border-radius:0.6rem; border:1px solid rgba(77,163,77,0.2);" />
      <div>
        <p style="color:#e7e6e2; font-size:0.82rem; font-weight:600;">{{ $order->product->nama_produk }}</p>
        <p style="color:#ff9b33; font-size:0.85rem; font-weight:800;">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
      </div>
    </div>
  </div>

  <!-- ===== IFRAME WRAPPER ===== -->
  <div id="iframe-wrapper">

    <!-- Xendit Invoice Iframe -->
    <iframe
      id="payment-iframe"
      src="{{ $order->xendit_invoice_url }}"
      title="Halaman Pembayaran Xendit"
      allow="payment"
      onload="onIframeLoad()"
      onerror="onIframeError()"
    ></iframe>

    <!-- Fallback jika iframe diblokir -->
    <div id="fallback-banner">
      <div class="fallback-card">
        <div style="font-size:3rem; margin-bottom:1rem;">🔒</div>
        <h2 style="color:white; font-size:1.2rem; font-weight:700; margin-bottom:0.5rem;">
          Browser memblokir halaman pembayaran
        </h2>
        <p style="color:#787469; font-size:0.82rem; line-height:1.6; margin-bottom:1.75rem;">
          Beberapa browser memblokir halaman pembayaran tertanam karena alasan keamanan.
          Klik tombol di bawah untuk membuka halaman pembayaran Xendit di tab baru.
        </p>

        <!-- Order summary mini -->
        <div style="background:rgba(11,45,11,0.5); border:1px solid rgba(77,163,77,0.15); border-radius:0.875rem; padding:0.9rem 1rem; margin-bottom:1.5rem; text-align:left;">
          <div style="display:flex; justify-content:space-between; font-size:0.8rem; margin-bottom:0.4rem;">
            <span style="color:#787469;">Pesanan</span>
            <span style="color:#b3d9b3; font-weight:700;">{{ $order->kode_pesanan }}</span>
          </div>
          <div style="display:flex; justify-content:space-between; font-size:0.8rem;">
            <span style="color:#787469;">Total</span>
            <span style="color:#ff9b33; font-weight:800;">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
          </div>
        </div>

        <a href="{{ $order->xendit_invoice_url }}"
           target="_blank"
           rel="noopener"
           class="btn-xendit-link"
           id="open-xendit-btn">
          <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
          </svg>
          Buka Halaman Pembayaran
        </a>

        <p style="color:#625f55; font-size:0.7rem; margin-top:1rem;">
          Setelah membayar, kembali ke sini dan klik "Cek Pesanan" untuk memverifikasi status.
        </p>
      </div>
    </div>

  </div>

  <!-- ===== SECURITY BAR ===== -->
  <div class="security-bar">
    <span>
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
      </svg>
      Pembayaran aman & terenkripsi
    </span>
    <span>|</span>
    <span>
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
      </svg>
      Diproses oleh Xendit
    </span>
    <span>|</span>
    <span>Kode: <strong style="color:#7dbf7d;">{{ $order->kode_pesanan }}</strong></span>
  </div>


  <script>
    // ================================================================
    // IFRAME LOAD HANDLER
    // ================================================================
    let iframeLoaded = false;
    let loadTimeout;

    function onIframeLoad() {
      iframeLoaded = true;
      clearTimeout(loadTimeout);

      // Sembunyikan loading screen dengan fade
      const loading = document.getElementById('loading-screen');
      loading.classList.add('fade-out');
      setTimeout(() => { loading.style.display = 'none'; }, 400);

      // Cek apakah iframe berhasil dimuat (coba akses konten)
      try {
        const iframe = document.getElementById('payment-iframe');
        // Kalau berhasil akses contentDocument berarti sama-origin — ini tidak akan terjadi
        // Kalau cross-origin dan blocked, akan throw error
        const doc = iframe.contentDocument || iframe.contentWindow.document;
        // Jika body kosong, mungkin diblokir
        if (!doc || doc.body.innerHTML === '') {
          showFallback();
        }
      } catch (e) {
        // Cross-origin = normal, iframe berhasil dimuat dari domain lain
        // Ini adalah kondisi SUKSES
      }
    }

    function onIframeError() {
      clearTimeout(loadTimeout);
      showFallback();
    }

    function showFallback() {
      // Sembunyikan loading
      const loading = document.getElementById('loading-screen');
      loading.classList.add('fade-out');
      setTimeout(() => { loading.style.display = 'none'; }, 400);

      // Tampilkan fallback
      document.getElementById('fallback-banner').classList.add('show');
    }

    // Timeout 15 detik — jika iframe tidak load, tampilkan fallback
    loadTimeout = setTimeout(() => {
      if (!iframeLoaded) showFallback();
    }, 15000);

    // ================================================================
    // POLLING STATUS — cek apakah sudah dibayar setiap 5 detik
    // Jika sudah paid, redirect ke halaman thank-you
    // ================================================================
    const KODE_PESANAN = '{{ $order->kode_pesanan }}';
    const STATUS_URL   = '{{ route("checkout.status") }}';
    const THANKYOU_URL = '{{ route("checkout.thankyou", ["kode" => $order->kode_pesanan]) }}';

    setInterval(async () => {
      try {
        const res  = await fetch(STATUS_URL + '?kode=' + encodeURIComponent(KODE_PESANAN));
        const data = await res.json();

        if (data.status === 'confirmed') {
          // Pembayaran berhasil! Redirect ke halaman thank-you
          window.location.href = THANKYOU_URL;
        }
      } catch (e) {
        // Ignore network errors
      }
    }, 5000);
  </script>

</body>
</html>
