<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register Penjual — ECOutdoor</title>
  <link rel="icon" type="image/png" href="{{ asset('images/image_1.png') }}">
  <meta name="description" content="Daftar akun penjual ECOutdoor." />
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
            fadeUp:  { '0%':{ opacity:'0', transform:'translateY(24px)' }, '100%':{ opacity:'1', transform:'translateY(0)' } },
            float:   { '0%, 100%': { transform:'translateY(0)' }, '50%': { transform:'translateY(-10px)' } }
          },
          animation: {
            'fade-up': 'fadeUp 0.6s ease-out both',
            'float':   'float 4s ease-in-out infinite',
          },
        },
      },
    };
  </script>
  <style>
    * { box-sizing: border-box; }
    body {
      font-family: 'Outfit', sans-serif;
      background: radial-gradient(ellipse at top left, #0b2d0b 0%, #1f1e1b 60%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
      position: relative;
      overflow: hidden;
    }

    /* Ambient Glows */
    body::before {
      content: '';
      position: absolute;
      top: -10%; left: -5%;
      width: 400px; height: 400px;
      background: radial-gradient(circle, rgba(77,163,77,0.15) 0%, transparent 60%);
      pointer-events: none;
      border-radius: 50%;
    }
    body::after {
      content: '';
      position: absolute;
      bottom: -15%; right: -5%;
      width: 500px; height: 500px;
      background: radial-gradient(circle, rgba(255,124,10,0.1) 0%, transparent 60%);
      pointer-events: none;
      border-radius: 50%;
    }

    .glass-card {
      background: linear-gradient(160deg, rgba(30,35,30,0.85) 0%, rgba(20,25,20,0.95) 100%);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(77,163,77,0.25);
      border-radius: 1.75rem;
      box-shadow: 0 40px 80px rgba(0,0,0,0.6), inset 0 1px 0 rgba(255,255,255,0.1);
      max-height: 95vh;
      overflow-y: auto;
      z-index: 10;
    }

    /* Custom Scrollbar */
    .glass-card::-webkit-scrollbar { width: 6px; }
    .glass-card::-webkit-scrollbar-track { background: rgba(0,0,0,0.2); border-radius: 8px; }
    .glass-card::-webkit-scrollbar-thumb { background: rgba(77,163,77,0.4); border-radius: 8px; }

    /* Modern Inputs */
    .input-wrap { position: relative; }
    .input-icon {
      position: absolute;
      left: 1.1rem;
      top: 50%;
      transform: translateY(-50%);
      color: rgba(145,142,132,0.6);
      transition: color 0.3s;
      pointer-events: none;
    }
    .input-field {
      width: 100%;
      background: rgba(255,255,255,0.03);
      border: 1.5px solid rgba(77,163,77,0.15);
      border-radius: 1rem;
      padding: 0.9rem 1rem 0.9rem 3rem;
      color: #e7e6e2;
      font-size: 0.9rem;
      font-weight: 500;
      transition: all 0.3s;
      outline: none;
    }
    .input-field::placeholder { color: rgba(145,142,132,0.5); font-weight: 400; }
    .input-field:focus {
      background: rgba(255,255,255,0.06);
      border-color: rgba(77,163,77,0.6);
      box-shadow: 0 0 0 4px rgba(77,163,77,0.1);
    }
    .input-field:focus + .input-icon { color: #4da34d; }
    
    .input-field:-webkit-autofill {
      -webkit-box-shadow: 0 0 0 30px #1a1f1a inset !important;
      -webkit-text-fill-color: #e7e6e2 !important;
    }

    .btn-submit {
      width: 100%;
      background: linear-gradient(135deg, #2d8a2d, #1e6e1e);
      border: 1px solid rgba(77,163,77,0.5);
      border-radius: 1rem;
      padding: 1rem 1.5rem;
      color: white;
      font-size: 0.95rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 8px 24px rgba(45,138,45,0.3), inset 0 1px 0 rgba(255,255,255,0.2);
    }
    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 32px rgba(45,138,45,0.4), inset 0 1px 0 rgba(255,255,255,0.2);
      background: linear-gradient(135deg, #329932, #217a21);
    }
    .btn-submit:active { transform: translateY(0); }

    /* Eye toggle password */
    .eye-btn {
      position: absolute;
      right: 1rem;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      color: rgba(145,142,132,0.6);
      transition: color 0.2s;
      padding: 0.2rem;
    }
    .eye-btn:hover { color: #4da34d; }
  </style>
</head>
<body>

  <!-- Floating Elements -->
  <div class="absolute w-24 h-24 rounded-3xl bg-forest-500/10 blur-xl top-10 left-10 animate-float"></div>
  <div class="absolute w-32 h-32 rounded-full bg-adventure-500/10 blur-xl bottom-10 right-10 animate-float" style="animation-delay: 2s;"></div>

  <div class="glass-card w-full max-w-[28rem] px-8 sm:px-10 py-12 animate-fade-up">

    <!-- Logo & Header -->
    <div class="text-center mb-8">
      <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl mb-4" style="background:rgba(255,255,255,0.03); border:1px solid rgba(77,163,77,0.2); box-shadow:0 8px 32px rgba(0,0,0,0.3);">
        <a href="{{ url('/') }}">
          <img src="{{ asset('images/image_1.png') }}" alt="ECOutdoor Logo" class="h-12 w-auto object-contain hover:scale-110 transition-transform duration-300" />
        </a>
      </div>
      <h1 class="font-playfair text-3xl font-bold text-white mb-2">
        Buat Akun Penjual
      </h1>
      <p class="text-stone-400 text-sm">
        Daftar dan mulai berjualan perlengkapan outdoor 🏕️
      </p>
    </div>

    <!-- Error message -->
    @if($errors->any())
      <div class="mb-6 px-5 py-4 rounded-xl flex items-start gap-3" style="background:rgba(220,38,38,0.1); border:1px solid rgba(220,38,38,0.3);">
        <span class="text-lg flex-shrink-0">⚠️</span>
        <ul class="text-sm text-red-300 space-y-1">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <!-- Register Form -->
    <form method="POST" action="{{ route('register') }}" id="register-form" class="space-y-5">
      @csrf

      <!-- Name -->
      <div>
        <label for="name" class="block text-xs font-bold mb-2 tracking-wider" style="color:#7dbf7d;">NAMA LENGKAP</label>
        <div class="input-wrap">
          <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Nama Lengkap Anda" class="input-field" />
          <svg class="w-5 h-5 input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
      </div>

      <!-- Email -->
      <div>
        <label for="email" class="block text-xs font-bold mb-2 tracking-wider" style="color:#7dbf7d;">EMAIL</label>
        <div class="input-wrap">
          <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="email@anda.com" class="input-field" />
          <svg class="w-5 h-5 input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
      </div>

      <!-- WhatsApp Number -->
      <div>
        <label for="no_whatsapp" class="block text-xs font-bold mb-2 tracking-wider" style="color:#7dbf7d;">NOMOR WHATSAPP</label>
        <div class="input-wrap">
          <input id="no_whatsapp" type="tel" name="no_whatsapp" value="{{ old('no_whatsapp') }}" required autocomplete="tel" placeholder="Contoh: 081234567890" class="input-field" />
          <svg class="w-5 h-5 input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
        </div>
      </div>

      <!-- Password -->
      <div>
        <label for="password" class="block text-xs font-bold mb-2 tracking-wider" style="color:#7dbf7d;">PASSWORD</label>
        <div class="input-wrap">
          <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" class="input-field" style="padding-right:3rem;" />
          <svg class="w-5 h-5 input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
          <button type="button" class="eye-btn" onclick="togglePassword('password', 'eye-icon-1')" title="Tampilkan password">
            <svg id="eye-icon-1" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
          </button>
        </div>
      </div>

      <!-- Confirm Password -->
      <div class="pb-2">
        <label for="password_confirmation" class="block text-xs font-bold mb-2 tracking-wider" style="color:#7dbf7d;">KONFIRMASI PASSWORD</label>
        <div class="input-wrap">
          <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" class="input-field" style="padding-right:3rem;" />
          <svg class="w-5 h-5 input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
          <button type="button" class="eye-btn" onclick="togglePassword('password_confirmation', 'eye-icon-2')" title="Tampilkan password">
            <svg id="eye-icon-2" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
          </button>
        </div>
      </div>

      <!-- Submit -->
      <button type="submit" class="btn-submit" id="btn-submit">
        <span id="btn-text">🚀 Daftar Sekarang</span>
      </button>

      <!-- Login link -->
      <div class="mt-6 text-center text-sm">
        <span class="text-stone-500">Sudah punya akun?</span>
        <a href="{{ route('login') }}" class="font-bold ml-1 transition-colors hover:underline" style="color:#7dbf7d;" onmouseover="this.style.color='#b3d9b3'" onmouseout="this.style.color='#7dbf7d'">
          Masuk di sini
        </a>
      </div>
    </form>

    <!-- Footer -->
    <div class="mt-8 pt-6 border-t" style="border-color:rgba(77,163,77,0.1);">
      <a href="{{ url('/') }}" class="flex items-center justify-center gap-2 text-sm font-medium transition-colors" style="color:rgba(145,142,132,0.8);" onmouseover="this.style.color='#4da34d'" onmouseout="this.style.color='rgba(145,142,132,0.8)'">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Beranda
      </a>
    </div>

  </div>

  <script>
    function togglePassword(inputId, iconId) {
      const input = document.getElementById(inputId);
      const icon  = document.getElementById(iconId);
      const isHidden = input.type === 'password';
      input.type = isHidden ? 'text' : 'password';
      icon.innerHTML = isHidden
        ? `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`
        : `<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
    }

    document.getElementById('register-form').addEventListener('submit', function() {
      const btn  = document.getElementById('btn-submit');
      const text = document.getElementById('btn-text');
      btn.disabled = true;
      btn.style.opacity = '0.8';
      text.textContent = '⏳ Memproses...';
    });
  </script>
</body>
</html>
