{{-- resources/views/layouts/partials/public-header.blade.php --}}
<header class="bg-gray-100 dark:bg-dark-base sticky top-0 z-50 shadow-md">
    <nav class="container mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
        <!-- Logo -->
        <a href="/" class="text-2xl font-bold text-gray-800 dark:text-gray-100">
            TAGS<span class="text-tags-red">.</span>MENU
        </a>

        <!-- Navigation & Theme Toggle -->
        <div class="flex items-center space-x-4 sm:space-x-6">
            
            {{-- === Entdecken Button === --}}
            <a href="{{ route('search.index') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-tags-red dark:hover:text-crown-gold transition-colors">
                Entdecken
            </a>
            
            <a href="/blog" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-tags-red dark:hover:text-crown-gold transition-colors">
                Blog
            </a>
            
            {{-- === Sprachwechsler (Mit dynamischer Anzeige) === --}}
            <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                
                {{-- Dropdown-Button (Zeigt aktuelle Sprache an) --}}
                <button @click="open = !open" type="button" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-tags-red dark:hover:text-crown-gold transition-colors" aria-haspopup="true" :aria-expanded="open.toString()">
                    {{-- KORREKTUR: Zeigt die aktuelle App-Sprache dynamisch an --}}
                    <span>{{ strtoupper(app()->getLocale()) }}</span> 
                    
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                
                {{-- Dropdown-Menü --}}
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-28 origin-top-right bg-white dark:bg-dark-surface rounded-md shadow-lg ring-1 ring-black ring-opacity-5 dark:ring-gray-700 focus:outline-none z-20"
                     role="menu" aria-orientation="vertical" tabindex="-1"
                     style="display: none;">
                    
                    <div class="py-1" role="none">
                        {{-- HINWEIS: Ersetzen Sie '#' durch Ihre Sprachwechsel-Routen (z.B. route('locale.set', 'de')) --}}
                        <a href="http://tagsmenu.test/language/de" {{-- HIER IHRE ROUTE FÜR DE --}} class="text-gray-700 dark:text-gray-200 block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-dark-base" role="menuitem" tabindex="-1">DE</a>
                        <a href="http://tagsmenu.test/language/en" {{-- HIER IHRE ROUTE FÜR EN --}} class="text-gray-700 dark:text-gray-200 block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-dark-base" role="menuitem" tabindex="-1">EN</a>
                        <a href="http://tagsmenu.test/language/hu" {{-- HIER IHRE ROUTE FÜR HU --}} class="text-gray-700 dark:text-gray-200 block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-dark-base" role="menuitem" tabindex="-1">HU</a>
                        <a href="http://tagsmenu.test/language/sk" {{-- HIER IHRE ROUTE FÜR SK --}} class="text-gray-700 dark:text-gray-200 block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-dark-base" role="menuitem" tabindex="-1">SK</a>
                    </div>
                </div>
            </div>

            <!-- Theme Toggle Button (Funktioniert mit public.blade.php) -->
            <button id="theme-toggle" aria-label="Toggle light/dark theme" class="w-10 h-10 rounded-full flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-dark-surface transition-colors">
                <svg class="theme-icon-sun h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <svg class="theme-icon-moon h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
            </button>
        </div>
    </nav>
</header>

