<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DevBlog</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, h5, h6, .font-display {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="font-sans antialiased text-slate-800 bg-white min-h-screen flex flex-col">

    <!-- Header / Navbar -->
    <header class="sticky top-0 z-50 w-full border-b border-slate-100 bg-white/80 backdrop-blur-md">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                
                <!-- Logo / Brand -->
                <div class="flex items-center gap-6">
                    <a href="/" class="flex items-center gap-2 group">
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-600 text-white shadow-md shadow-indigo-200 group-hover:scale-105 transition-transform duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </span>
                        <span class="text-xl font-bold tracking-tight text-slate-900 font-display bg-gradient-to-r from-slate-900 to-indigo-600 bg-clip-text text-transparent">
                            DevBlog
                        </span>
                    </a>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex items-center gap-4 sm:gap-6">
                    <a href="/" class="text-sm font-semibold {{ request()->is('/') ? 'text-indigo-600' : 'text-slate-600 hover:text-slate-900' }} transition-colors duration-150">
                        Home
                    </a>

                    @auth
                        <a href="/posts/create" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-3.5 py-2 text-sm font-semibold text-white shadow-sm shadow-indigo-100 hover:bg-indigo-500 hover:shadow-indigo-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-all duration-150">
                            Tulis Artikel
                        </a>

                        <div class="h-4 w-px bg-slate-200 hidden sm:block"></div>

                        <div class="flex items-center gap-3">
                            <span class="text-sm font-medium text-slate-600 hidden sm:inline">
                                {{ Auth::user()->name }}
                            </span>
                            <form action="/logout" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-sm font-semibold text-rose-600 hover:text-rose-700 transition-colors duration-150">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="h-4 w-px bg-slate-200"></div>
                        <a href="/login" class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors duration-150">
                            Login
                        </a>
                        <a href="/register" class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-3.5 py-2 text-sm font-semibold text-white hover:bg-slate-800 transition-colors duration-150">
                            Register
                        </a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-grow max-w-4xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-100 py-6 mt-auto">
        <div class="max-w-5xl mx-auto px-4 text-center text-sm text-slate-500">
            &copy; {{ date('Y') }} DevBlog. Built with Laravel & Tailwind CSS.
        </div>
    </footer>

</body>
</html>