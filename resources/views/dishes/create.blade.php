@extends('layouts.admin')

@section('title', $type === 'food' ? __('dishes.create_dish_title') : __('dishes.create_drink_title'))

@section('content')
    <h2 class="text-2xl font-bold text-white mb-6">{{ $type === 'food' ? __('dishes.create_dish_title') : __('dishes.create_drink_title') }}</h2>

    @if ($errors->any())
        <div class="bg-red-500/20 border-l-4 border-red-500 text-red-300 p-4 rounded-lg mb-6" role="alert">
            <p class="font-bold">{{ __('general.error_occurred') }}</p>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-gray-800 p-6 rounded-lg">
        <form action="{{ route('dishes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <input type="hidden" name="type" value="{{ $type }}">

            <div class="space-y-6">

                {{-- Main Details --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-400">{{ __('dishes.category') }}</label>
                        <select id="category_id" name="category_id" class="w-full mt-1 bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">{{ __('dishes.category_placeholder') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{-- Holt den Kategorienamen in der aktuell aktiven Sprache --}}
                                    {{ $category->translations->firstWhere('locale', app()->getLocale())?->name ?? __('dishes.unnamed_category', ['id' => $category->id]) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-400">{{ __('dishes.price_in_eur') }}</label>
                        <input type="number" step="any" id="price" name="price" value="{{ old('price') }}" class="w-full mt-1 bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                </div>

                {{-- Image Upload --}}
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-400">{{ __('dishes.image') }}</label>
                    <input type="file" id="image" name="image" class="w-full mt-1 text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                    <p class="text-xs text-gray-500 mt-1">{{ __('dishes.image_recommendation') }}</p>
                </div>

                {{-- Translations --}}
                <div class="space-y-4">
                    @foreach (app('translator')->get('languages') as $langCode => $langName)
                        <div class="bg-gray-700 p-4 rounded-md">
                            <label class="text-sm font-medium text-gray-300">{{ $langName }}</label>
                            <input type="text" name="name_{{ $langCode }}" value="{{ old('name_' . $langCode) }}" placeholder="{{ __('dishes.name') }}" class="w-full mt-1 bg-gray-600 border border-gray-500 rounded-md px-3 py-2 text-white" {{ $langCode == 'de' ? 'required' : '' }}>
                            <textarea name="description_{{ $langCode }}" placeholder="{{ __('dishes.description') }}" class="w-full mt-2 h-20 bg-gray-600 border border-gray-500 rounded-md px-3 py-2 text-white text-sm">{{ old('description_' . $langCode) }}</textarea>
                        </div>
                    @endforeach
                </div>
                
                {{-- Tags --}}
                @if($type === 'food')
                    <div>
                        <label class="block text-sm font-medium text-gray-400">{{ __('dishes.tags') }}</label>
                        <div class="flex flex-wrap gap-x-6 gap-y-2 mt-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_special" value="1" {{ old('is_special') ? 'checked' : '' }} class="h-4 w-4 rounded text-blue-500 bg-gray-600 border-gray-500">
                                <span class="ml-2 text-sm text-gray-300">{{ __('dishes.specialty') }}</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_vegetarian" value="1" {{ old('is_vegetarian') ? 'checked' : '' }} class="h-4 w-4 rounded text-blue-500 bg-gray-600 border-gray-500">
                                <span class="ml-2 text-sm text-gray-300">{{ __('dishes.vegetarian') }}</span>
                            </label>
                        </div>
                    </div>

                    {{-- =================================== --}}
                    {{-- NEU: HASHTAGS INPUT-FELD           --}}
                    {{-- =================================== --}}
                    <div>
                        {{-- === KORREKTUR: Zweiter Parameter entfernt === --}}
                        <label for="hashtags_input" class="block text-sm font-medium text-gray-400">{{ __('dishes.hashtags') }}</label>
                        <input type="text" id="hashtags_input" name="hashtags_input" placeholder="#Vegan, #Scharf, #Glutenfrei"
                               {{-- $currentHashtagsString ist in der create-view nicht vorhanden, daher wird der Fallback '' verwendet --}}
                               value="{{ old('hashtags_input', $currentHashtagsString ?? '') }}"
                               class="w-full px-4 py-2 mt-2 text-white bg-gray-700 border border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        {{-- === KORREKTUR: Zweiter Parameter entfernt === --}}
                        <p class="mt-1 text-xs text-gray-500">{{ __('dishes.hashtags_hint') }}</p>
                    </div>
                @endif

            </div>

            <div class="pt-6 flex justify-end space-x-4">
                <a href="{{ route('dishes.index', ['type' => $type]) }}" class="px-4 py-2 text-white bg-gray-600 rounded-md hover:bg-gray-500">{{ __('general.cancel') }}</a>
                <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">{{ __('general.save') }}</button>
            </div>
        </form>
    </div>
@endsection