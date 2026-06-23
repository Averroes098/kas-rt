<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>KAS RT BINTARAN WETAN — Sistem Informasi Kas dan Inventaris RT</title>
        <meta name="description" content="Sistem Informasi Pengelolaan Kas dan Inventaris RT Dusun Bintaran Wetan. Dibangun oleh KKN 84.048 UPN Veteran Yogyakarta.">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            * { box-sizing: border-box; margin: 0; padding: 0; }

            body {
                font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
                background-color: #F8FAF5;
                color: #1F2937;
                -webkit-font-smoothing: antialiased;
            }

            /* ===== NAVBAR ===== */
            .kas-navbar {
                position: sticky;
                top: 0;
                z-index: 50;
                background: rgba(255, 255, 255, 0.92);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border-bottom: 1px solid #E5E7EB;
            }
            .kas-navbar-inner {
                max-width: 1200px;
                margin: 0 auto;
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0 1.5rem;
                height: 70px;
            }
            .kas-navbar-brand {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                text-decoration: none;
                color: #2F5D34;
            }
            .kas-navbar-brand img {
                width: 38px;
                height: 38px;
                object-fit: contain;
            }
            .kas-navbar-brand-text {
                font-weight: 800;
                font-size: 1rem;
                letter-spacing: -0.01em;
            }
            .kas-navbar-links {
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }

            /* ===== HERO ===== */
            .kas-hero {
                background: linear-gradient(160deg, #F8FAF5 0%, #EAF3E6 60%, #F8FAF5 100%);
                padding: 5rem 1.5rem 4rem;
                overflow: hidden;
                position: relative;
            }
            .kas-hero::before {
                content: '';
                position: absolute;
                top: -50%;
                right: -20%;
                width: 600px;
                height: 600px;
                background: radial-gradient(circle, rgba(47,93,52,0.06) 0%, transparent 70%);
                border-radius: 50%;
                pointer-events: none;
            }
            .kas-hero-inner {
                max-width: 1200px;
                margin: 0 auto;
                display: flex;
                align-items: center;
                gap: 4rem;
            }
            .kas-hero-content {
                flex: 1;
            }
            .kas-hero-badge {
                display: inline-flex;
                align-items: center;
                padding: 0.375rem 0.875rem;
                background: rgba(47, 93, 52, 0.08);
                border: 1px solid rgba(47, 93, 52, 0.15);
                border-radius: 999px;
                font-size: 0.75rem;
                font-weight: 600;
                color: #2F5D34;
                margin-bottom: 1.5rem;
            }
            .kas-hero-badge::before {
                content: '';
                width: 6px;
                height: 6px;
                background: #2F5D34;
                border-radius: 50%;
                margin-right: 0.5rem;
                animation: pulse-dot 2s infinite;
            }
            @keyframes pulse-dot {
                0%, 100% { opacity: 1; transform: scale(1); }
                50% { opacity: 0.5; transform: scale(1.3); }
            }
            .kas-hero h1 {
                font-size: 2.75rem;
                font-weight: 900;
                color: #2F5D34;
                line-height: 1.1;
                letter-spacing: -0.025em;
                margin-bottom: 1rem;
            }
            .kas-hero-subtitle {
                font-size: 1.125rem;
                color: #4B5563;
                line-height: 1.6;
                max-width: 480px;
                margin-bottom: 2rem;
            }
            .kas-hero-buttons {
                display: flex;
                align-items: center;
                gap: 1rem;
                flex-wrap: wrap;
            }
            .kas-hero-logo {
                flex-shrink: 0;
                position: relative;
            }
            .kas-hero-logo img {
                width: 180px;
                height: 180px;
                object-fit: contain;
                filter: drop-shadow(0 8px 24px rgba(47,93,52,0.12));
                animation: float-logo 6s ease-in-out infinite;
            }
            @keyframes float-logo {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-10px); }
            }

            /* ===== BUTTONS (Landing) ===== */
            .kas-hero-btn-primary {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0.875rem 2rem;
                background-color: #2F5D34;
                color: #ffffff;
                font-weight: 700;
                font-size: 0.9375rem;
                border-radius: 0.75rem;
                border: none;
                cursor: pointer;
                transition: all 0.25s ease;
                text-decoration: none;
                box-shadow: 0 2px 8px rgba(47,93,52,0.2);
            }
            .kas-hero-btn-primary:hover {
                background-color: #4F7A3F;
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(47,93,52,0.3);
            }
            .kas-hero-btn-gold {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0.875rem 2rem;
                background-color: #D4A62A;
                color: #ffffff;
                font-weight: 700;
                font-size: 0.9375rem;
                border-radius: 0.75rem;
                border: none;
                cursor: pointer;
                transition: all 0.25s ease;
                text-decoration: none;
                box-shadow: 0 2px 8px rgba(212,166,42,0.2);
            }
            .kas-hero-btn-gold:hover {
                background-color: #c09525;
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(212,166,42,0.3);
            }

            /* ===== FEATURES ===== */
            .kas-features {
                padding: 4rem 1.5rem 5rem;
                background: #ffffff;
                border-top: 1px solid #E5E7EB;
            }
            .kas-features-inner {
                max-width: 1200px;
                margin: 0 auto;
            }
            .kas-features-title {
                text-align: center;
                margin-bottom: 3rem;
            }
            .kas-features-title h2 {
                font-size: 1.75rem;
                font-weight: 800;
                color: #1F2937;
                margin-bottom: 0.5rem;
            }
            .kas-features-title p {
                font-size: 1rem;
                color: #6B7280;
            }
            .kas-features-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 1.5rem;
            }
            .kas-feature-card {
                background: #F8FAF5;
                border: 1px solid #E5E7EB;
                border-radius: 1rem;
                padding: 1.75rem;
                transition: all 0.3s ease;
                cursor: default;
            }
            .kas-feature-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 8px 24px rgba(47,93,52,0.08);
                border-color: #D4A62A;
            }
            .kas-feature-icon {
                width: 48px;
                height: 48px;
                border-radius: 0.75rem;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1rem;
                font-size: 1.5rem;
            }
            .kas-feature-card h3 {
                font-size: 1rem;
                font-weight: 700;
                color: #1F2937;
                margin-bottom: 0.5rem;
            }
            .kas-feature-card p {
                font-size: 0.875rem;
                color: #6B7280;
                line-height: 1.5;
            }

            /* ===== FOOTER ===== */
            .kas-footer {
                background: #2F5D34;
                color: rgba(255,255,255,0.85);
                padding: 2rem 1.5rem;
                text-align: center;
            }
            .kas-footer-inner {
                max-width: 1200px;
                margin: 0 auto;
            }
            .kas-footer p {
                font-size: 0.8125rem;
                line-height: 1.6;
            }
            .kas-footer strong {
                color: #D4A62A;
                font-weight: 600;
            }

            /* ===== RESPONSIVE ===== */
            @media (max-width: 768px) {
                .kas-hero-inner {
                    flex-direction: column;
                    text-align: center;
                    gap: 2rem;
                }
                .kas-hero h1 {
                    font-size: 2rem;
                }
                .kas-hero-subtitle {
                    margin-left: auto;
                    margin-right: auto;
                }
                .kas-hero-buttons {
                    justify-content: center;
                }
                .kas-hero-logo {
                    order: -1;
                }
                .kas-hero-logo img {
                    width: 140px;
                    height: 140px;
                }
                .kas-features-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
                .kas-navbar-brand-text {
                    font-size: 0.875rem;
                }
            }

            @media (max-width: 480px) {
                .kas-features-grid {
                    grid-template-columns: 1fr;
                }
                .kas-hero {
                    padding: 3rem 1rem 2.5rem;
                }
                .kas-hero h1 {
                    font-size: 1.75rem;
                }
            }
        </style>
    </head>
    <body>
        <!-- ===== NAVBAR ===== -->
        <nav class="kas-navbar">
            <div class="kas-navbar-inner">
                <a href="/" class="kas-navbar-brand">
                    <img src="{{ asset('logo.png') }}" alt="Logo">
                    <span class="kas-navbar-brand-text">KAS RT BINTARAN WETAN</span>
                </a>
                <div class="kas-navbar-links">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="kas-hero-btn-primary" style="padding: 0.5rem 1.25rem; font-size: 0.8125rem;">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="kas-hero-btn-primary" style="padding: 0.5rem 1.25rem; font-size: 0.8125rem;">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="kas-hero-btn-gold" style="padding: 0.5rem 1.25rem; font-size: 0.8125rem;">
                                Daftar
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </nav>

        <!-- ===== HERO SECTION ===== -->
        <section class="kas-hero">
            <div class="kas-hero-inner">
                <div class="kas-hero-content">
                    <div class="kas-hero-badge">
                        Dusun Bintaran Wetan
                    </div>
                    <h1>KAS RT<br>BINTARAN WETAN</h1>
                    <p class="kas-hero-subtitle">
                        Sistem Informasi Pengelolaan Kas dan Inventaris RT
                        <br>Dusun Bintaran Wetan
                    </p>
                    <div class="kas-hero-buttons">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="kas-hero-btn-primary">
                                <svg style="width:18px;height:18px;margin-right:8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                Buka Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="kas-hero-btn-primary">
                                <svg style="width:18px;height:18px;margin-right:8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                                Masuk
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="kas-hero-btn-gold">
                                    <svg style="width:18px;height:18px;margin-right:8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                    </svg>
                                    Daftar
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
                <div class="kas-hero-logo">
                    <img src="{{ asset('logo.png') }}" alt="Logo Dusun Bintaran Wetan">
                </div>
            </div>
        </section>

        <!-- ===== FEATURES SECTION ===== -->
        <section class="kas-features">
            <div class="kas-features-inner">
                <div class="kas-features-title">
                    <h2>Fitur Sistem</h2>
                    <p>Kelola keuangan dan inventaris RT secara efisien dalam satu platform</p>
                </div>
                <div class="kas-features-grid">
                    <!-- Feature 1: Kas RT -->
                    <div class="kas-feature-card">
                        <div class="kas-feature-icon" style="background: #EAF3E6; color: #2F5D34;">
                            💰
                        </div>
                        <h3>Kas RT</h3>
                        <p>Catat pemasukan dan pengeluaran kas RT secara detail dengan bukti transaksi digital.</p>
                    </div>

                    <!-- Feature 2: Inventaris -->
                    <div class="kas-feature-card">
                        <div class="kas-feature-icon" style="background: #FEF3C7; color: #92400E;">
                            📦
                        </div>
                        <h3>Inventaris</h3>
                        <p>Kelola data barang inventaris RT termasuk nama, jumlah, kondisi, dan tahun perolehan.</p>
                    </div>

                    <!-- Feature 3: Multi RT -->
                    <div class="kas-feature-card">
                        <div class="kas-feature-icon" style="background: #EDE9FE; color: #5B21B6;">
                            🏘️
                        </div>
                        <h3>Multi RT</h3>
                        <p>Mendukung data terpisah untuk RT 01 hingga RT 06 Dusun Bintaran Wetan secara mandiri.</p>
                    </div>

                    <!-- Feature 4: Dashboard -->
                    <div class="kas-feature-card">
                        <div class="kas-feature-icon" style="background: #DBEAFE; color: #1D4ED8;">
                            📊
                        </div>
                        <h3>Dashboard</h3>
                        <p>Pantau saldo, grafik tren keuangan, dan statistik inventaris dalam satu tampilan ringkas.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== FOOTER ===== -->
        <footer class="kas-footer">
            <div class="kas-footer-inner">
                <p>© 2026 <strong>Kas RT Bintaran Wetan</strong></p>
                <p>KKN 84.048 UPN Veteran Yogyakarta</p>
            </div>
        </footer>
    </body>
</html>
