@extends('layouts.app')

@section('content')

<h1>Tambah Artikel</h1>

<form action="/posts" method="POST">
    @csrf

    <input type="text" name="title" placeholder="Judul">

    <br><br>

    <textarea name="content" placeholder="Isi Artikel"></textarea>

    <br><br>

    <button type="submit">Simpan</button>
</form>

@endsection