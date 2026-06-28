@extends('layouts.front')

@section('title', 'Tentang Kami — ECOutdoor')

@section('content')
<div class="py-24 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
  <div class="bg-stone-900 rounded-3xl p-8 sm:p-12 border border-stone-800 shadow-2xl animate-fade-up">
    
    <div class="text-center mb-10">
      <span class="inline-block text-adventure-400 text-sm font-bold tracking-widest uppercase mb-3">— Perjalanan Kami —</span>
      <h1 class="font-playfair text-4xl sm:text-5xl font-bold text-white mb-4">
        Tentang <span class="text-forest-400">ECOutdoor</span>
      </h1>
      <div class="w-20 h-1 bg-gradient-to-r from-forest-500 to-adventure-500 mx-auto rounded-full"></div>
    </div>

    <div class="prose prose-invert prose-lg max-w-none text-stone-300">
      <p>
        <strong>ECOutdoor</strong> lahir dari semangat dan kecintaan kami terhadap alam bebas. Kami menyadari bahwa perlengkapan outdoor yang berkualitas tidak selalu harus mahal, dan perlengkapan bekas yang masih layak pakai seharusnya bisa diteruskan ke petualang lain daripada dibuang.
      </p>
      
      <p>
        Didirikan pada tahun 2024, ECOutdoor bukan sekadar toko online. Kami adalah wadah komunitas pecinta alam Indonesia. Kami mempertemukan mereka yang ingin menjual perlengkapan outdoor mereka (tas carrier, tenda, sepatu gunung, dsb.) dengan mereka yang sedang mencari gear berkualitas dengan harga bersahabat.
      </p>

      <div class="grid sm:grid-cols-2 gap-8 my-10">
        <div class="bg-stone-950 p-6 rounded-2xl border border-stone-800/50">
          <div class="w-12 h-12 bg-forest-900/50 text-forest-400 rounded-xl flex items-center justify-center text-2xl mb-4">🌍</div>
          <h3 class="text-xl font-bold text-white mb-2">Visi Kami</h3>
          <p class="text-sm">Menjadi platform perlengkapan outdoor berkelanjutan (sustainable) nomor satu di Indonesia yang mendukung gaya hidup ramah lingkungan.</p>
        </div>
        <div class="bg-stone-950 p-6 rounded-2xl border border-stone-800/50">
          <div class="w-12 h-12 bg-adventure-900/50 text-adventure-400 rounded-xl flex items-center justify-center text-2xl mb-4">🤝</div>
          <h3 class="text-xl font-bold text-white mb-2">Misi Kami</h3>
          <p class="text-sm">Membangun ekosistem jual beli gear outdoor yang aman, transparan, dan saling menguntungkan bagi semua pihak.</p>
        </div>
      </div>

      <p>
        Terima kasih telah mempercayakan petualangan Anda bersama ECOutdoor. Mari terus melangkah, menjelajah, dan menjaga kelestarian alam bersama-sama.
      </p>

      <div class="mt-12 text-center">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 bg-forest-600 hover:bg-forest-500 text-white px-8 py-3 rounded-full font-bold transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
          Kembali ke Beranda
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
