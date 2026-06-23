@section('page_title', 'Konfirmasi Password — KAS RT BINTARAN WETAN')

<x-guest-layout>
    <div class="kas-auth-card">
        <!-- Logo & Header -->
        <div class="text-center mb-6">
            <a href="/" class="inline-block">
                <img src="{{ asset('logo.png') }}" alt="Logo Dusun Bintaran Wetan" class="mx-auto mb-4" style="width: 80px; height: 80px; object-fit: contain;">
            </a>
            <h1 class="text-xl font-bold" style="color: #1F2937;">Konfirmasi Password</h1>
        </div>

        <div class="mb-4 p-4 rounded-xl text-sm" style="background-color: #F3F4F6; color: #4B5563;">
            <p>Area ini membutuhkan keamanan tambahan. Silakan konfirmasi password Anda sebelum melanjutkan.</p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div class="mb-6">
                <label for="password" class="kas-label">Password</label>
                <input id="password" class="kas-input" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan password Anda">
                @error('password')
                    <p class="kas-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="kas-btn-primary">
                Konfirmasi
            </button>
        </form>
    </div>

    <!-- Footer -->
    <p class="text-center text-xs mt-8" style="color: #9CA3AF;">
        © 2026 Kas RT Bintaran Wetan · KKN 84.048 UPN Veteran Yogyakarta
    </p>
</x-guest-layout>
