<!-- Desktop Sidebar (Permanen di kiri untuk desktop >= lg) -->
<aside class="hidden lg:flex lg:flex-col lg:fixed lg:inset-y-0 lg:left-0 lg:z-20 custom-sidebar text-white border-r border-[#4F7A3F]/30 h-full">
    <!-- Header Branding with Logo -->
    <div class="px-6 py-6 border-b border-[#4F7A3F]/50 flex flex-col items-center text-center">
        <!-- Logo Image container with matching border/shadow -->
        <div class="bg-white p-2 rounded-full mb-3 shadow-md inline-flex items-center justify-center w-20 h-20">
            <img src="{{ asset('logo.png') }}" alt="Logo Bintaran Wetan" class="w-16 h-16 object-contain">
        </div>
        <h2 class="font-extrabold text-white text-base tracking-wider uppercase leading-tight">
            KAS RT BINTARAN WETAN
        </h2>
        <p class="text-xs font-semibold text-[#D4A62A] mt-1.5 uppercase tracking-wider">
            Dusun Bintaran Wetan
        </p>
        <p class="text-[10px] text-gray-300 mt-1 font-medium leading-relaxed">
            KKN 84.048 UPN Veteran Yogyakarta
        </p>

        <!-- Active RT Badge -->
        <div class="mt-4 inline-flex items-center px-2.5 py-1 bg-white/10 text-white rounded-lg text-xs font-bold border border-white/20 w-fit">
            <span class="w-1.5 h-1.5 bg-[#D4A62A] rounded-full mr-2"></span>
            RT Aktif: {{ auth()->user()->rt ? auth()->user()->rt->nama_rt : '-' }}
        </div>
    </div>

    <!-- Navigation links -->
    <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
        <!-- Dashboard Link -->
        <a href="{{ route('dashboard') }}" 
           class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard') ? 'custom-sidebar-active' : 'custom-sidebar-inactive' }}">
            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
        </a>

        <!-- Transaksi Kas Link -->
        <a href="{{ route('transaksi.index') }}" 
           class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-150 {{ request()->routeIs('transaksi.*') ? 'custom-sidebar-active' : 'custom-sidebar-inactive' }}">
            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            Transaksi Kas
        </a>

        <!-- Inventaris Link -->
        <a href="{{ route('inventaris.index') }}" 
           class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-150 {{ request()->routeIs('inventaris.*') ? 'custom-sidebar-active' : 'custom-sidebar-inactive' }}">
            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            Inventaris
        </a>

        <!-- Profile Link -->
        <a href="{{ route('profile.edit') }}" 
           class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-150 {{ request()->routeIs('profile.edit') ? 'custom-sidebar-active' : 'custom-sidebar-inactive' }}">
            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Profil Saya
        </a>
    </nav>

    <!-- Footer Profile & Logout (Selalu menempel di paling bawah) -->
    <div class="p-4 border-t border-[#4F7A3F]/50 mt-auto bg-black/10">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    class="w-full flex items-center justify-center px-4 py-2.5 text-xs font-bold text-red-200 bg-red-950/40 hover:bg-red-900/60 hover:text-white rounded-xl border border-red-900/50 transition-colors cursor-pointer">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Keluar Aplikasi
            </button>
        </form>
    </div>
</aside>

<!-- Mobile Sidebar Backdrop & Sliding Side Menu -->
<div x-show="mobileOpen" 
     class="fixed inset-0 z-40 lg:hidden" 
     role="dialog" 
     aria-modal="true"
     style="display: none;">
    <!-- Backdrop overlay -->
    <div x-show="mobileOpen"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-900 bg-opacity-80"
         @click="mobileOpen = false"></div>

    <!-- Sidebar content container -->
    <div x-show="mobileOpen"
         x-transition:enter="transition ease-in-out duration-300 transform"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in-out duration-300 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="relative flex flex-col w-[280px] bg-[#2F5D34] text-white h-full border-r border-[#4F7A3F]/30 z-50">
        
        <!-- Close button for mobile menu -->
        <div class="absolute top-0 right-0 -mr-12 pt-4">
            <button @click="mobileOpen = false" type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                <span class="sr-only">Tutup sidebar</span>
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Header Branding with Logo -->
        <div class="px-6 py-6 border-b border-[#4F7A3F]/50 flex flex-col items-center text-center">
            <!-- Logo Image -->
            <div class="bg-white p-2 rounded-full mb-3 shadow-md inline-flex items-center justify-center w-20 h-20">
                <img src="{{ asset('logo.png') }}" alt="Logo Bintaran Wetan" class="w-16 h-16 object-contain">
            </div>
            <h2 class="font-extrabold text-white text-base tracking-wider uppercase leading-tight">
                KAS RT BINTARAN WETAN
            </h2>
            <p class="text-xs font-semibold text-[#D4A62A] mt-1.5 uppercase tracking-wider">
                Dusun Bintaran Wetan
            </p>
            <p class="text-[10px] text-gray-300 mt-1 font-medium leading-relaxed">
                KKN 84.048 UPN Veteran Yogyakarta
            </p>
            
            <!-- Active RT Badge -->
            <div class="mt-3 inline-flex items-center px-2.5 py-1 bg-white/10 text-white rounded-lg text-xs font-bold border border-white/20 w-fit">
                <span class="w-1.5 h-1.5 bg-[#D4A62A] rounded-full mr-2"></span>
                RT Aktif: {{ auth()->user()->rt ? auth()->user()->rt->nama_rt : '-' }}
            </div>
        </div>

        <!-- Mobile Navigation links -->
        <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
            <a href="{{ route('dashboard') }}" 
               class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard') ? 'custom-sidebar-active' : 'custom-sidebar-inactive' }}">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>

            <a href="{{ route('transaksi.index') }}" 
               class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-150 {{ request()->routeIs('transaksi.*') ? 'custom-sidebar-active' : 'custom-sidebar-inactive' }}">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Transaksi Kas
            </a>

            <a href="{{ route('inventaris.index') }}" 
               class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-150 {{ request()->routeIs('inventaris.*') ? 'custom-sidebar-active' : 'custom-sidebar-inactive' }}">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                Inventaris
            </a>

            <a href="{{ route('profile.edit') }}" 
               class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-150 {{ request()->routeIs('profile.edit') ? 'custom-sidebar-active' : 'custom-sidebar-inactive' }}">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Profil Saya
            </a>
        </nav>

        <!-- Logout Button (mt-auto) -->
        <div class="p-4 border-t border-[#4F7A3F]/50 mt-auto bg-black/10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="w-full flex items-center justify-center px-4 py-2.5 text-xs font-bold text-red-200 bg-red-950/40 hover:bg-red-900/60 hover:text-white rounded-xl border border-red-900/50 transition-colors cursor-pointer">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Keluar Aplikasi
                </button>
            </form>
        </div>
    </div>
</div>
