<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage; // Wichtig für das Löschen von Bildern

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(15);
        return view('superadmin.posts.index', compact('posts'));
    }

    public function create()
    {
        $post = new Post(); 
        return view('superadmin.posts.create', compact('post'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:posts,title',
            'excerpt' => 'required|string|max:500',
            'body' => 'required|string',
            'author' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            // is_published wird validiert, aber nicht direkt gespeichert
        ]);

        $post = new Post();
        $post->title = $validated['title'];
        $post->excerpt = $validated['excerpt'];
        $post->body = $validated['body'];
        $post->author = $validated['author'];
        $post->slug = Str::slug($validated['title']);
        $post->published_at = $request->has('is_published') ? now() : null;

        if ($request->hasFile('image')) {
            $post->image_path = $request->file('image')->store('blog_images', 'public');
        }

        $post->save();

        return redirect()->route('superadmin.posts.index')->with('success', 'Blogbeitrag erfolgreich erstellt.');
    }

    public function edit(Post $post)
    {
        return view('superadmin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255', Rule::unique('posts')->ignore($post->id)],
            'excerpt' => 'required|string|max:500',
            'body' => 'required|string',
            'author' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $post->title = $validated['title'];
        $post->excerpt = $validated['excerpt'];
        $post->body = $validated['body'];
        $post->author = $validated['author'];
        $post->slug = Str::slug($validated['title']);
        $post->published_at = $request->has('is_published') ? ($post->published_at ?? now()) : null;

        if ($request->hasFile('image')) {
            // Optional: Altes Bild löschen, wenn ein neues hochgeladen wird
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
            $post->image_path = $request->file('image')->store('blog_images', 'public');
        }

        $post->save();

        return redirect()->route('superadmin.posts.index')->with('success', 'Blogbeitrag erfolgreich aktualisiert.');
    }

    public function destroy(Post $post)
    {
        // Bild löschen, bevor der Beitrag gelöscht wird
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }
        $post->delete();
        
        return redirect()->route('superadmin.posts.index')->with('success', 'Blogbeitrag gelöscht.');
    }
}