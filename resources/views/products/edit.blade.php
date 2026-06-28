<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            {{-- Brand + Title --}}
            <div class="flex items-center gap-4">
                <div class="relative">
                    <div class="w-11 h-11 rounded-2xl flex items-center justify-center shadow-lg"
                         style="background: linear-gradient(135deg, #0b2d0b, #2d8a2d);">
                        <svg class="w-6 h-6" style="color:#ff9b33" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17 8C8 10 5.9 16.17 3.82 21H5.88C6.73 19 7.86 17.4 9.19 16.05C10.86 17.32 12.73 18 15 18H21V16C19.3 16 17.84 15.53 16.57 14.7C17.13 13.2 17.66 11.45 18 9L17 8ZM5 6L3 8C5 10.7 7.07 13.07 9.19 15.08C10.24 13.97 11.56 13 13.18 12.26C11.34 11.1 9.24 10 7 9L5 6Z"/>
                        </svg>
                    </div>
                    <span class="absolute -top-1 -right-1 w-3 h-3 rounded-full border-2 border-white"
                          style="background:#2d8a2d;"></span>
                </div>
                <div>
                    <h2 class="text-xl font-bold tracking-tight" style="color:#0b2d0b;">
                        ECOutdoor <span style="color:#2d8a2d;">Partner Hub</span>
                    </h2>
                    <p class="text-xs mt-0.5" style="color:#7dbf7d;">
                        Edit Produk — <strong style="color:#175517;">{{ $product->nama_produk }}</strong>
                    </p>
                </div>
            </div>

            {{-- Back button --}}
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold transition-all duration-200"
               style="background:#f0f7f0; border:1px solid #d8ecd8; color:#175517;"
               onmouseover="this.style.background='#d8ecd8'"
               onmouseout="this.style.background='#f0f7f0'">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="partner-hub-bg py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-7">

            {{-- Flash / Error messages --}}
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

            {{-- Main 2-column layout --}}
            <div class="grid lg:grid-cols-5 gap-7">

                {{-- ==================== FORM EDIT (3/5) ==================== --}}
                <div class="lg:col-span-3">
                    <div class="eco-card">

                        {{-- Card Header --}}
                        <div class="eco-card-header px-7 py-6 relative z-10">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                                     style="background:rgba(255,255,255,0.1); backdrop-filter:blur(8px);">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-white font-bold text-base tracking-tight">Edit Produk</h3>
                                    <p style="color:rgba(255,255,255,0.55); font-size:0.75rem; margin-top:0.1rem;">
                                        Perbarui informasi produk di etalase ECOutdoor Partner Hub
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Form --}}
                        <form action="{{ route('products.update', $product) }}" method="POST"
                              enctype="multipart/form-data" class="p-7 space-y-5">
                            @csrf
                            @method('PUT')

                            {{-- Nama Produk --}}
                            <div>
                                <label for="nama_produk" class="eco-label">
                                    Nama Produk <span style="color:#dc2626;">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="nama_produk"
                                    name="nama_produk"
                                    value="{{ old('nama_produk', $product->nama_produk) }}"
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
                                    <option value="" disabled {{ old('kategori', $product->kategori) ? '' : 'selected' }}>Pilih Kategori...</option>
                                    <option value="Tenda" {{ old('kategori', $product->kategori) == 'Tenda' ? 'selected' : '' }}>Tenda</option>
                                    <option value="Tas & Carrier" {{ old('kategori', $product->kategori) == 'Tas & Carrier' ? 'selected' : '' }}>Tas & Carrier</option>
                                    <option value="Alas Kaki" {{ old('kategori', $product->kategori) == 'Alas Kaki' ? 'selected' : '' }}>Alas Kaki</option>
                                    <option value="Aksesoris" {{ old('kategori', $product->kategori) == 'Aksesoris' ? 'selected' : '' }}>Aksesoris</option>
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
                                >{{ old('deskripsi', $product->deskripsi) }}</textarea>
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
                                            value="{{ old('harga', max(0, $product->harga - 10000)) }}"
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
                                            value="{{ old('stok', $product->stok) }}"
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

                            {{-- Foto Produk (opsional saat edit) --}}
                            <div>
                                <label class="eco-label">
                                    Foto Produk
                                    <span style="color:#7dbf7d; font-weight:400; font-size:0.72rem;">(opsional — kosongkan untuk pakai foto saat ini)</span>
                                </label>

                                {{-- Preview gambar saat ini --}}
                                <div class="flex items-center gap-4 mb-3 p-3 rounded-xl" style="background:#f0f7f0; border:1px solid #d8ecd8;">
                                    <img src="{{ $product->image_url }}"
                                         alt="{{ $product->nama_produk }}"
                                         class="w-16 h-16 object-cover rounded-lg"
                                         style="border:1.5px solid #b3d9b3;" />
                                    <div>
                                        <p style="font-size:0.78rem; font-weight:600; color:#175517;">Foto saat ini</p>
                                        <p style="font-size:0.68rem; color:#7dbf7d; margin-top:0.15rem;">{{ $product->nama_file_gambar }}</p>
                                        <p style="font-size:0.68rem; color:#4da34d; margin-top:0.25rem;">Upload foto baru di bawah untuk menggantinya</p>
                                    </div>
                                </div>

                                {{-- Dropzone upload baru --}}
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
                                                Klik untuk pilih foto baru
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

                            {{-- Submit & Cancel --}}
                            <div class="flex items-center justify-between pt-2"
                                 style="border-top:1px solid #f0f7f0; margin-top:1.5rem; padding-top:1.5rem;">
                                <a href="{{ route('dashboard') }}"
                                   style="font-size:0.8rem; color:#7dbf7d; font-weight:500; text-decoration:none;"
                                   onmouseover="this.style.color='#175517'"
                                   onmouseout="this.style.color='#7dbf7d'">
                                    ← Batal, kembali ke dashboard
                                </a>
                                <button type="submit" class="eco-btn-primary">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- ==================== INFO CARD (2/5) ==================== --}}
                <div class="lg:col-span-2 flex flex-col gap-5">

                    {{-- Info produk saat ini --}}
                    <div class="eco-card">
                        <div class="px-5 py-5 border-b" style="border-color:#f0f7f0;">
                            <h4 class="font-bold text-sm flex items-center gap-2" style="color:#0b2d0b;">
                                <svg class="w-4 h-4" style="color:#2d8a2d" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Informasi Produk Saat Ini
                            </h4>
                        </div>
                        <div class="px-5 py-4 space-y-3">
                            @foreach([
                                ['📦', 'ID Produk', '#' . $product->id],
                                ['📅', 'Diupload', $product->created_at->format('d M Y')],
                                ['🔄', 'Terakhir diubah', $product->updated_at->diffForHumans()],
                                ['💰', 'Harga saat ini', 'Rp ' . number_format($product->harga, 0, ',', '.')],
                                ['📊', 'Stok saat ini', $product->stok . ' unit'],
                            ] as [$icon, $label, $value])
                            <div class="flex justify-between items-center">
                                <span style="font-size:0.78rem; color:#7dbf7d; display:flex; align-items:center; gap:0.4rem;">
                                    <span>{{ $icon }}</span> {{ $label }}
                                </span>
                                <span style="font-size:0.78rem; font-weight:600; color:#175517;">{{ $value }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Tips --}}
                    <div class="eco-card">
                        <div class="px-5 py-5 border-b" style="border-color:#f0f7f0;">
                            <h4 class="font-bold text-sm flex items-center gap-2" style="color:#0b2d0b;">
                                <svg class="w-4 h-4" style="color:#ff7c0a" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                Tips Edit Produk
                            </h4>
                        </div>
                        <div class="px-5 py-4 space-y-3">
                            @foreach([
                                ['🖼️', 'Foto Opsional', 'Biarkan kosong jika tidak ingin mengganti foto produk.'],
                                ['✏️', 'Nama Produk', 'Perubahan nama akan mempengaruhi nama file gambar baru.'],
                                ['💰', 'Update Harga', 'Harga baru akan langsung tampil di katalog pembeli.'],
                                ['📊', 'Update Stok', 'Perbarui stok secara rutin agar tidak terjadi overselling.'],
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
                </div>

            </div>
        </div>
    </div>

    <script>
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
    </script>
</x-app-layout>
