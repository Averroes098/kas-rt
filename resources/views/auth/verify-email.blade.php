@section('page_title', 'Verifikasi Email — KAS RT BINTARAN WETAN')

<x-guest-layout>
    <div class="kas-auth-card">
        <!-- Logo & Header -->
        <div class="text-center mb-6">
            <a href="/" class="inline-block">
                <img src="{{ asset('logo.png') }}" alt="Logo Dusun Bintaran Wetan" class="mx-auto mb-4" style="width: 80px; height: 80px; object-fit: contain;">
            </a>
            <h1 class="text-xl font-bold" style="color: #1F2937;">Verifikasi Email</h1>
        </div>

        <div class="mb-4 p-4 rounded-xl text-sm" style="background-color: #FEF9EE; border: 1px solid #F3DFA2; color: #92400E;">
            <p>Terima kasih telah mendaftar! Sebelum melanjutkan, harap verifikasi email Anda dengan mengklik link yang kami kirimkan. Jika Anda tidak menerima email, kami akan mengirimkan ulang.</p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 p-3 rounded-xl text-sm font-medium" style="background-color: #EAF3E6; color: #2F5D34;">
                Link verifikasi baru telah dikirim ke alamat email yang Anda gunakan saat pendaftaran.
            </div>
        @endif

        <div class="flex items-center justify-between gap-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="kas-btn-primary" style="width: auto; padding: 0.625rem 1.25rem;">
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="kas-link text-sm" style="background: none; border: none; cursor: pointer;">
                    Keluar
                </button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <p class="text-center text-xs mt-8" style="color: #9CA3AF;">
        © 2026 Kas RT Bintaran Wetan · KKN 84.048 UPN Veteran Yogyakarta
    </p>
</x-guest-layout>
