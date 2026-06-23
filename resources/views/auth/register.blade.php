@section('page_title', 'Daftar — KAS RT BINTARAN WETAN')

<x-guest-layout>
    <div class="kas-auth-card" style="max-width: 460px;">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <a href="/" class="inline-block">
                <img src="{{ asset('logo.png') }}" alt="Logo Dusun Bintaran Wetan" class="mx-auto mb-4" style="width: 80px; height: 80px; object-fit: contain;">
            </a>
            <h1 class="text-xl font-bold" style="color: #1F2937;">Daftar Akun Baru</h1>
            <p class="text-sm mt-1" style="color: #6B7280;">Kas & Inventaris RT Bintaran Wetan</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="kas-label">Nama Lengkap</label>
                <input id="name" class="kas-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap">
                @error('name')
                    <p class="kas-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="kas-label">Email</label>
                <input id="email" class="kas-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="email@contoh.com">
                @error('email')
                    <p class="kas-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- RT Selection -->
            <div class="mb-4">
                <label for="rt_id" class="kas-label">Pilih RT</label>
                <select id="rt_id" name="rt_id" class="kas-input" required style="cursor: pointer;">
                    <option value="" disabled {{ old('rt_id') ? '' : 'selected' }}>— Pilih RT —</option>
                    @foreach(\App\Models\Rt::orderBy('id')->get() as $rt)
                        <option value="{{ $rt->id }}" {{ old('rt_id') == $rt->id ? 'selected' : '' }}>
                            {{ $rt->nama_rt }}
                        </option>
                    @endforeach
                </select>
                @error('rt_id')
                    <p class="kas-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="kas-label">Password</label>
                <input id="password" class="kas-input" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter">
                @error('password')
                    <p class="kas-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <label for="password_confirmation" class="kas-label">Konfirmasi Password</label>
                <input id="password_confirmation" class="kas-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password">
                @error('password_confirmation')
                    <p class="kas-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Register Button -->
            <button type="submit" class="kas-btn-primary">
                Daftar
            </button>

            <!-- Login Link -->
            <p class="text-center text-sm mt-6" style="color: #6B7280;">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="kas-link font-semibold">Masuk di sini</a>
            </p>
        </form>
    </div>

    <!-- Footer -->
    <p class="text-center text-xs mt-8" style="color: #9CA3AF;">
        © 2026 Kas RT Bintaran Wetan · KKN 84.048 UPN Veteran Yogyakarta
    </p>
</x-guest-layout>
