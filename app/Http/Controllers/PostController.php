<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post; // <-- HINZUFÜGEN
use Illuminate\View\View;

class PostController extends Controller
{
    // Zeigt die Blog-Übersichtsseite
    public function index(): View
    {
        $posts = Post::whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->paginate(9); // 9 Beiträge pro Seite

        return view('blog.index', compact('posts'));
    }

    // Zeigt einen einzelnen Blogbeitrag
    public function show(Post $post): View
    {
        // Stellt sicher, dass nur veröffentlichte Beiträge angezeigt werden
        if (is_null($post->published_at)) {
            abort(404);
        }
        
        return view('blog.show', compact('post'));
    }
}