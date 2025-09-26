<nav class="flex-1 px-2 py-4 bg-gray-800">
    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 mt-2 text-gray-400 rounded-md hover:bg-gray-700 hover:text-gray-100 sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        <span>Dashboard</span>
    </a>
    <a href="{{ route('categories.index') }}" class="flex items-center px-4 py-2 mt-2 text-gray-400 rounded-md hover:bg-gray-700 hover:text-gray-100 sidebar-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
        <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        <span>Kategorien</span>
    </a>
    <a href="{{ route('dishes.index') }}" class="flex items-center px-4 py-2 mt-2 text-gray-400 rounded-md hover:bg-gray-700 hover:text-gray-100 sidebar-link {{ request()->routeIs('dishes.*') ? 'active' : '' }}">
        <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        <span>Speisekarte</span>
    </a>
    <a href="{{ route('settings.index') }}" class="flex items-center px-4 py-2 mt-2 text-gray-400 rounded-md hover:bg-gray-700 hover:text-gray-100 sidebar-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
        <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426-1.756-2.924-1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        <span>Einstellungen</span>
    </a>

    {{-- Superadmin Link --}}
    @if (Auth::user()->role === 'superadmin')
        <div class="pt-4 mt-4 border-t border-gray-700">
            <a href="{{ route('superadmin.clients.index') }}" class="flex items-center px-4 py-2 mt-2 text-gray-400 rounded-md hover:bg-gray-700 hover:text-gray-100 sidebar-link {{ request()->routeIs('superadmin.*') ? 'active' : '' }}">
                <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a3.004 3.004 0 015.288 0M12 15a3 3 0 110-6 3 3 0 010 6z" /></svg>
                <span>Kunden</span>
            </a>
        </div>
    @endif
</nav>