<!DOCTYPE html>
<html lang="de" class="scroll-smooth" x-data="menuApp" x-bind:class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Wichtig für AJAX POST Requests --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $restaurant->seo_title ?? ($restaurant->name . ' - Speisekarte') }}</title>
    <meta name="description" content="{{ $restaurant->meta_description ?? 'Online menu for ' . $restaurant->name }}">
    
    <meta property="og:title" content="{{ $restaurant->seo_title ?? ($restaurant->name . ' - Speisekarte') }}">
    <meta property="og:description" content="{{ $restaurant->meta_description ?? 'Entdecken Sie unsere Speisekarte online.' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    @if($restaurant->og_image_url)
        <meta property="og:image" content="{{ $restaurant->og_image_url }}">
    @elseif($restaurant->logo_url)
        <meta property="og:image" content="{{ asset('storage/' . $restaurant->logo_url) }}">
    @endif
    
    {{-- WICHTIG: Dark Mode Persistence Script --}}
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        [x-cloak] { display: none !important; }

        :root {
            --accent-color: {{ $restaurant->accent_color ?? '#D97706' }}; 
        }
        .bg-accent { background-color: var(--accent-color); }
        .text-accent { color: var(--accent-color); }
        .hover\:text-accent:hover { color: var(--accent-color); }
        .hover\:bg-accent:hover { background-color: var(--accent-color); }
    </style>
</head>

<body class="bg-gray-100 text-gray-800 dark:bg-dark-bg dark:text-gray-200 transition-colors duration-300">

    <div class="max-w-6xl mx-auto p-4 md:p-8">

        {{-- Header Area --}}
        <header class="text-center py-10">
             @if($restaurant->logo_url)
                <img src="{{ asset('storage/' . $restaurant->logo_url) }}" alt="{{ $restaurant->name }} Logo" class="mx-auto h-20 md:h-24 w-auto mb-4">
            @else
                <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white tracking-widest uppercase">{{ $restaurant->name }}</h1>
            @endif
        </header>

        {{-- Control Bar (Sticky) --}}
        <div class="sticky top-0 bg-gray-100 dark:bg-dark-bg pt-4 pb-6 z-20 transition-colors duration-300 shadow-md dark:shadow-black/50">
            
            <div class="flex justify-center items-center gap-6 mb-6">
                
                {{-- Filter Buttons --}}
                <div class="flex space-x-2 p-1 bg-white dark:bg-gray-900 rounded-full shadow-inner">
                    @if($foodCategories->isNotEmpty())
                    <button @click="activeFilter = 'food'" class="px-5 py-2 rounded-full text-sm font-semibold transition-colors duration-200" 
                            :class="{'bg-accent text-white shadow-lg': activeFilter === 'food', 'text-gray-600 dark:text-gray-400 hover:text-accent dark:hover:text-white': activeFilter !== 'food'}">
                        <span x-text="getTrans({{ 
                            json_encode(collect($availableLangs)->mapWithKeys(fn($lang) => [$lang => __('public.menu.food', [], $lang)])) 
                        }})"></span>
                    </button>
                    @endif
                    @if($drinkCategories->isNotEmpty())
                    <button @click="activeFilter = 'drink'" class="px-5 py-2 rounded-full text-sm font-semibold transition-colors duration-200" 
                            :class="{'bg-accent text-white shadow-lg': activeFilter === 'drink', 'text-gray-600 dark:text-gray-400 hover:text-accent dark:hover:text-white': activeFilter !== 'drink'}">
                        <span x-text="getTrans({{ 
                            json_encode(collect($availableLangs)->mapWithKeys(fn($lang) => [$lang => __('public.menu.drinks', [], $lang)])) 
                        }})"></span>
                    </button>
                    @endif
                </div>

                {{-- Language Switcher --}}
                @if($availableLangs->count() > 1)
                <div class="flex items-center bg-white dark:bg-gray-900 rounded-full p-1 text-sm shadow-inner">
                    @foreach($availableLangs as $lang)
                        <button @click="setLanguage('{{ $lang }}')" 
                                class="px-3 py-2 rounded-full font-semibold transition-colors duration-200 uppercase" 
                                :class="{ 'bg-accent text-white shadow-md': currentLang === '{{ $lang }}', 'text-gray-600 dark:text-gray-400 hover:text-accent dark:hover:text-white': currentLang !== '{{ $lang }}' }">
                            {{ $lang }}
                        </button>
                    @endforeach
                </div>
                @endif

                {{-- Theme Switcher --}}
                <button @click="toggleDarkMode()" title="Theme wechseln" class="p-2 rounded-full bg-white dark:bg-gray-900 text-gray-600 dark:text-gray-400 hover:text-accent dark:hover:text-white transition-colors shadow-inner">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-cloak><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                    <svg x-show="darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-cloak><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </button>
            </div>

            <nav class="flex flex-wrap justify-center items-center gap-4">
                <template x-if="activeFilter === 'food'">
                    <div class="flex flex-wrap justify-center items-center gap-4">
                        @foreach($foodCategories->take(5) as $category)
                            <a href="#category-{{ $category->id }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-400 rounded-full text-sm font-medium hover:bg-accent hover:text-white dark:hover:bg-accent dark:hover:text-white transition-colors shadow-sm">
                                <span x-text="getTrans({{ json_encode($category->translations->pluck('name', 'locale')->all()) }})"></span>
                            </a>
                        @endforeach
                        @if($foodCategories->count() > 5)
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="px-4 py-2 bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-400 rounded-full text-sm font-medium hover:bg-accent hover:text-white dark:hover:bg-accent dark:hover:text-white transition-colors shadow-sm">
                                    <span x-text="getTrans({{ 
                                        json_encode(collect($availableLangs)->mapWithKeys(fn($lang) => [$lang => __('public.menu.more', [], $lang)])) 
                                    }})"></span>
                                </button>
                                <div x-show="open" @click.away="open = false" x-transition class="absolute top-full mt-2 right-0 w-48 bg-white dark:bg-gray-900 rounded-lg shadow-xl py-2 z-10" x-cloak>
                                    @foreach($foodCategories->skip(5) as $category)
                                        <a href="#category-{{ $category->id }}" @click="open = false" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                            <span x-text="getTrans({{ json_encode($category->translations->pluck('name', 'locale')->all()) }})"></span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </template>
                
                <template x-if="activeFilter === 'drink'">
                    <div class="flex flex-wrap justify-center items-center gap-4">
                        @foreach($drinkCategories->take(5) as $category)
                             <a href="#category-{{ $category->id }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-400 rounded-full text-sm font-medium hover:bg-accent hover:text-white dark:hover:bg-accent dark:hover:text-white transition-colors shadow-sm">
                                <span x-text="getTrans({{ json_encode($category->translations->pluck('name', 'locale')->all()) }})"></span>
                            </a>
                        @endforeach
                        @if($drinkCategories->count() > 5)
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="px-4 py-2 bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-400 rounded-full text-sm font-medium hover:bg-accent hover:text-white dark:hover:bg-accent dark:hover:text-white transition-colors shadow-sm">
                                    <span x-text="getTrans({{ 
                                        json_encode(collect($availableLangs)->mapWithKeys(fn($lang) => [$lang => __('public.menu.more', [], $lang)])) 
                                    }})"></span>
                                </button>
                                <div x-show="open" @click.away="open = false" x-transition class="absolute top-full mt-2 right-0 w-48 bg-white dark:bg-gray-900 rounded-lg shadow-xl py-2 z-10" x-cloak>
                                    @foreach($drinkCategories->skip(5) as $category)
                                        <a href="#category-{{ $category->id }}" @click="open = false" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                            <span x-text="getTrans({{ json_encode($category->translations->pluck('name', 'locale')->all()) }})"></span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </template>
            </nav>
        </div>

        {{-- Main Content --}}
        <main class="mt-10">
             @if($foodCategories->isEmpty() && $drinkCategories->isEmpty())
                <div class="text-center py-12 text-gray-500 dark:text-gray-500">
                    <p x-text="getTrans({{ 
                        json_encode(collect($availableLangs)->mapWithKeys(fn($lang) => [$lang => __('public.menu.empty_menu', 'Die Speisekarte wird gerade vorbereitet.', $lang)])) 
                    }})"></p>
                </div>
            @endif

            <div x-show="activeFilter === 'food'" x-transition x-cloak>
                @foreach($foodCategories as $category)
                    @include('public.partials.category-section', ['category' => $category, 'restaurant' => $restaurant])
                @endforeach
            </div>

            <div x-show="activeFilter === 'drink'" x-transition x-cloak>
                @foreach($drinkCategories as $category)
                    @include('public.partials.category-section', ['category' => $category, 'restaurant' => $restaurant])
                @endforeach
            </div>
        </main>

        <footer class="mt-20 py-6 border-t border-gray-300 dark:border-gray-800 text-center text-sm text-gray-500">
            Powered by TAGS.MENU
        </footer>
    </div>

    {{-- Gericht Details Modal (Popup) --}}
    <div x-cloak x-show="isModalOpen" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="isModalOpen" x-transition.opacity @click="closeModal()" class="fixed inset-0 bg-black bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="isModalOpen" x-transition class="inline-block align-bottom bg-white dark:bg-dark-card rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <template x-if="selectedDish">
                    <div>
                        <div class="relative">
                            <template x-if="selectedDish.image_url">
                                <img :src="selectedDish.image_url" alt="Dish Image" class="w-full h-64 object-cover">
                            </template>
                            <template x-if="!selectedDish.image_url">
                                <div class="w-full h-64 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                    <span class="text-gray-500" x-text="getTrans({{ 
                                        json_encode(collect($availableLangs)->mapWithKeys(fn($lang) => [$lang => __('public.menu.no_image', [], $lang)])) 
                                    }})"></span>
                                </div>
                            </template>
                            <button @click="closeModal()" class="absolute top-3 right-3 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-baseline mb-4">
                                <h3 class="text-2xl font-bold text-accent" x-text="getTrans(selectedDish.translations, 'name')"></h3>
                                <span class="text-xl font-semibold text-gray-900 dark:text-white ml-4" x-text="selectedDish.price_formatted"></span>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 mb-6 leading-relaxed min-h-[5rem]" 
                               x-html="poeticDescription || getTrans(selectedDish.translations, 'description')"></p>
                            <button @click="fetchPoeticDescription()" :disabled="isFetchingPoetic"
                                    x-show="!poeticDescription"
                                    class="w-full py-3 bg-accent text-white font-semibold rounded-full shadow-md hover:opacity-90 transition duration-150 disabled:opacity-50">
                                <span x-show="!isFetchingPoetic" x-text="getTrans({{ 
                                json_encode(collect($availableLangs)->mapWithKeys(fn($lang) => [$lang => __('public.ai.button', [], $lang)])) 
                            }})"></span>
                            <span x-show="isFetchingPoetic" x-text="getTrans({{json_encode(collect($availableLangs)->mapWithKeys(fn($lang) => [$lang => __('public.ai.loading', [], $lang)])) }})"></span>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    {{-- Floating Contact Info Button --}}
    @if($restaurant->address || $restaurant->contact_phone || $restaurant->contact_email)
    <div x-data="{ openContact: false }" class="fixed bottom-6 left-6 z-50">
        <button @click="openContact = !openContact"
                class="w-14 h-14 bg-gray-700 dark:bg-gray-800 rounded-full shadow-lg text-white flex items-center justify-center hover:opacity-90 transition focus:outline-none">
            <svg x-show="!openContact" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <svg x-show="openContact" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
        <div x-show="openContact" @click.away="openContact = false" x-transition
             class="absolute bottom-20 left-0 bg-white dark:bg-dark-card rounded-lg shadow-xl p-6 w-72 text-sm text-gray-800 dark:text-gray-200" x-cloak>
            <h4 class="font-bold text-lg mb-4 text-accent" x-text="getTrans({{ 
                json_encode(collect($availableLangs)->mapWithKeys(fn($lang) => [$lang => __('public.contact.title', [], $lang)])) 
            }})"></h4>
            <div class="space-y-3">
                @if($restaurant->address)
                    <div>
                        <p class="font-semibold" x-text="getTrans({{ 
                            json_encode(collect($availableLangs)->mapWithKeys(fn($lang) => [$lang => __('public.contact.address', [], $lang)])) 
                        }})"></p>
                        <p class="text-gray-600 dark:text-gray-400">{!! nl2br(e($restaurant->address)) !!}</p>
                    </div>
                @endif
                @if($restaurant->contact_phone)
                    <div>
                        <p class="font-semibold" x-text="getTrans({{ 
                            json_encode(collect($availableLangs)->mapWithKeys(fn($lang) => [$lang => __('public.contact.phone', [], $lang)])) 
                        }})"></p>
                        <p class="text-gray-600 dark:text-gray-400">{{ $restaurant->contact_phone }}</p>
                    </div>
                @endif
                @if($restaurant->contact_email)
                    <div>
                        <p class="font-semibold" x-text="getTrans({{ 
                            json_encode(collect($availableLangs)->mapWithKeys(fn($lang) => [$lang => __('public.contact.email', [], $lang)])) 
                        }})"></p>
                        <p class="text-gray-600 dark:text-gray-400">{{ $restaurant->contact_email }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    {{-- Floating Social Media Icons --}}
    @if(is_array($restaurant->social_links) && count(array_filter($restaurant->social_links)) > 0)
        <div x-data="{ openSocial: false }" class="fixed bottom-6 right-6 z-50">
        <button @click="openSocial = !openSocial"
                class="w-14 h-14 bg-accent rounded-full shadow-lg text-white flex items-center justify-center hover:opacity-90 transition focus:outline-none">
            <svg x-show="!openSocial" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
            <svg x-show="openSocial" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
        <div x-show="openSocial" @click.away="openSocial = false" x-transition class="absolute bottom-20 right-0 flex flex-col items-center space-y-4" x-cloak>
            @foreach($restaurant->social_links as $platform => $url)
                @if(!empty($url))
                <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" title="{{ ucfirst($platform) }}"
                   class="w-12 h-12 bg-gray-700 rounded-full shadow-md text-white flex items-center justify-center hover:bg-gray-600 transition transform hover:scale-110">
                    @if($platform == 'facebook') <svg viewBox="0 0 24 24" class="w-6 h-6" fill="currentColor"><path d="M12 2.039C6.495 2.039 2 6.313 2 11.583c0 4.692 3.29 8.688 7.785 9.65V14.37h-2.44V11.58h2.44V9.476c0-2.498 1.46-3.883 3.693-3.883 1.086 0 2.18.195 2.18.195v2.35h-1.25c-1.236 0-1.618.77-1.618 1.543v1.902h2.736l-.438 2.79H14.22v6.863c4.495-.96 7.78-4.957 7.78-9.65 0-5.27-4.495-9.544-10-9.544z"/></svg>
                    @elseif($platform == 'instagram') <svg viewBox="0 0 24 24" class="w-6 h-6" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 5.778 2.673 5.926 5.926.058 1.265.07 1.645.07 4.85s-.012 3.584-.07 4.85c-.148 3.252-2.673 5.778-5.926 5.926-1.265.058-1.645.07-4.85.07s-3.584-.012-4.85-.07c-3.252-.148-5.778-2.673-5.926-5.926-.058-1.265-.07-1.645-.07-4.85s.012-3.584.07-4.85c.148-3.252 2.673 5.778 5.926-5.926 1.265-.058 1.645-.07 4.85-.07zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    @elseif($platform == 'tiktok') <svg viewBox="0 0 24 24" class="w-6 h-6" fill="currentColor"><path d="M22.289 5.865c-1.712-1.69-4.412-1.671-6.366.057v8.928c0 2.761-2.334 5.072-5.198 5.072-2.864 0-5.198-2.311-5.198-5.072 0-2.761 2.334-5.072 5.198-5.072.373 0 .741.043 1.101.125V5.381c-.36-.067-.732-.102-1.101-.102-4.935 0-8.934 3.875-8.934 8.666 0 4.791 4 8.666 8.934 8.666s8.934-3.875 8.934-8.666V3.173h-2.802c1.752 1.224 2.802 2.4 2.802 2.692z"/></svg>
                    @elseif($platform == 'google') <svg viewBox="0 0 24 24" class="w-6 h-6" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                    @else <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                    @endif
                </a>
                @endif
            @endforeach
        </div>
    </div>
    @endif


    {{-- JavaScript (unverändert) --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('menuApp', () => ({
                darkMode: document.documentElement.classList.contains('dark'),
                currentLang: localStorage.getItem('menu_lang') || 'de', 
                activeFilter: '{{ $foodCategories->isNotEmpty() ? 'food' : ($drinkCategories->isNotEmpty() ? 'drink' : null) }}',
                isModalOpen: false,
                selectedDish: null,
                poeticDescription: null,
                isFetchingPoetic: false,

                init() { this.setLanguage(this.currentLang); },
                toggleDarkMode() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
                    if (this.darkMode) { document.documentElement.classList.add('dark'); } 
                    else { document.documentElement.classList.remove('dark'); }
                },
                setLanguage(lang) {
                    this.currentLang = lang;
                    localStorage.setItem('menu_lang', lang);
                    document.documentElement.lang = lang;
                },
                getTrans(translations, key = 'name') {
                    if (!translations) return '';
                    let data;
                    if (typeof translations === 'object' && translations !== null) {
                        if (translations.hasOwnProperty('name') && translations.hasOwnProperty('description')) { data = translations[key]; } 
                        else { data = translations; }
                    } else { return translations || ''; }
                    if (typeof data !== 'object' || data === null) return data || '';
                    return data[this.currentLang] || data['de'] || Object.values(data)[0] || '';
                },
                openModal(dishData) {
                    this.selectedDish = dishData;
                    this.poeticDescription = null;
                    this.isFetchingPoetic = false;
                    this.isModalOpen = true;
                    document.body.style.overflow = 'hidden';
                },
                closeModal() {
                    this.isModalOpen = false;
                    document.body.style.overflow = 'auto';
                    setTimeout(() => { this.selectedDish = null; }, 300);
                },
                async fetchPoeticDescription() {
                    if (!this.selectedDish || this.isFetchingPoetic || this.poeticDescription) return;
                    this.isFetchingPoetic = true;
                    const urlTemplate = '{{ route('public.ai.poetic', ['dish' => ':id']) }}';
                    const url = urlTemplate.replace(':id', this.selectedDish.id);
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    try {
                        const response = await fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                            body: JSON.stringify({ language: this.currentLang })
                        });
                        if (!response.ok) {
                            const errorData = await response.json().catch(() => ({})); 
                            if (response.status === 403) { this.poeticDescription = "<i class='text-sm opacity-75'>(Diese KI-Funktion ist für dieses Restaurant nicht aktiviert.)</i>"; } 
                            else { throw new Error(errorData.error || 'Netzwerkfehler bei der Anfrage.'); }
                            return;
                        }
                        const data = await response.json();
                        if (data.poetic_text) { this.poeticDescription = data.poetic_text + "<span class='text-xs block mt-2 opacity-50'>✨ (KI-generiert)</span>"; } 
                        else { throw new Error('Keine gültige Antwort von der KI erhalten.'); }
                    } catch (error) {
                        console.error('Fehler bei der KI-Anfrage:', error);
                        this.poeticDescription = `<span class="text-red-500 italic">Fehler: ${error.message}</span>`;
                    } finally { this.isFetchingPoetic = false; }
                }
            }));
        });
        async function likeDish(buttonElement, dishId) {
            if (buttonElement.disabled) return;
            const countElement = document.getElementById(`likes-count-${dishId}`);
            const svgElement = buttonElement.querySelector('svg');
            let originalCount = parseInt(countElement.textContent);
            svgElement.classList.add('fill-red-500', 'text-red-500');
            buttonElement.classList.remove('hover:text-red-500');
            countElement.textContent = originalCount + 1;
            buttonElement.disabled = true;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const url = `/interact/like/${dishId}`;
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                });
                if (!response.ok) throw new Error('Netzwerkfehler.');
                const data = await response.json();
                countElement.textContent = data.new_likes_count;
                if (!data.success && data.message !== 'Bereits geliked.') {
                    rollbackLike(countElement, svgElement, buttonElement, originalCount);
                    showToast('Aktion fehlgeschlagen.', 'error');
                }
            } catch (error) {
                console.error('Fehler beim Liken:', error);
                rollbackLike(countElement, svgElement, buttonElement, originalCount);
                showToast('Like-Funktion fehlgeschlagen (Keine Verbindung?).', 'error');
            }
        }
        function rollbackLike(countElement, svgElement, buttonElement, originalCount) {
            svgElement.classList.remove('fill-red-500', 'text-red-500');
            buttonElement.classList.add('hover:text-red-500');
            countElement.textContent = originalCount;
            buttonElement.disabled = false;
        }
        function shareDish(title, url) {
            const shareData = {
                title: `TAGS.MENU - ${title}`,
                text: `Ich habe "${title}" auf der Speisekarte gefunden! Schau es dir an:`,
                url: url,
            };
            if (navigator.share) { navigator.share(shareData).catch((error) => console.error('Fehler beim Teilen', error)); } 
            else { navigator.clipboard.writeText(url).then(() => { showToast('Link kopiert!'); }, () => { showToast('Kopieren fehlgeschlagen.', 'error'); }); }
        }
        function showToast(message, type = 'success') {
            const feedback = document.createElement('div');
            feedback.textContent = message;
            const bgColor = type === 'error' ? 'bg-red-600' : 'bg-green-600';
            feedback.className = `fixed bottom-24 left-1/2 transform -translate-x-1/2 ${bgColor} text-white px-4 py-2 rounded-lg shadow-lg transition-opacity duration-300 z-50`;
            document.body.appendChild(feedback);
            setTimeout(() => {
                feedback.style.opacity = '0';
                setTimeout(() => feedback.remove(), 300);
            }, 2500);
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.Alpine && typeof window.Alpine.start === 'function' && !window.Alpine.initialized) {
                window.Alpine.start();
            }
        });
    </script>
</body>
</html>