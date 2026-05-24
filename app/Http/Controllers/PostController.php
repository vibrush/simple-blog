<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        $request->user()->posts()->create($request->all());

        return redirect('/');
    }

    public function edit(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengedit artikel ini.');
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah artikel ini.');
        }

        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        $post->update($request->all());

        return redirect('/');
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus artikel ini.');
        }

        $post->delete();

        return redirect('/');
    }
}