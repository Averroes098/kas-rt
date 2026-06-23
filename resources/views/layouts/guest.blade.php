<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('page_title', 'KAS RT BINTARAN WETAN')</title>
        <meta name="description" content="Sistem Informasi Pengelolaan Kas dan Inventaris RT Dusun Bintaran Wetan">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --primary-green: #2F5D34;
                --secondary-green: #4F7A3F;
                --accent-gold: #D4A62A;
                --bg-light: #F8FAF5;
            }

            body {
                font-family: 'Inter', ui-sans-serif, system-ui, sans-serif !important;
            }

            /* Auth input styling */
            .kas-input {
                width: 100%;
                padding: 0.75rem 1rem;
                border: 1px solid #E5E7EB;
                border-radius: 0.75rem;
                font-size: 0.875rem;
                color: #1F2937;
                background: #ffffff;
                transition: all 0.2s ease;
                outline: none;
            }
            .kas-input:focus {
                border-color: #2F5D34;
                box-shadow: 0 0 0 3px rgba(47, 93, 52, 0.12);
            }
            .kas-input::placeholder {
                color: #9CA3AF;
            }

            /* Auth button styling */
            .kas-btn-primary {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                padding: 0.75rem 1.5rem;
                background-color: #2F5D34;
                color: #ffffff;
                font-weight: 600;
                font-size: 0.875rem;
                border-radius: 0.75rem;
                border: none;
                cursor: pointer;
                transition: all 0.2s ease;
            }
            .kas-btn-primary:hover {
                background-color: #4F7A3F;
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(47, 93, 52, 0.3);
            }

            .kas-btn-gold {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0.75rem 2rem;
                background-color: #D4A62A;
                color: #ffffff;
                font-weight: 600;
                font-size: 0.875rem;
                border-radius: 0.75rem;
                border: none;
                cursor: pointer;
                transition: all 0.2s ease;
                text-decoration: none;
            }
            .kas-btn-gold:hover {
                background-color: #c09525;
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(212, 166, 42, 0.3);
            }

            .kas-btn-outline {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0.75rem 2rem;
                background-color: transparent;
                color: #2F5D34;
                font-weight: 600;
                font-size: 0.875rem;
                border-radius: 0.75rem;
                border: 2px solid #2F5D34;
                cursor: pointer;
                transition: all 0.2s ease;
                text-decoration: none;
            }
            .kas-btn-outline:hover {
                background-color: #2F5D34;
                color: #ffffff;
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(47, 93, 52, 0.3);
            }

            /* Auth card styling */
            .kas-auth-card {
                background: #ffffff;
                border-radius: 1.25rem;
                box-shadow: 0 4px 6px -1px rgba(0,0,0,0.07), 0 10px 25px -5px rgba(0,0,0,0.05);
                border: 1px solid #E5E7EB;
                max-width: 420px;
                width: 100%;
                padding: 2.5rem;
            }

            /* Label styling */
            .kas-label {
                display: block;
                font-size: 0.8125rem;
                font-weight: 600;
                color: #374151;
                margin-bottom: 0.375rem;
            }

            /* Error message styling */
            .kas-error {
                font-size: 0.75rem;
                color: #DC2626;
                margin-top: 0.25rem;
            }

            /* Checkbox styling */
            .kas-checkbox {
                width: 1rem;
                height: 1rem;
                border-radius: 0.25rem;
                border: 1.5px solid #D1D5DB;
                accent-color: #2F5D34;
            }

            /* Link styling */
            .kas-link {
                color: #2F5D34;
                font-size: 0.8125rem;
                font-weight: 500;
                text-decoration: none;
                transition: color 0.2s;
            }
            .kas-link:hover {
                color: #4F7A3F;
                text-decoration: underline;
            }
        </style>
    </head>
    <body class="h-full antialiased" style="background-color: #F8FAF5;">
        <div class="min-h-screen flex flex-col items-center justify-center px-4 py-8">
            {{ $slot }}
        </div>
    </body>
</html>
