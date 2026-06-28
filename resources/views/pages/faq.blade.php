@extends('layouts.front')

@section('title', 'Tanya Jawab (FAQ) — ECOutdoor')

@section('content')
<div class="py-24 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
  <div class="bg-stone-900 rounded-3xl p-8 sm:p-12 border border-stone-800 shadow-2xl animate-fade-up">
    
    <div class="text-center mb-12">
      <span class="inline-block text-adventure-400 text-sm font-bold tracking-widest uppercase mb-3">— Bantuan —</span>
      <h1 class="font-playfair text-4xl sm:text-5xl font-bold text-white mb-4">
        Tanya Jawab (FAQ)
      </h1>
      <div class="w-20 h-1 bg-gradient-to-r from-forest-500 to-adventure-500 mx-auto rounded-full"></div>
    </div>

    <div class="space-y-6">
      
      <!-- FAQ Item 1 -->
      <div class="bg-stone-950 p-6 rounded-2xl border border-stone-800/50">
        <h3 class="text-lg font-bold text-forest-400 mb-2 flex items-start gap-3">
          <span class="text-2xl mt-0.5">Q.</span> Bagaimana cara membeli barang di ECOutdoor?
        </h3>
        <p class="text-stone-300 ml-10 text-sm leading-relaxed">
          Anda tidak perlu mendaftar untuk melihat katalog kami. Jika Anda menemukan barang yang Anda sukai, klik tombol "Lihat Detail" lalu hubungi penjual via WhatsApp yang tertera di sana untuk melakukan negosiasi atau transaksi langsung.
        </p>
      </div>

      <!-- FAQ Item 2 -->
      <div class="bg-stone-950 p-6 rounded-2xl border border-stone-800/50">
        <h3 class="text-lg font-bold text-forest-400 mb-2 flex items-start gap-3">
          <span class="text-2xl mt-0.5">Q.</span> Apakah saya dikenakan biaya admin jika berjualan?
        </h3>
        <p class="text-stone-300 ml-10 text-sm leading-relaxed">
          Tidak. Saat ini ECOutdoor membebaskan biaya admin bagi pengguna baru untuk 10 kali transaksi pertama. Nikmati pengalaman berjualan 100% gratis tanpa potongan!
        </p>
      </div>

      <!-- FAQ Item 3 -->
      <div class="bg-stone-950 p-6 rounded-2xl border border-stone-800/50">
        <h3 class="text-lg font-bold text-forest-400 mb-2 flex items-start gap-3">
          <span class="text-2xl mt-0.5">Q.</span> Bagaimana jika barang yang saya beli cacat atau tidak sesuai?
        </h3>
        <p class="text-stone-300 ml-10 text-sm leading-relaxed">
          Kami menyarankan Anda untuk selalu meminta video kondisi barang terbaru kepada penjual sebelum melakukan transfer. Untuk informasi lengkap mengenai pengembalian, silakan baca <a href="{{ route('pages.return-policy') }}" class="text-adventure-400 hover:underline">Kebijakan Return</a> kami.
        </p>
      </div>

      <!-- FAQ Item 4 -->
      <div class="bg-stone-950 p-6 rounded-2xl border border-stone-800/50">
        <h3 class="text-lg font-bold text-forest-400 mb-2 flex items-start gap-3">
          <span class="text-2xl mt-0.5">Q.</span> Apakah ECOutdoor menyediakan sistem Rekber (Rekening Bersama)?
        </h3>
        <p class="text-stone-300 ml-10 text-sm leading-relaxed">
          Saat ini kami masih dalam tahap pengembangan untuk sistem Rekber otomatis di dalam aplikasi. Transaksi dilakukan secara P2P (Peer-to-Peer) antara pembeli dan penjual secara langsung. Kami mengimbau agar selalu berhati-hati.
        </p>
      </div>

    </div>

    <div class="mt-12 text-center">
      <p class="text-stone-400 mb-4">Masih punya pertanyaan yang belum terjawab?</p>
      <div class="flex flex-wrap justify-center gap-4">
        <a href="https://wa.me/6285804049637" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 bg-adventure-600 hover:bg-adventure-500 text-white px-8 py-3 rounded-full font-bold transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
          Hubungi Customer Service
        </a>
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 bg-forest-600 hover:bg-forest-500 text-white px-8 py-3 rounded-full font-bold transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
          Kembali ke Beranda
        </a>
      </div>
    </div>

  </div>
</div>
@endsection
