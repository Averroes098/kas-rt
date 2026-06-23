@section('page_title', 'Reset Password — KAS RT BINTARAN WETAN')

<x-guest-layout>
    <div class="kas-auth-card">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <a href="/" class="inline-block">
                <img src="{{ asset('logo.png') }}" alt="Logo Dusun Bintaran Wetan" class="mx-auto mb-4" style="width: 80px; height: 80px; object-fit: contain;">
            </a>
            <h1 class="text-xl font-bold" style="color: #1F2937;">Reset Password</h1>
            <p class="text-sm mt-1" style="color: #6B7280;">Masukkan password baru Anda</p>
        </div>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="kas-label">Email</label>
                <input id="email" class="kas-input" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" placeholder="email@contoh.com">
                @error('email')
                    <p class="kas-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="kas-label">Password Baru</label>
                <input id="password" class="kas-input" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter">
                @error('password')
                    <p class="kas-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <label for="password_confirmation" class="kas-label">Konfirmasi Password Baru</label>
                <input id="password_confirmation" class="kas-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password baru">
                @error('password_confirmation')
                    <p class="kas-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="kas-btn-primary">
                Reset Password
            </button>
        </form>
    </div>

    <!-- Footer -->
    <p class="text-center text-xs mt-8" style="color: #9CA3AF;">
        © 2026 Kas RT Bintaran Wetan · KKN 84.048 UPN Veteran Yogyakarta
    </p>
</x-guest-layout>
