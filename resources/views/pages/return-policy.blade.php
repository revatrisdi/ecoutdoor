@extends('layouts.front')

@section('title', 'Kebijakan & Pengajuan Return — ECOutdoor')

@section('content')
<div class="py-16 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

  {{-- SUCCESS MESSAGE --}}
  @if(session('return_success'))
    <div class="mb-8 flex items-start gap-4 px-6 py-5 rounded-2xl" style="background:rgba(45,138,45,0.12); border:1px solid rgba(77,163,77,0.35);">
      <span class="text-2xl flex-shrink-0">✅</span>
      <div>
        <p class="text-forest-300 font-bold text-sm">Pengajuan Berhasil Dikirim!</p>
        <p class="text-forest-400/80 text-xs mt-0.5">{{ session('return_success') }}</p>
      </div>
    </div>
  @endif

  {{-- HEADER --}}
  <div class="text-center mb-12">
    <span class="inline-block text-adventure-400 text-xs font-bold tracking-widest uppercase mb-3">— Jaminan Kami —</span>
    <h1 class="font-playfair text-4xl sm:text-5xl font-bold text-white mb-4">
      Kebijakan <span class="text-forest-400">Return</span>
    </h1>
    <div class="w-20 h-1 bg-gradient-to-r from-forest-500 to-adventure-500 mx-auto rounded-full"></div>
  </div>

  <div class="grid lg:grid-cols-2 gap-8 items-start">

    {{-- KOLOM KIRI: KEBIJAKAN --}}
    <div class="space-y-6">
      <div class="rounded-2xl p-6" style="background:rgba(36,36,32,0.8); border:1px solid rgba(77,163,77,0.15);">
        <p class="text-stone-300 text-sm leading-relaxed">
          Di <strong class="text-white">ECOutdoor</strong>, kepuasan Anda adalah prioritas utama. Karena platform kami memfasilitasi transaksi jual-beli barang bekas (<em>pre-loved</em>), berikut syarat & ketentuan pengembalian barang.
        </p>
      </div>

      {{-- Syarat --}}
      <div class="rounded-2xl p-6" style="background:rgba(36,36,32,0.8); border:1px solid rgba(77,163,77,0.15);">
        <h3 class="text-base font-bold text-white mb-4 flex items-center gap-2">
          <span class="w-6 h-6 rounded-lg flex items-center justify-center text-xs font-black text-white" style="background:linear-gradient(135deg,#2d8a2d,#1e6e1e);">1</span>
          Syarat Pengembalian
        </h3>
        <ul class="space-y-2.5 text-sm text-stone-300">
          <li class="flex items-start gap-2"><span class="text-forest-400 mt-0.5">✓</span> Barang terbukti rusak/cacat <strong class="text-white">yang tidak disebutkan</strong> di deskripsi.</li>
          <li class="flex items-start gap-2"><span class="text-forest-400 mt-0.5">✓</span> Barang dikirim berbeda dari yang dipesan (salah tipe/warna/ukuran).</li>
          <li class="flex items-start gap-2"><span class="text-adventure-400 mt-0.5">⏰</span> Klaim dilakukan maksimal <strong class="text-adventure-400">2×24 jam</strong> setelah paket diterima.</li>
        </ul>
      </div>

      {{-- Proses --}}
      <div class="rounded-2xl p-6" style="background:rgba(36,36,32,0.8); border:1px solid rgba(77,163,77,0.15);">
        <h3 class="text-base font-bold text-white mb-4 flex items-center gap-2">
          <span class="w-6 h-6 rounded-lg flex items-center justify-center text-xs font-black text-white" style="background:linear-gradient(135deg,#2d8a2d,#1e6e1e);">2</span>
          Proses Klaim
        </h3>
        <ol class="space-y-3 text-sm text-stone-300">
          <li class="flex items-start gap-3">
            <span class="flex-shrink-0 w-5 h-5 rounded-full text-[10px] font-black flex items-center justify-center" style="background:rgba(77,163,77,0.2); color:#4da34d;">1</span>
            Buat <strong class="text-white">video unboxing tanpa jeda</strong> sejak paket masih tersegel.
          </li>
          <li class="flex items-start gap-3">
            <span class="flex-shrink-0 w-5 h-5 rounded-full text-[10px] font-black flex items-center justify-center" style="background:rgba(77,163,77,0.2); color:#4da34d;">2</span>
            Isi formulir pengajuan return di halaman ini →
          </li>
          <li class="flex items-start gap-3">
            <span class="flex-shrink-0 w-5 h-5 rounded-full text-[10px] font-black flex items-center justify-center" style="background:rgba(77,163,77,0.2); color:#4da34d;">3</span>
            Tim ECOutdoor menghubungi Anda via WhatsApp dalam <strong class="text-white">1×24 jam</strong>.
          </li>
        </ol>
      </div>

      {{-- Tidak bisa dikembalikan --}}
      <div class="rounded-2xl p-6" style="background:rgba(220,38,38,0.05); border:1px solid rgba(220,38,38,0.2);">
        <h3 class="text-base font-bold text-white mb-4 flex items-center gap-2">
          <span class="text-red-400">🚫</span> Barang Tidak Bisa Dikembalikan
        </h3>
        <ul class="space-y-2 text-sm" style="color:rgba(248,113,113,0.8);">
          <li class="flex items-start gap-2"><span>•</span> Kerusakan akibat kelalaian kurir (klaim ke asuransi kurir).</li>
          <li class="flex items-start gap-2"><span>•</span> Barang sudah dipakai beraktivitas outdoor.</li>
          <li class="flex items-start gap-2"><span>•</span> "Berubah pikiran" atau salah perkiraan ukuran.</li>
        </ul>
      </div>

      {{-- Cek status --}}
      <div class="rounded-2xl p-6" style="background:rgba(36,36,32,0.8); border:1px solid rgba(77,163,77,0.15);">
        <h3 class="text-sm font-bold text-white mb-3">🔍 Cek Status Pengajuan Return</h3>
        <div class="flex gap-2">
          <input type="text" id="cek-kode-input" placeholder="Kode pesanan (ECO-XXXXX)"
                 class="flex-1 px-3 py-2.5 rounded-xl text-sm text-stone-200 outline-none"
                 style="background:rgba(255,255,255,0.05); border:1.5px solid rgba(77,163,77,0.2); font-family:Outfit,sans-serif;"
                 onkeydown="if(event.key==='Enter') cekStatus()">
          <button onclick="cekStatus()" class="px-4 py-2.5 rounded-xl text-sm font-bold text-white transition-all"
                  style="background:linear-gradient(135deg,#2d8a2d,#1e6e1e);">Cek</button>
        </div>
        <div id="cek-result" class="mt-3 hidden"></div>
      </div>

      <div class="mt-4 text-center">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-stone-500 hover:text-forest-400 transition-colors text-sm">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
          Kembali ke Beranda
        </a>
      </div>
    </div>

    {{-- KOLOM KANAN: FORM PENGAJUAN RETURN --}}
    <div class="lg:sticky lg:top-24">
      <div class="rounded-3xl p-6 sm:p-8" style="background:linear-gradient(160deg,#1a1f1a,#0f1a0f); border:1px solid rgba(77,163,77,0.25); box-shadow:0 20px 60px rgba(0,0,0,0.4);">

        <div class="flex items-center gap-3 mb-6">
          <div class="w-10 h-10 rounded-2xl flex items-center justify-center" style="background:linear-gradient(135deg,rgba(255,124,10,0.2),rgba(240,96,0,0.1)); border:1px solid rgba(255,124,10,0.3);">
            <span class="text-xl">↩️</span>
          </div>
          <div>
            <h2 class="text-white font-bold text-lg">Ajukan Return</h2>
            <p class="text-stone-500 text-xs">Isi form ini dengan jujur & lengkap</p>
          </div>
        </div>

        @if($errors->any())
          <div class="mb-5 px-4 py-3 rounded-xl text-sm" style="background:rgba(220,38,38,0.1); border:1px solid rgba(220,38,38,0.3); color:#f87171;">
            <ul class="space-y-1 list-disc pl-4">
              @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('return.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
          @csrf

          {{-- Kode Pesanan --}}
          <div>
            <label class="block text-xs font-semibold mb-1.5" style="color:#918e84;">KODE PESANAN <span class="text-red-400">*</span></label>
            <input type="text" name="kode_pesanan" required placeholder="ECO-XXXXXX"
                   value="{{ old('kode_pesanan') }}"
                   class="w-full px-4 py-3 rounded-xl text-sm text-stone-200 outline-none uppercase tracking-wider transition-all"
                   style="background:rgba(255,255,255,0.05); border:1.5px solid rgba(77,163,77,0.2); font-family:Outfit,sans-serif;"
                   onfocus="this.style.borderColor='rgba(77,163,77,0.6)'"
                   onblur="this.style.borderColor='rgba(77,163,77,0.2)'">
          </div>

          {{-- Nama --}}
          <div>
            <label class="block text-xs font-semibold mb-1.5" style="color:#918e84;">NAMA PEMBELI <span class="text-red-400">*</span></label>
            <input type="text" name="nama_pembeli" required placeholder="Nama lengkap Anda"
                   value="{{ old('nama_pembeli') }}"
                   class="w-full px-4 py-3 rounded-xl text-sm text-stone-200 outline-none transition-all"
                   style="background:rgba(255,255,255,0.05); border:1.5px solid rgba(77,163,77,0.2); font-family:Outfit,sans-serif;"
                   onfocus="this.style.borderColor='rgba(77,163,77,0.6)'"
                   onblur="this.style.borderColor='rgba(77,163,77,0.2)'">
          </div>

          {{-- WhatsApp --}}
          <div>
            <label class="block text-xs font-semibold mb-1.5" style="color:#918e84;">NOMOR WHATSAPP <span class="text-red-400">*</span></label>
            <input type="tel" name="whatsapp" required placeholder="08xxxxxxxxxx"
                   value="{{ old('whatsapp') }}"
                   class="w-full px-4 py-3 rounded-xl text-sm text-stone-200 outline-none transition-all"
                   style="background:rgba(255,255,255,0.05); border:1.5px solid rgba(77,163,77,0.2); font-family:Outfit,sans-serif;"
                   onfocus="this.style.borderColor='rgba(77,163,77,0.6)'"
                   onblur="this.style.borderColor='rgba(77,163,77,0.2)'">
          </div>

          {{-- Alasan --}}
          <div>
            <label class="block text-xs font-semibold mb-1.5" style="color:#918e84;">ALASAN RETURN <span class="text-red-400">*</span></label>
            <div class="grid grid-cols-2 gap-2">
              @foreach([
                'barang_rusak'                  => '🔨 Barang Rusak',
                'barang_berbeda'                => '📦 Barang Berbeda',
                'barang_tidak_sesuai_deskripsi' => '📝 Tidak Sesuai Deskripsi',
                'lainnya'                       => '❓ Lainnya',
              ] as $val => $label)
                <label class="flex items-center gap-2 px-3 py-2.5 rounded-xl cursor-pointer transition-all"
                       style="background:rgba(255,255,255,0.03); border:1.5px solid rgba(77,163,77,0.15);"
                       onclick="this.style.borderColor='rgba(77,163,77,0.6)'; this.style.background='rgba(77,163,77,0.08)'">
                  <input type="radio" name="alasan" value="{{ $val }}" required class="accent-green-500"
                         {{ old('alasan') === $val ? 'checked' : '' }}>
                  <span class="text-xs text-stone-300">{{ $label }}</span>
                </label>
              @endforeach
            </div>
          </div>

          {{-- Deskripsi --}}
          <div>
            <label class="block text-xs font-semibold mb-1.5" style="color:#918e84;">DESKRIPSI MASALAH <span class="text-red-400">*</span></label>
            <textarea name="deskripsi" required rows="4" maxlength="2000"
                      placeholder="Jelaskan secara detail kerusakan/perbedaan barang yang Anda terima..."
                      class="w-full px-4 py-3 rounded-xl text-sm text-stone-200 outline-none resize-none transition-all"
                      style="background:rgba(255,255,255,0.05); border:1.5px solid rgba(77,163,77,0.2); font-family:Outfit,sans-serif;"
                      onfocus="this.style.borderColor='rgba(77,163,77,0.6)'"
                      onblur="this.style.borderColor='rgba(77,163,77,0.2)'">{{ old('deskripsi') }}</textarea>
          </div>

          {{-- Foto Bukti --}}
          <div>
            <label class="block text-xs font-semibold mb-1.5" style="color:#918e84;">FOTO BUKTI <span class="text-xs font-normal" style="color:#5a5750;">(opsional, max 5MB)</span></label>
            <label for="bukti-foto-input"
                   class="flex items-center gap-3 w-full px-4 py-3 rounded-xl cursor-pointer transition-all"
                   style="background:rgba(255,255,255,0.03); border:2px dashed rgba(77,163,77,0.25);"
                   onmouseenter="this.style.borderColor='rgba(77,163,77,0.5)'"
                   onmouseleave="this.style.borderColor='rgba(77,163,77,0.25)'">
              <svg class="w-5 h-5 flex-shrink-0" style="color:#4da34d;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
              <span id="bukti-foto-label" class="text-xs text-stone-500">Klik untuk pilih foto/screenshot bukti kerusakan</span>
              <input type="file" id="bukti-foto-input" name="bukti_foto" accept="image/*" class="hidden"
                     onchange="document.getElementById('bukti-foto-label').textContent = this.files[0]?.name || 'Pilih file'">
            </label>
          </div>

          <div class="pt-1">
            <button type="submit"
                    class="w-full py-4 rounded-2xl text-white font-bold text-sm transition-all shadow-lg"
                    style="background:linear-gradient(135deg,#ff7c0a,#f06000); box-shadow:0 8px 24px rgba(255,124,10,0.3);"
                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 32px rgba(255,124,10,0.4)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 24px rgba(255,124,10,0.3)'">
              📨 Kirim Pengajuan Return
            </button>
          </div>

          <p class="text-xs text-center" style="color:#5a5750;">
            Pengajuan akan diproses oleh tim ECOutdoor dalam 1×24 jam hari kerja.
          </p>
        </form>
      </div>
    </div>

  </div>
</div>

<script>
async function cekStatus() {
  const kode = document.getElementById('cek-kode-input').value.trim().toUpperCase();
  const result = document.getElementById('cek-result');
  if (!kode) return;

  result.innerHTML = '<p class="text-xs text-stone-500">Memeriksa...</p>';
  result.classList.remove('hidden');

  try {
    const res = await fetch(`/return/cek?kode_pesanan=${encodeURIComponent(kode)}`, {
      headers: { 'Accept': 'application/json' }
    });
    const data = await res.json();

    if (!data.found) {
      result.innerHTML = `<p class="text-xs text-red-400">❌ Tidak ditemukan pengajuan return untuk kode <strong>${kode}</strong>.</p>`;
      return;
    }

    const statusColors = {
      pending:   { bg:'rgba(255,124,10,0.1)', border:'rgba(255,124,10,0.3)', color:'#ff9b33', icon:'⏳' },
      diproses:  { bg:'rgba(26,115,232,0.1)', border:'rgba(26,115,232,0.3)', color:'#60a5fa', icon:'🔄' },
      disetujui: { bg:'rgba(45,138,45,0.1)',  border:'rgba(77,163,77,0.3)',  color:'#4da34d', icon:'✅' },
      ditolak:   { bg:'rgba(220,38,38,0.1)',  border:'rgba(220,38,38,0.3)', color:'#f87171', icon:'❌' },
    };
    const s = statusColors[data.status] || statusColors.pending;

    result.innerHTML = `
      <div class="p-4 rounded-xl text-xs space-y-1.5" style="background:${s.bg}; border:1px solid ${s.border};">
        <p class="font-bold" style="color:${s.color};">${s.icon} ${data.status_label}</p>
        <p class="text-stone-400">Kode: <strong class="text-white">${data.kode_pesanan}</strong></p>
        <p class="text-stone-400">Pembeli: <strong class="text-white">${data.nama_pembeli}</strong></p>
        <p class="text-stone-400">Alasan: ${data.alasan_label}</p>
        <p class="text-stone-400">Diajukan: ${data.created_at}</p>
        ${data.catatan_admin ? `<p class="pt-1 border-t border-white/10 mt-2" style="color:${s.color};">💬 Catatan Admin: ${data.catatan_admin}</p>` : ''}
      </div>`;
  } catch(e) {
    result.innerHTML = '<p class="text-xs text-red-400">⚠️ Gagal menghubungi server.</p>';
  }
}
</script>
@endsection
