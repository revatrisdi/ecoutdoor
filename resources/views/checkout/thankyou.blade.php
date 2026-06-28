<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $order->status === 'confirmed' ? 'Pembayaran Berhasil!' : 'Pesanan Diterima' }} — ECOutdoor</title>
  <link rel="icon" type="image/png" href="{{ asset('images/image_1.png') }}">
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
            popIn: { '0%':{ opacity:'0', transform:'scale(0.7) translateY(20px)' }, '100%':{ opacity:'1', transform:'scale(1) translateY(0)' } },
            fadeUp: { '0%':{ opacity:'0', transform:'translateY(20px)' }, '100%':{ opacity:'1', transform:'translateY(0)' } },
            ring: { '0%,100%':{ transform:'scale(1)' }, '50%':{ transform:'scale(1.12)' } },
            pulse: { '0%,100%':{ opacity:'1' }, '50%':{ opacity:'0.5' } },
            confetti: { '0%':{ transform:'translateY(0) rotate(0deg)', opacity:'1' }, '100%':{ transform:'translateY(400px) rotate(720deg)', opacity:'0' } },
          },
          animation: {
            'pop-in': 'popIn 0.6s cubic-bezier(0.34,1.56,0.64,1) both',
            'fade-up': 'fadeUp 0.6s ease-out both',
            'ring': 'ring 2s ease-in-out infinite',
            'pulse-slow': 'pulse 2s ease-in-out infinite',
          },
        },
      },
    };
  </script>
  <style>
    * { box-sizing: border-box; }
    body {
      font-family: 'Outfit', sans-serif;
      background: radial-gradient(ellipse at top, #0b2d0b 0%, #1f1e1b 55%);
      min-height: 100vh;
      display: flex; flex-direction: column;
    }
    .glass-card {
      background: rgba(36,36,32,0.82);
      backdrop-filter: blur(16px);
      border: 1px solid rgba(77,163,77,0.18);
    }
    .success-ring {
      background: conic-gradient(#2d8a2d 0%, #7dbf7d 30%, #2d8a2d 60%, #ff7c0a 80%, #2d8a2d 100%);
      animation: ring 3s ease-in-out infinite;
    }
    .pending-ring {
      background: conic-gradient(#ff9b33 0%, #ffcc66 40%, #ff9b33 70%, #f06000 100%);
      animation: ring 2s ease-in-out infinite;
    }
    .detail-row { display:flex; justify-content:space-between; align-items:flex-start; gap:1rem; }
    .btn-wa {
      background: linear-gradient(135deg, #25d366, #128c7e);
      transition: all 0.3s;
    }
    .btn-wa:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(37,211,102,0.35); }
    .btn-shop {
      background: linear-gradient(135deg, #ff7c0a, #f06000);
      transition: all 0.3s;
    }
    .btn-shop:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(255,124,10,0.35); }

    /* Confetti animation */
    .confetti-piece {
      position: fixed;
      width: 10px; height: 10px;
      animation: confetti 2.5s ease-out forwards;
      pointer-events: none;
      z-index: 9999;
    }

    /* Step indicator */
    .step-dot { width: 2rem; height: 2rem; border-radius: 9999px; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700; transition: all 0.3s; }
    .step-active { background: linear-gradient(135deg, #2d8a2d, #1e6e1e); color: white; }
    .step-done   { background: rgba(45,138,45,0.2); color: #7dbf7d; border: 1.5px solid rgba(77,163,77,0.4); }
    .step-inactive { background: rgba(77,163,77,0.1); color: #625f55; border: 1.5px solid rgba(77,163,77,0.2); }
  </style>
</head>
<body class="text-white">

  <!-- Navbar minimal -->
  <nav style="background:rgba(11,45,11,0.7); backdrop-filter:blur(20px); border-bottom:1px solid rgba(77,163,77,0.15);" class="sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
      <a href="{{ url('/') }}" class="flex items-center group">
        <img src="{{ asset('images/image_1.png') }}" alt="ECOutdoor" class="h-10 w-auto object-contain group-hover:scale-105 transition-transform" />
      </a>

      <!-- Step indicator -->
      <div class="hidden md:flex items-center gap-2 text-xs">
        <div class="step-dot step-done">✓</div>
        <span class="font-medium" style="color:#7dbf7d;">Detail Pemesanan</span>
        <div class="w-4 lg:w-8 h-px" style="background:rgba(77,163,77,0.25);"></div>
        <div class="step-dot step-done">✓</div>
        <span class="font-medium" style="color:#7dbf7d;">Konfirmasi & Bayar</span>
        <div class="w-4 lg:w-8 h-px" style="background:rgba(77,163,77,0.25);"></div>
        <div class="step-dot step-active">3</div>
        <span class="font-medium" style="color:#4da34d;">Status & Bukti</span>
      </div>

      <a href="{{ url('/') }}"
         class="text-stone-400 hover:text-forest-400 transition-colors text-sm flex items-center gap-1.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        Beranda
      </a>
    </div>
  </nav>

  <!-- Main -->
  <main class="flex-1 flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-xl">

      <!-- ===================== SUCCESS STATE ===================== -->
      <div id="state-confirmed" class="{{ $order->status === 'confirmed' ? '' : 'hidden' }}">

        <!-- Success icon -->
        <div class="flex justify-center mb-8 animate-pop-in">
          <div class="relative">
            <div class="success-ring w-24 h-24 rounded-full p-1">
              <div class="w-full h-full rounded-full flex items-center justify-center" style="background:#0b2d0b;">
                <svg class="w-12 h-12" style="color:#7dbf7d;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
              </div>
            </div>
            <span class="absolute -top-2 -right-2 text-xl animate-bounce" style="animation-delay:0.2s">🎉</span>
            <span class="absolute -bottom-1 -left-3 text-lg animate-bounce" style="animation-delay:0.5s">✨</span>
          </div>
        </div>

        <!-- Heading -->
        <div class="text-center mb-8 animate-fade-up" style="animation-delay:0.2s;">
          <h1 class="font-playfair text-3xl sm:text-4xl font-bold text-white mb-2">
            Pembayaran <span style="color:#4da34d;">Berhasil!</span> ✅
          </h1>
          <p class="text-stone-400 text-sm leading-relaxed">
            Terima kasih, <strong class="text-forest-400">{{ $order->nama_pembeli }}</strong>!<br/>
            Pembayaranmu telah dikonfirmasi. Penjual segera memproses pesananmu.
          </p>
          @if($order->paid_at)
            <p class="text-forest-300 text-xs mt-2">
              ✅ Dikonfirmasi pada {{ $order->paid_at->format('d M Y, H:i') }} WIB
            </p>
          @endif
        </div>

      </div>
      <!-- /SUCCESS STATE -->

      <!-- ===================== PENDING STATE ===================== -->
      <div id="state-pending" class="{{ $order->status !== 'confirmed' ? '' : 'hidden' }}">

        <!-- Pending icon -->
        <div class="flex justify-center mb-8 animate-pop-in">
          <div class="relative">
            <div class="pending-ring w-24 h-24 rounded-full p-1">
              <div class="w-full h-full rounded-full flex items-center justify-center" style="background:#0b2d0b;">
                <svg class="w-12 h-12 animate-spin" style="color:#ff9b33;" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
              </div>
            </div>
            <span class="absolute -top-2 -right-2 text-xl animate-bounce" style="animation-delay:0.3s">⏳</span>
          </div>
        </div>

        <!-- Heading -->
        <div class="text-center mb-6 animate-fade-up" style="animation-delay:0.2s;">
          <h1 class="font-playfair text-3xl sm:text-4xl font-bold text-white mb-2">
            Pesanan <span style="color:#ff9b33;">Diterima!</span>
          </h1>
          <p class="text-stone-400 text-sm leading-relaxed">
            Pesananmu sudah masuk. Selesaikan pembayaran dan upload buktinya di bawah.
          </p>
        </div>

        {{-- ===== INSTRUKSI & UPLOAD BERDASARKAN METODE ===== --}}

        @if($order->metode_bayar === 'cod')
          {{-- COD info --}}
          <div class="mb-5 p-4 rounded-2xl flex gap-3" style="background:rgba(45,138,45,0.1); border:1px solid rgba(77,163,77,0.25);">
            <span class="text-2xl">💵</span>
            <div>
              <p class="text-forest-400 font-semibold text-sm">Bayar di Tempat (COD)</p>
              <p class="text-stone-400 text-xs mt-0.5 leading-relaxed">Siapkan uang tunai saat barang tiba. Penjual akan menghubungimu via WhatsApp untuk konfirmasi jadwal pengiriman.</p>
            </div>
          </div>

          {{-- Info menunggu --}}
          <div class="mb-5 p-3 rounded-2xl flex items-center gap-3"
               style="background:rgba(255,124,10,0.08); border:1px solid rgba(255,124,10,0.2);">
            <span class="text-adventure-400 text-sm">📋</span>
            <span class="text-stone-400 text-xs">Admin akan mengkonfirmasi dan menghubungimu segera. Pesanan COD tidak perlu upload bukti.</span>
          </div>

        @elseif($order->metode_bayar === 'transfer' && $order->status === 'pending')

          @if($order->bukti_bayar)
            {{-- Bukti sudah diupload, menunggu konfirmasi admin --}}
            <div class="mb-5 p-4 rounded-2xl animate-fade-up" style="background:rgba(45,138,45,0.08); border:1px solid rgba(77,163,77,0.25);">
              <div class="flex items-center gap-3 mb-3">
                <span class="text-xl">✅</span>
                <div>
                  <p class="text-forest-400 font-semibold text-sm">Bukti Pembayaran Terkirim</p>
                  <p class="text-stone-400 text-xs mt-0.5">Admin sedang memverifikasi pembayaranmu. Biasanya dalam 1–2 jam.</p>
                </div>
              </div>
              @if($order->catatan_admin)
                <div class="p-3 rounded-xl mt-2" style="background:rgba(220,38,38,0.08); border:1px solid rgba(220,38,38,0.25);">
                  <p class="text-red-400 text-xs font-semibold">Catatan Admin:</p>
                  <p class="text-stone-300 text-xs mt-0.5">{{ $order->catatan_admin }}</p>
                </div>
              @endif
              {{-- Tombol ganti bukti --}}
              <button onclick="document.getElementById('upload-section').classList.toggle('hidden')"
                      class="mt-3 text-xs text-stone-500 hover:text-forest-400 underline transition-colors">
                Upload ulang bukti pembayaran
              </button>
            </div>
          @else
            {{-- Belum ada bukti, tampilkan instruksi --}}
            <div class="mb-5 p-4 rounded-2xl" style="background:rgba(255,124,10,0.06); border:1px solid rgba(255,124,10,0.2);">
              <div class="flex items-start gap-3">
                <span class="text-2xl">🏦</span>
                <div class="flex-1">
                  <p class="text-adventure-400 font-semibold text-sm mb-2">
                    Langkah Pembayaran Transfer Bank
                  </p>
                  <ol class="text-stone-400 text-xs space-y-1.5 list-decimal list-inside">
                    <li>Transfer ke rekening yang tertera di konfirmasi pesanan</li>
                    <li>Pastikan nominal tepat: <strong class="text-adventure-400">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong></li>
                    <li>Screenshot / foto struk bukti pembayaran</li>
                    <li>Upload foto bukti di bawah ini</li>
                    <li>Tunggu konfirmasi admin (biasanya 1–2 jam)</li>
                  </ol>
                </div>
              </div>
            </div>
          @endif

          {{-- Flash success upload --}}
          @if(session('success'))
            <div class="mb-5 p-4 rounded-2xl flex gap-3 animate-fade-up" style="background:rgba(45,138,45,0.1); border:1px solid rgba(77,163,77,0.3);">
              <span>✅</span>
              <p class="text-forest-400 text-sm">{{ session('success') }}</p>
            </div>
          @endif

          {{-- Form Upload --}}
          <div id="upload-section" class="{{ $order->bukti_bayar ? 'hidden' : '' }} mb-5">
            <form action="{{ route('checkout.upload-bukti') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="kode_pesanan" value="{{ $order->kode_pesanan }}" />

              <div class="p-5 rounded-2xl" style="background:rgba(36,36,32,0.8); border:1px solid rgba(77,163,77,0.15);">
                <p class="text-white font-bold text-sm mb-4 flex items-center gap-2">
                  <span class="w-1 h-5 rounded-full" style="background:#ff7c0a;"></span>
                  Upload Bukti Pembayaran
                </p>

                {{-- Error messages --}}
                @if($errors->has('bukti_bayar'))
                  <div class="mb-3 p-3 rounded-xl" style="background:rgba(220,38,38,0.1); border:1px solid rgba(220,38,38,0.3);">
                    <p class="text-red-400 text-xs">{{ $errors->first('bukti_bayar') }}</p>
                  </div>
                @endif

                {{-- Drop zone --}}
                <label for="bukti-input"
                       class="flex flex-col items-center justify-center gap-3 p-6 rounded-xl cursor-pointer transition-all"
                       style="border:2px dashed rgba(77,163,77,0.3); background:rgba(11,45,11,0.2);"
                       id="drop-zone">
                  <div class="text-4xl" id="drop-icon">📄</div>
                  <div class="text-center">
                    <p class="text-forest-400 font-semibold text-sm" id="drop-text">Klik atau Drag & Drop foto bukti pembayaran</p>
                    <p class="text-stone-600 text-xs mt-0.5">JPG, PNG, WebP • Maks. 5MB</p>
                  </div>
                  <input type="file" id="bukti-input" name="bukti_bayar" accept="image/*"
                         class="hidden" onchange="previewBukti(this)" />
                </label>

                {{-- Preview --}}
                <div id="preview-wrap" class="hidden mt-3">
                  <img id="preview-img" src="" alt="Preview" class="w-full max-h-48 object-contain rounded-xl" />
                  <p class="text-stone-500 text-xs text-center mt-1.5" id="preview-name"></p>
                </div>

                <button type="submit"
                        class="mt-4 w-full py-3.5 rounded-2xl text-white font-bold text-sm transition-all"
                        style="background:linear-gradient(135deg,#2d8a2d,#1e6e1e);"
                        id="btn-upload">
                  📤 Kirim Bukti Pembayaran
                </button>
              </div>
            </form>
          </div>

        @endif
        {{-- /INSTRUKSI & UPLOAD --}}

      </div>
      <!-- /PENDING STATE -->


      <!-- ===================== WARNING (jika ada) ===================== -->
      @if(session('warning'))
        <div class="mb-5 p-4 rounded-2xl flex gap-3 animate-fade-up" style="background:rgba(255,124,10,0.1); border:1px solid rgba(255,124,10,0.3);">
          <span>⚠️</span>
          <p class="text-adventure-400 text-sm">{{ session('warning') }}</p>
        </div>
      @endif

      <!-- Order card -->
      <div class="glass-card rounded-3xl p-6 mb-6 animate-fade-up" style="animation-delay:0.35s;">
        <!-- Status badge -->
        <div class="flex justify-center mb-5">
          @php
            $statusConfig = [
              'pending'   => ['bg' => 'rgba(255,124,10,0.12)', 'border' => 'rgba(255,124,10,0.3)', 'text' => '#ff9b33', 'icon' => '⏳', 'label' => 'Menunggu Konfirmasi Admin'],
              'confirmed' => ['bg' => 'rgba(45,138,45,0.12)',  'border' => 'rgba(77,163,77,0.3)',  'text' => '#4da34d', 'icon' => '✅', 'label' => 'Pembayaran Dikonfirmasi'],
              'shipped'   => ['bg' => 'rgba(26,115,232,0.12)', 'border' => 'rgba(26,115,232,0.3)', 'text' => '#60a5fa', 'icon' => '🚚', 'label' => 'Sedang Dikirim'],
              'done'      => ['bg' => 'rgba(45,138,45,0.2)',   'border' => 'rgba(77,163,77,0.5)',  'text' => '#7dbf7d', 'icon' => '🎁', 'label' => 'Pesanan Selesai'],
              'cancelled' => ['bg' => 'rgba(220,38,38,0.12)', 'border' => 'rgba(220,38,38,0.3)',  'text' => '#f87171', 'icon' => '❌', 'label' => 'Dibatalkan'],
            ];
            $sc = $statusConfig[$order->status] ?? $statusConfig['pending'];
          @endphp
          <div id="status-badge" class="px-4 py-2 rounded-full text-sm font-bold flex items-center gap-2"
               style="background:{{ $sc['bg'] }}; border:1px solid {{ $sc['border'] }}; color:{{ $sc['text'] }};">
            <span id="status-icon">{{ $sc['icon'] }}</span>
            <span id="status-label">{{ $sc['label'] }}</span>
          </div>
        </div>

        <!-- Product preview -->
        <div class="space-y-3 mb-5">
          @foreach($order->orderItems as $item)
            <div class="flex gap-4 p-4 rounded-2xl" style="background:rgba(11,45,11,0.3); border:1px solid rgba(77,163,77,0.1);">
              <img src="{{ $item->product->image_url }}"
                   alt="{{ $item->product->nama_produk }}"
                   class="w-16 h-16 object-cover rounded-xl flex-shrink-0"
                   style="border:1.5px solid rgba(77,163,77,0.2);" />
              <div class="min-w-0 flex-1">
                <p class="text-white font-bold text-sm">{{ $item->product->nama_produk }}</p>
                <p class="text-stone-500 text-xs mt-0.5">{{ $item->jumlah }} unit x Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
                <p class="text-adventure-400 font-black text-base mt-1">
                  Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                </p>
              </div>
            </div>
          @endforeach
        </div>

        <div style="height:1px; background:rgba(77,163,77,0.1);" class="mb-5"></div>

        <!-- Detail order -->
        <div class="space-y-3.5">
          @foreach([
            ['📛', 'Nama Pembeli',    $order->nama_pembeli],
            ['📱', 'WhatsApp',        $order->no_whatsapp],
            ['🏦', 'Metode Bayar',    match($order->metode_bayar) { 'transfer' => 'Transfer Bank', 'cod' => 'Bayar di Tempat (COD)', default => $order->metode_bayar }],
            ['🔢', 'Total Item',      $order->orderItems->sum('jumlah') . ' unit'],
            ['💰', 'Total Bayar',     'Rp ' . number_format($order->total_harga, 0, ',', '.')],
          ] as [$icon, $label, $value])
          <div class="detail-row">
            <span class="text-stone-500 text-sm flex items-center gap-1.5 flex-shrink-0">
              <span>{{ $icon }}</span> {{ $label }}
            </span>
            <span class="text-white text-sm font-medium text-right">{{ $value }}</span>
          </div>
          @endforeach

          <!-- Alamat (full width) -->
          <div class="pt-1">
            <p class="text-stone-500 text-sm flex items-center gap-1.5 mb-1.5">📍 Alamat Pengiriman</p>
            <p class="text-white text-sm leading-relaxed p-3 rounded-xl"
               style="background:rgba(11,45,11,0.35); border:1px solid rgba(77,163,77,0.1);">
              {{ $order->alamat_pengiriman }}
            </p>
          </div>
        </div>
      </div>

      <!-- CTA Buttons -->
      <div class="space-y-3 animate-fade-up" style="animation-delay:0.5s;">

        <!-- Pesanan Saya -->
        <a href="{{ route('pesanan.index') }}"
           class="w-full flex items-center justify-center gap-2.5 rounded-2xl py-4 text-white font-bold text-base transition-all hover:-translate-y-0.5"
           style="background:linear-gradient(135deg,#2d8a2d,#1e6e1e); box-shadow:0 6px 20px rgba(45,138,45,0.3);">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
          </svg>
          Lihat di Pesanan Saya
        </a>

        @php
          $firstItem = $order->orderItems->first();
          $seller    = $firstItem ? $firstItem->product->user : null; // Asumsi single seller atau chat seller produk pertama
          $waNumber  = $seller ? preg_replace('/[^0-9]/', '', $seller->no_whatsapp ?? '') : '';
          if (str_starts_with($waNumber, '0')) {
              $waNumber = '62' . substr($waNumber, 1);
          }
          
          $productNames = $order->orderItems->map(fn($item) => $item->product->nama_produk)->join(', ');
          if (strlen($productNames) > 50) $productNames = substr($productNames, 0, 47) . '...';
          
          $waMsg     = urlencode(
            "Halo, saya *{$order->nama_pembeli}* ingin konfirmasi pesanan:\n" .
            "• Produk: *{$productNames}*\n" .
            "• Kode Pesanan: *{$order->kode_pesanan}*\n" .
            "• Total Bayar: Rp " . number_format($order->total_harga, 0, ',', '.') . "\n" .
            "• Metode: " . match($order->metode_bayar) { 'transfer' => 'Transfer Bank', 'cod' => 'COD', default => $order->metode_bayar } . "\n" .
            "• Alamat: {$order->alamat_pengiriman}\n\nMohon konfirmasinya. Terima kasih! 🙏"
          );
        @endphp

        @if($waNumber)
          <a href="https://wa.me/{{ $waNumber }}?text={{ $waMsg }}" target="_blank" rel="noopener"
             class="btn-wa w-full flex items-center justify-center gap-2.5 rounded-2xl py-4 text-white font-bold text-base">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
              <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm.029 18.88a9.87 9.87 0 01-4.724-1.207L2.88 19.12l1.482-4.306a9.844 9.844 0 01-1.373-5.069C2.989 7.023 7.042 3 12.029 3c2.425 0 4.7.946 6.413 2.663A9.015 9.015 0 0121.059 12c0 4.988-4.048 9.04-9.03 9.04v-.16z"/>
            </svg>
            Chat Penjual via WhatsApp
          </a>
        @else
          <div class="w-full flex items-center justify-center gap-2 rounded-2xl py-4 text-stone-500 font-medium text-sm"
               style="background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08);">
            💬 Penjual akan menghubungi kamu melalui WhatsApp: <strong class="text-forest-400">{{ $order->no_whatsapp }}</strong>
          </div>
        @endif

        <!-- Lanjut belanja -->
        <a href="{{ url('/') }}#produk"
           class="btn-shop w-full flex items-center justify-center gap-2.5 rounded-2xl py-3.5 text-white font-semibold text-sm">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
          </svg>
          Lanjut Belanja Produk Lain
        </a>
      </div>

      <p class="text-center text-stone-600 text-xs mt-6">
        Butuh bantuan? Hubungi kami di <span class="text-forest-500">support@ecoutdoor.id</span>
      </p>

    </div>
  </main>

  <script>
    // ================================================================
    // SIMPAN KODE PESANAN KE LOCALSTORAGE (PERMANEN DI BROWSER)
    // Session PHP bisa hilang, localStorage tidak.
    // ================================================================
    (function() {
      const LS_KEY  = 'ecoutdoor_pesanan';
      const kode    = '{{ $order->kode_pesanan }}';
      try {
        const existing = JSON.parse(localStorage.getItem(LS_KEY) || '[]');
        if (!existing.includes(kode)) {
          existing.unshift(kode); // masukkan di depan (terbaru dulu)
          localStorage.setItem(LS_KEY, JSON.stringify(existing.slice(0, 50))); // maks 50
        }
        
        // Hapus keranjang jika dari checkout sukses
        if (new URLSearchParams(window.location.search).get('clear_cart') == 1) {
          const checkedOut = JSON.parse(sessionStorage.getItem('ecoutdoor_checkout_items') || '[]');
          const checkedOutIds = checkedOut.map(i => i.id);
          
          let mainCart = JSON.parse(localStorage.getItem('ecoutdoor_cart') || '[]');
          mainCart = mainCart.filter(item => !checkedOutIds.includes(item.id));
          localStorage.setItem('ecoutdoor_cart', JSON.stringify(mainCart));
          
          sessionStorage.removeItem('ecoutdoor_checkout_items');
        }
      } catch (e) { /* localStorage tidak tersedia */ }
    })();

    // ================================================================
    // POLLING SEDERHANA — cek status dari DB setiap 10 detik
    // Hanya aktif jika masih pending, berhenti saat confirmed
    // ================================================================
    const KODE_PESANAN   = '{{ $order->kode_pesanan }}';
    const STATUS_URL     = '{{ route("checkout.status") }}';
    const INITIAL_STATUS = '{{ $order->status }}';

    let pollInterval = null;
    let pollCount    = 0;
    const MAX_POLLS  = 36; // 36 × 10 detik = 6 menit

    function startPolling() {
      if (INITIAL_STATUS === 'confirmed' || INITIAL_STATUS === 'cancelled') return;

      pollInterval = setInterval(async () => {
        pollCount++;

        try {
          const res  = await fetch(STATUS_URL + '?kode=' + encodeURIComponent(KODE_PESANAN));
          const data = await res.json();

          if (data.status === 'confirmed') {
            clearInterval(pollInterval);
            onPaymentConfirmed(data);
          }
        } catch (e) {
          console.warn('Polling error:', e);
        }

        if (pollCount >= MAX_POLLS) {
          clearInterval(pollInterval);
        }

      }, 10000); // Poll setiap 10 detik (bukan 5, karena konfirmasi manual)
    }

    function onPaymentConfirmed(data) {
      // Hide pending state, show success state
      document.getElementById('state-pending').classList.add('hidden');
      document.getElementById('state-confirmed').classList.remove('hidden');

      // Update status badge
      document.getElementById('status-icon').textContent  = '✅';
      document.getElementById('status-label').textContent = 'Pembayaran Dikonfirmasi';
      const badge = document.getElementById('status-badge');
      badge.style.background   = 'rgba(45,138,45,0.12)';
      badge.style.borderColor  = 'rgba(77,163,77,0.3)';
      badge.style.color        = '#4da34d';

      // Trigger confetti
      spawnConfetti();
    }

    function spawnConfetti() {
      const colors = ['#4da34d', '#7dbf7d', '#ff9b33', '#ff7c0a', '#ffffff', '#ffcc66'];
      for (let i = 0; i < 60; i++) {
        setTimeout(() => {
          const el    = document.createElement('div');
          el.classList.add('confetti-piece');
          el.style.left            = Math.random() * 100 + 'vw';
          el.style.top             = '-10px';
          el.style.background      = colors[Math.floor(Math.random() * colors.length)];
          el.style.width           = (Math.random() * 8 + 6) + 'px';
          el.style.height          = (Math.random() * 8 + 6) + 'px';
          el.style.borderRadius    = Math.random() > 0.5 ? '50%' : '2px';
          el.style.animationDelay  = Math.random() * 0.5 + 's';
          el.style.animationDuration = (Math.random() * 1.5 + 2) + 's';
          document.body.appendChild(el);
          setTimeout(() => el.remove(), 4000);
        }, i * 30);
      }
    }

    // Start polling on page load
    startPolling();

    // If already confirmed on load, show confetti once
    if (INITIAL_STATUS === 'confirmed') {
      setTimeout(spawnConfetti, 600);
    }

    // ================================================================
    // PREVIEW FOTO BUKTI
    // ================================================================
    function previewBukti(input) {
      const file = input.files[0];
      if (!file) return;

      const wrap  = document.getElementById('preview-wrap');
      const img   = document.getElementById('preview-img');
      const name  = document.getElementById('preview-name');
      const icon  = document.getElementById('drop-icon');
      const text  = document.getElementById('drop-text');
      const zone  = document.getElementById('drop-zone');

      const reader = new FileReader();
      reader.onload = (e) => {
        img.src = e.target.result;
        wrap.classList.remove('hidden');
        icon.textContent = '✅';
        text.textContent = 'Foto dipilih — klik untuk ganti';
        zone.style.borderColor = 'rgba(77,163,77,0.6)';
        zone.style.background  = 'rgba(45,138,45,0.1)';
        name.textContent = file.name + ' (' + (file.size / 1024).toFixed(0) + ' KB)';
      };
      reader.readAsDataURL(file);
    }

    // ================================================================
    // DRAG AND DROP LOGIC
    // ================================================================
    const uploadDropZone = document.getElementById('drop-zone');
    const uploadFileInput = document.getElementById('bukti-input');

    if (uploadDropZone && uploadFileInput) {
      ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadDropZone.addEventListener(eventName, function(e) {
          e.preventDefault();
          e.stopPropagation();
        }, false);
      });

      ['dragenter', 'dragover'].forEach(eventName => {
        uploadDropZone.addEventListener(eventName, function(e) {
          uploadDropZone.style.borderColor = 'rgba(77,163,77,0.8)';
          uploadDropZone.style.background = 'rgba(45,138,45,0.2)';
        }, false);
      });

      ['dragleave', 'drop'].forEach(eventName => {
        uploadDropZone.addEventListener(eventName, function(e) {
          // Hanya kembalikan warna awal jika belum ada file yang dipilih
          if (!uploadFileInput.files || uploadFileInput.files.length === 0) {
            uploadDropZone.style.borderColor = 'rgba(77,163,77,0.3)';
            uploadDropZone.style.background = 'rgba(11,45,11,0.2)';
          } else {
            uploadDropZone.style.borderColor = 'rgba(77,163,77,0.6)';
            uploadDropZone.style.background = 'rgba(45,138,45,0.1)';
          }
        }, false);
      });

      uploadDropZone.addEventListener('drop', function(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files && files.length > 0) {
          uploadFileInput.files = files;
          previewBukti(uploadFileInput);
        }
      }, false);
    }
  </script>


</body>
</html>
