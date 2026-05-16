@extends('layouts.app')

@section('content')

<h1>Daftar Artikel</h1>

@foreach($posts as $post)

    <h3>{{ $post->title }}</h3>

    <p>{{ $post->content }}</p>

    <a href="/posts/{{ $post->id }}">Detail</a>

    @auth
        <a href="/posts/{{ $post->id }}/edit">Edit</a>

        <form action="/posts/{{ $post->id }}" method="POST">
            @csrf
            @method('DELETE')

            <button type="submit">Hapus</button>
        </form>
    @endauth

    <hr>

@endforeach

@endsection