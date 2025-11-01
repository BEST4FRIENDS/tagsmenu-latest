@extends('layouts.admin')

@section('title', 'Speisekarten-Verwaltung')

@section('content')
    {{-- Die gesamte Logik wird von der Livewire-Komponente gesteuert --}}
    <livewire:dish-list />
@endsection