@extends('layouts.admin')

@section('title', __('categories.edit_title'))

@section('content')
    <h2 class="text-2xl font-bold text-white mb-6">{{ __('categories.edit_title') }}</h2>

    <div class="bg-gray-800 p-6 rounded-lg">
        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-400">{{ __('categories.category_type') }}</label>
                    <select id="type" name="type" class="w-full mt-1 bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="food" {{ old('type', $category->type) == 'food' ? 'selected' : '' }}>{{ __('categories.food') }}</option>
                        <option value="drink" {{ old('type', $category->type) == 'drink' ? 'selected' : '' }}>{{ __('categories.drinks') }}</option>
                    </select>
                </div>

                {{-- German --}}
                <div>
                    <label for="name_de" class="block text-sm font-medium text-gray-400">{{ __('categories.name_de') }}</label>
                    <input type="text" id="name_de" name="name_de" value="{{ old('name_de', $category->translations->firstWhere('locale', 'de')->name ?? '') }}" class="w-full mt-1 bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                {{-- English --}}
                <div>
                    <label for="name_en" class="block text-sm font-medium text-gray-400">{{ __('categories.name_en') }}</label>
                    <input type="text" id="name_en" name="name_en" value="{{ old('name_en', $category->translations->firstWhere('locale', 'en')->name ?? '') }}" class="w-full mt-1 bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Hungarian --}}
                <div>
                    <label for="name_hu" class="block text-sm font-medium text-gray-400">{{ __('categories.name_hu') }}</label>
                    <input type="text" id="name_hu" name="name_hu" value="{{ old('name_hu', $category->translations->firstWhere('locale', 'hu')->name ?? '') }}" class="w-full mt-1 bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Slovak --}}
                <div>
                    <label for="name_sk" class="block text-sm font-medium text-gray-400">{{ __('categories.name_sk') }}</label>
                    <input type="text" id="name_sk" name="name_sk" value="{{ old('name_sk', $category->translations->firstWhere('locale', 'sk')->name ?? '') }}" class="w-full mt-1 bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

            </div>

            <div class="pt-6 flex justify-end space-x-4">
                <a href="{{ route('categories.index') }}" class="px-4 py-2 text-white bg-gray-600 rounded-md hover:bg-gray-500">{{ __('general.cancel') }}</a>
                <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">{{ __('categories.update_category') }}</button>
            </div>
        </form>
    </div>
@endsection