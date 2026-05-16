<!DOCTYPE html>
<html>
<head>
    <title>Blog App</title>
</head>
<body>

<nav>
    <a href="/">Home</a>

    @auth
        <a href="/posts/create">Tambah Artikel</a>

        <form action="/logout" method="POST" style="display:inline;">
            @csrf
            <button type="submit">Logout</button>
        </form>
    @else
        <a href="/login">Login</a>
        <a href="/register">Register</a>
    @endauth
</nav>

<hr>

@yield('content')

</body>
</html>