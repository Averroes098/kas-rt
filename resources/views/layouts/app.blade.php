<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F8FAF5]">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'KAS RT BINTARAN WETAN') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Robust Layout CSS Styles to Prevent JIT Compilation Issues -->
        <style>
            :root {
                --primary-green: #2F5D34;
                --secondary-green: #4F7A3F;
                --light-green: #EAF3E6;
                --accent-gold: #D4A62A;
                --bg-light: #F8FAF5;
            }

            body {
                font-family: 'Inter', ui-sans-serif, system-ui, sans-serif !important;
                background-color: var(--bg-light) !important;
                color: #1F2937 !important;
            }

            /* Sidebar style locks */
            .custom-sidebar {
                width: 280px !important;
                background-color: var(--primary-green) !important;
            }

            .custom-sidebar-active {
                background-color: var(--accent-gold) !important;
                color: var(--primary-green) !important;
            }

            .custom-sidebar-inactive {
                color: #f3f4f6 !important;
            }
            .custom-sidebar-inactive:hover {
                background-color: rgba(79, 122, 63, 0.4) !important;
                color: #ffffff !important;
            }

            /* Desktop adjustments */
            @media (min-width: 1024px) {
                .custom-main-offset {
                    margin-left: 280px !important;
                }
            }

            /* Header height lock */
            .custom-header {
                height: 70px !important;
            }

            /* Stat card height locks */
            .custom-card-stat {
                min-height: 120px !important;
            }

            /* Table sticky headers */
            .custom-table-header {
                background-color: var(--primary-green) !important;
                color: #ffffff !important;
            }
        </style>
    </head>
    <body class="h-full font-sans antialiased bg-[#F8FAF5] text-[#1F2937]">
        <div x-data="{ mobileOpen: false }" class="flex min-h-screen bg-[#F8FAF5]">
            
            <!-- Sidebar Navigation Include -->
            @include('layouts.navigation')

            <!-- Main Wrapper (Fixed offset on desktop) -->
            <div class="flex-1 custom-main-offset flex flex-col min-w-0">
                
                <!-- Header (Height: 70px) -->
                <header class="bg-white border-b border-[#E5E7EB] custom-header flex items-center justify-between px-6 z-30 sticky top-0">
                    <div class="flex items-center">
                        <!-- Mobile Hamburger Button -->
                        <button @click="mobileOpen = true" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-[#2F5D34] hover:bg-[#EAF3E6] focus:outline-none lg:hidden">
                            <span class="sr-only">Buka Sidebar</span>
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <div class="ml-4 lg:ml-0">
                            <!-- Page Title Dynamic Yield -->
                            <h1 class="font-bold text-gray-900 leading-tight text-base md:text-lg">
                                @yield('page_title')
                            </h1>
                        </div>
                    </div>

                    <!-- User and RT Status on Right -->
                    <div class="flex flex-col text-right">
                        <span class="text-sm font-bold text-gray-900">{{ auth()->user()->name }}</span>
                        <span class="text-[10px] text-gray-500 font-semibold uppercase tracking-wider">
                            {{ auth()->user()->rt ? auth()->user()->rt->nama_rt : 'RT -' }} ({{ ucfirst(auth()->user()->role) }})
                        </span>
                    </div>
                </header>

                <!-- Page Content Area -->
                <main class="p-8 w-full max-w-[1400px] mx-auto flex-1 flex flex-col justify-between">
                    <!-- Main Content Wrapper -->
                    <div class="w-full">
                        {{ $slot }}
                    </div>

                    <!-- Footer Section -->
                    <footer class="mt-12 pt-6 border-t border-[#E5E7EB] text-center text-xs text-gray-400">
                        <p class="font-semibold">© 2026 Kas RT Bintaran Wetan</p>
                        <p class="mt-1">KKN 84.048 UPN Veteran Yogyakarta</p>
                    </footer>
                </main>
            </div>
        </div>
    </body>
</html>
