@extends('layouts.app')

@section('content')

<h1>Edit Artikel</h1>

<form action="/posts/{{ $post->id }}" method="POST">

    @csrf
    @method('PUT')

    <input type="text" name="title" value="{{ $post->title }}">

    <br><br>

    <textarea name="content">{{ $post->content }}</textarea>

    <br><br>

    <button type="submit">Update</button>

</form>

@endsection