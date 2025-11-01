@extends('layouts.admin')

@section('title', 'Neue Portal-Kategorie erstellen')

@section('content')
    <h2 class="text-2xl font-bold text-white mb-6">Neue Portal-Kategorie erstellen</h2>

    <div class="bg-gray-800 p-8 rounded-lg">
        {{-- Wir entfernen den alten Formular-Code und binden das Partial ein --}}
        <form action="{{ route('superadmin.portal-categories.store') }}" method="POST">
            @csrf
            
            {{-- 
                Wir binden das neue Partial ein. 
                $portalCategory kommt aus dem PortalCategoryController@create
            --}}
            @include('superadmin.portal-categories.partials.form', ['category' => $portalCategory])
        </form>
    </div>
@endsection