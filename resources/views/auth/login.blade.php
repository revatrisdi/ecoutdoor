<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login — ECOutdoor</title>
  <link rel="icon" type="image/png" href="{{ asset('images/image_1.png') }}">
  <meta name="description" content="Login ke akun ECOutdoor untuk mengakses dashboard." />
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
            shimmer: { '0%':{ backgroundPosition:'200% center' }, '100%':{ backgroundPosition:'-200% center' } },
          },
          animation: {
            'fade-up': 'fadeUp 0.6s ease-out both',
            shimmer:   'shimmer 3s linear infinite',
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

    /* Decorative blobs */
    body::before {
      content: '';
      position: fixed;
      top: -20%;
      right: -10%;
      width: 500px;
      height: 500px;
      background: radial-gradient(circle, rgba(45,138,45,0.12) 0%, transparent 70%);
      pointer-events: none;
    }
    body::after {
      content: '';
      position: fixed;
      bottom: -15%;
      left: -10%;
      width: 400px;
      height: 400px;
      background: radial-gradient(circle, rgba(255,124,10,0.07) 0%, transparent 70%);
      pointer-events: none;
    }

    .glass-card {
      background: rgba(22, 28, 22, 0.88);
      backdrop-filter: blur(24px);
      -webkit-backdrop-filter: blur(24px);
      border: 1px solid rgba(77,163,77,0.2);
      border-radius: 1.5rem;
      box-shadow: 0 32px 64px rgba(0,0,0,0.5), 0 0 0 1px rgba(77,163,77,0.05);
    }

    .input-field {
      width: 100%;
      background: rgba(11,45,11,0.35);
      border: 1.5px solid rgba(77,163,77,0.2);
      border-radius: 0.75rem;
      padding: 0.8rem 1rem;
      color: #e7e6e2;
      font-size: 0.9rem;
      font-family: 'Outfit', sans-serif;
      transition: border-color 0.2s, box-shadow 0.2s;
      outline: none;
    }
    .input-field::placeholder { color: rgba(120,116,105,0.7); }
    .input-field:focus {
      border-color: rgba(77,163,77,0.5);
      box-shadow: 0 0 0 3px rgba(45,138,45,0.12);
    }
    .input-field:autofill,
    .input-field:-webkit-autofill {
      -webkit-box-shadow: 0 0 0 30px rgba(11,45,11,0.9) inset !important;
      -webkit-text-fill-color: #e7e6e2 !important;
    }

    .btn-login {
      width: 100%;
      background: linear-gradient(135deg, #2d8a2d, #1e6e1e);
      border: none;
      border-radius: 0.85rem;
      padding: 0.9rem 1.5rem;
      color: white;
      font-size: 0.95rem;
      font-weight: 700;
      font-family: 'Outfit', sans-serif;
      cursor: pointer;
      transition: all 0.2s;
      box-shadow: 0 6px 20px rgba(45,138,45,0.3);
      position: relative;
      overflow: hidden;
    }
    .btn-login::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.06), transparent);
      transform: translateX(-100%);
      transition: transform 0.5s;
    }
    .btn-login:hover::before { transform: translateX(100%); }
    .btn-login:hover {
      transform: translateY(-1px);
      box-shadow: 0 10px 28px rgba(45,138,45,0.4);
    }
    .btn-login:active { transform: translateY(0); }

    /* Floating leaves decoration */
    .leaf {
      position: fixed;
      opacity: 0.04;
      pointer-events: none;
      font-size: 5rem;
    }
    .leaf-1 { top: 10%; left: 5%;  transform: rotate(-20deg); font-size: 4rem; }
    .leaf-2 { top: 70%; right: 5%; transform: rotate(15deg);  font-size: 6rem; }
    .leaf-3 { top: 40%; left: 2%;  transform: rotate(30deg);  font-size: 3rem; }

    .error-box {
      background: rgba(220,38,38,0.1);
      border: 1px solid rgba(220,38,38,0.3);
      border-radius: 0.75rem;
      padding: 0.75rem 1rem;
      color: #fca5a5;
      font-size: 0.82rem;
    }
    .success-box {
      background: rgba(45,138,45,0.1);
      border: 1px solid rgba(77,163,77,0.3);
      border-radius: 0.75rem;
      padding: 0.75rem 1rem;
      color: #86efac;
      font-size: 0.82rem;
    }

    /* Eye toggle password */
    .input-wrap { position: relative; }
    .eye-btn {
      position: absolute;
      right: 0.85rem;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      color: rgba(120,116,105,0.7);
      transition: color 0.2s;
      padding: 0.2rem;
    }
    .eye-btn:hover { color: #4da34d; }
  </style>
</head>
<body>
  <!-- Decorative leaves -->
  <span class="leaf leaf-1">🌿</span>
  <span class="leaf leaf-2">🍃</span>
  <span class="leaf leaf-3">🌱</span>

  <div class="glass-card w-full max-w-md px-8 py-10 animate-fade-up">

    <!-- Logo & Brand -->
    <div class="text-center mb-8">
      <a href="{{ url('/') }}" class="inline-block group">
        <img src="{{ asset('images/image_1.png') }}"
             alt="ECOutdoor Logo"
             class="h-16 w-auto mx-auto object-contain group-hover:scale-105 transition-transform duration-300" />
      </a>
      <h1 class="font-playfair text-2xl font-bold text-white mt-3 mb-1">
        Selamat Datang
      </h1>
      <p class="text-stone-500 text-sm">
        Login untuk mengakses dashboard ECOutdoor
      </p>
      <div class="inline-flex items-center gap-1.5 mt-2.5 px-3 py-1 rounded-full text-xs font-medium"
           style="background:rgba(77,163,77,0.1); border:1px solid rgba(77,163,77,0.2); color:#7dbf7d;">
        🔐 Khusus Admin & Penjual
      </div>
    </div>

    <!-- Session Status (e.g. password reset) -->
    @if(session('status'))
      <div class="success-box mb-4">{{ session('status') }}</div>
    @endif

    <!-- Error message -->
    @if($errors->any())
      <div class="error-box mb-4">
        <div class="flex items-start gap-2">
          <span class="text-base">⚠️</span>
          <div>
            @foreach($errors->all() as $error)
              <p>{{ $error }}</p>
            @endforeach
          </div>
        </div>
      </div>
    @endif

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" id="login-form">
      @csrf

      <!-- Email -->
      <div class="mb-4">
        <label for="email" class="block text-xs font-semibold mb-1.5" style="color:#7dbf7d; letter-spacing:0.04em;">
          EMAIL
        </label>
        <input
          id="email"
          type="email"
          name="email"
          value="{{ old('email') }}"
          required
          autofocus
          autocomplete="username"
          placeholder="admin@ecoutdoor.com"
          class="input-field"
        />
      </div>

      <!-- Password -->
      <div class="mb-5">
        <div class="flex items-center justify-between mb-1.5">
          <label for="password" class="block text-xs font-semibold" style="color:#7dbf7d; letter-spacing:0.04em;">
            PASSWORD
          </label>
          @if(Route::has('password.request'))
            <a href="{{ route('password.request') }}"
               class="text-xs transition-colors"
               style="color:#625f55;"
               onmouseover="this.style.color='#4da34d'"
               onmouseout="this.style.color='#625f55'">
              Lupa password?
            </a>
          @endif
        </div>
        <div class="input-wrap">
          <input
            id="password"
            type="password"
            name="password"
            required
            autocomplete="current-password"
            placeholder="••••••••"
            class="input-field pr-10"
          />
          <button type="button" class="eye-btn" onclick="togglePassword()" id="eye-btn" title="Tampilkan/Sembunyikan password">
            <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
          </button>
        </div>
      </div>

      <!-- Remember me -->
      <div class="flex items-center gap-2 mb-6">
        <input
          id="remember_me"
          type="checkbox"
          name="remember"
          class="w-4 h-4 rounded cursor-pointer"
          style="accent-color: #2d8a2d;"
        />
        <label for="remember_me" class="text-sm cursor-pointer" style="color:#787469;">
          Ingat saya di perangkat ini
        </label>
      </div>

      <!-- Submit -->
      <button type="submit" class="btn-login" id="btn-submit">
        <span id="btn-text">🔑 Masuk ke Dashboard</span>
      </button>
    </form>

    <!-- Footer -->
    <div class="mt-6 pt-5" style="border-top:1px solid rgba(77,163,77,0.1);">
      <a href="{{ url('/') }}"
         class="flex items-center justify-center gap-1.5 text-sm transition-colors"
         style="color:#625f55;"
         onmouseover="this.style.color='#4da34d'"
         onmouseout="this.style.color='#625f55'">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Beranda
      </a>
    </div>

  </div>

  <script>
    // Toggle password visibility
    function togglePassword() {
      const input = document.getElementById('password');
      const icon  = document.getElementById('eye-icon');
      const isHidden = input.type === 'password';
      input.type = isHidden ? 'text' : 'password';
      icon.innerHTML = isHidden
        ? `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`
        : `<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
    }

    // Loading state on submit
    document.getElementById('login-form').addEventListener('submit', function() {
      const btn  = document.getElementById('btn-submit');
      const text = document.getElementById('btn-text');
      btn.disabled = true;
      btn.style.opacity = '0.7';
      text.textContent = '⏳ Memproses...';
    });
  </script>
</body>
</html>
