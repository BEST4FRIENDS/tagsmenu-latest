@extends('layouts.admin')

@section('title', __('categories.title'))

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-white">{{ __('categories.title') }}</h2>
        <a href="{{ route('categories.create') }}" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
            {{ __('categories.create_new') }}
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-500/20 border-l-4 border-green-500 text-green-300 p-4 rounded-lg mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <livewire:category-list />

@endsection