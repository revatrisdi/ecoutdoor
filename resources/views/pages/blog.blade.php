@extends('layouts.front')

@section('title', 'Blog & Panduan — ECOutdoor')

@section('content')
<div class="py-24 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
  <div class="text-center mb-16 animate-fade-up">
    <span class="inline-block text-adventure-400 text-sm font-bold tracking-widest uppercase mb-3">— Tips & Trik —</span>
    <h1 class="font-playfair text-4xl sm:text-5xl font-bold text-white mb-4">
      Blog & <span class="text-forest-400">Panduan</span>
    </h1>
    <p class="text-stone-400 text-lg max-w-2xl mx-auto">
      Kumpulan artikel, cerita inspiratif, dan panduan memilih perlengkapan untuk petualangan Anda berikutnya.
    </p>
  </div>

  <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
    
    <!-- Blog Post 1 -->
    <article class="bg-stone-900 rounded-2xl border border-stone-800 overflow-hidden group hover:border-forest-500/50 transition-colors duration-300">
      <div class="h-48 bg-stone-800 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-tr from-forest-900 to-stone-800 opacity-60"></div>
        <div class="absolute inset-0 flex items-center justify-center text-5xl">🏔️</div>
      </div>
      <div class="p-6">
        <div class="flex items-center gap-3 text-xs text-stone-400 mb-3">
          <span class="bg-forest-900/50 text-forest-400 px-2 py-1 rounded">Panduan</span>
          <span>•</span>
          <span>5 Menit baca</span>
        </div>
        <h3 class="text-xl font-bold text-white mb-2 group-hover:text-forest-400 transition-colors">Cara Memilih Sepatu Hiking yang Tepat untuk Pemula</h3>
        <p class="text-stone-400 text-sm line-clamp-3 mb-4">
          Sepatu adalah aset paling berharga saat mendaki. Jangan sampai petualangan pertamamu hancur karena salah memilih ukuran atau jenis sol sepatu. Simak tips memilih sepatu hiking agar kaki tidak lecet.
        </p>
        <a href="#" class="text-adventure-400 text-sm font-bold hover:underline">Baca Selengkapnya →</a>
      </div>
    </article>

    <!-- Blog Post 2 -->
    <article class="bg-stone-900 rounded-2xl border border-stone-800 overflow-hidden group hover:border-forest-500/50 transition-colors duration-300">
      <div class="h-48 bg-stone-800 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-tr from-adventure-900 to-stone-800 opacity-60"></div>
        <div class="absolute inset-0 flex items-center justify-center text-5xl">⛺</div>
      </div>
      <div class="p-6">
        <div class="flex items-center gap-3 text-xs text-stone-400 mb-3">
          <span class="bg-adventure-900/50 text-adventure-400 px-2 py-1 rounded">Tips</span>
          <span>•</span>
          <span>4 Menit baca</span>
        </div>
        <h3 class="text-xl font-bold text-white mb-2 group-hover:text-forest-400 transition-colors">Merawat Tenda agar Awet Bertahun-tahun</h3>
        <p class="text-stone-400 text-sm line-clamp-3 mb-4">
          Tenda basah setelah turun gunung? Jangan biarkan terlipat lama di dalam carrier! Ini cara membersihkan dan melipat tenda yang benar agar lapisan waterproof-nya tidak cepat rusak atau terkelupas.
        </p>
        <a href="#" class="text-adventure-400 text-sm font-bold hover:underline">Baca Selengkapnya →</a>
      </div>
    </article>

    <!-- Blog Post 3 -->
    <article class="bg-stone-900 rounded-2xl border border-stone-800 overflow-hidden group hover:border-forest-500/50 transition-colors duration-300">
      <div class="h-48 bg-stone-800 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-tr from-stone-700 to-stone-900 opacity-60"></div>
        <div class="absolute inset-0 flex items-center justify-center text-5xl">🎒</div>
      </div>
      <div class="p-6">
        <div class="flex items-center gap-3 text-xs text-stone-400 mb-3">
          <span class="bg-stone-700 text-stone-300 px-2 py-1 rounded">Gear Review</span>
          <span>•</span>
          <span>7 Menit baca</span>
        </div>
        <h3 class="text-xl font-bold text-white mb-2 group-hover:text-forest-400 transition-colors">Carrier 40L vs 60L: Mana yang Kamu Butuhkan?</h3>
        <p class="text-stone-400 text-sm line-clamp-3 mb-4">
          Banyak pendaki pemula yang membeli carrier berkapasitas sangat besar, padahal mereka hanya melakukan pendakian tek-tok (sehari). Temukan ukuran carrier yang paling ideal dengan gaya mendakimu.
        </p>
        <a href="#" class="text-adventure-400 text-sm font-bold hover:underline">Baca Selengkapnya →</a>
      </div>
    </article>

  </div>

  <div class="text-center mt-12 flex flex-col items-center gap-6">
    <button class="bg-stone-800 hover:bg-stone-700 text-stone-300 px-6 py-2.5 rounded-full text-sm font-medium transition-colors">
      Muat Lebih Banyak Artikel
    </button>
    <a href="{{ url('/') }}" class="inline-flex items-center gap-2 bg-forest-600 hover:bg-forest-500 text-white px-8 py-3 rounded-full font-bold transition-colors">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
      Kembali ke Beranda
    </a>
  </div>
</div>
@endsection
