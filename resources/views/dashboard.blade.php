<x-app-layout>
    {{-- ======================================================
         PAGE HEADER — ECOutdoor Partner Hub
    ====================================================== --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            {{-- Brand + Title --}}
            <div class="flex items-center gap-4">
                <div class="relative">
                    <img src="{{ asset('images/image_1.png') }}" alt="ECOutdoor Logo" class="h-11 w-11 object-contain drop-shadow-md rounded-xl" style="border:1px solid #d8ecd8; background:white;" />
                    <span class="absolute -top-1 -right-1 w-3 h-3 rounded-full border-2 border-white"
                          style="background:#2d8a2d;"></span>
                </div>
                <div>
                    <h2 class="text-xl font-bold tracking-tight" style="color:#0b2d0b;">
                        ECOutdoor <span style="color:#2d8a2d;">Partner Hub</span>
                    </h2>
                    <p class="text-xs mt-0.5" style="color:#7dbf7d;">
                        Selamat datang kembali, <strong style="color:#175517;">{{ Auth::user()->name }}</strong> 👋
                    </p>
                </div>
            </div>

            {{-- Quick Stats in Header --}}
            <div class="hidden sm:flex items-center gap-2">
                <div class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm"
                     style="background:#f0f7f0; border:1px solid #d8ecd8;">
                    <svg class="w-4 h-4" style="color:#2d8a2d" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                    </svg>
                    <span style="color:#175517; font-weight:700;">{{ Auth::user()->products->count() }}</span>
                    <span style="color:#4da34d; font-size:0.75rem;">Produk Aktif</span>
                </div>
                <a href="{{ url('/') }}" 
                   class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold transition-all duration-200"
                   style="background:#ffffff; border:1px solid #d8ecd8; color:#175517;"
                   onmouseover="this.style.background='#f0f7f0'"
                   onmouseout="this.style.background='#ffffff'">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Lihat Toko
                </a>
            </div>
        </div>
    </x-slot>

    <div class="partner-hub-bg py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-7">

            {{-- ======================================================
                 FLASH MESSAGES
            ====================================================== --}}
            @if(session('success'))
                <div id="flash-success" class="eco-alert-success">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center"
                         style="background:rgba(45,138,45,0.12);">
                        <svg class="w-4 h-4" style="color:#2d8a2d" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-sm" style="color:#0b2d0b;">Berhasil!</p>
                        <p class="text-xs mt-0.5" style="color:#175517;">{{ session('success') }}</p>
                    </div>
                    <button onclick="document.getElementById('flash-success').remove()"
                            class="ml-auto flex-shrink-0 opacity-50 hover:opacity-100 transition-opacity"
                            style="color:#124012;">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="eco-alert-error">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-4 h-4 flex-shrink-0" style="color:#dc2626" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-bold text-sm">Ada beberapa kesalahan yang perlu diperbaiki:</span>
                    </div>
                    <ul class="space-y-1 ml-6 list-disc" style="font-size:0.8rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ======================================================
                 NOTIFIKASI PESANAN MASUK (PERLU DIPROSES)
            ====================================================== --}}
            @if(isset($ordersToProcess) && $ordersToProcess->count() > 0)
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-sm" style="background:linear-gradient(135deg, #ff7c0a, #ff9b33);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-xl tracking-tight" style="color:#0b2d0b;">
                                Daftar Pesanan Aktif 
                                @php $baruCount = $ordersToProcess->where('status', 'confirmed')->count(); @endphp
                                @if($baruCount > 0)
                                    <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full ml-1 align-middle">{{ $baruCount }} Perlu Diproses</span>
                                @endif
                            </h3>
                            <p class="text-xs text-stone-500 mt-0.5">Kelola pesanan pelanggan Anda di bawah ini</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        @foreach($ordersToProcess as $order)
                            <div class="eco-card overflow-hidden flex flex-col h-full border hover:shadow-lg transition-all duration-300" style="border-color:#f0f7f0;">
                                {{-- Card Header --}}
                                <div class="px-5 py-4 border-b flex justify-between items-center" style="background:#fafdfa; border-color:#f0f7f0;">
                                    <div class="flex items-center gap-2">
                                        <span class="font-black text-sm tracking-wide" style="color:#175517;">#{{ $order->kode_pesanan }}</span>
                                    </div>
                                    <span class="text-[0.7rem] font-medium text-stone-400 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $order->updated_at->diffForHumans() }}
                                    </span>
                                </div>

                                {{-- Card Body --}}
                                <div class="p-5 flex-grow space-y-4">
                                    {{-- Pembeli Info --}}
                                    <div class="flex items-start gap-4 p-4 rounded-2xl" style="background: linear-gradient(to right, #fbfdfb, #f4f9f4); border:1px solid #e8f4e8;">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 text-white shadow-sm" style="background: linear-gradient(135deg, #2d8a2d, #1e6e1e);">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                                        </div>
                                        <div class="flex-grow">
                                            <div class="flex items-center justify-between mb-1">
                                                <p class="font-bold text-sm tracking-tight" style="color:#0b2d0b;">{{ $order->nama_pembeli }}</p>
                                                <span class="flex items-center gap-1 text-[0.65rem] font-bold px-2 py-0.5 rounded-full" style="background:#e8f4e8; color:#2d8a2d; border:1px solid #d8ecd8;">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                                    {{ $order->no_whatsapp }}
                                                </span>
                                            </div>
                                            <p class="text-xs leading-relaxed" style="color:#5c7e5c;">
                                                <span class="inline-block mr-1">📍</span>{{ $order->alamat_pengiriman }}
                                            </p>
                                        </div>
                                    </div>

                                    {{-- List Produk --}}
                                    <div>
                                        <p class="text-[0.7rem] font-bold uppercase tracking-wider text-stone-400 mb-3">Item Dipesan</p>
                                        <div class="space-y-3">
                                            @foreach($order->orderItems as $item)
                                                @if($item->product->user_id === Auth::id())
                                                    <div class="flex items-center gap-3 bg-white p-2.5 rounded-xl border shadow-sm transition-all hover:shadow-md" style="border-color:#f0f0f0;">
                                                        <img src="{{ $item->product->image_url }}" 
                                                             alt="{{ $item->product->nama_produk }}" 
                                                             class="w-12 h-12 rounded-lg object-cover flex-shrink-0 border"
                                                             style="border-color:#f0f7f0;">
                                                        <div class="flex-grow min-w-0">
                                                            <p class="font-bold text-sm text-stone-800 truncate">{{ $item->product->nama_produk }}</p>
                                                            <p class="text-[0.7rem] font-semibold text-stone-500 mt-0.5">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <span class="px-2.5 py-1 rounded-lg font-black text-xs" style="background:#f0f7f0; color:#2d8a2d;">x{{ $item->jumlah }}</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                {{-- Card Footer --}}
                                <div class="px-5 py-4 border-t flex flex-col sm:flex-row items-center gap-3" style="background:#fff; border-color:#f0f7f0;">
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', str_starts_with($order->no_whatsapp, '0') ? '62'.substr($order->no_whatsapp,1) : $order->no_whatsapp) }}" target="_blank" rel="noopener" class="w-full sm:w-auto flex-1 flex justify-center items-center gap-2 py-2.5 px-4 rounded-xl font-bold text-xs transition-colors" style="background:#f0f7f0; color:#2d8a2d; border:1px solid #d8ecd8;" onmouseover="this.style.background='#d8ecd8'" onmouseout="this.style.background='#f0f7f0'">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                        Chat
                                    </a>
                                    
                                    @if($order->status === 'confirmed')
                                        <form action="{{ route('dashboard.orders.ship', $order->id) }}" method="POST" class="w-full sm:w-auto flex-[2]" onsubmit="return confirm('Tandai pesanan ini sudah Anda kemas dan serahkan ke kurir / proses kirim?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="w-full text-center font-bold py-2.5 px-4 rounded-xl shadow-md transition-all duration-300 hover:-translate-y-0.5 text-xs flex items-center justify-center gap-2" style="background: linear-gradient(135deg, #0b2d0b, #2d8a2d); color: white;">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                                Proses & Kirim
                                            </button>
                                        </form>
                                    @elseif($order->status === 'shipped')
                                        <div class="w-full sm:w-auto flex-[2] flex justify-center items-center gap-2 py-2.5 px-4 rounded-xl font-bold text-xs" style="background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; cursor: default;">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Menunggu Konfirmasi Pembeli
                                        </div>
                                    @elseif($order->status === 'done')
                                        <div class="w-full sm:w-auto flex-[2] flex justify-center items-center gap-2 py-2.5 px-4 rounded-xl font-bold text-xs" style="background: rgba(77,163,77,0.1); color: #2d8a2d; border: 1px solid rgba(77,163,77,0.2); cursor: default;">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                            Pesanan Diterima
                                        </div>
                                        <form action="{{ route('dashboard.orders.archive', $order->id) }}" method="POST" class="w-full sm:w-auto flex-1" onsubmit="return confirm('Hapus data pesanan ini dari dashboard Anda?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full text-center font-bold py-2.5 px-4 rounded-xl transition-all duration-300 hover:-translate-y-0.5 text-xs flex items-center justify-center gap-2" style="background: rgba(220,38,38,0.1); color: #dc2626; border: 1px solid rgba(220,38,38,0.2);">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                Hapus Data
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ======================================================
                 STAT CARDS ROW
            ====================================================== --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                {{-- Total Produk --}}
                <div class="eco-stat-card">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                             style="background:rgba(45,138,45,0.12);">
                            <svg class="w-4 h-4" style="color:#2d8a2d" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                            </svg>
                        </div>
                        <span style="font-size:0.72rem; font-weight:600; color:#7dbf7d; letter-spacing:0.05em; text-transform:uppercase;">Total Produk</span>
                    </div>
                    <div class="eco-stat-number">{{ Auth::user()->products->count() }}</div>
                    <p style="font-size:0.72rem; color:#7dbf7d; margin-top:0.25rem;">produk terdaftar</p>
                </div>

                {{-- Total Stok --}}
                <div class="eco-stat-card">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                             style="background:rgba(30,110,30,0.1);">
                            <svg class="w-4 h-4" style="color:#1e6e1e" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <span style="font-size:0.72rem; font-weight:600; color:#4da34d; letter-spacing:0.05em; text-transform:uppercase;">Total Stok</span>
                    </div>
                    <div class="eco-stat-number">{{ Auth::user()->products->sum('stok') }}</div>
                    <p style="font-size:0.72rem; color:#7dbf7d; margin-top:0.25rem;">unit tersedia</p>
                </div>

                {{-- Nilai Inventori --}}
                <div class="eco-stat-card">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                             style="background:rgba(255,155,51,0.1);">
                            <svg class="w-4 h-4" style="color:#ff7c0a" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span style="font-size:0.72rem; font-weight:600; color:#ff9b33; letter-spacing:0.05em; text-transform:uppercase;">Nilai Inventori</span>
                    </div>
                    @php
                        $totalNilai = Auth::user()->products->sum(fn($p) => $p->harga * $p->stok);
                    @endphp
                    <div class="eco-stat-number" style="font-size:1.25rem;">
                        Rp {{ number_format($totalNilai, 0, ',', '.') }}
                    </div>
                    <p style="font-size:0.72rem; color:#7dbf7d; margin-top:0.25rem;">estimasi nilai stok</p>
                </div>

                {{-- Stok Rendah --}}
                @php $stokRendah = Auth::user()->products->where('stok', '<=', 10)->where('stok', '>', 0)->count(); @endphp
                <div class="eco-stat-card">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                             style="background:rgba(234,179,8,0.1);">
                            <svg class="w-4 h-4" style="color:#ca8a04" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <span style="font-size:0.72rem; font-weight:600; color:#ca8a04; letter-spacing:0.05em; text-transform:uppercase;">Stok Rendah</span>
                    </div>
                    <div class="eco-stat-number" style="{{ $stokRendah > 0 ? 'color:#854d0e' : 'color:#124012' }}">
                        {{ $stokRendah }}
                    </div>
                    <p style="font-size:0.72rem; color:#7dbf7d; margin-top:0.25rem;">perlu restok segera</p>
                </div>
            </div>

            {{-- ======================================================
                 MAIN CONTENT — 2 Column Layout
            ====================================================== --}}
            <div class="grid lg:grid-cols-5 gap-7">

                {{-- ==================== FORM CARD (3/5) ==================== --}}
                <div class="lg:col-span-3">
                    <div class="eco-card">

                        {{-- Card Header --}}
                        <div class="eco-card-header px-7 py-6 relative z-10">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                                     style="background:rgba(255,255,255,0.1); backdrop-filter:blur(8px);">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-white font-bold text-base tracking-tight">Upload Produk Baru</h3>
                                    <p style="color:rgba(255,255,255,0.55); font-size:0.75rem; margin-top:0.1rem;">
                                        Tambahkan produk ke etalase ECOutdoor Partner Hub
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Form --}}
                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"
                              class="p-7 space-y-5">
                            @csrf

                            {{-- Nama Produk --}}
                            <div>
                                <label for="nama_produk" class="eco-label">
                                    Nama Produk <span style="color:#dc2626;">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="nama_produk"
                                    name="nama_produk"
                                    value="{{ old('nama_produk') }}"
                                    placeholder="Contoh: Tenda Summit 4P"
                                    class="eco-input {{ $errors->has('nama_produk') ? 'eco-error' : '' }}"
                                />
                                @error('nama_produk')
                                    <p class="flex items-center gap-1 mt-1.5" style="color:#dc2626; font-size:0.75rem;">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Kategori Produk --}}
                            <div>
                                <label for="kategori" class="eco-label">
                                    Kategori Produk <span style="color:#dc2626;">*</span>
                                </label>
                                <select
                                    id="kategori"
                                    name="kategori"
                                    class="eco-input {{ $errors->has('kategori') ? 'eco-error' : '' }}"
                                >
                                    <option value="" disabled {{ old('kategori') ? '' : 'selected' }}>Pilih Kategori...</option>
                                    <option value="Tenda" {{ old('kategori') == 'Tenda' ? 'selected' : '' }}>Tenda</option>
                                    <option value="Tas & Carrier" {{ old('kategori') == 'Tas & Carrier' ? 'selected' : '' }}>Tas & Carrier</option>
                                    <option value="Alas Kaki" {{ old('kategori') == 'Alas Kaki' ? 'selected' : '' }}>Alas Kaki</option>
                                    <option value="Aksesoris" {{ old('kategori') == 'Aksesoris' ? 'selected' : '' }}>Aksesoris</option>
                                </select>
                                @error('kategori')
                                    <p class="flex items-center gap-1 mt-1.5" style="color:#dc2626; font-size:0.75rem;">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Deskripsi --}}
                            <div>
                                <label for="deskripsi" class="eco-label">
                                    Deskripsi Produk <span style="color:#dc2626;">*</span>
                                </label>
                                <textarea
                                    id="deskripsi"
                                    name="deskripsi"
                                    rows="4"
                                    placeholder="Jelaskan spesifikasi, keunggulan, bahan, dan detail produk kamu..."
                                    class="eco-input {{ $errors->has('deskripsi') ? 'eco-error' : '' }}"
                                    style="resize:none;"
                                >{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <p class="flex items-center gap-1 mt-1.5" style="color:#dc2626; font-size:0.75rem;">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Harga & Stok --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="harga" class="eco-label">
                                        Harga Barang Asli (Rp) <span style="color:#dc2626;">*</span>
                                    </label>
                                    <p style="font-size:0.72rem; color:#7dbf7d; margin-bottom:0.4rem; line-height:1.2;">
                                        *Sistem akan otomatis menambah Rp 10.000 ke harga akhir sebagai subsidi Gratis Ongkir.
                                    </p>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none"
                                              style="color:#7dbf7d; font-size:0.8rem; font-weight:700;">Rp</span>
                                        <input
                                            type="number"
                                            id="harga"
                                            name="harga"
                                            value="{{ old('harga') }}"
                                            min="0"
                                            step="1000"
                                            placeholder="500000"
                                            class="eco-input {{ $errors->has('harga') ? 'eco-error' : '' }}"
                                            style="padding-left: 2.25rem;"
                                        />
                                    </div>
                                    @error('harga')
                                        <p class="flex items-center gap-1 mt-1.5" style="color:#dc2626; font-size:0.75rem;">
                                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="stok" class="eco-label">
                                        Stok (Unit) <span style="color:#dc2626;">*</span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                            <svg class="w-4 h-4" style="color:#7dbf7d" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                                            </svg>
                                        </span>
                                        <input
                                            type="number"
                                            id="stok"
                                            name="stok"
                                            value="{{ old('stok') }}"
                                            min="0"
                                            placeholder="100"
                                            class="eco-input {{ $errors->has('stok') ? 'eco-error' : '' }}"
                                            style="padding-left: 2.25rem;"
                                        />
                                    </div>
                                    @error('stok')
                                        <p class="flex items-center gap-1 mt-1.5" style="color:#dc2626; font-size:0.75rem;">
                                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Upload Gambar --}}
                            <div>
                                <label for="gambar" class="eco-label">
                                    Foto Produk <span style="color:#dc2626;">*</span>
                                </label>
                                <label for="gambar"
                                       class="eco-dropzone {{ $errors->has('gambar') ? 'eco-error' : '' }}"
                                       id="dropzone-label">
                                    <div id="upload-placeholder" class="flex flex-col items-center gap-2.5 p-6 text-center">
                                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center"
                                             style="background:rgba(45,138,45,0.09);">
                                            <svg class="w-7 h-7" style="color:#4da34d" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p style="font-size:0.875rem; font-weight:600; color:#175517;">
                                                Klik atau Drag & Drop foto produk
                                            </p>
                                            <p style="font-size:0.72rem; color:#7dbf7d; margin-top:0.2rem;">
                                                PNG, JPG, JPEG, WEBP — Maks. 2 MB
                                            </p>
                                        </div>
                                    </div>
                                    <div id="file-preview" class="hidden flex-col items-center gap-2 p-6 text-center">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                                             style="background:rgba(45,138,45,0.12);">
                                            <svg class="w-5 h-5" style="color:#2d8a2d" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <p id="file-name-display" style="font-size:0.8rem; font-weight:600; color:#175517;"></p>
                                        <p style="font-size:0.7rem; color:#7dbf7d;">Klik untuk ganti gambar</p>
                                    </div>
                                    <input
                                        type="file"
                                        id="gambar"
                                        name="gambar"
                                        accept="image/png,image/jpeg,image/jpg,image/webp"
                                        class="hidden"
                                        onchange="showFileName(this)"
                                    />
                                </label>
                                @error('gambar')
                                    <p class="flex items-center gap-1 mt-1.5" style="color:#dc2626; font-size:0.75rem;">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Submit --}}
                            <div class="flex items-center justify-between pt-2" style="border-top:1px solid #f0f7f0; margin-top: 1.5rem; padding-top: 1.5rem;">
                                <p style="font-size:0.72rem; color:#7dbf7d;">
                                    <span style="color:#dc2626;">*</span> Semua field wajib diisi
                                </p>
                                <button type="submit" class="eco-btn-primary">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                    </svg>
                                    Upload Produk
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- ==================== TIPS CARD (2/5) ==================== --}}
                <div class="lg:col-span-2 flex flex-col gap-5">

                    {{-- Tips Panel --}}
                    <div class="eco-card">
                        <div class="px-5 py-5 border-b" style="border-color:#f0f7f0;">
                            <h4 class="font-bold text-sm flex items-center gap-2" style="color:#0b2d0b;">
                                <svg class="w-4 h-4" style="color:#ff7c0a" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                Tips Upload Produk
                            </h4>
                        </div>
                        <div class="px-5 py-4 space-y-3">
                            @foreach([
                                ['🏷️', 'Nama Produk', 'Gunakan nama yang jelas dan spesifik agar mudah ditemukan pembeli.'],
                                ['📝', 'Deskripsi', 'Sertakan bahan, ukuran, warna, dan keunggulan produk.'],
                                ['💰', 'Harga', 'Riset harga pasar untuk daya saing yang optimal.'],
                                ['🖼️', 'Foto', 'Gunakan foto resolusi tinggi dengan latar bersih.'],
                            ] as [$icon, $title, $desc])
                            <div class="flex gap-3 items-start">
                                <span class="text-lg flex-shrink-0 mt-0.5">{{ $icon }}</span>
                                <div>
                                    <p style="font-size:0.8rem; font-weight:600; color:#175517;">{{ $title }}</p>
                                    <p style="font-size:0.72rem; color:#7dbf7d; margin-top:0.1rem; line-height:1.5;">{{ $desc }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Partner Badge --}}
                    <div class="eco-card" style="background: linear-gradient(135deg, #0b2d0b, #175517);">
                        <div class="p-6 text-center">
                            <img src="{{ asset('images/image_1.png') }}" alt="ECOutdoor Logo" class="w-14 h-14 object-contain rounded-2xl mx-auto mb-4 drop-shadow-md" style="background:white; padding: 4px;" />
                            <p style="color:rgba(255,255,255,0.5); font-size:0.7rem; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; margin-bottom:0.5rem;">
                                ECOutdoor Partner
                            </p>
                            <p class="text-white font-bold text-base">{{ Auth::user()->name }}</p>
                            <p style="color:rgba(255,255,255,0.45); font-size:0.72rem; margin-top:0.25rem;">{{ Auth::user()->email }}</p>
                            <div class="mt-4 pt-4" style="border-top:1px solid rgba(255,255,255,0.1);">
                                <div class="flex justify-center gap-6">
                                    <div class="text-center">
                                        <p class="text-white font-bold text-lg">{{ Auth::user()->products->count() }}</p>
                                        <p style="color:rgba(255,255,255,0.4); font-size:0.65rem;">Produk</p>
                                    </div>
                                    <div style="width:1px; background:rgba(255,255,255,0.1);"></div>
                                    <div class="text-center">
                                        <p class="text-white font-bold text-lg">{{ Auth::user()->products->sum('stok') }}</p>
                                        <p style="color:rgba(255,255,255,0.4); font-size:0.65rem;">Total Stok</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ======================================================
                 PRODUK SAYA TABLE
            ====================================================== --}}
            <div class="eco-card">
                {{-- Table Header --}}
                <div class="flex items-center justify-between px-6 py-5">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center"
                             style="background:#f0f7f0; border:1px solid #d8ecd8;">
                            <svg class="w-4 h-4" style="color:#2d8a2d" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold" style="color:#0b2d0b; font-size:0.9375rem;">Produk Saya</h3>
                            <p style="color:#7dbf7d; font-size:0.72rem; margin-top:0.1rem;">
                                {{ Auth::user()->products->count() }} produk · diurutkan terbaru
                            </p>
                        </div>
                    </div>

                    @if(Auth::user()->products->isNotEmpty())
                        <span class="px-3 py-1 rounded-full text-xs font-semibold"
                              style="background:#f0f7f0; color:#175517; border:1px solid #d8ecd8;">
                            ✅ Aktif Berjualan
                        </span>
                    @endif
                </div>

                <hr class="eco-divider">

                @if(Auth::user()->products->isEmpty())
                    {{-- Empty state --}}
                    <div class="py-20 flex flex-col items-center text-center px-8">
                        <div class="w-20 h-20 rounded-3xl flex items-center justify-center mb-5"
                             style="background:#f0f7f0; border:2px dashed #b3d9b3;">
                            <svg class="w-10 h-10" style="color:#b3d9b3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                            </svg>
                        </div>
                        <h4 class="font-bold mb-2" style="color:#0b2d0b; font-size:0.9375rem;">Etalase masih kosong</h4>
                        <p style="color:#7dbf7d; font-size:0.8rem; max-width:280px; line-height:1.6;">
                            Upload produk pertamamu sekarang dan mulai berjualan di ECOutdoor Partner Hub!
                        </p>
                    </div>
                @else
                    <div style="overflow-x:auto;">
                        <table class="eco-table">
                            <thead>
                                <tr>
                                    <th style="width:70px;">Foto</th>
                                    <th>Nama & Deskripsi</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Nilai Stok</th>
                                    <th>Tgl Upload</th>
                                    <th style="width:120px; text-align:center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(Auth::user()->products->sortByDesc('created_at') as $product)
                                <tr>
                                    <td>
                                        <div class="eco-thumb">
                                            <img src="{{ $product->image_url }}"
                                                 alt="{{ $product->nama_produk }}" />
                                        </div>
                                    </td>
                                    <td>
                                        <p style="font-weight:600; color:#0b2d0b; font-size:0.875rem;">
                                            {{ $product->nama_produk }}
                                        </p>
                                        <p style="color:#7dbf7d; font-size:0.72rem; margin-top:0.2rem; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                                            {{ $product->deskripsi }}
                                        </p>
                                    </td>
                                    <td>
                                        <span style="font-weight:700; color:#175517; font-size:0.875rem; white-space:nowrap;">
                                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($product->stok === 0)
                                            <span class="eco-badge-empty">Habis</span>
                                        @elseif($product->stok <= 10)
                                            <span class="eco-badge-low">{{ $product->stok }} unit</span>
                                        @else
                                            <span class="eco-badge-ok">{{ $product->stok }} unit</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span style="font-size:0.8rem; color:#4da34d; font-weight:600; white-space:nowrap;">
                                            Rp {{ number_format($product->harga * $product->stok, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>
                                            <p style="font-size:0.8rem; color:#175517; font-weight:500;">
                                                {{ $product->created_at->format('d M Y') }}
                                            </p>
                                            <p style="font-size:0.68rem; color:#7dbf7d; margin-top:0.1rem;">
                                                {{ $product->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </td>

                                    {{-- Kolom Aksi --}}
                                    <td style="text-align:center;">
                                        <div class="flex items-center justify-center gap-2">
                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('products.edit', $product) }}"
                                               title="Edit produk"
                                               style="display:inline-flex; align-items:center; gap:0.3rem; padding:0.3rem 0.75rem; border-radius:0.5rem; font-size:0.72rem; font-weight:600; background:linear-gradient(135deg,#ff9b33,#ff7c0a); color:#ffffff; text-decoration:none; transition:all 0.2s; white-space:nowrap;"
                                               onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(255,124,10,0.4)';"
                                               onmouseout="this.style.transform=''; this.style.boxShadow='';">
                                                <svg style="width:0.8rem;height:0.8rem;flex-shrink:0;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                </svg>
                                                Edit
                                            </a>

                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('products.destroy', $product) }}" method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus produk &quot;{{ addslashes($product->nama_produk) }}&quot;? Tindakan ini tidak dapat dibatalkan.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        title="Hapus produk"
                                                        style="display:inline-flex; align-items:center; gap:0.3rem; padding:0.3rem 0.75rem; border-radius:0.5rem; font-size:0.72rem; font-weight:600; background:linear-gradient(135deg,#f87171,#dc2626); color:#ffffff; border:none; cursor:pointer; transition:all 0.2s; white-space:nowrap;"
                                                        onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(220,38,38,0.4)';"
                                                        onmouseout="this.style.transform=''; this.style.boxShadow='';">
                                                    <svg style="width:0.8rem;height:0.8rem;flex-shrink:0;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Table Footer --}}
                    <div class="px-6 py-4 flex items-center justify-between"
                         style="border-top:1px solid #f0f7f0; background:#fafcfa;">
                        <p style="font-size:0.75rem; color:#7dbf7d;">
                            Menampilkan <strong style="color:#175517;">{{ Auth::user()->products->count() }}</strong> produk
                        </p>
                        <p style="font-size:0.75rem; color:#175517; font-weight:600;">
                            Total Nilai Inventori: Rp {{ number_format(Auth::user()->products->sum(fn($p) => $p->harga * $p->stok), 0, ',', '.') }}
                        </p>
                    </div>
                @endif
            </div>

        </div>
    </div>

    {{-- ======================================================
         JAVASCRIPT
    ====================================================== --}}
    <script>
        // Tampilkan nama file setelah dipilih
        function showFileName(input) {
            const placeholder = document.getElementById('upload-placeholder');
            const preview     = document.getElementById('file-preview');
            const nameDisplay = document.getElementById('file-name-display');
            if (input.files && input.files[0]) {
                placeholder.classList.add('hidden');
                preview.classList.remove('hidden');
                preview.classList.add('flex');
                nameDisplay.textContent = input.files[0].name;
            }
        }

        // Drag and Drop Logic
        const dropzone = document.getElementById('dropzone-label');
        const fileInput = document.getElementById('gambar');

        if (dropzone && fileInput) {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropzone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                dropzone.style.borderColor = '#2d8a2d';
                dropzone.style.backgroundColor = 'rgba(45,138,45,0.05)';
            }

            function unhighlight(e) {
                dropzone.style.borderColor = '';
                dropzone.style.backgroundColor = '';
            }

            dropzone.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                
                if (files && files.length > 0) {
                    fileInput.files = files;
                    showFileName(fileInput);
                }
            }
        }

        // Auto-dismiss flash success setelah 5 detik
        setTimeout(() => {
            const flash = document.getElementById('flash-success');
            if (flash) {
                flash.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                flash.style.opacity = '0';
                flash.style.transform = 'translateY(-8px)';
                setTimeout(() => flash.remove(), 600);
            }
        }, 5000);
    </script>
</x-app-layout>
