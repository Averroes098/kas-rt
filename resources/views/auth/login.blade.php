@section('page_title', 'Masuk — KAS RT BINTARAN WETAN')

<x-guest-layout>
    <div class="kas-auth-card">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <a href="/" class="inline-block">
                <img src="{{ asset('logo.png') }}" alt="Logo Dusun Bintaran Wetan" class="mx-auto mb-4" style="width: 80px; height: 80px; object-fit: contain;">
            </a>
            <h1 class="text-xl font-bold" style="color: #1F2937;">Masuk ke Sistem</h1>
            <p class="text-sm mt-1" style="color: #6B7280;">Kas & Inventaris RT Bintaran Wetan</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 p-3 rounded-xl text-sm font-medium" style="background-color: #EAF3E6; color: #2F5D34;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="kas-label">Email</label>
                <input id="email" class="kas-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="email@contoh.com">
                @error('email')
                    <p class="kas-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="kas-label">Password</label>
                <input id="password" class="kas-input" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                @error('password')
                    <p class="kas-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between mb-6">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox" class="kas-checkbox" name="remember">
                    <span class="ms-2 text-sm" style="color: #6B7280;">Ingat saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="kas-link" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>

            <!-- Login Button -->
            <button type="submit" class="kas-btn-primary">
                Masuk
            </button>

            <!-- Register Link -->
            @if (Route::has('register'))
                <p class="text-center text-sm mt-6" style="color: #6B7280;">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="kas-link font-semibold">Daftar sekarang</a>
                </p>
            @endif
        </form>
    </div>

    <!-- Footer -->
    <p class="text-center text-xs mt-8" style="color: #9CA3AF;">
        © 2026 Kas RT Bintaran Wetan · KKN 84.048 UPN Veteran Yogyakarta
    </p>
</x-guest-layout>
