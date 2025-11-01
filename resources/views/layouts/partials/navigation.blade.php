<nav class="mt-5 flex-1 px-2 space-y-1">
    {{-- Dashboard --}}
    <a href="{{ route('dashboard') }}" 
       class="sidebar-link text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <x-heroicon-o-home class="mr-3 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-300"/>
        {{ __('nav.dashboard') }}
    </a>

    <div class="pt-4 pb-2 px-2">
        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('nav.menu_management') }}</span>
    </div>

    {{-- Kategorien --}}
    <a href="{{ route('categories.index') }}" 
       class="sidebar-link text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('categories.*') ? 'active' : '' }}">
        <x-heroicon-o-tag class="mr-3 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-300"/>
        {{ __('nav.categories') }}
    </a>

    {{-- Speisekarte --}}
    <a href="{{ route('dishes.index', ['type' => 'food']) }}" 
       class="sidebar-link text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ (request()->routeIs('dishes.*') && request()->query('type') == 'food') ? 'active' : '' }}">
        <x-heroicon-o-rectangle-stack class="mr-3 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-300"/>
        {{ __('nav.food_menu') }}
    </a>

    {{-- Getränkekarte --}}
    <a href="{{ route('dishes.index', ['type' => 'drink']) }}" 
       class="sidebar-link text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ (request()->routeIs('dishes.*') && request()->query('type') == 'drink') ? 'active' : '' }}">
        <x-heroicon-o-beaker class="mr-3 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-300"/>
        {{ __('nav.drink_menu') }}
    </a>
    
    {{-- Importieren --}}
    <a href="{{ route('imports.index') }}" 
       class="sidebar-link text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('imports.*') ? 'active' : '' }}">
        <x-heroicon-o-arrow-down-tray class="mr-3 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-300"/>
        {{ __('nav.imports') }}
    </a>

    <div class="pt-4 pb-2 px-2">
        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('nav.configuration') }}</span>
    </div>

    {{-- Einstellungen --}}
    <a href="{{ route('settings.index') }}" 
       class="sidebar-link text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('settings.*') ? 'active' : '' }}">
        <x-heroicon-o-cog-6-tooth class="mr-3 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-300"/>
        {{ __('nav.settings') }}
    </a>

    {{-- Abrechnung --}}
     <a href="{{ route('billing.portal') }}" 
        class="sidebar-link text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        <x-heroicon-o-credit-card class="mr-3 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-300"/>
        {{ __('nav.billing') }}
    </a>

    {{-- Superadmin Bereich --}}
     @if(auth()->user()->role === 'superadmin')
        <div class="pt-4 pb-2 px-2">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('nav.administration') }}</span>
        </div>
        {{-- Kunden verwalten --}}
        <a href="{{ route('superadmin.clients.index') }}" 
           class="sidebar-link text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('superadmin.clients.*') ? 'active' : '' }}">
            <x-heroicon-o-users class="mr-3 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-300"/>
            {{ __('nav.manage_clients') }}
        </a>
        
        {{-- Portal-Kategorien verwalten --}}
        <a href="{{ route('superadmin.portal-categories.index') }}" 
           class="sidebar-link text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('superadmin.portal-categories.*') ? 'active' : '' }}">
            <x-heroicon-o-queue-list class="mr-3 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-300"/>
            {{ __('nav.manage_portal_categories') }}
        </a>

        {{-- Blogbeiträge verwalten --}}
        <a href="{{ route('superadmin.posts.index') }}"
           class="sidebar-link text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('superadmin.posts.*') ? 'active' : '' }}">
            <x-heroicon-o-pencil-square class="mr-3 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-300"/>
            {{-- HINWEIS: 'manage_posts' muss noch zu Ihrer lang/de/nav.php hinzugefügt werden --}}
            {{ __('nav.manage_posts', [], 'Blogbeiträge') }}
        </a>
    @endif
</nav>