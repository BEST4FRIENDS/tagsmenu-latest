@extends('layouts.admin')

@section('title', 'Neuen Blogbeitrag erstellen')

@section('content')
    <h2 class="text-2xl font-bold text-white mb-6">Neuen Blogbeitrag erstellen</h2>

    <div class="bg-gray-800 p-8 rounded-lg">
        <form action="{{ route('superadmin.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('superadmin.posts.partials.form', ['post' => new \App\Models\Post()])
        </form>
    </div>
@endsection