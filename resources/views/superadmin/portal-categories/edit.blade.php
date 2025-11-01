@extends('layouts.admin')

@section('title', 'Portal-Kategorie bearbeiten')

@section('content')
    <h2 class="text-2xl font-bold text-white mb-6">Portal-Kategorie bearbeiten: {{ $portalCategory->getTranslation('name', 'de') }}</h2>

    <div class="bg-gray-800 p-8 rounded-lg">
        {{-- Wir entfernen den alten Formular-Code und binden das Partial ein --}}
        <form action="{{ route('superadmin.portal-categories.update', $portalCategory) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- 
                Wir binden das Partial ein und übergeben die $portalCategory,
                die vom Controller kommt.
            --}}
            @include('superadmin.portal-categories.partials.form', ['category' => $portalCategory])
        </form>
    </div>
@endsection