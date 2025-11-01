@extends('layouts.admin')

{{-- ÜBERSETZUNG --}}
@section('title', __('settings.title'))

@section('content')
    {{-- ÜBERSETZUNG --}}
    <h2 class="text-2xl font-bold text-white mb-6">{{ __('settings.title') }}</h2>

    {{-- Erfolgs- und Fehlermeldungen --}}
    @if (session('success'))
        <div class="bg-green-500/20 border-l-4 border-green-500 text-green-300 p-4 rounded-lg mb-6" role="alert">
            {{-- Hinweis: Die Erfolgsmeldung kommt vom Controller. Wir müssen sicherstellen, dass der Controller auch übersetzt wird (nächster Schritt). --}}
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-500/20 border-l-4 border-red-500 text-red-300 p-4 rounded-lg mb-6" role="alert">
            {{-- ÜBERSETZUNG (aus general.php) --}}
            <p class="font-bold">{{ __('general.error_occurred') }}</p>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-gray-800 p-6 rounded-lg mb-8">
        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="space-y-8">

                {{-- Abschnitt: Allgemeine Informationen & Kontakt --}}
                <div>
                    {{-- ÜBERSETZUNG --}}
                    <h3 class="text-xl font-semibold text-white mb-4">{{ __('settings.general_section.title') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Restaurant Name --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-400">{{ __('settings.general_section.name') }}</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $restaurant->name ?? '') }}" required
                                   class="w-full px-4 py-2 mt-2 text-white bg-gray-700 border border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        {{-- Währungsauswahl --}}
                        <div>
                            <label for="currency" class="block text-sm font-medium text-gray-400">{{ __('settings.general_section.currency') }}</label>
                            <select id="currency" name="currency"
                                    class="w-full px-4 py-2 mt-2 text-white bg-gray-700 border border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                {{-- HINWEIS: Währungsnamen werden hier nicht übersetzt, da sie international standardisiert sind --}}
                                @foreach(['EUR' => 'Euro (EUR)', 'HUF' => 'Forint (HUF)', 'USD' => 'US-Dollar (USD)', 'CHF' => 'Schweizer Franken (CHF)', 'GBP' => 'Britisches Pfund (GBP)'] as $code => $label)
                                    <option value="{{ $code }}" {{ old('currency', $restaurant->currency ?? 'EUR') == $code ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Kontakt E-Mail --}}
                        <div>
                            <label for="contact_email" class="block text-sm font-medium text-gray-400">{{ __('settings.general_section.contact_email') }}</label>
                            <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email', $restaurant->contact_email ?? '') }}"
                                   class="w-full px-4 py-2 mt-2 text-white bg-gray-700 border border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        {{-- Telefonnummer --}}
                         <div>
                            <label for="contact_phone" class="block text-sm font-medium text-gray-400">{{ __('settings.general_section.contact_phone') }}</label>
                            <input type="text" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $restaurant->contact_phone ?? '') }}"
                                   class="w-full px-4 py-2 mt-2 text-white bg-gray-700 border border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="+49 123 456789">
                        </div>

                        {{-- Subdomain Auswahl --}}
                        <div class="md:col-span-2">
                            <label for="subdomain" class="block text-sm font-medium text-gray-400">{{ __('settings.general_section.subdomain') }}</label>
                            <div class="flex items-center mt-2">
                                <input type="text" id="subdomain" name="subdomain" value="{{ old('subdomain', $restaurant->subdomain ?? '') }}"
                                       class="w-full bg-gray-700 border border-gray-600 rounded-l-md px-4 py-2 text-white focus:ring-blue-500 focus:border-blue-500">
                                <span class="inline-flex items-center px-3 h-[42px] rounded-r-md border border-l-0 border-gray-600 bg-gray-600 text-gray-300 text-sm">
                                    .tagsmenu.app
                                </span>
                            </div>
                            {{-- ÜBERSETZUNG --}}
                            <p class="mt-2 text-xs text-gray-500">{{ __('settings.general_section.subdomain_help') }}</p>
                            <p class="mt-1 text-xs text-yellow-500 font-semibold">
                                {{ __('settings.general_section.subdomain_warning') }}
                            </p>
                        </div>

                        {{-- ENTFERNT: Der Adressblock wird entfernt, da dies nun von der Livewire-Komponente verwaltet wird. --}}

                    </div>
                </div>

                <hr class="border-gray-700">

                {{-- Abschnitt: Design & Branding --}}
                <div>
                    {{-- ÜBERSETZUNG --}}
                    <h3 class="text-xl font-semibold text-white mb-4">{{ __('settings.design_section.title') }}</h3>
                    <div class="space-y-6">
                         {{-- Logo Upload --}}
                        <div>
                            <label for="logo" class="block text-sm font-medium text-gray-400">{{ __('settings.design_section.logo') }}</label>
                            <input type="file" id="logo" name="logo" accept="image/png, image/jpeg, image/webp"
                                   class="w-full mt-2 text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                            {{-- ÜBERSETZUNG --}}
                            <p class="mt-1 text-xs text-gray-500">{{ __('settings.design_section.logo_help') }}</p>
                            @if($restaurant?->logo_url)
                                <div class="mt-4 flex items-center space-x-4">
                                    {{-- ÜBERSETZUNG --}}
                                    <p class="text-xs text-gray-500">{{ __('settings.design_section.current_logo') }}</p>
                                    <img src="{{ asset('storage/' . $restaurant->logo_url) }}" alt="Aktuelles Logo"
                                         class="rounded-md max-h-20 bg-white p-1">
                                </div>
                            @endif
                        </div>

                        {{-- Akzentfarbe --}}
                        <div>
                            <label for="accent_color" class="block text-sm font-medium text-gray-400">{{ __('settings.design_section.accent_color') }}</label>
                            <div class="flex items-center mt-2">
                                @php $defaultColor = $restaurant->accent_color ?? '#3B82F6'; @endphp
                                <input type="color" id="accent_color_picker" value="{{ old('accent_color', $defaultColor) }}" class="mr-3 h-10 w-10 rounded-md border border-gray-600 bg-gray-700 p-1">
                                <input type="text" id="accent_color" name="accent_color" value="{{ old('accent_color', $defaultColor) }}"
                                       class="w-48 px-4 py-2 text-white bg-gray-700 border border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="#3B82F6">
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-700">

                {{-- Abschnitt: Social Media Links --}}
                <div>
                    {{-- ÜBERSETZUNG --}}
                    <h3 class="text-xl font-semibold text-white mb-4">{{ __('settings.social_section.title') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @php
                            // Die Schlüssel für die Schleife (Labels werden jetzt aus der Sprachdatei gezogen)
                            $socialKeys = ['website', 'google', 'facebook', 'instagram', 'tiktok', 'other'];
                        @endphp

                        @foreach($socialKeys as $key)
                            <div>
                                {{-- ÜBERSETZUNG (Dynamisch) --}}
                                <label for="social_links_{{ $key }}" class="block text-sm font-medium text-gray-400">{{ __('settings.social_section.' . $key) }}</label>
                                <input type="url" id="social_links_{{ $key }}" name="social_links[{{ $key }}]"
                                       value="{{ old('social_links.' . $key, $restaurant->social_links[$key] ?? '') }}"
                                       placeholder="https://..."
                                       class="w-full px-4 py-2 mt-2 text-white bg-gray-700 border border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        @endforeach
                    </div>
                </div>

                <hr class="border-gray-700">

                {{-- Abschnitt: SEO Einstellungen & Social Media Image --}}
                <div>
                    {{-- ÜBERSETZUNG --}}
                    <h3 class="text-xl font-semibold text-white mb-4">{{ __('settings.seo_section.title') }}</h3>
                    <div class="space-y-6">
                        {{-- SEO Title --}}
                        <div>
                            <label for="seo_title" class="block text-sm font-medium text-gray-400">{{ __('settings.seo_section.seo_title') }}</label>
                            <input type="text" id="seo_title" name="seo_title" value="{{ old('seo_title', $restaurant->seo_title ?? '') }}"
                                   class="w-full px-4 py-2 mt-2 text-white bg-gray-700 border border-gray-600 rounded-md"
                                   placeholder="z.B. Crown Restaurant & Bar - Speisekarte">
                            {{-- ÜBERSETZUNG --}}
                            <p class="mt-2 text-xs text-gray-500">{{ __('settings.seo_section.seo_title_help') }}</p>
                        </div>

                        {{-- Meta Description --}}
                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-400">{{ __('settings.seo_section.meta_description') }}</label>
                            <textarea id="meta_description" name="meta_description" rows="3"
                                      class="w-full px-4 py-2 mt-2 text-white bg-gray-700 border border-gray-600 rounded-md"
                                      placeholder="z.B. Entdecken Sie köstliche Gerichte und Getränke...">{{ old('meta_description', $restaurant->meta_description ?? '') }}</textarea>
                            {{-- ÜBERSETZUNG --}}
                            <p class="mt-2 text-xs text-gray-500">{{ __('settings.seo_section.meta_description_help') }}</p>
                        </div>

                        {{-- Social Media Image URL --}}
                        <div>
                            <label for="og_image_url" class="block text-sm font-medium text-gray-400">{{ __('settings.seo_section.og_image_url') }}</label>
                            <input type="url" id="og_image_url" name="og_image_url" value="{{ old('og_image_url', $restaurant->og_image_url ?? '') }}"
                                   class="w-full px-4 py-2 mt-2 text-white bg-gray-700 border border-gray-600 rounded-md"
                                   placeholder="https://beispiel.com/social-media-bild.jpg">
                            {{-- ÜBERSETZUNG --}}
                            <p class="mt-2 text-xs text-gray-500">{{ __('settings.seo_section.og_image_url_help') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-8 flex justify-end">
                {{-- ÜBERSETZUNG (aus general.php) --}}
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition duration-150 ease-in-out">
                    {{ __('general.save_changes') }}
                </button>
            </div>
        </form>
    </div>

    {{-- NEU: Die Livewire-Komponente für das Portal-Profil wird hier eingebettet. --}}
    <div class="mb-8">
        <livewire:restaurant-profile-manager />
    </div>

    {{-- Mitarbeiter-Zugang (Kitchen Interface) --}}
    <div class="bg-gray-800 p-6 rounded-lg mb-8 shadow-xl" x-data="{ copied: false }">
        {{-- ÜBERSETZUNG --}}
        <h3 class="text-xl font-semibold text-white mb-4">{{ __('settings.staff_access_section.title') }}</h3>
        <p class="text-gray-400 mb-4">
            {{ __('settings.staff_access_section.description') }}
        </p>

        @php
            $staffUrl = route('staff.index', ['token' => $restaurant->staff_access_token]);
        @endphp

        <div class="flex items-center mt-4">
            <input type="text" value="{{ $staffUrl }}" readonly
                   class="flex-grow bg-gray-900 text-gray-300 border border-gray-600 rounded-l-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 truncate"
                   id="staff-access-url">

            <button @click="
                        navigator.clipboard.writeText('{{ $staffUrl }}').then(() => {
                            copied = true;
                            setTimeout(() => { copied = false; }, 2000);
                        });
                    "
                    class="px-6 py-2 bg-blue-600 text-white font-bold rounded-r-md hover:bg-blue-700 transition duration-150">
                {{-- ÜBERSETZUNG --}}
                <span x-show="!copied">{{ __('settings.staff_access_section.copy') }}</span>
                <span x-show="copied" x-cloak>{{ __('settings.staff_access_section.copied') }}</span>
            </button>
        </div>

        <p class="text-sm text-yellow-500 mt-3">
            {{-- ÜBERSETZUNG --}}
            <strong>{{ __('settings.staff_access_section.warning') }}</strong> {{ __('settings.staff_access_section.warning_text') }}
        </p>
    </div>


    {{-- Abonnement & Abrechnung --}}
    <div class="bg-gray-800 p-6 rounded-lg">
        {{-- ÜBERSETZUNG --}}
        <h3 class="text-xl font-semibold text-white mb-4">{{ __('settings.billing_section.title') }}</h3>
        <p class="text-gray-400 mb-4">
            {{ __('settings.billing_section.description') }}
        </p>
        {{-- ÜBERSETZUNG --}}
        <a href="{{ route('billing.portal') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
            {{ __('settings.billing_section.manage_billing') }}
        </a>
    </div>

@endsection

@push('scripts')
<script>
    // (JavaScript für Color Picker bleibt unverändert)
    document.addEventListener('DOMContentLoaded', function () {
        const colorPicker = document.getElementById('accent_color_picker');
        const colorInput = document.getElementById('accent_color');

        if (colorPicker && colorInput) {
            colorPicker.addEventListener('input', function() {
                colorInput.value = colorPicker.value;
            });

            colorInput.addEventListener('input', function() {
                if (/^#[0-9A-F]{6}$/i.test(colorInput.value)) {
                    colorPicker.value = colorInput.value;
                }
            });
        }
    });
</script>
@endpush