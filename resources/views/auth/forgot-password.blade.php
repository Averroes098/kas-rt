@section('page_title', 'Lupa Password — KAS RT BINTARAN WETAN')

<x-guest-layout>
    <div class="kas-auth-card">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <a href="/" class="inline-block">
                <img src="{{ asset('logo.png') }}" alt="Logo Dusun Bintaran Wetan" class="mx-auto mb-4" style="width: 80px; height: 80px; object-fit: contain;">
            </a>
            <h1 class="text-xl font-bold" style="color: #1F2937;">Lupa Password</h1>
            <p class="text-sm mt-1" style="color: #6B7280;">Masukkan email Anda untuk menerima link reset password</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 p-3 rounded-xl text-sm font-medium" style="background-color: #EAF3E6; color: #2F5D34;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-6">
                <label for="email" class="kas-label">Email</label>
                <input id="email" class="kas-input" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="email@contoh.com">
                @error('email')
                    <p class="kas-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="kas-btn-primary">
                Kirim Link Reset Password
            </button>

            <!-- Back to Login -->
            <p class="text-center text-sm mt-6" style="color: #6B7280;">
                Ingat password?
                <a href="{{ route('login') }}" class="kas-link font-semibold">Kembali ke login</a>
            </p>
        </form>
    </div>

    <!-- Footer -->
    <p class="text-center text-xs mt-8" style="color: #9CA3AF;">
        © 2026 Kas RT Bintaran Wetan · KKN 84.048 UPN Veteran Yogyakarta
    </p>
</x-guest-layout>
