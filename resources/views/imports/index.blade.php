@extends('layouts.admin')

{{-- TRANSLATED --}}
@section('title', __('imports.title'))

@section('content')
    {{-- TRANSLATED --}}
    <h2 class="text-2xl font-bold text-white mb-6">{{ __('imports.title') }}</h2>

    {{-- Feedback-Meldungen (Unverändert) --}}
    @if (session('success'))
        <div class="bg-green-500/20 border-l-4 border-green-500 text-green-300 p-4 rounded-lg mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-500/20 border-l-4 border-red-500 text-red-300 p-4 rounded-lg mb-6" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif
     @if (session('warning'))
        <div class="bg-yellow-500/20 border-l-4 border-yellow-500 text-yellow-300 p-4 rounded-lg mb-6" role="alert">
            <p>{{ session('warning') }}</p>
        </div>
    @endif
    @if ($errors->has('import_file'))
         <div class="bg-red-500/20 border-l-4 border-red-500 text-red-300 p-4 rounded-lg mb-6" role="alert">
            <ul>
                @foreach ($errors->get('import_file') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Import Formular --}}
        {{--
            ALPINE.JS DATEN-PRÄPARATION:
            Wir erstellen hier ein PHP-Array mit den übersetzten Texten
            und übergeben es als JSON an die x-data Direktive.
        --}}
        @php
            $alpineData = json_encode([
                'isUploading' => false,
                'fileName' => null,
                'isDragging' => false,
                'selectFileText' => __('imports.upload_button_select'),
                'changeFileText' => __('imports.upload_button_change'),
            ]);
        @endphp
        <div class="lg:col-span-2 bg-gray-800 p-6 rounded-lg shadow-lg"
             x-data="{{ $alpineData }}"
             x-on:submit="isUploading = true">
            <form action="{{ route('imports.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-8">
                    <div>
                        {{-- TRANSLATED --}}
                        <label class="block text-sm font-medium text-gray-300 mb-3">{{ __('imports.form_select_type') }}</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                             <label class="flex items-start p-5 bg-gray-700 rounded-lg cursor-pointer border border-gray-600 hover:border-blue-500 transition">
                                <input type="radio" name="import_type" value="csv" class="h-5 w-5 text-blue-600 bg-gray-600 border-gray-500 focus:ring-blue-500 mt-0.5" checked>
                                <div class="ml-4">
                                    <div class="flex items-center font-semibold text-white">
                                        <x-heroicon-o-table-cells class="w-6 h-6 mr-2 text-blue-400"/>
                                        {{-- TRANSLATED --}}
                                        {{ __('imports.type_csv_title') }}
                                    </div>
                                    {{-- TRANSLATED --}}
                                    <p class="text-sm text-gray-400 mt-1">{{ __('imports.type_csv_desc') }}</p>
                                </div>
                            </label>

                             {{-- TRANSLATED --}}
                             <label class="flex items-start p-5 bg-gray-700 rounded-lg border border-gray-600 transition opacity-50 cursor-not-allowed" title="{{ __('imports.type_pdf_soon') }}">
                                <input type="radio" name="import_type" value="pdf_ki" class="h-5 w-5 text-cyan-600 bg-gray-600 border-gray-500 mt-0.5" disabled>
                                <div class="ml-4">
                                    <div class="flex items-center font-semibold text-white">
                                        <x-heroicon-o-sparkles class="w-6 h-6 mr-2 text-cyan-400"/>
                                        {{-- TRANSLATED --}}
                                        {{ __('imports.type_pdf_title') }}
                                    </div>
                                    {{-- TRANSLATED --}}
                                    <p class="text-sm text-gray-400 mt-1">{{ __('imports.type_pdf_desc') }}</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div>
                        {{-- TRANSLATED --}}
                        <label for="import_file" class="block text-sm font-medium text-gray-300 mb-2">{{ __('imports.upload_label') }}</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed rounded-md bg-gray-700 transition-colors duration-150"
                             :class="{'border-blue-500 bg-gray-600': isDragging, 'border-gray-600': !isDragging}"
                             x-on:dragover.prevent.stop="isDragging = true"
                             x-on:dragleave.prevent.stop="isDragging = false"
                             x-on:drop.prevent.stop="
                                isDragging = false;
                                if ($event.dataTransfer.files.length) {
                                    $refs.fileInput.files = $event.dataTransfer.files;
                                    fileName = $event.dataTransfer.files[0].name;
                                }
                             ">
                             <div class="space-y-1 text-center">
                                <template x-if="!fileName"><x-heroicon-o-arrow-up-tray class="mx-auto h-12 w-12 text-gray-500"/></template>
                                <template x-if="fileName"><x-heroicon-o-document-check class="mx-auto h-12 w-12 text-green-500"/></template>
                                <template x-if="fileName"><p class="text-sm font-medium text-white mb-2" x-text="fileName"></p></template>

                                <div class="flex text-sm text-gray-400 justify-center">
                                    <label for="import_file" class="relative cursor-pointer rounded-md font-medium text-blue-500 hover:text-blue-400">
                                        {{-- TRANSLATED (via Alpine.js) --}}
                                        <span x-text="fileName ? changeFileText : selectFileText"></span>
                                        <input id="import_file" name="import_file" type="file" class="sr-only" accept=".csv,.xlsx,.xls"
                                               x-ref="fileInput"
                                               x-on:change="fileName = $event.target.files.length ? $event.target.files[0].name : null">
                                    </label>
                                    {{-- TRANSLATED --}}
                                    <p class="pl-1" x-show="!fileName">{{ __('imports.upload_drag_drop') }}</p>
                                </div>
                                {{-- TRANSLATED --}}
                                <p class="text-xs text-gray-500">{{ __('imports.upload_file_specs') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-8 flex justify-end">
                    <button type="submit"
                            class="px-6 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 flex items-center transition disabled:opacity-50"
                            :disabled="isUploading || !fileName">
                        <span x-show="!isUploading" class="flex items-center">
                            <x-heroicon-o-cloud-arrow-up class="w-5 h-5 mr-2"/>
                            {{-- TRANSLATED --}}
                            {{ __('imports.submit_button_start') }}
                        </span>
                        <span x-show="isUploading" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{-- TRANSLATED --}}
                            {{ __('imports.submit_button_processing') }}
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-gray-800 p-6 rounded-lg shadow-lg h-fit">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <x-heroicon-o-information-circle class="w-6 h-6 mr-2 text-blue-400"/>
                {{-- TRANSLATED --}}
                {{ __('imports.instructions_title') }}
            </h3>
            <ol class="list-decimal list-inside text-gray-400 space-y-3 text-sm">
                {{-- TRANSLATED --}}
                <li>{{ __('imports.instructions_step_1') }}</li>
                {{-- TRANSLATED mit Platzhaltern und {!! !!} für HTML --}}
                <li>
                    {!! __('imports.instructions_step_2', [
                        'food' => '<code class="text-xs bg-gray-700 p-1 rounded">food</code>',
                        'drink' => '<code class="text-xs bg-gray-700 p-1 rounded">drink</code>'
                    ]) !!}
                </li>
                {{-- TRANSLATED --}}
                <li>{{ __('imports.instructions_step_3') }}</li>
            </ol>

            <div class="mt-6">
                {{-- TRANSLATED --}}
                <a href="{{ route('imports.downloadTemplate') }}" class="w-full flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition">
                    <x-heroicon-o-arrow-down-tray class="w-5 h-5 mr-2"/>
                    {{ __('imports.download_template_button') }}
                </a>
            </div>
        </div>
    </div>

    @if ($errors->has('import_errors'))
        <div class="bg-red-900 p-6 rounded-lg shadow-lg mt-8 border border-red-700">
            {{-- TRANSLATED --}}
            <h3 class="text-lg font-semibold text-red-400 mb-4">{{ __('imports.validation_error_details') }}</h3>
            <div class="max-h-64 overflow-y-auto text-sm text-red-200 space-y-2">
                @foreach ($errors->get('import_errors') as $error)
                    @foreach((array)$error as $message)
                        <p>{{ $message }}</p> {{-- Diese Meldungen kommen meist schon übersetzt vom Backend --}}
                    @endforeach
                @endforeach
            </div>
        </div>
    @endif
@endsection