<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin-Panel') - TAGS.MENU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        .sidebar-link.active { background-color: #1F2937; color: #E5E7EB; }
    </style>
</head>
<body class="bg-gray-900 text-gray-200" x-data="{ isMobileMenuOpen: false }">
    <div class="flex h-screen">
        {{-- Desktop Sidebar --}}
        <div class="hidden md:flex flex-col w-64 bg-gray-800">
            <div class="flex items-center justify-center h-16 bg-gray-900">
                <span class="text-white font-bold text-xl">TAGS.MENU</span>
            </div>
            <div class="flex flex-col flex-1 overflow-y-auto">
                @include('layouts.partials.navigation')
            </div>
        </div>

        {{-- Mobile Sidebar --}}
        <div x-show="isMobileMenuOpen" @click.away="isMobileMenuOpen = false" class="fixed inset-0 flex z-40 md:hidden" x-cloak>
            <div x-show="isMobileMenuOpen" class="fixed inset-0 bg-black opacity-50"></div>
            <div x-show="isMobileMenuOpen" class="relative flex-1 flex flex-col max-w-xs w-full bg-gray-800">
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button @click="isMobileMenuOpen = false" type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none">
                        <svg class="h-6 w-6 text-white" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="flex items-center justify-center h-16 bg-gray-900">
                    <span class="text-white font-bold text-xl">TAGS.MENU</span>
                </div>
                <div class="flex flex-col flex-1 overflow-y-auto">
                    @include('layouts.partials.navigation')
                </div>
            </div>
        </div>

        {{-- Main Content Area --}}
        <div class="flex flex-col flex-1 overflow-y-auto">
            <header class="flex items-center justify-between h-16 bg-gray-800 border-b border-gray-700 px-4">
                <button @click="isMobileMenuOpen = true" class="md:hidden text-gray-400 hover:text-white">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                 <h1 class="text-white font-semibold text-lg hidden md:block">@yield('title', 'Dashboard')</h1>
                 <div class="flex items-center space-x-4">
                    <span class="text-white hidden sm:block">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-3 py-1 bg-red-600 text-white text-sm rounded-md hover:bg-red-700">Logout</button>
                    </form>
                 </div>
            </header>
            <main class="p-4 md:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- NEU: Script-Stack für seiten-spezifisches JavaScript -->
    @stack('scripts')

</body>
</html>