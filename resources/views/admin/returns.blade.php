<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kelola Return — ECOutdoor Admin</title>
  <link rel="icon" type="image/png" href="{{ asset('images/image_1.png') }}">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            forest:    { 50:'#f0f7f0',100:'#d8ecd8',300:'#7dbf7d',400:'#4da34d',500:'#2d8a2d',600:'#1e6e1e',900:'#0b2d0b' },
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
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav style="background:rgba(11,45,11,0.95); border-bottom:1px solid rgba(77,163,77,0.2); position:sticky; top:0; z-index:40;">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
      <div class="flex items-center gap-4">
        <a href="{{ route('admin.orders') }}" class="text-stone-400 hover:text-white transition-colors text-sm">← Pesanan</a>
        <span style="color:rgba(77,163,77,0.3);">|</span>
        <p class="text-white font-bold text-sm">↩️ Kelola Return</p>
      </div>
      <div class="flex items-center gap-3">
        <span class="text-xs text-stone-400">{{ auth()->user()->name }}</span>
        <a href="{{ route('admin.orders') }}" class="text-xs text-forest-400 hover:underline">Dashboard</a>
      </div>
    </div>
  </nav>

  <div class="max-w-6xl mx-auto px-4 py-10">
    <div class="flex items-center justify-between mb-8">
      <div>
        <h1 class="text-2xl font-bold text-white">Pengajuan Pengembalian Barang</h1>
        <p class="text-stone-500 text-sm mt-1">{{ $returns->count() }} total pengajuan</p>
      </div>
      <div class="flex gap-2 flex-wrap">
        @foreach(['pending'=>'⏳','diproses'=>'🔄','disetujui'=>'✅','ditolak'=>'❌'] as $s => $icon)
          <span class="text-xs px-3 py-1.5 rounded-full font-semibold"
                style="background:rgba(77,163,77,0.1); border:1px solid rgba(77,163,77,0.2); color:#4da34d;">
            {{ $icon }} {{ $returns->where('status',$s)->count() }} {{ ucfirst($s) }}
          </span>
        @endforeach
      </div>
    </div>

    @if(session('success'))
      <div class="mb-6 px-5 py-4 rounded-2xl text-sm" style="background:rgba(45,138,45,0.12); border:1px solid rgba(77,163,77,0.3); color:#4da34d;">
        ✅ {{ session('success') }}
      </div>
    @endif

    @if($returns->isEmpty())
      <div class="text-center py-20 text-stone-600">
        <p class="text-4xl mb-4">📭</p>
        <p class="text-lg font-semibold">Belum ada pengajuan return</p>
      </div>
    @else
      <div class="space-y-5">
        @foreach($returns as $ret)
          @php
            $statusConfig = [
              'pending'   => ['bg'=>'rgba(255,124,10,0.12)', 'border'=>'rgba(255,124,10,0.35)', 'color'=>'#ff9b33', 'icon'=>'⏳'],
              'diproses'  => ['bg'=>'rgba(59,130,246,0.12)', 'border'=>'rgba(59,130,246,0.35)', 'color'=>'#60a5fa', 'icon'=>'🔄'],
              'disetujui' => ['bg'=>'rgba(45,138,45,0.12)',  'border'=>'rgba(77,163,77,0.35)',  'color'=>'#4da34d', 'icon'=>'✅'],
              'ditolak'   => ['bg'=>'rgba(220,38,38,0.12)',  'border'=>'rgba(220,38,38,0.35)', 'color'=>'#f87171', 'icon'=>'❌'],
            ][$ret->status] ?? ['bg'=>'rgba(77,163,77,0.1)','border'=>'rgba(77,163,77,0.2)','color'=>'#4da34d','icon'=>'?'];
          @endphp
          <div class="rounded-2xl overflow-hidden" style="background:rgba(30,30,26,0.9); border:1px solid {{ $statusConfig['border'] }};">
            <div class="flex flex-col sm:flex-row sm:items-start gap-4 p-5">

              {{-- Status badge --}}
              <div class="flex-shrink-0">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold"
                      style="background:{{ $statusConfig['bg'] }}; color:{{ $statusConfig['color'] }}; border:1px solid {{ $statusConfig['border'] }};">
                  {{ $statusConfig['icon'] }} {{ $ret->status_label }}
                </span>
                <p class="text-stone-600 text-xs mt-1.5">{{ $ret->created_at->format('d M Y, H:i') }}</p>
              </div>

              {{-- Info --}}
              <div class="flex-1 min-w-0 grid sm:grid-cols-2 gap-x-6 gap-y-2 text-sm">
                <div>
                  <p class="text-stone-500 text-xs">Kode Pesanan</p>
                  <p class="text-white font-bold">{{ $ret->kode_pesanan }}</p>
                </div>
                <div>
                  <p class="text-stone-500 text-xs">Nama Pembeli</p>
                  <p class="text-white font-semibold">{{ $ret->nama_pembeli }}</p>
                </div>
                <div>
                  <p class="text-stone-500 text-xs">WhatsApp</p>
                  <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/\D/','',$ret->whatsapp)) }}"
                     target="_blank" class="text-forest-400 hover:underline font-semibold">{{ $ret->whatsapp }}</a>
                </div>
                <div>
                  <p class="text-stone-500 text-xs">Alasan</p>
                  <p class="text-stone-200">{{ $ret->alasan_label }}</p>
                </div>
                <div class="sm:col-span-2">
                  <p class="text-stone-500 text-xs">Deskripsi Masalah</p>
                  <p class="text-stone-300 text-sm leading-relaxed mt-0.5">{{ $ret->deskripsi }}</p>
                </div>
                @if($ret->info_rekening)
                  <div class="sm:col-span-2 px-3 py-2 rounded-lg" style="background:rgba(255,155,51,0.08); border-left:3px solid #ff9b33;">
                    <p class="text-xs text-stone-500">Rekening Pengembalian Dana</p>
                    <p class="text-adventure-400 font-medium text-sm mt-0.5">{{ $ret->info_rekening }}</p>
                  </div>
                @endif
                @if($ret->bukti_foto)
                  <div class="sm:col-span-2">
                    <p class="text-stone-500 text-xs mb-2">Foto Bukti</p>
                    <a href="{{ asset('storage/' . $ret->bukti_foto) }}" target="_blank">
                      <img src="{{ asset('storage/' . $ret->bukti_foto) }}" alt="Bukti"
                           class="h-24 w-24 object-cover rounded-xl hover:scale-105 transition-transform"
                           style="border:1.5px solid rgba(77,163,77,0.3);">
                    </a>
                  </div>
                @endif
                @if($ret->catatan_admin)
                  <div class="sm:col-span-2 px-3 py-2 rounded-lg" style="background:rgba(77,163,77,0.08); border-left:3px solid #4da34d;">
                    <p class="text-xs text-stone-500">Catatan Admin</p>
                    <p class="text-forest-300 text-sm">{{ $ret->catatan_admin }}</p>
                  </div>
                @endif
              </div>

              {{-- Form Update --}}
              <div class="flex-shrink-0 sm:w-52">
                <form action="{{ route('admin.returns.update', $ret->id) }}" method="POST">
                  @csrf @method('PATCH')
                  <label class="block text-xs text-stone-500 mb-1">Ubah Status</label>
                  <select name="status" class="w-full text-xs rounded-xl px-3 py-2 mb-2 text-white outline-none"
                          style="background:rgba(255,255,255,0.08); border:1px solid rgba(77,163,77,0.25);">
                    @foreach(['pending'=>'⏳ Pending','diproses'=>'🔄 Diproses','disetujui'=>'✅ Disetujui','ditolak'=>'❌ Ditolak'] as $val => $lbl)
                      <option value="{{ $val }}" style="background: #1f1e1b; color: #fff;" {{ $ret->status === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                    @endforeach
                  </select>
                  <textarea name="catatan_admin" rows="3" placeholder="Catatan untuk pembeli..."
                            class="w-full text-xs rounded-xl px-3 py-2 mb-2 text-stone-200 outline-none resize-none"
                            style="background:rgba(255,255,255,0.05); border:1px solid rgba(77,163,77,0.2);">{{ $ret->catatan_admin }}</textarea>
                  <button type="submit" class="w-full py-2 rounded-xl text-xs font-bold text-white transition-all mb-2"
                          style="background:linear-gradient(135deg,#2d8a2d,#1e6e1e);">
                    Simpan Perubahan
                  </button>
                </form>
                
                <form action="{{ route('admin.returns.destroy', $ret->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengajuan return ini? Data yang dihapus tidak dapat dikembalikan.');">
                  @csrf @method('DELETE')
                  <button type="submit" class="w-full py-2 rounded-xl text-xs font-bold transition-all"
                          style="background:rgba(220,38,38,0.1); color:#f87171; border:1px solid rgba(220,38,38,0.2);"
                          onmouseover="this.style.background='rgba(220,38,38,0.2)'"
                          onmouseout="this.style.background='rgba(220,38,38,0.1)'">
                    Hapus Pengajuan
                  </button>
                </form>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</body>
</html>
