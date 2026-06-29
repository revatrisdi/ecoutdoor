<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Admin — ECOutdoor</title>
  <link rel="icon" type="image/png" href="{{ asset('images/image_1.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            forest:    { 50:'#f0f7f0',100:'#d8ecd8',200:'#b3d9b3',300:'#7dbf7d',400:'#4da34d',500:'#2d8a2d',600:'#1e6e1e',800:'#124012',900:'#0b2d0b' },
            stone:     { 400:'#918e84',500:'#787469',600:'#625f55',950:'#1f1e1b' },
            adventure: { 400:'#ff9b33',500:'#ff7c0a' },
          },
          fontFamily: { outfit: ['Outfit','sans-serif'] },
        },
      },
    };
  </script>
  <style>
    * { box-sizing: border-box; }
    body { font-family: 'Outfit', sans-serif; background: #0f1a0f; min-height: 100vh; color: #e7e6e2; }
    .glass { background: rgba(30,30,26,0.9); backdrop-filter: blur(12px); border: 1px solid rgba(77,163,77,0.15); }
    .badge { display:inline-flex; align-items:center; padding:0.2rem 0.65rem; border-radius:9999px; font-size:0.72rem; font-weight:700; }
    .badge-pending   { background:rgba(255,124,10,0.15); color:#ff9b33; border:1px solid rgba(255,124,10,0.3); }
    .badge-confirmed { background:rgba(45,138,45,0.15);  color:#4da34d; border:1px solid rgba(77,163,77,0.3); }
    .badge-cancelled { background:rgba(220,38,38,0.15);  color:#f87171; border:1px solid rgba(220,38,38,0.3); }
    .badge-shipped   { background:rgba(59,130,246,0.15); color:#60a5fa; border:1px solid rgba(59,130,246,0.3); }
    .badge-done      { background:rgba(16,185,129,0.15); color:#34d399; border:1px solid rgba(16,185,129,0.3); }
    .btn-confirm { background:linear-gradient(135deg,#2d8a2d,#1e6e1e); color:white; border:none; padding:0.45rem 1rem; border-radius:0.6rem; font-weight:600; font-size:0.8rem; cursor:pointer; transition:all 0.2s; }
    .btn-confirm:hover { transform:translateY(-1px); box-shadow:0 6px 16px rgba(45,138,45,0.35); }
    .btn-reject { background:rgba(220,38,38,0.12); color:#f87171; border:1px solid rgba(220,38,38,0.3); padding:0.45rem 1rem; border-radius:0.6rem; font-weight:600; font-size:0.8rem; cursor:pointer; transition:all 0.2s; }
    .btn-reject:hover { background:rgba(220,38,38,0.2); }
    .modal-overlay { position:fixed; inset:0; background:rgba(0,0,0,0.7); z-index:50; display:flex; align-items:center; justify-content:center; padding:1rem; }
    .modal-card { background:#1a1e1a; border:1px solid rgba(77,163,77,0.2); border-radius:1.25rem; max-width:500px; width:100%; max-height:90vh; overflow-y:auto; }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav style="background:rgba(11,45,11,0.95); border-bottom:1px solid rgba(77,163,77,0.2); position:sticky; top:0; z-index:40;">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <img src="{{ asset('images/image_1.png') }}" alt="ECOutdoor" class="h-9 w-auto" />
        <div>
          <p class="text-white font-bold text-sm leading-none">ECOutdoor</p>
          <p class="text-forest-400 text-xs">Admin Dashboard</p>
        </div>
      </div>
      <div class="flex items-center gap-4">
        {{-- Tab navigasi --}}
        <a href="{{ route('admin.orders') }}" class="text-white text-sm font-semibold border-b-2 border-forest-400 pb-0.5">📦 Pesanan</a>
        <a href="{{ route('admin.returns') }}" class="text-stone-400 hover:text-white text-sm transition-colors">↩️ Return</a>
        {{-- Info admin --}}
        <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-xl" style="background:rgba(45,138,45,0.1); border:1px solid rgba(77,163,77,0.2);">
          <span class="text-xs">👤</span>
          <div class="leading-none">
            <p class="text-white text-xs font-semibold">{{ auth()->user()->name }}</p>
            <p class="text-forest-400" style="font-size:0.65rem;">Administrator</p>
          </div>
        </div>
        <a href="{{ url('/') }}" class="text-stone-500 hover:text-forest-400 text-sm transition-colors">← Beranda</a>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button class="text-stone-500 hover:text-red-400 text-sm transition-colors">Logout</button>
        </form>
      </div>
    </div>
  </nav>

  <div class="max-w-7xl mx-auto px-4 py-8">

    <!-- Header -->
    <div class="mb-7 flex items-center justify-between flex-wrap gap-4">
      <div>
        <h1 class="text-2xl font-bold text-white">Manajemen Pesanan</h1>
        <p class="text-stone-500 text-sm mt-0.5">Konfirmasi bukti transfer dari pelanggan</p>
      </div>

      <!-- Stats -->
      @php
        $totalPending   = \App\Models\Order::where('status','pending')->whereNotNull('bukti_bayar')->count();
        $totalConfirmed = \App\Models\Order::where('status','confirmed')->count();
        $totalAll       = \App\Models\Order::count();
      @endphp
      <div class="flex gap-3 flex-wrap">
        <div class="glass rounded-xl px-4 py-2.5 text-center">
          <p class="text-adventure-400 font-black text-xl">{{ $totalPending }}</p>
          <p class="text-stone-500 text-xs">Butuh Konfirmasi</p>
        </div>
        <div class="glass rounded-xl px-4 py-2.5 text-center">
          <p class="text-forest-400 font-black text-xl">{{ $totalConfirmed }}</p>
          <p class="text-stone-500 text-xs">Dikonfirmasi</p>
        </div>
        <div class="glass rounded-xl px-4 py-2.5 text-center">
          <p class="text-white font-black text-xl">{{ $totalAll }}</p>
          <p class="text-stone-500 text-xs">Total Pesanan</p>
        </div>
      </div>
    </div>

    <!-- Grafik Penjualan Day-to-Day -->
    <div class="glass rounded-2xl p-5 mb-7">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-bold text-white">📈 Tren Pendapatan (7 Hari Terakhir)</h2>
        <span class="text-xs font-medium text-stone-400 bg-stone-900 px-3 py-1 rounded-full border border-stone-700">Total Penjualan Selesai/Diproses</span>
      </div>
      <div style="height: 300px; width: 100%;">
        <canvas id="revenueChart"></canvas>
      </div>
    </div>

    <!-- Flash message -->
    @if(session('success'))
      <div class="mb-5 p-4 rounded-xl flex items-center gap-3" style="background:rgba(45,138,45,0.12); border:1px solid rgba(77,163,77,0.3);">
        <span class="text-lg">✅</span>
        <p class="text-forest-400 font-medium text-sm">{{ session('success') }}</p>
      </div>
    @endif

    <!-- Filter Tabs -->
    <div class="flex gap-2 mb-5 flex-wrap">
      @foreach(['semua' => 'Semua', 'pending' => 'Pending', 'confirmed' => 'Dikonfirmasi', 'shipped' => 'Dikirim', 'done' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $val => $label)
        <a href="{{ route('admin.orders', ['status' => $val]) }}"
           class="px-4 py-1.5 rounded-full text-sm font-medium transition-all
                  {{ $status === $val ? 'bg-forest-600 text-white' : 'text-stone-400 hover:text-white' }}"
           style="{{ $status === $val ? '' : 'background:rgba(255,255,255,0.05);' }}">
          {{ $label }}
        </a>
      @endforeach
    </div>

    <!-- Orders Table -->
    <div class="glass rounded-2xl overflow-hidden">
      @if($orders->count() === 0)
        <div class="py-16 text-center">
          <p class="text-4xl mb-3">📭</p>
          <p class="text-stone-500">Tidak ada pesanan untuk filter ini.</p>
        </div>
      @else
        <div class="overflow-x-auto">
          <table style="width:100%; border-collapse:collapse;">
            <thead>
              <tr style="background:rgba(45,138,45,0.08); border-bottom:1px solid rgba(77,163,77,0.15);">
                <th class="px-4 py-3 text-left text-xs font-bold text-forest-400 uppercase tracking-wider">Kode</th>
                <th class="px-4 py-3 text-left text-xs font-bold text-forest-400 uppercase tracking-wider">Pelanggan</th>
                <th class="px-4 py-3 text-left text-xs font-bold text-forest-400 uppercase tracking-wider">Produk</th>
                <th class="px-4 py-3 text-left text-xs font-bold text-forest-400 uppercase tracking-wider">Total</th>
                <th class="px-4 py-3 text-left text-xs font-bold text-forest-400 uppercase tracking-wider">Metode</th>
                <th class="px-4 py-3 text-left text-xs font-bold text-forest-400 uppercase tracking-wider">Status</th>
                <th class="px-4 py-3 text-left text-xs font-bold text-forest-400 uppercase tracking-wider">Bukti</th>
                <th class="px-4 py-3 text-left text-xs font-bold text-forest-400 uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($orders as $order)
                <tr style="border-bottom:1px solid rgba(77,163,77,0.07); transition:background 0.15s;"
                    onmouseover="this.style.background='rgba(45,138,45,0.05)'"
                    onmouseout="this.style.background='transparent'">

                  <!-- Kode -->
                  <td class="px-4 py-3.5">
                    <p class="text-white font-bold text-xs tracking-wider">{{ $order->kode_pesanan }}</p>
                    <p class="text-stone-600 text-xs mt-0.5">{{ $order->created_at->format('d M Y, H:i') }}</p>
                  </td>

                  <!-- Pelanggan -->
                  <td class="px-4 py-3.5">
                    <p class="text-white text-sm font-medium">{{ $order->nama_pembeli }}</p>
                    <p class="text-stone-500 text-xs">{{ $order->no_whatsapp }}</p>
                  </td>

                  <!-- Produk -->
                  <td class="px-4 py-3.5">
                    @foreach($order->orderItems as $item)
                    <div class="mb-1">
                      <p class="text-stone-300 text-sm leading-snug">{{ Str::limit($item->product->nama_produk ?? '-', 28) }}</p>
                      <p class="text-stone-600 text-xs">{{ $item->jumlah }} unit x Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                  </td>

                  <!-- Total -->
                  <td class="px-4 py-3.5">
                    <p class="text-adventure-400 font-bold text-sm">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                  </td>

                  <!-- Metode -->
                  <td class="px-4 py-3.5">
                    <span class="text-stone-400 text-xs">
                      {{ match($order->metode_bayar) { 'transfer' => '🏦 Transfer', 'cod' => '💵 COD', default => $order->metode_bayar } }}
                    </span>
                  </td>

                  <!-- Status -->
                  <td class="px-4 py-3.5">
                    <span class="badge badge-{{ $order->status }}">
                      {{ match($order->status) {
                        'pending'   => '⏳ Pending',
                        'confirmed' => '✅ Confirmed',
                        'shipped'   => '🚚 Shipped',
                        'done'      => '🎁 Done',
                        'cancelled' => '❌ Cancelled',
                        default     => $order->status,
                      } }}
                    </span>
                    @if($order->paid_at)
                      <p class="text-stone-600 text-xs mt-0.5">{{ $order->paid_at->format('d M, H:i') }}</p>
                    @endif
                  </td>

                  <!-- Bukti -->
                  <td class="px-4 py-3.5">
                    @if($order->bukti_bayar)
                      <button onclick="openBukti('{{ $order->bukti_url }}', '{{ $order->kode_pesanan }}', {{ $order->id }})"
                              class="text-xs px-2.5 py-1 rounded-lg font-semibold transition-all hover:scale-105"
                              style="background:rgba(26,115,232,0.15); color:#60a5fa; border:1px solid rgba(26,115,232,0.3);">
                        📄 Lihat Bukti
                      </button>
                    @else
                      <span class="text-stone-600 text-xs">Belum ada</span>
                    @endif
                  </td>

                  <!-- Aksi -->
                  <td class="px-4 py-3.5">
                    @if($order->status === 'pending' && $order->bukti_bayar)
                      <div class="flex gap-2">
                        <form action="{{ route('admin.confirm', $order->id) }}" method="POST">
                          @csrf
                          <input type="hidden" name="action" value="confirm" />
                          <button type="submit" class="btn-confirm" onclick="return confirm('Konfirmasi pembayaran pesanan {{ $order->kode_pesanan }}?')">✓ Konfirmasi</button>
                        </form>
                        <button onclick="openReject({{ $order->id }}, '{{ $order->kode_pesanan }}')" class="btn-reject">✕ Tolak</button>
                      </div>
                    @elseif(in_array($order->status, ['confirmed', 'shipped']))
                      <!-- Tombol update status pengiriman -->
                      <form action="{{ route('admin.confirm', $order->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="confirm" />
                        <select name="status_baru" onchange="this.form.submit()"
                                style="background:rgba(255,255,255,0.05); border:1px solid rgba(77,163,77,0.2); color:#b3d9b3; border-radius:0.5rem; padding:0.3rem 0.6rem; font-size:0.75rem; cursor:pointer;">
                          <option value="">Update Status...</option>
                          @if($order->status !== 'shipped')
                          <option value="shipped">🚚 Dikirim</option>
                          @endif
                          <option value="done">🎁 Selesai</option>
                        </select>
                      </form>
                    @else
                      <span class="text-stone-700 text-xs">—</span>
                    @endif

                    {{-- Tombol Hapus History --}}
                    @if(in_array($order->status, ['done', 'cancelled', 'pending']))
                    <div class="mt-2">
                      <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus riwayat pesanan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-red-400 hover:text-red-300 transition-colors" style="background:rgba(220,38,38,0.1); border:1px solid rgba(220,38,38,0.3); padding:0.2rem 0.5rem; border-radius:0.4rem;">🗑️ Hapus</button>
                      </form>
                    </div>
                    @endif
                  </td>

                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
          <div class="px-4 py-4 border-t" style="border-color:rgba(77,163,77,0.1);">
            {{ $orders->withQueryString()->links() }}
          </div>
        @endif
      @endif
    </div>

  </div>

  <!-- Modal: Lihat Bukti Transfer -->
  <div id="modal-bukti" class="modal-overlay" style="display:none;" onclick="closeBukti(event)">
    <div class="modal-card p-5" onclick="event.stopPropagation()">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-white font-bold text-base" id="modal-title">Bukti Transfer</h3>
        <button onclick="closeBukti()" class="text-stone-500 hover:text-white text-xl leading-none">✕</button>
      </div>
      <img id="modal-img" src="" alt="Bukti Transfer" class="w-full rounded-xl object-contain max-h-96" />
      <div class="mt-4 flex gap-2">
        <form id="form-confirm-modal" action="" method="POST" class="flex-1">
          @csrf
          <input type="hidden" name="action" value="confirm" />
          <button type="submit" class="btn-confirm w-full py-2.5">✓ Konfirmasi Pembayaran</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal: Tolak Bukti -->
  <div id="modal-reject" class="modal-overlay" style="display:none;" onclick="closeReject(event)">
    <div class="modal-card p-5" onclick="event.stopPropagation()">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-white font-bold text-base">Tolak Bukti Transfer</h3>
        <button onclick="closeReject()" class="text-stone-500 hover:text-white text-xl">✕</button>
      </div>
      <form id="form-reject" action="" method="POST">
        @csrf
        <input type="hidden" name="action" value="reject" />
        <div class="mb-4">
          <label class="block text-xs font-semibold text-stone-400 mb-1.5">Alasan penolakan (opsional)</label>
          <textarea name="catatan_admin" rows="3"
                    placeholder="Contoh: Nominal tidak sesuai, gambar tidak jelas, dll."
                    style="width:100%; background:rgba(11,45,11,0.3); border:1px solid rgba(77,163,77,0.2); border-radius:0.75rem; padding:0.75rem; color:#e7e6e2; font-size:0.85rem; resize:none; outline:none; font-family:Outfit,sans-serif;"></textarea>
        </div>
        <div class="flex gap-2">
          <button type="button" onclick="closeReject()" class="flex-1 py-2.5 rounded-xl text-stone-400 text-sm font-medium" style="background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08);">Batal</button>
          <button type="submit" class="flex-1 py-2.5 rounded-xl font-bold text-sm" style="background:rgba(220,38,38,0.15); color:#f87171; border:1px solid rgba(220,38,38,0.3);">✕ Tolak Bukti</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function openBukti(url, kode, orderId) {
      document.getElementById('modal-img').src = url;
      document.getElementById('modal-title').textContent = 'Bukti Pembayaran — ' + kode;
      // Set form action dengan order ID yang benar
      document.getElementById('form-confirm-modal').action = '/admin/orders/' + orderId + '/confirm';
      document.getElementById('modal-bukti').style.display = 'flex';
    }
    function closeBukti(e) {
      if (!e || e.target === document.getElementById('modal-bukti')) {
        document.getElementById('modal-bukti').style.display = 'none';
      }
    }
    function openReject(id, kode) {
      document.getElementById('form-reject').action = '/admin/orders/' + id + '/confirm';
      document.getElementById('modal-reject').style.display = 'flex';
    }
    function closeReject(e) {
      if (!e || e.target === document.getElementById('modal-reject')) {
        document.getElementById('modal-reject').style.display = 'none';
      }
    }
    // Initialize Chart.js for Revenue
    document.addEventListener("DOMContentLoaded", function() {
      const ctx = document.getElementById('revenueChart').getContext('2d');
      const chartLabels = {!! json_encode($chartLabels) !!};
      const chartValues = {!! json_encode($chartValues) !!};
      
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: chartLabels,
          datasets: [{
            label: 'Total Pendapatan (Rp)',
            data: chartValues,
            borderColor: '#4da34d',
            backgroundColor: 'rgba(77, 163, 77, 0.2)',
            borderWidth: 2,
            pointBackgroundColor: '#2d8a2d',
            pointBorderColor: '#fff',
            pointRadius: 4,
            pointHoverRadius: 6,
            fill: true,
            tension: 0.4
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false
            },
            tooltip: {
              backgroundColor: 'rgba(11,45,11,0.9)',
              titleFont: { family: 'Outfit', size: 13 },
              bodyFont: { family: 'Outfit', size: 14, weight: 'bold' },
              padding: 10,
              displayColors: false,
              callbacks: {
                label: function(context) {
                  let label = context.dataset.label || '';
                  if (label) {
                    label += ': ';
                  }
                  if (context.parsed.y !== null) {
                    label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                  }
                  return label;
                }
              }
            }
          },
          scales: {
            x: {
              grid: { color: 'rgba(255,255,255,0.05)', borderColor: 'rgba(255,255,255,0.1)' },
              ticks: { color: '#918e84', font: { family: 'Outfit', size: 12 } }
            },
            y: {
              grid: { color: 'rgba(255,255,255,0.05)', borderColor: 'transparent' },
              ticks: { 
                color: '#918e84', 
                font: { family: 'Outfit', size: 12 },
                callback: function(value) {
                  if (value >= 1000000) {
                    return 'Rp ' + (value / 1000000).toFixed(1) + ' Jt';
                  } else if (value >= 1000) {
                    return 'Rp ' + (value / 1000).toFixed(0) + ' Rb';
                  }
                  return 'Rp ' + value;
                }
              }
            }
          }
        }
      });
    });
  </script>

</body>
</html>
