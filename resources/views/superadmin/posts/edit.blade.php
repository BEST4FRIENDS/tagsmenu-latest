@extends('layouts.admin')

@section('title', 'Blogbeitrag bearbeiten')

@section('content')
    <h2 class="text-2xl font-bold text-white mb-6">Blogbeitrag bearbeiten</h2>

    <div class="bg-gray-800 p-8 rounded-lg">
        <form action="{{ route('superadmin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('superadmin.posts.partials.form')
        </form>
    </div>
@endsection