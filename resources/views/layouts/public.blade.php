<!DOCTYPE html>
{{-- KORREKTUR: 'lang'-Attribut und Anti-FOUC-Skript hinzugefügt --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $seoTitle ?? config('app.name', 'TAGS.MENU') }}</title>
    <meta name="description" content="{{ $seoDescription ?? 'Entdecken Sie die besten Restaurants und Speisekarten in Ihrer Nähe.' }}">

    {{-- Tailwind CSS via CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- CROWN DESIGN: Google Fonts (Inter) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800&display=swap" rel="stylesheet">

    {{-- Livewire Styles --}}
    @livewireStyles

    {{-- CROWN DESIGN: Globale Stile, Schriftart und Scrollbar --}}
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Light mode scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cb2828; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #b91c1c; }
        /* Dark mode scrollbar */
        html.dark ::-webkit-scrollbar-track { background: #2C2C2C; }
        html.dark ::-webkit-scrollbar-thumb { background: #b8995e; }
        html.dark ::-webkit-scrollbar-thumb:hover { background: #a08852; }
        /* Spinner (für AI-Ladeanimation) */
        .spinner { animation: rotate 1s linear infinite; }
        @keyframes rotate { to { transform: rotate(360deg); } }

        {{-- Stile für Blog-Texte (unverändert) --}}
        .prose p { margin-bottom: 1.25em; }
        .prose h2 { font-size: 1.5em; font-weight: bold; margin-top: 1.5em; margin-bottom: 1em; }
        .prose a { color: #2563eb; text-decoration: underline; }
    </style>

    {{-- CROWN DESIGN: Tailwind Konfiguration & Dark Mode --}}
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'tags-red': '#cb2828',
                        'crown-gold': '#b8995e',
                        'dark-bg': '#1E1E1E',
                        'dark-surface': '#2C2C2C',
                        'dark-base': '#121212',
                    }
                }
            }
        }
    </script>

    {{-- CROWN DESIGN: Anti-FOUC (Flash of Unstyled Content) Skript --}}
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
{{-- KORREKTUR: Dark Mode Klassen hinzugefügt + Flex-Layout --}}
<body class="bg-white dark:bg-dark-bg text-gray-800 dark:text-gray-200 min-h-screen flex flex-col transition-colors duration-300">

    {{-- Header --}}
    @include('layouts.partials.public-header')

    {{-- Hauptinhalt der Seite --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.partials.public-footer')

    {{-- Livewire Scripts (wird benötigt für Alpine.js im Header) --}}
    @livewireScripts

    {{-- CROWN DESIGN: Theme Toggler & Copyright Skript --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- Theme Toggler ---
            const themeToggleBtn = document.getElementById('theme-toggle');
            const themeIconSun = document.querySelector('.theme-icon-sun');
            const themeIconMoon = document.querySelector('.theme-icon-moon');
            
            const updateThemeIcons = (isDark) => {
                if (themeIconSun && themeIconMoon) {
                    themeIconSun.classList.toggle('hidden', isDark);
                    themeIconMoon.classList.toggle('hidden', !isDark);
                }
            };

            // Initialen Status setzen
            updateThemeIcons(document.documentElement.classList.contains('dark'));

            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', function() {
                    const isDark = document.documentElement.classList.toggle('dark');
                    localStorage.setItem('color-theme', isDark ? 'dark' : 'light');
                    updateThemeIcons(isDark);
                });
            }

            // --- Dynamic Copyright Year (aus Footer) ---
            const copyrightYearEl = document.getElementById('copyright-year');
            if (copyrightYearEl) {
                copyrightYearEl.textContent = new Date().getFullYear();
            }
        });
    </script>
</body>
</html>

